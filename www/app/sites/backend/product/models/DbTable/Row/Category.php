<?php
/**
 * 
 * @author khanhdtp
 */
class Product_Model_DbTable_Row_Category extends Category_Model_DbTable_Row_Category
{
	/**
	 * Find current row's dependent category rowset
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function findChildrenCategory() {
		return $this->findDependentRowset('Product_Model_DbTable_Category', 'Parent');
	}
	
	/**
	 * Find current row's dependent category entry rowset
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function findChildrenEntry($lang = null) {
		// 
		$rows = $this->findDependentRowset('Product_Model_DbTable_CategoryEntry', 'Category');
		// Return;
		return $rows->getGroupedData(Product_Model_DbTable_Category::PHRASE, $this->_data['id'], $lang);
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