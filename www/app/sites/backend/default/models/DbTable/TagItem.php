<?php
/**
 */
class Default_Model_DbTable_TagItem extends K111_Db_Table
{
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_tag_item';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = array('tag_id', 'item_id', 'context');
	
	/** 
	 * @var string Classname for rowset 
	 */
    protected $_rowsetClass = 'Default_Model_DbTable_Rowset_TagItem';
	
    /** 
	 * @var string Classname for row 
	 */
    protected $_rowClass = 'Default_Model_DbTable_Row_TagItem';
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Tag' => array(
            'columns' => 'tag_id',
            'refTableClass' => 'Default_Model_DbTable_Tag',
            'refColumns' => 'id'
        ),
    );
	
// +++ Repo helpers
    /**
     * Build fetch all data selector
	 * 
	 * @param array $options An array of options
	 * @param array $order Order array
	 * @return Zend_Db_Table_Selector
     */
    public function buildFetchDataSelector(array $options = array(), array $order = array()) {
        // Init select
        $select = $this->select()
			->from($this->_name)
		;
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ keyword
        
        // Return;
        return $select;
    }
// +++ End.Repo helpers
}