<?php
/**
 * 
 * @author khanhdtp
 *
 */
class GroupController extends K111_Controller_Action
{
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		/* Initialize action controller here */
	}
	
	/**
	 *
	 */
	public function indexAction()
	{
	    //
	    $params = $this->_getAllParams();
	    
	    // Define var # view's data;
	    $vData = array();
	     
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Group_Index();
		// +++ 
		
		// +++ 
		$vData['form']->populate($params); 
	    
	    // Fetch data;
	    $groupDbTable = new Default_Model_DbTable_Group();
	    // 
	    $selector = $groupDbTable->buildFetchDataSelector($params);
	    // 
	    $vData['paginator'] = $paginator = Zend_Paginator::factory($selector);
	    $paginator->setCurrentPageNumber($this->_getParam('page'));
	    
	    // Render view
	    $this->view->assign($vData);
	}
	
	/**
	 * Action: create new data;
	 * @return void
	 */
	public function createAction()
	{
	    // Define var # view's data;
	    $vData = array();
	    
	    // Define var # form;
	    $vData['form'] = $form = new Default_Form_Group_Insert();
	    
	    // Process on POST 
	    if ($this->_request->isPost()) {
	        // Get post data
	        $postData = $this->_request->getPost();
	        
	        // Check form valid?
	        if ($form->isValid($postData)) {
	            // Define vars
    	        $dbTblGroup = new Default_Model_DbTable_Group();
    	        
    	        //Check duplicate code! 
                $dataExists = !!$dbTblGroup->fetchRow(array('code = ?' => $postData['code']));
                if ($dataExists) {
    	            $form
    	               ->getElement('code')
    	                   ->addError($txt = $this->view->translate('Mã nhóm tài khoản đã tồn tại!'))
    	            ;
                }
	            
	            // Get form data;
	            $formValues = $form->getValues();
	            
	            // Form has no errors?
	            if (!$form->hasErrors()) {
	                // +++
    	            $groupRow = $dbTblGroup->fetchNew();
    	            // +++ 
    	            $groupRow->setFromArray(array_merge($formValues, array(
    	                'create_account_id' => $this->_authIdentity->id,
    	            )));
    	            // +++  
    	            $gDataId = $groupRow->save();
    	            
    	            // Inform
    	            $this->_helper->flashMessenger->addMessage(
    	                $this->view->translate('Thêm mới dữ liệu thành công!'),
    	                'layout-messages'
                    );
    	            
    	            // Redirect
    	            switch ($postData['_act']) {
    	                // +++ save_n_new
    	                case 'save_n_new' : {
                            $this->_helper->redirector(
                                $this->_request->getActionName(),
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
	    }
	    
	    // Render view
	    $this->view->assign($vData);
	}
	
	/**
	 *
	 */
	public function updateAction()
	{
	}
	
	/**
	 * 
	 */
	protected function _editAction() {
	    
	}
}