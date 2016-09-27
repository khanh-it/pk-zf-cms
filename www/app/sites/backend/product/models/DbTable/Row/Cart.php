<?php
/**
 * 
 * @author khanhdtp
 */
class Product_Model_DbTable_Row_Cart extends K111_Db_Table_Row_Abstract
{
	/**
	 * Find current row's parent row Creator
	 * 
	 * @return Default_Model_DbTable_Row_Account|null
	 */
	public function findParentCreator() {
		return $this->findParentRowByRule('Creator');
	}
	
	/**
	 * Find current row's dependent cart details data
	 * 
	 * @return array
	 */
	public function findChildrenCartDetails() {
		// Return 
		return $rows = $this->findDependentRowset('Product_Model_DbTable_CartDetail', 'Cart');
	}
	
	/**
	 * Find current row's dependent cart logs data
	 * 
	 * @return array
	 */
	public function findChildrenCartLogs() {
		// Return 
		return $rows = $this->findDependentRowset('Product_Model_DbTable_CartLog', 'Cart');
	}
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{
		return parent::init();
	}
}