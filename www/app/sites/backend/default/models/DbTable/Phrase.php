<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Phrase extends K111_Db_Table
{
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_phrase';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'phr_id';
    
	/**
     * Classname for rowset
     * @var string
     */
    protected $_rowsetClass = 'Default_Model_DbTable_Rowset_Phrase';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Default_Model_DbTable_Row_Phrase';
    
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
        $select = $this->select()
			->from($this->_name)
		;
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ keyword
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
		// +++ code?
		$options['code'] = array_filter((array)($options['code']));
        if (!empty($options['code'])) {
            $select
                ->where('code IN (?)', $options['code'])
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
// +++ End.Repo helpers

	/**
	 * 
	 */
	public function fetchDecodedData($context, $relId, $lang = null, array $options = array()) {
		// Build selector 
		$select = $this->buildFetchDataSelector(array(
			'context' => $context,
			'rel_id' => $relId,
			'lang' => $lang
		));
		
		// Fetch data
		$rows = $this->fetchAll($select);
		
		// Format output
		$data = array();
		foreach ($rows as $row) {
			$data[$row->context][$row->rel_id][$row->lang] = $row->data;
		}
		$data = (!is_array($context) && $context) ? $data[$context] : $data; 
		
		// Return
		return $data; 
	}
}