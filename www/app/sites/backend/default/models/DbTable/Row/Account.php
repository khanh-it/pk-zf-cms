<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Account extends K111_Db_Table_Row_BitStat
{
	/**
	 * Encode password
	 * @param $password string Password
	 * @return this
	 */
	public function setPassword($password) {
		// Format input
		$this->modifyData('password', md5($password));

		return $this;
	}
	
	/**
	 * Check group_id data valid?
	 * @param $groupId int|string Group id
	 * @return this
	 */
	public function setGroup_id($groupId) {
		// Format input
		$this->modifyData('group_id', ('' == (string)$groupId) ? null : $groupId);

		return $this;
	}
	
	/**
	 * Get settings
	 * @return mixed
	 */
	public function getSettings($decode = false) {
		$settings = $this->_data['settings'];
		if ($decode && is_string($settings)) {
			$settings = @unserialize($settings);
			$settings = (false === $settings) ? array() : (array)$settings;
			if (is_string($decode)) {
				$settings = $settings[$decode];
			}
		}
		return $settings;
	}
	
	/**
	 * Set settings
	 * 
	 * @param $settings array|string Settings
	 * @param $key string Data key
	 * @return mixed
	 */
	public function setSettings($settings, $key = null) {
		if ($key) {
			$_settings = (array)$this->getSettings(true);
			$_settings[$key] = $settings;
			$settings = $_settings;
		}
		$settings = is_array($settings) ? serialize($settings) : $settings;
		$this->modifyData('settings', $settings);
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
	    if ($this->isClean()) {
		    // +++ 
		    $date = new DateTime();
		    $this->created_time = $date->format('Y-m-d H:i:s');
		}
	}
}