<?php
/**
 */
class Default_Model_DbTable_Account extends K111_Db_Table
{
    /**
     * The table name.
     * @var string
     */
    const TBL_NAME = 'tbl_account';
    
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_account';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'id';
    
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Default_Model_DbTable_Row_Account';
    
    /**
     * Classname for rowset
     * @var string
     */
    protected $_rowsetClass = 'Default_Model_DbTable_Rowset_Account';
    
    /**
     * @var int 1 (active yes)
     */
    const ACTIVE_YES = 1;
}