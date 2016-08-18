<?php
/**
 * 
 * @author khanhdtp
 * @MCAInfo({
 	"name": "Tagging",
	"info": "Quản lý tag"
})
 */
class TagController extends K111_Controller_Action
{
	/**
	 * @var Default_Model_DbTable_Tag
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
		$this->_repo = new Default_Model_DbTable_Tag();
	}
	
	/**
	 * Action: list data;
	 * @MCAInfo({
 			"name" : "Index action",
			"info" : "List tag data"
		})
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
	    $vData['form'] = $form = new Default_Form_Tag_Index();
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
}