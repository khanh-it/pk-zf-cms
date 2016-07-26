<?php
/**
 */
class Default_Model_DbTable_Account extends K111_Db_Table
{
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
     * Reference map
     */
    protected $_referenceMap = array(
        'Group' => array(
            'columns' => 'group_id',
            'refTableClass' => 'Default_Model_DbTable_Group',
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
    /**
     * Build fetch all data selector
	 * 
	 * @param array $options An array of options
	 * @param array $order Order array
	 * @return Zend_Db_Table_Selector
     */
    public function buildFetchDataSelector(array $options = array(), array $order = array()) {
        // 
        $select = $this->select();
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ keyword
        $options['keyword'] = trim($options['keyword']);
        if ($options['keyword']) {
            $subOrWhere = array(
                '(' . $dbA->quoteIdentifier('username') . ' LIKE :keyword)',
                '(' . $dbA->quoteIdentifier('fullname') . ' LIKE :keyword)'
            );
            $select
                ->where(implode(' OR ', $subOrWhere))
                ->bind(array(
                    'keyword' => "%{$options['keyword']}%"
                ))
            ;
        }
		// +++ active?
        $options['active'] = trim($options['active']);
        if ('' != $options['active']) {
            $select
                ->where('active = :active', $options['active'])
                ->bind(array(
                    'active' => $options['active']
                ))
            ;
        }
        
        // Return;
        return $select;
    }

	/**
	 * Check data exist by username
	 * 
	 * @param $username string Username
	 * @param $options array An array of options
	 * @return bool
	 */
	public function checkExistsByUsername($username, array $options = array()) {
		//
		$where = array(
        	'username = ?' => $username
		);
		// +++ 
		$options['exclude_id'] = array_filter((array)$options['exclude_id']);
		if ($options['exclude_id']) {
			$where['id NOT IN (?)'] = $options['exclude_id'];
		}
		
		// Return;
		return !!$this->fetchRow($where);
	}
// +++ End.Repo helpers
}