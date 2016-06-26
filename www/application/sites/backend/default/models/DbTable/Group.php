<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Group extends K111_Db_Table
{
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_group';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'id';
    
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Default_Model_DbTable_Row_Group';
    
    /**
     * Classname for rowset
     * @var string
     */
    protected $_rowsetClass = 'Default_Model_DbTable_Rowset_Group';
    
    /**
     * @var int 1 (active yes)
     */
    const ACTIVE_YES = 1;
    /**
     * @var int 1 (active no)
     */
    const ACTIVE_NO = 0;
    
    
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Creator' => array(
            'columns' => 'create_account_id',
            'refTableClass' => 'Default_Model_DbTable_Account',
            'refColumns' => array('id')
        )
    );

// +++ Repo helpers

    
// +++ End.Repo helpers
}