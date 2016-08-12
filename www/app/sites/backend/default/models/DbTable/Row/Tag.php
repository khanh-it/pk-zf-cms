<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Tag extends K111_Db_Table_Row_Abstract
{
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{
		// Set default data
	    if ($this->isClean()) {
			$date = new DateTime();
		    // +++
		    $this->created_time = $date->format('Y-m-d H:i:s');
	    }
	}
}