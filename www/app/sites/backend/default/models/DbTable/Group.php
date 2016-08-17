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
     * Reference map
     */
    protected $_referenceMap = array(
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
		$bind = $select->getBind();
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ keyword
        $options['keyword'] = trim($options['keyword']);
        if ($options['keyword']) {
        	$bind['keyword'] = "%{$options['keyword']}%";
            $select->where(implode(' OR ', array(
                '(' . $dbA->quoteIdentifier('code') . ' LIKE :keyword)',
                '(' . $dbA->quoteIdentifier('name') . ' LIKE :keyword)'
            )));
        }
		// +++ code?
		$options['code'] = array_filter((array)($options['code']));
        if (!empty($options['code'])) {
            $select->where('code IN (?)', $options['code']);
        }
		// +++ active?
        $options['active'] = trim($options['active']);
        if ('' != $options['active']) {
            $select->where('active = ?', $options['active']);
        }
		// +++ Bind filter data 
		$select->bind($bind);
        //die($select);
        
        // Return;
        return $select;
    }

	/**
	 * Check data exist by code
	 * 
	 * @param $code string Code
	 * @param $options array An array of options
	 * @return bool
	 */
	public function checkExistsByCode($code, array $options = array()) {
		// Where
		$where = array(
        	'code = ?' => $code
		);
		// +++ 
		$options['exclude_id'] = array_filter((array)$options['exclude_id']);
		if (!empty($options['exclude_id'])) {
			$where['id NOT IN (?)'] = $options['exclude_id'];
		}
		
		// Return;
		return !!$this->fetchRow($where);
	}
	
	/**
	 * Fetch all built in groups
	 * 
	 * @return array
	 */
	public function fetchBuiltInGroups() {
		// Where?
		$where = array(
        	'code IN (?)' => Default_Model_DbTable_Row_Group::returnBuiltInGroupsCode()
		);
		
		// Return;
		return $this->fetchAll($where);
	}
	
	/**
	 * Fetch options
	 * 
	 * @return array
	 */
	public function fetchOptions(array $options = array(), array $order = array()) {
		// Call helper, build selector
		$selector = $this->buildFetchDataSelector($options, $order);
		// +++ Reset query parts, re init
		$selector
			->reset(Zend_Db_Select::COLUMNS)
			->columns(array(
				'id', 
				is_null($options['include_code']) ? 'name'
				: (true === $options['include_code']
					? 'CONCAT(name, " [", code, "]")'
					: 'CONCAT("[", code, "] ", name)'
				)
			))
		;
		// Fetch data
		$return = $this->getAdapter()->fetchPairs($selector);
		
		// Return;
		return $return;
	}
// +++ End.Repo helpers
}