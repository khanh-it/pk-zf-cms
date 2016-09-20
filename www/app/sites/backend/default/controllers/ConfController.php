<?php
/**
 * 
 * @author khanhdtp
 * @MCAInfo({
 	"name": "Index controller",
	"info": "Manage categories"
})
 */
class ConfController extends K111_Controller_Action
{
	/**
	 * @var options
	 */
	protected $_options = array();
	
	/**
	 * @var Default_Model_DbTable_Conf
	 */ 
	protected $_repo;
		
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		/* Initialize action controller here */
		// +++ Sync module/controller/action name?
		if ($this->_options['syncModuleName']) {
			$this->_request->setModuleName($this->_request->getParam('module'));
		}
		if ($this->_options['syncControllerName']) {
			$this->_request->setControllerName($this->_request->getParam('controller'));
		}
		if ($this->_options['syncActionName']) {
			$this->_request->setActionName($this->_request->getParam('action'));
		}
		// +++ Format, + get options (from others forwared controllers)
		// +++ Check for required option
		$this->_options['group'] = $this->_request->getModuleName();
		if (!$this->_options['group']) {
			throw new Zend_Controller_Action_Exception("Conf group is missing!");
		}
		// +++ Entity's repo;
		$this->_repo = new Default_Model_DbTable_Conf();
		$this->_repo->setDefaultGroup($this->_options['group']);
	}
	
	/**
	 * Action: list data;
	 * 
	 * @return void
	 */
	public function indexAction()
	{
	    // Get request params
	    $params = $this->_getAllParams();
	    
	    // Define var # view's data;
	    $vData = array();
	     
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Conf_Index();
		// +++ 
		
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
		// +++ Render script
		$this->renderScript('conf/index.phtml');
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
		// +++ @var Default_Model_DbTable_Util_Phrase
		$vData['phrUtil'] = $phrUtil = Default_Model_DbTable_Util_Phrase::getInstance();
		
		// Get language info
		list($langKey, $langData) = Language::getDefault();
		
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Conf_Crud(array(
	    // +++ Controller's options
	    	'controllerOptions' => $this->_options
		));
		// +++ Disable elements on detail mode
		if ($options['isActDetail']) {
			foreach ($form->getElements() as $ele) {
				$ele->setAttrib('disabled', 'disabled');
			}
			unset($ele);
		}
		
	    // Process on POST
	    if ($this->_request->isPost() && !$options['isActDetail']) {
	        // Get post data
	        $postData = $this->_request->getPost();
	        
	        // Check form valid?
	        if ($form->isValid($postData)) {
	        	// Get form data;
	            $formValues = $form->getValues();
				// +++ group
				$formValues['group'] = $this->_options['group'];
				// +++ value
				if (Default_Model_DbTable_Conf::INPUT_PLAINTEXT == $formValues['input']) {
					$formValues['value'] = $formValues['value_plaintext']; 
				}
				if (Default_Model_DbTable_Conf::INPUT_HTML == $formValues['input']) {
					$formValues['value'] = $formValues['value_html']; 
				}
				unset($formValues['value_plaintext'], $formValues['value_html']);
				
				// Check duplicate code!
    	        $dataExists = $this->_repo->checkExistsByCode($formValues['code'], $formValues['group'], array(
    	        	'exclude_id' => array($entity->id) 
				)); 
                if ($dataExists) {
    	            $form
    	               ->getElement('code')
    	                   ->addError($txt = $this->view->translate('Mã cấu hình đã tồn tại!'))
    	            ;
                }
				
	            // Form has no errors?
	            if (!$form->hasErrors()) {
	                // Create new entity (if not any)
    	            $entity = $entity ?: $this->_repo->fetchNew();
    	            // Fill entity data 
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
                                array('id' => $entity->id)
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
				// +++ value
				if ($entity->isInputPlainText()) {
					$formData['value_plaintext'] = $formData['value']; 
				}
				if ($entity->isInputHtml()) {
					$formData['value_html'] = $formData['value']; 
				}
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
		$this->renderScript('conf/crud.phtml');
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
		$dbA = $this->_repo->getDefaultAdapter(); 
		$entity = $this->_repo->fetchRow(array(
			$dbA->quoteIdentifier('id') . ' = ?' => $id, 
			$dbA->quoteIdentifier('group') . ' = ?' => $this->_options['group']
		));
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found!'), 500);
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
		$dbA = $this->_repo->getDefaultAdapter(); 
		$entity = $this->_repo->fetchRow(array(
			$dbA->quoteIdentifier('id') . ' = ?' => $id, 
			$dbA->quoteIdentifier('group') . ' = ?' => $this->_options['group']
		));
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found!'), 500);
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
		$dbA = $this->_repo->getDefaultAdapter();
		$entities = $this->_repo->fetchAll(array(
			$dbA->quoteIdentifier('id') . ' IN (?)' => $id, 
			$dbA->quoteIdentifier('group') . ' = ?' => $this->_options['group']
		));
		
		// Check data valid?
		if (!count($entities)) {
			throw new Exception($this->view->translate('Data not found!'), 500);
		}
		if (count($id) != count($entities)) {
			throw new Exception($this->view->translate('Data count not matched!'), 500);
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

	/**
	 * Action: language;
	 * @return void
	 */
	public function languageAction()
	{
		// Get params
		// +++ Data ID;
		$id = $this->_getParam('id');
		// +++ Selected lang;
		$lang = $this->_getParam('lang');
		
		// Fetch data
		$dbA = $this->_repo->getDefaultAdapter(); 
		$entity = $this->_repo->fetchRow(array(
			$dbA->quoteIdentifier('id') . ' = ?' => $id, 
			$dbA->quoteIdentifier('group') . ' = ?' => $this->_options['group']
		));
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found!'), 500);
		}
		
	    // Define var # view's data;
	    $vData = array();
		// +++ Entity object
		$vData['entity'] = $entity;
		// +++ @var Default_Model_DbTable_Util_Phrase
		$vData['phrUtil'] = $phrUtil = Default_Model_DbTable_Util_Phrase::getInstance();
		
		// Get language info
		// +++ List of languages
		$vData['languages'] = Language::get();
		// +++ Default language
		list($dfLangKey) = Language::getDefault();
		unset($vData['languages'][$dfLangKey]);
		// +++ Selected language 
		if ($vData['langData'] = $vData['languages'][$lang]) {
			$vData['langKey'] = $lang;
		} else {
			$vData['langKey'] = key($vData['languages']);
			$vData['langData'] = $vData['languages'][$vData['langKey']];
		}
		
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Conf_Lang(array(
	    // +++ Controller's options
	    	'controllerOptions' => array_merge($this->_options, array(
	    		'input' => $entity->input
			))
		));
		
	    // Process on POST
	    if ($this->_request->isPost()) {
	        // Get post data
	        $postData = $this->_request->getPost();
	        
	        // Check form valid?
	        if ($form->isValid($postData)) {
	        	// Get form data;
	            $formValues = $form->getValues();
				// +++ Make alias
				$formValues['alias'] = $this->_helper->common->str2Alias(
					$formValues['alias'] ?: $formValues['name']
				);
				
	            // Form has no errors?
	            if (!$form->hasErrors()) {
					// Save phrase data? 
					$phrUtil->savePhrase(
						Default_Model_DbTable_Conf::PHRASE,
						$entity->id, $vData['langKey'], $formValues
					);
				
    	            // Inform
    	            $this->_helper->flashMessenger->addMessage(
    	                $this->view->translate('Dịch ngôn ngữ thành công!'),
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
                                array(
                                	'id' => $entity->id,
                                	'lang' => $vData['langKey']
								)
                            );
    	                } break;
    	                // +++ save_n_close
    	                case 'save_n_close' : {
    	                    $this->_helper->redirector(
    	                        null,
    	                        $this->_request->getControllerName(),
    	                        $this->_request->getModuleName(),
    	                        array('id' => null, 'lang' => null)
    	                    );
    	                } break;
    	            }
	            }
	        }

		// Case: on page's first load
	    } else {
	    	// Fill form's data;
			// +++ Phrase data
			$phrData = (array)$entity->findChildrenEntry($vData['langKey']);
			// +++ 
			$form->populate($phrData);
		}
	    
	    // Render view
	    $this->view->assign(array_merge($vData, array(
		)));
		// +++ Render script
		$this->renderScript('conf/language.phtml');
	}
}