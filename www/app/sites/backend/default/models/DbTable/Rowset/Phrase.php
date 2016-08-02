<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Rowset_Phrase extends K111_Db_Table_Rowset_Abstract
{
	/**
	 * @var array Language data 
	 */
	protected $_langData = array();
	
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
    			[$row->phr_lang] = (array)$row->getPhr_data();
			;
		}
    }
	
	/**
	 * 
	 * 
	 */
	public function getPhrData($context, $relId, $lang = null) {
		// Get data
		$data = $this->_langData;
		// +++ 
		if ($context) {
			$data = (array)$data[$context];
		}
		if ($relId) {
			$data = (array)$data[$relId];
		}
		
		return $lang ? $data[$lang] : $data;
	}
}