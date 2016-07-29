<?php
/**
 * 
 * @author khanhdtp
 *
 */
class AccountController extends K111_Controller_Action
{
	/**
	 * @var Default_Model_DbTable_Account
	 */ 
	protected $_repo;
	
	/**
	 * @var Default_Model_DbTable_Group
	 */ 
	protected $_repoGroup;
		
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		/* Initialize action controller here */
		// +++ Entity's repo;
		$this->_repo = new Default_Model_DbTable_Account();
		// +++ Entity's repo;
		$this->_repoGroup = new Default_Model_DbTable_Group();
	}
	
	/**
	 * Action: login page
	 * 
	 * @return void
	 */
	public function loginAction()
	{
	    // Case: logged in!
	    if ($this->_authIdentity) {
	        // Redirect to home page!
	        return $this->redirect($this->view->baseUrl('/'), array(
	            'prependBaseUrl' => false
	        ));
	    }
	    
	    // Use layout `login`
	    $this->_helper->layout()->setLayout('login');
	    
	    // Start session (if was not)
	    if (!Zend_Session::isStarted()) {
	        Zend_Session::start();
	    }
	    
	    // Define vars
	    $vData = array();
	    
	    // Case: post data, process...
	    if ($this->_request->isPost()) {
	        // Get post data;
	        $postData = $this->_request->getPost();
			
			// Security
			$security = $_SESSION['security'];
			unset($_SESSION['security']);
	        
	        // Check data's validation
	        if (($securityMatched = ($postData['security'] == $security)) // security
	            && ($postData['username'] = trim(strip_tags($postData['username']))) // username
	            && ($postData['password'] = trim(strip_tags($postData['password']))) // password
            ) {
                // Get Zend_Auth
                $zAuth = Zend_Auth::getInstance();
                // Use Zend_Auth_Adapter_DbTable to authenticate.
                $zAuthAdapterDbTable = new Zend_Auth_Adapter_DbTable();
                // Get authenticate result. 
                $zAuthResult = $zAuthAdapterDbTable
                    ->setTableName($this->_repo->getName())
                    ->setIdentityColumn('username')
                    ->setIdentity($postData['username'])
                    ->setCredentialColumn('password')
                    ->setCredential($postData['password'])
                    ->setCredentialTreatment('MD5(?) AND `active` = ' . Default_Model_DbTable_Row_Account::STAT_YES)
                    ->authenticate()
                ;
                // Check authenticate result
                switch ($zAuthResult->getCode()) {
                    // Case: failed unkhown
                    case Zend_Auth_Result::FAILURE : 
                    case Zend_Auth_Result::FAILURE_UNCATEGORIZED: {
                        Zend_Registry::set('layout-messages', '[danger]' 
                            . $this->view->translate('Đăng nhập không thành công!')
                            . ' Errs: ' . implode("<br />\n", $zAuthResult->getMessages())
                        );
                    } break;
                    // Case: username or password not macthed.
                    case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
                    case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS: 
                    case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND: {
                        Zend_Registry::set('layout-messages', '[danger]'
                            . $this->view->translate('Đăng nhập không thành công! Tên đăng nhập/Mật khẩu không đúng!')
                        );
                    } break;
                    // Case: success.
                    case Zend_Auth_Result::SUCCESS: {
                        // Account object info from database;
                        $accountResultObject = $zAuthAdapterDbTable->getResultRowObject();
                        // Write a session storage to Zend_Auth;
                        // +++ Group data 
						if ($accountResultObject->group_id) {
							// Fetch group data;
							$groupEntity = $this->_repoGroup->find($accountResultObject->group_id)->current();
							if ($groupEntity) {
								$groupAcl = array();
								foreach ((array)$groupEntity->getAcl() as $site => $acl) {
									$groupAcl[$site] = ',' . implode(',', $acl) . ',';
								}
								$accountResultObject = (object)array_merge((array)$accountResultObject, array(
									'group_name' => $groupEntity->name, 'group_acl' => $groupAcl
								));
								unset($groupAcl, $site, $acl);
							}
						}	
                        // +++ Remember me?
						if ($postData['remember']) {
                            Zend_Session::rememberMe(2 * 86400); //2 days
                        }
						// +++ 
                        // +++ 
                        $zAuthStorage = new Zend_Auth_Storage_Session();
                        $zAuthStorage->write($accountResultObject);
                        $zAuth->setStorage($zAuthStorage);
                        
                        // Inform user;
                        $this->_helper->flashMessenger->addMessage($this->view->translate('Đăng nhập thành công!'));
                        
                        // Redirect to home page!
                        return $this->redirect($this->view->baseUrl('/'), array(
                            'prependBase' => false
                        ));
                    } break;
                }
            // Case: invalid submit data
            } else {
                // Case: invalid security. 
                if (!$securityMatched) {
                    Zend_Registry::set('layout-messages', '[danger]' . $this->view->translate('Mã bảo vệ không hợp lệ!'));
                    
                // Case: empty username or password  
                } else {
                    Zend_Registry::set('layout-messages', '[danger]' . $this->view->translate('Vui lòng nhập đầy đủ thông tin tên đăng nhập, và mật khẩu!'));
                }
            }
	    }
	    
	    // Create new security code;
	    $_SESSION['security'] = $vData['security'] = md5(uniqid());
	    
	    // Assign view's vars
	    $this->view->assign($vData);
	    
	}
	
	/**
	 * Action: logout
	 * 
	 * @return void
	 */
	public function logoutAction()
	{
	    // Get Zend_Auth
	    $zAuth = Zend_Auth::getInstance();
	    // +++ Clear storage!
	    $zAuth->getStorage()->clear();
	    // +++ Clear identity
	    $zAuth->clearIdentity();
	    
	    // Redirect to home page!
	    return $this->redirect($this->view->baseUrl('/'), array(
	        'prependBase' => false
	    ));
	}
	
	/**
	 *
	 */
	public function profileAction()
	{
	}
	
	/**
	 * Action: list data;
	 * @return void
	 */
	public function indexAction()
	{
	    // Get request params
	    $params = $this->_getAllParams();
	    
	    // Define var # view's data;
	    $vData = array();
		
		// Fetch relative data
		// +++ Group
		$vData['groupOptions'] = (array)$this->_repoGroup->fetchOptions(array(
			//'include_code' => true
		));
	     
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Account_Index();
		// +++ Fill form's elemnents data
		// +++ +++ Group
		$form->group_id && $form->group_id->setMultiOptions(
			array('' => LANG_SELECT) + $vData['groupOptions']
		); 
		
		// +++ Fill form's data;
		$vData['form']->populate($params);
		
	    // Fetch data;
	    // +++  
	    $selector = $this->_repo->buildFetchDataSelector($params);
	    // +++ Paaginator
	    $vData['paginator'] = $paginator = Zend_Paginator::factory($selector);
	    $paginator->setCurrentPageNumber($this->_getParam('page'));
	    
	    // Render view
	    $this->view->assign($vData);
	}
	
	/**
	 * Action: active;
	 * @return void
	 */
	public function activeAction()
	{
		// Get params
		// +++ Data ID;
		$id = $this->_getParam('id');
		// +++ Flag: active;
		$active = (1 * $this->_getParam('active'));
		$active = 1 - ((1 == $active) ? $active : 0);
		
		// Fetch data
		$entity = $this->_repo->find($id)->current();
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found'), 500);
		}
		
		try {
			// Switch active state;
			$entity->active = $active;
			$entity->save();
			// Return  
			return $this->_helper->json(array(
				'id' => $id, 'active' => $active
			));
		} catch (Exception $e) {
			// Return
			return $this->_helper->json(array(
				'error' => $e->getMessage()
			));
		}
	}
	
	/**
	 * CRUD
	 * @param $options array An array of options
	 * @return void
	 */
	protected function _crud(array $options = array()) 
	{
		// Get, format options
		$entity = $options['entity'];
		// +++ Flag: is update mode?
		$options['isActUpdate'] = ('update' == $options['act']); 
		// +++ Flag: is detail mode?
		$options['isActDetail'] = ('detail' == $options['act']);
		
	    // Define var # view's data;
	    $vData = array();
		
		// Fetch relative data
		// +++ Group
		$vData['groupOptions'] = (array)$this->_repoGroup->fetchOptions(array(
			'include_code' => true
		));
	    
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Account_Crud();
		// +++ Fill form's elemnents data
		// +++ +++ Group
		$form->group_id && $form->group_id->setMultiOptions(
			array('' => LANG_SELECT) + $vData['groupOptions']
		);
		// +++ Change filter, validation coditions on update mode
		if ($options['isActUpdate']) {
			$form->password && $form->password->setRequired(false);
		} 
		// +++ Modify elements on detail mode
		if ($options['isActDetail']) {
			// Disable elements
			foreach ($form->getElements() as $ele) {
				$ele->setAttrib('disabled', 'disabled');
			} unset($ele);
			// +++ 
			$form->password && $form->removeElement('password'); 
		}
	    
	    // Process on POST
	    if ($this->_request->isPost() && !$options['isActDetail']) {
	        // Get post data
	        $postData = $this->_request->getPost();
	        
	        // Check form valid?
	        if ($form->isValid($postData)) {
	        	// Get form data;
	            $formValues = $form->getValues();
				
    	        // Check duplicate code!
    	        $dataExists = $this->_repo->checkExistsByUsername($formValues['username'], array(
    	        	'exclude_id' => array($entity->id) 
				)); 
                if ($dataExists) {
    	            $form
    	               ->getElement('username')
    	                   ->addError($txt = $this->view->translate('Tên đăng nhập đã tồn tại!'))
    	            ;
                }
	            
	            // Form has no errors?
	            if (!$form->hasErrors()) {
	                // Create new entity (if not any)
    	            $entity = $entity ?: $this->_repo->fetchNew();
    	            // Fill entity data
					// +++ Don't reset password if has no input
					if ($options['isActUpdate']) {
						if ('' == (string)$formValues['password']) {
							unset($formValues['password']);
						}
					}
					// +++ 
    	            $entity->setFromArray(array_merge($formValues,
    	            	$options['isActUpdate']
					// +++ Case: update
						? array(
							'last_modified_account_id' => $this->_authIdentity->id,
	    	                'last_modified_time' => date('Y-m-d H:i:s'),
						) 
					// +++ Case: create
	    	            : array(
	    	                'create_account_id' => $this->_authIdentity->id,
	    	            )
					));
    	            // +++ Get last insert id (if any)
    	            $entityId = $entity->save();
    	            
    	            // Inform
    	            $this->_helper->flashMessenger->addMessage(
    	                $this->view->translate('Thao tác dữ liệu thành công!'),
    	                'layout-messages'
                    );
    	            
    	            // Redirect
    	            switch ($postData['_act']) {
    	            	// +++ apply
    	                case 'apply' : {
                            $this->_helper->redirector(
                                $this->_request->getActionName(),
                                $this->_request->getControllerName(),
                                $this->_request->getModuleName(),
                                $this->_request->getUserParams()
                            );
    	                } break;
    	                // +++ save_n_new
    	                case 'save_n_new' : {
                            $this->_helper->redirector(
                                'create',
                                $this->_request->getControllerName(),
                                $this->_request->getModuleName(),
                                array('id' => null)
                            );
    	                } break;
    	                // +++ save_n_close
    	                case 'save_n_close' : {
    	                    $this->_helper->redirector(
    	                        null,
    	                        $this->_request->getControllerName(),
    	                        $this->_request->getModuleName(),
    	                        array('id' => null)
    	                    );
    	                } break;
    	            }
	            }
	        }

		// Case: on page's first load
	    } else {
	    	// Fill form's data;
	    	if ($entity) {
		    	// +++ 
				$formData = $entity->toArray();
				// +++ 
				$form->populate($formData);
			}
		}
	    
	    // Render view
	    $this->view->assign(array_merge($vData, array(
	    // +++ Controller options
	    	'contOpts' => $options
		)));
		// +++ Render script
		$this->renderScript($this->_request->getControllerName() . '/crud.phtml');
	}
	
	/**
	 * Action: create new data;
	 * @return void
	 */
	public function createAction()
	{
		return $this->_crud();
	}
	
	/**
	 * Action: update data;
	 * @return void
	 */
	public function updateAction()
	{
		// Get params
		// +++ Data ID;
		$id = $this->_getParam('id');
		
		// Fetch data
		$entity = $this->_repo->find($id)->current();
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found'), 500);
		}
		
		// Forward request;
		return $this->_crud(array(
			'entity' => $entity,
			'act' => 'update' 
		));
	}
	
	/**
	 * Action: update data;
	 * @return void 
	 */
	public function detailAction() 
	{
		// Get params
		// +++ Data ID;
		$id = $this->_getParam('id');
		
		// Fetch data
		$entity = $this->_repo->find($id)->current();
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found'), 500);
		}
		
		// Forward request;
		return $this->_crud(array(
			'entity' => $entity,
			'act' => 'detail' 
		));
	}
	
	/**
	 * Action: delete;
	 * @return void
	 */
	public function deleteAction()
	{
		// Get params
		// +++ Data ID;
		$id = (array)$this->_request->getPost('id');
		$id = array_filter($id);
		
		// Fetch data
		$entities = $this->_repo->find($id);
		
		// Check data valid?
		if (empty($entities)) {
			throw new Exception($this->view->translate('Data not found'), 500);
		}
		
		// Loop, delete data;
		foreach ($entities as $entity) {
			$entity->delete();
		}
		
		// Inform
        $this->_helper->flashMessenger->addMessage(
            $this->view->translate('Xóa dữ liệu thành công!'),
            'layout-messages'
        );
		
		// Redirect
		if ($_SERVER['HTTP_REFERER']) {
			header("Location: {$_SERVER['HTTP_REFERER']}");
			die();
		}
		$this->_helper->redirector(
            null,
            $this->_request->getControllerName(),
            $this->_request->getModuleName(),
            array('id' => null)
        );
	}
}