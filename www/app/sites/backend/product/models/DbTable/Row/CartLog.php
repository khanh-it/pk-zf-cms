<?php
/**
 * 
 * @author khanhdtp
 */
class Product_Model_DbTable_Row_CartLog extends K111_Db_Table_Row_Abstract
{
	/**
	 * Find current row's parent row cart
	 * 
	 * @return Product_Model_DbTable_Row_Cart|null
	 */
	public function findParentCart() {
		return $this->findParentRowByRule('Cart');
	}
	
	/**
	 * Find current row's parent row creator
	 * 
	 * @return Default_Model_DbTable_Row_Account|null
	 */
	public function findParentCreator() {
		return $this->findParentRowByRule('Creator');
	}
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{
	    // Set default data
	    if ($this->isClean()) {
		    // +++ 
		    $date = new DateTime();
			$this->modifyData('created_time', $date->format('Y-m-d H:i:s'));
		}
	}
}