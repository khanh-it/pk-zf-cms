<?php
/**
 * 
 * @author khanhdtp
 *
 */
class GroupController extends K111_Controller_Action
{
	/**
	 * @var Default_Model_DbTable_Group
	 */ 
	protected $_repo;
		
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		/* Initialize action controller here */
		// +++ Entity's repo;
		$this->_repo = new Default_Model_DbTable_Group();
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
	     
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Group_Index();
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
	    
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Group_Crud();
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
	        	
    	        // Check duplicate code!
    	        $dataExists = $this->_repo->checkExistsByCode($formValues['code'], array(
    	        	'exclude_id' => array($entity->id) 
				)); 
                if ($dataExists) {
    	            $form
    	               ->getElement('code')
    	                   ->addError($txt = $this->view->translate('Mã nhóm tài khoản đã tồn tại!'))
    	            ;
                }
	            
	            // Form has no errors?
	            if (!$form->hasErrors()) {
	                // Create new entity (if not any)
    	            $entity = $entity ?: $this->_repo->fetchNew();
    	            // Fill entity data 
    	            $entity->setFromArray(array_merge($formValues,
    	            	('update' == $options['act'])
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
		// +++ 
		$this->renderScript('group/crud.phtml');
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
            $this->view->translate('Thao tác dữ liệu thành công!'),
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