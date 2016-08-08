<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Rowset_Phrase extends K111_Db_Table_Rowset_Abstract
{
	/**
	 * @var array Grouped data 
	 */
	protected $_groupedData = array();
	
	/**
	 * @var array Grouped data row
	 */
	protected $_groupedDataRow = array();
	
    /**
     * Initialize object
     *
     * @return void
     */
    public function init()
    {
    	// Pre format data
    	foreach ($this as $row) {
    		$this->_groupedData[$row->phr_context]
    			[$row->phr_rel_id]
    			[$row->phr_lang]
    			[$row->phr_column] = $row->phr_data;
			;
			$this->_groupedDataRow[$row->phr_context]
    			[$row->phr_rel_id]
    			[$row->phr_lang]
    			[$row->phr_column] = $row;
			;
		}
    }
	
	/**
	 * Get data grouped
	 * 
	 * 
	 */
	public function getGroupedData($context = null, $relId = null, $lang = null, array $options = array()) {
		// Format, + get options
		// +++ Get data only? 
		$options['get_data_only'] = !!($options['get_data_only'] ?: false);
			
		// Get data
		$data = $options['get_data_only'] 
			? $this->_groupedData
			: $this->_groupedDataRow
		;
		// +++ Filter by context
		if ($context) {
			$data = (array)$data[$context];
		}
		// +++ Filter by relative object's id
		if ($relId) {
			$data = (array)$data[$relId];
		}
		// +++ Filter by language
		if ($lang) {
			$data = (array)$data[$lang];
		}
		
		// Return;
		return $data;
	}
}