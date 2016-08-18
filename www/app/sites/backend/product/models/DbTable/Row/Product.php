<?php
/**
 * 
 * @author khanhdtp
 */
class Product_Model_DbTable_Row_Product extends K111_Db_Table_Row_BitStat
{
	/**
	 * Check code
	 * @param $code string Product's code
	 * @return this
	 */
	public function setCode($code) {
		// Format input
		$this->modifyData('code', ('' == (string)$code) ? null : $code);

		return $this;
	}
	
	/**
	 * Check sku
	 * @param $sku string Product's sku
	 * @return this
	 */
	public function setSku($sku) {
		// Format input
		$this->modifyData('sku', ('' == (string)$sku) ? null : $sku);

		return $this;
	}
	
	/**
	 * Check price
	 * @param $price double|string Product's price
	 * @return this
	 */
	public function setPrice($price) {
		// Format input
		$this->modifyData('price', (($price = doubleval($price)) <= 0) ? 0 : $price);

		return $this;
	}
	
	/**
	 * Check price dropped
	 * @param $price double|string Product's price
	 * @return this
	 */
	public function setPrice_dropped($price) {
		// Format input
		$this->modifyData('price_dropped', (($price = doubleval($price)) <= 0) ? 0 : $price);

		return $this;
	}
	
	/**
	 * Find current row's dependent product entry (phrase) data
	 * 
	 * @param $lang string Language string
	 * @return array
	 */
	public function findChildrenEntry($lang = null) {
		// 
		$rows = $this->findDependentRowset('Product_Model_DbTable_ProductEntry', 'Product');
		// Return;
		return $rows->getGroupedData(
			Product_Model_DbTable_Product::PHRASE,
			$this->_data['id'],
			$lang
		);
	}
	
	/**
	 * Find current row's dependent tag item dta
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract|array
	 */
	public function findChildrenTagItem() {
		// Fetch data
		$rows = $this->findDependentRowset('Product_Model_DbTable_TagItem', 'Product');
		
		// Return;
		return $rows->getGroupedData(
			Product_Model_DbTable_Product::TAG,
			$this->_data['id']
		);
	}
	
	/**
	 * Find current row's dependent product category data
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract|array
	 */
	public function findChildrenProductCategory() {
		// Fetch data
		$rows = $this->findDependentRowset('Product_Model_DbTable_ProductCategory', 'Product');
		
		// Return data
		$return = array();
		foreach ($rows as $row) {
			$return[$row->category_id] = $row->findParentCategory();
		}
		
		// Return;
		return $return;
	}
	
	/**
	 * Return account's avatar uploaded web path
	 * 
	 * @param $type string Product's type
	 * @return string
	 */
	public function returnImgsWebPath($type = null) {
		return Product_Model_DbTable_Product::returnImgsWebPath(
			$this->imgs, $type ?: $this->getTable()->getDefaultType()
		);
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
		$this->modifyData('phrase', Product_Model_DbTable_Product::PHRASE);
		// +++ Always use default tag context!
		$this->modifyData('tag', Product_Model_DbTable_Product::TAG);
	}
}