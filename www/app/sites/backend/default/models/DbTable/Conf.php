<?php
/**
 */
class Default_Model_DbTable_Conf extends K111_Db_Table
{
	/**
	 * @var string Input mode: plaintext 
	 */
	const INPUT_PLAINTEXT = 'plaintext';
	/**
	 * @var string Input mode: html 
	 */
	const INPUT_HTML = 'html';
	/**
	 * Get input modes
	 * @return array
	 */
	public static function returnInputs() {
		return array(
			self::INPUT_PLAINTEXT => 'PlainText',
			self::INPUT_HTML => 'Html',
		);
	}
	
	/**
	 * @var string 
	 */
	const PHRASE = 'CONF';
	
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_conf';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = array('id', 'phrase');
	/**
     * The primary values.
     * @var mixed
     */
    protected $_primaryValues = array(null, 'CONF');
    
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Default_Model_DbTable_Row_Conf';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Default_Model_DbTable_Conf',
		'Default_Model_DbTable_ConfEntry'
	);
	
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
	
	/**
	 * Default conf's group
	 */
	protected $_defaultGroup;
	/**
	 * Get default conf's group
	 * 
	 * @return string Conf group
	 */
	public function getDefaultGroup() {
		// Return;
		return $this->_defaultGroup;
	} 
	/**
	 * Set default conf's group
	 * 
	 * @param $group string Conf group
	 * @return void
	 */
	public function setDefaultGroup($group) {
		$this->_defaultGroup = (string)$group;
		// Return;
		return $this;
	}
	
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
		// +++ id?
		$options['exclude_id'] = array_filter((array)($options['exclude_id']));
        if (!empty($options['exclude_id'])) {
            $select->where($dbA->quoteIdentifier('id') . ' NOT IN (?)', $options['exclude_id']);
        }
		// +++ code
        $options['code'] = trim($options['code']);
        if ($options['code']) {
			$select->where($dbA->quoteIdentifier('code') . ' = ?', $options['code']);
        }
		// +++ name
        $options['name'] = trim($options['name']);
        if ($options['name']) {
			$select->where($dbA->quoteIdentifier('name') . ' = ?', $options['name']);
        }
		// +++ group?
        $options['group'] = array_filter(
        	(array)($options['group'] ?: $this->_defaultGroup)
		);
        if (!empty($options['group'])) {
            $select->where($dbA->quoteIdentifier('group') . ' IN (?)', $options['group']);
        }
		// +++ Bind filter data 
		$select->bind($bind);
        //die($select);
        
        // Return;
        return $select;
    }

	/**
	 * Fetch data as key/value pair by group, code
	 * 
	 * @param $code string Config code
	 * @param $group string Group name
	 * @param $options array An array of options
	 * @return bool
	 */
	public function fetchPair($code, $group = null, array $options = array()) {
		// Format input 
		$group = $group ?: $this->getDefaultGroup();
		// Where
		$where = array(
		// ++++ code?
			'code' => $code,
		// +++ group?
			'group' => $group
		);
		// +++ exclude_id?
		$options['exclude_id'] = array_filter((array)$options['exclude_id']);
		if (!empty($options['exclude_id'])) {
			$where['exclude_id'] = $options['exclude_id'];
		}
		
		// Build selector
		$sql = $this->buildFetchDataSelector($where);
		$sql->colums(array('code', 'value'));
		
		// Return
		return $this->_db->fetchPairs($sql);
	}
	
	/**
	 * Check data exist by code
	 * 
	 * @param $code string Code
	 * @param $group string Group name
	 * @param $options array An array of options
	 * @return bool
	 */
	public function checkExistsByCode($code, $group, array $options = array()) {
		// Where
		$where = array('code' => $code, 'group' => $group);
		// +++ exclude_id?
		$options['exclude_id'] = array_filter((array)$options['exclude_id']);
		if (!empty($options['exclude_id'])) {
			$where['exclude_id'] = $options['exclude_id'];
		}
		
		// Build selector
		$sql = $this->buildFetchDataSelector($where);
		//die($sql);
		
		// Return
		return !!$this->_db->fetchRow($sql);
	}
// +++ End.Repo helpers
}