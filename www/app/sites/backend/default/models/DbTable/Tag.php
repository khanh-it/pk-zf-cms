<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Tag extends K111_Db_Table
{
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_tag';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'id';
    
	/** @var string Classname for rowset */
    //protected $_rowsetClass = '';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Default_Model_DbTable_Row_Tag';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Default_Model_DbTable_TagItem'
	);
    
// +++ Repo helpers
    /**
     * Build fetch all data selector
	 * 
	 * @param $options array An array of options
	 * @param $order array Order array
	 * @return Zend_Db_Table_Selector
     */
    public function buildFetchDataSelector(array $options = array(), array $order = array()) {
        // Get selector object
        $select = $this->select()
			->from($this->_name)
		;
		$bind = $select->getBind();
        
        // Filter data;
        $dbA = $select->getAdapter();
		// +++ keyword
        $options['keyword'] = trim($options['keyword']);
        if ($options['keyword']) {
        	$bind['keyword'] = "%{$options['keyword']}%";
            $select->where(implode(' OR ', array(
                '(' . $dbA->quoteIdentifier('name') . ' LIKE :keyword)',
                '(' . $dbA->quoteIdentifier('alias') . ' LIKE :keyword)'
            )));
        }
        // +++ name?
        $options['name'] = array_filter((array)($options['name']));
        if (!empty($options['name'])) {
            $select->where('name IN (?)', $options['name']);
        }
		// +++ Bind filter data 
		$select->bind($bind);
        //die($select);
        
        // Return;
        return $select;
    }
// +++ End.Repo helpers
}