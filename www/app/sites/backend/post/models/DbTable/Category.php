<?php
/**
 */
class Post_Model_DbTable_Category extends Category_Model_DbTable_Category
{
	/**
	 * Default category's type
	 */
	protected static $_defaultType = 'POST';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Post_Model_DbTable_Row_Category';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Post_Model_DbTable_Category',
		'Post_Model_DbTable_CategoryEntry'
	);
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Parent' => array(
            'columns' => 'parent_id',
            'refTableClass' => 'Post_Model_DbTable_Category',
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