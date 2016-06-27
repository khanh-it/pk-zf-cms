<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Group extends K111_Db_Table_Row_Abstract
{
	/**
	 * 
	 */
	public function getCreated_time() {
		return $date = new Zend_Date();
	}
}