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
	    //phpinfo();die();
	}
	
	/**
	 *
	 */
	public function createAction()
	{
	    $dbTblGroup = new Default_Model_DbTable_Group();
	    
	    
	    $groupRSet = $dbTblGroup->fetchAll();
	    
	    $groupRow = $groupRSet->current();
	    
	    $accountRow = $groupRow->findParentRowByRule('Creator');
	    
	    
	    \Zend_Debug::dump($groupRow->code);
	    
	    \Zend_Debug::dump($accountRow);
	    die();
	    
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