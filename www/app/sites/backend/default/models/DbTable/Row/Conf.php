<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Conf extends K111_Db_Table_Row_Abstract
{
	/**
	 * Find current row's dependent conf entry rowset
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function findChildrenEntry($lang = null) {
		// 
		$rows = $this->findDependentRowset('Default_Model_DbTable_ConfEntry', 'Conf');
		// Return;
		return $rows->getGroupedData(
			Default_Model_DbTable_Conf::PHRASE,
			$this->_data['id'],
			$lang
		);
	}
	
	/**
	 * Is input mode `plaintext`?
	 * 
	 * @return bool
	 */
	public function isInputPlainText() {
		return (Default_Model_DbTable_Conf::INPUT_PLAINTEXT == $this->_data['input']);
	}
	/**
	 * Is input mode `html`?
	 * 
	 * @return bool
	 */
	public function isInputHtml() {
		return (Default_Model_DbTable_Conf::INPUT_HTML == $this->_data['input']);
	}
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{
	    // Set default data
	    if ($this->isClean()) {
		    // +++ 
		    $date = new DateTime();
			$this->modifyData('created_time', $date->format('Y-m-d H:i:s'));
			// +++ Group
			$this->modifyData('group', $this->getTable()->getDefaultGroup());
		}
		// +++ Always use default phrase context!
		$this->modifyData('phrase', Default_Model_DbTable_Conf::PHRASE);
	}
}