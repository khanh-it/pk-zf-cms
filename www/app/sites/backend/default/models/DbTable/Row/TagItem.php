<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_TagItem extends K111_Db_Table_Row_BitStat
{
	/**
	 * Find current row's parent row
	 * 
	 * @return Default_Model_DbTable_Row_Tag|null
	 */
	public function findParentTag() {
		return $this->findParentRowByRule('Tag');
	}
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{}
}