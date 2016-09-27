<?php
/**
 * Product product
 * @author khanhdtp
 * @MCAInfo({
 	"name": "Giỏ hàng",
	"info": "Quản lý giỏ hàng"
})
 */
class Product_CartController extends K111_Controller_Action
{
	/**
	 * @var Product_Model_DbTable_Cart
	 */ 
	protected $_repo;
	
	/**
	 * @var Product_Model_DbTable_CartDetail
	 */ 
	protected $_repoCartDetail;
	
	/**
	 * @var Product_Model_DbTable_CartLog
	 */ 
	protected $_repoCartLog;
	
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		/* Initialize action controller here */
		// +++ Entity's repo(s);
		// +++ +++ Cart
		$this->_repo = new Product_Model_DbTable_Cart();
		// +++ +++ CartDetail
		$this->_repoCartDetail = new Product_Model_DbTable_CartDetail();
		// +++ +++ CartLog
		$this->_repoCartLog = new Product_Model_DbTable_CartLog();
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
	    $vData['form'] = $form = new Product_Form_Cart_Index(array(
	    // +++ Controller's options
	    	'controllerOptions' => $this->_options
		));
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
			throw new Exception($this->view->translate('Data not found!'), 500);
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
	 * Action: create new data;
	 * @return void
	 */
	public function createAction()
	{
		return $this->_crud();
	}
	
	/**
	 * Action: update data # logs;
	 * @return void
	 */
	public function updateAction()
	{
		// Get params
		// +++ Data ID;
		$id = $this->_getParam('id');
		
		// Define data
		$vData = array();
		
		// Fetch data
		$entity = $this->_repo->fetchRow(array(
			'id = ?' => $id
		));
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found!'), 500);
		}
		
		// Define var # form;
	    $vData['form'] = $form = new Product_Form_Cart_Log(array(
	    // +++ Controller's options
	    	'controllerOptions' => $this->_options
		));
		
		// Process on POST
	    if ($this->_request->isPost()) {
	        // Get post data
	        $postData = $this->_request->getPost();
			
	        // Check form valid?
	        if ($form->isValid($postData)) {
	        	// Get form data;
	            $formValues = $form->getValues();
				
	            // Form has no errors?
	            if (!$form->hasErrors()) {
	                // Create new entity (if not any)
    	            $cartLogEnt = $this->_repoCartLog->fetchNew();
    	            // Fill entity data 
    	            $cartLogEnt->setFromArray(array_merge($formValues, array(
    	            	'cart_id' => $entity->id,
    	                'create_account_id' => $this->_authIdentity->id,
    	            )));
    	            // +++ Get last insert id (if any)
    	            $cartLogId = $cartLogEnt->save();
					
					// Reupdate cart's process status
					$entity->process_status = $cartLogEnt->process_status;
					$entity->process_log = $cartLogEnt->content;
					$entity->save();
					
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
	    }
		
		// Render view
	    $this->view->assign(array_merge($vData, array(
	    // +++ Controller options
	    	'contOpts' => $options,
	    // +++ Entity data
	    	'entity' => $entity
		)));
		// +++ Render script
		$this->renderScript('cart/update.phtml');
	}
	
	/**
	 * Action: view detail;
	 * @return void 
	 */
	public function detailAction() 
	{
		// Get params
		// +++ Data ID;
		$id = $this->_getParam('id');
		
		// Define data
		$vData = array();
		
		// Fetch data
		$entity = $this->_repo->fetchRow(array(
			'id = ?' => $id
		));
		
		// Check data valid?
		if (!$entity) {
			throw new Exception($this->view->translate('Data not found!'), 500);
		}
		
		// Define var # form;
	    $vData['form'] = $form = new Product_Form_Cart_Crud(array(
	    // +++ Controller's options
	    	'controllerOptions' => $this->_options
		));
		foreach ($form->getElements() as $ele) {
			$ele->setAttrib('disabled', 'disabled');
		}
		unset($ele);
		// +++ Fill form's data
		$form->populate($entity->toArray());
		
		// Render view
	    $this->view->assign(array_merge($vData, array(
	    // +++ Controller options
	    	'contOpts' => $options,
	    // +++ Entity data
	    	'entity' => $entity
		)));
		// +++ Render script
		$this->renderScript('cart/detail.phtml');
	}
}