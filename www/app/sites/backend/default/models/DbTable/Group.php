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
    /**
     * 
     */
    public function buildFetchDataSelector(array $options = array(), array $order = array()) {
        // 
        $select = $this->select();
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ 
        $options['keyword'] = trim($options['keyword']);
        if ($options['keyword']) {
            $subOrWhere = array(
                '(' . $dbA->quoteIdentifier('code') . ' LIKE :keyword)',
                '(' . $dbA->quoteIdentifier('name') . ' LIKE :keyword)'
            );
            $select
                ->where(implode(' OR ', $subOrWhere))
                ->bind(array(
                    'keyword' => "%{$options['keyword']}%"
                ))
            ;
        }
        
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
		//
		$where = array(
        	'code = ?' => $code
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