<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Account extends K111_Db_Table_Row_BitStat
{
	/**
	 * Check group_id data valid?
	 * @param $groupId int|string Group id
	 * @return this
	 */
	public function setGroup_id($groupId) {
		// Format input
		$this->group_id = ('' == (string)$groupId) ? null : $groupId;

		return $this;
	}
	
	/**
	 * Return account's avatar uploaded web path
	 * 
	 * @param $avatar string Account's avatar
	 * @return string
	 */
	public function returnAvatarWebPath() {
		return Default_Model_DbTable_Account::returnAvatarWebPath($this->avatar);
	}
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{
	    // Set default data
	    // +++ 
	    $date = new DateTime();
	    $this->created_time = $date->format('Y-m-d H:i:s');
	}
}