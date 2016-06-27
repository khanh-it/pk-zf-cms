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
		$date = Zend_Date::now();
		
	    //phpinfo();die();
	    
	    $groupDbTable = new Default_Model_DbTable_Group();
		
		$groupRow = $groupDbTable->fetchRow(array(
			'code = ?' => 'ADMIN'
		));
		
		var_dump($date->get('YYYY-MM-dd HH:mm:ss'));
		
	    die('test');
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