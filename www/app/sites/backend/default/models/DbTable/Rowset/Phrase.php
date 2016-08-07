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
     * Initialize object
     *
     * @return void
     */
    public function init()
    {
    	// Pre format data
    	foreach ($this as $row) {
    		$this->_langData[$row->phr_context]
    			[$row->phr_rel_id]
    			[$row->phr_lang]
    			[$row->phr_column] = $row;
			;
		}
    }
	
	/**
	 * 
	 * 
	 */
	public function getGroupedData($context = null, $relId = null, $lang = null, array $options = array()) {
		// Get data
		$data = $this->_langData;
		// +++ 
		if ($context) {
			$data = (array)$data[$context];
		}
		// +++
		if ($relId) {
			$data = (array)$data[$relId];
		}
		// +++
		if ($lang) {
			$data = (array)$data[$lang];
		}
		
		// Get data only?
		if (true === $options['get_data_only']) {
			foreach ($data as $column => $_dat) {
				$data[$column] = $_dat->phr_data;
			}
		}
		
		// Return;
		return $data;
	}
}