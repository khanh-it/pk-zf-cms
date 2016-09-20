<?php
/**
 */
class Product_Model_DbTable_CartLog extends Category_Model_DbTable_Category
{
	/**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_cart_log';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'id';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Product_Model_DbTable_Row_CartLog';
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Cart' => array(
            'columns' => 'cart_id',
            'refTableClass' => 'Product_Model_DbTable_Cart',
            'refColumns' => array('id')
        ),
        'Creator' => array(
            'columns' => 'create_account_id',
            'refTableClass' => 'Default_Model_DbTable_Account',
            'refColumns' => array('id')
        )
    );
	
// +++ Repo helpers
	
// +++ End.Repo helpers
}