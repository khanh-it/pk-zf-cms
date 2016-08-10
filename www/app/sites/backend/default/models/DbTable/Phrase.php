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
	 * @param $options array An array of options
	 * @param $order array Order array
	 * @return Zend_Db_Table_Selector
     */
    public function buildFetchDataSelector(array $options = array(), array $order = array()) {
        // Get selector object
        $select = $this->select()
			->from($this->_name)
		;
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ context?
        $options['phr_context'] = array_filter((array)($options['phr_context']));
        if (!empty($options['phr_context'])) {
            $select
                ->where('phr_context IN (?)', $options['phr_context'])
            ;
        }
		// +++ relative id(s)?
		$options['phr_rel_id'] = array_filter((array)($options['phr_rel_id']));
        if (!empty($options['phr_rel_id'])) {
            $select
                ->where('phr_rel_id IN (?)', $options['phr_rel_id'])
            ;
        }
		// +++ lang?
		$options['phr_lang'] = array_filter((array)($options['phr_lang']));
        if (!empty($options['phr_lang'])) {
            $select
                ->where('phr_lang IN ()', $options['phr_lang'])
            ;
        }
		// +++ colum?
		$options['phr_column'] = array_filter((array)($options['phr_column']));
        if (!empty($options['phr_column'])) {
            $select
                ->where('phr_column IN ()', $options['phr_column'])
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