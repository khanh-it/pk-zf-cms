<?php
/**
 * 
 * @author khanhdtp
 */
class Category_Model_DbTable_Row_Category extends K111_Db_Table_Row_BitStat
{
	/**
	 * @var array category types
	 */
	const TYPE_PRODUCT = 'PRODUCT';
	/**
	 * Return category's types
	 * @return array 
	 */
	public static function returnTypes() {
		$return = array(
			self::TYPE_PRODUCT => 'Product'
		);
		
		return $return;
	}
	
	/**
	 * Find current row's dependent category rowset
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function findChildrenCategory() {
		return $this->findDependentRowset('Category_Model_DbTable_Category', 'Parent');
	}
	
	/**
	 * Find current row's dependent category entry rowset
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function findChildrenEntry($lang = null) {
		// 
		$rows = $this->findDependentRowset('Category_Model_DbTable_CategoryEntry', 'Category');
		// Return;
		return $rows->getPhrData(
			Category_Model_DbTable_Category::PHRASE,
			$this->_data['id'],
			$lang
		);
	}
	
	/**
	 * Find current row's parent row
	 * 
	 * @return Category_Model_DbTable_Row_Category|null
	 */
	public function findParentCategory() {
		return $this->findParentRowByRule('Parent');
	}
	
	/**
	 * Return account's avatar uploaded web path
	 * 
	 * @param $avatar string Account's avatar
	 * @return string
	 */
	public function returnImgsWebPath() {
		return Category_Model_DbTable_Category::returnImgsWebPath($this->avatar);
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
			// +++ Type 
			$this->modifyData('type', $this->getTable()->getDefaultType());
		}
		// +++ Always use default phrase context!
		$this->modifyData('phrase', Category_Model_DbTable_Category::PHRASE);
	}
}