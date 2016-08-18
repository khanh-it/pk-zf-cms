<?php
/**
 */
class Product_Model_DbTable_Category extends Category_Model_DbTable_Category
{
	/**
	 * Default category's type
	 */
	protected $_defaultType = 'PRODUCT';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Product_Model_DbTable_Row_Category';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Product_Model_DbTable_Category',
		'Product_Model_DbTable_CategoryEntry',
		'Product_Model_DbTable_ProductCategory'
	);
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Parent' => array(
            'columns' => 'parent_id',
            'refTableClass' => 'Product_Model_DbTable_Category',
            'refColumns' => array('id')
        ),
        'Creator' => array(
            'columns' => 'create_account_id',
            'refTableClass' => 'Default_Model_DbTable_Account',
            'refColumns' => array('id')
        ),
        'LastModifier' => array(
            'columns' => 'last_modified_account_id',
            'refTableClass' => 'Default_Model_DbTable_Account',
            'refColumns' => array('id')
        )
    );
// +++ Repo helpers

// +++ End.Repo helpers
}