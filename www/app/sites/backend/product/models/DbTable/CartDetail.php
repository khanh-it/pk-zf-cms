<?php
/**
 */
class Product_Model_DbTable_CartDetail extends K111_Db_Table
{
	/**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_cart_detail';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'id';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Product_Model_DbTable_Row_CartDetail';
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Cart' => array(
            'columns' => 'cart_id',
            'refTableClass' => 'Product_Model_DbTable_Cart',
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
	 * Insert cart - detail data
	 * 
	 * @param $cartId int|string Product's id 
	 * @param $productId int|string Category's id
	 * @param $options array An array of options
	 * @return array
	 */
	public function insertCartDetail($cartId, $productId = null, array $options = array()) {
		// Format data
		$data = array();
		if (is_array($cartId) && is_null($productId)) {
			$data = $cartId;
		} else {
			$data[$cartId] = $productId;
		}
		
		// Return data
		$return = array();
		
		// Loop, insert (or update) data
		if (!empty($data)) {
			foreach ($data as $cartId => $productId) {
				// Format product id
				$productId = array_filter(
					is_array($productId) ? $productId : (array)$productId
				);
				if (!empty($productId)) {
					foreach ($productId as $pId) {
						// Insert data (if not any)
						$row = $this->fetchRow(array(
							'cart_id = ?' => $cartId,
							'product_id = ?' => $pId
						));
						if (!$row) {
							$row = $this->createRow(array(
							// +++ Cart
								'cart_id' => $cartId,
							// +++ Product
								'product_id' => $pId,
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