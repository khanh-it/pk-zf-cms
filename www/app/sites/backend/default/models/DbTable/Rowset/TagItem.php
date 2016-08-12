<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Rowset_TagItem extends K111_Db_Table_Rowset_Abstract
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
    		$this->_groupedData[$row->context][$row->item_id][$row->tag_id] = $row->findParentTag();
		}
    }
	
	/**
	 * Get data grouped
	 * 
	 * @param $context string Context string
	 * @param $itemId int|string Entity relative id
	 * @param $tagId int|string Tag's id
	 * @param $options array An array of options
	 * @return array  
	 */
	public function getGroupedData($context = null, $itemId = null, $tagId = null, array $options = array()) {
		// Format, + get options
			
		// Filter
		$data = $this->_groupedData;
		// +++ Filter by context
		if ($context) {
			$data = (array)$data[$context];
		}
		// +++ Filter by item object's id
		if ($itemId) {
			$data = (array)$data[$itemId];
		}
		// +++ Filter tag id
		if ($tagId) {
			$data = (array)$data[$tagId];
		}
		
		// Return;
		return $data;
	}
}