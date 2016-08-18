<?php
/**
 */
class Product_Model_DbTable_ProductCategory extends Category_Model_DbTable_Category
{
	/**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_product_category';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'id';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Product_Model_DbTable_Row_ProductCategory';
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Category' => array(
            'columns' => 'category_id',
            'refTableClass' => 'Product_Model_DbTable_Category',
            'refColumns' => array('id')
        ),
        'Product' => array(
            'columns' => 'product_id',
            'refTableClass' => 'Product_Model_DbTable_Product',
            'refColumns' => array('id')
        )
    );
	
// +++ Repo helpers
	/**
	 * Insert product - category data
	 * 
	 * @param $productId int|string Product's id 
	 * @param $categoryId int|string Category's id
	 * @param $options array An array of options
	 * @return array
	 */
	public function insertProductCategory($productId, $categoryId = null, array $options = array()) {
		// Format data
		$data = array();
		if (is_array($productId) && is_null($categoryId)) {
			$data = $productId;
		} else {
			$data[$productId] = $categoryId;
		}
		
		// Return data
		$return = array();
		
		// Clean old data?
		if ($options['clean_old_product_data']) {
			$this->delete(array(
				'product_id IN (?)' => array_keys($data)
			));
		}
		
		// Loop, insert (or update) data
		if (!empty($data)) {
			foreach ($data as $productId => $categoryId) {
				// Format category id
				$categoryId = array_filter(
					is_array($categoryId) ? $categoryId : (array)$categoryId
				);
				if (!empty($categoryId)) {
					foreach ($categoryId as $cId) {
						// Insert data (if not any)
						$row = $this->fetchRow(array(
							'product_id = ?' => $productId,
							'category_id = ?' => $cId
						));
						if (!$row) {
							$row = $this->createRow(array(
							// +++ Product 
								'product_id' => $productId,
							// +++ Category
								'category_id' => $cId,
							// +++ Creator
								'create_account_id' => $options['create_account_id']
							));
							$row->save();
						}
						// 
						$return[] = $row;
					}
				}
			}
		}
		
		// Return
		return $return;
	}
// +++ End.Repo helpers
}