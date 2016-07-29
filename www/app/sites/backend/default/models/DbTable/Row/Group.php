<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Group extends K111_Db_Table_Row_BitStat
{
    /**
     * @var string A built-in group code
     */
    const BUILT_IN_ADMIN = 'ADMIN';
    /**
     * @var array An array of built-in groups code
     */
    public static function returnBuiltInGroupsCode() {
        return array(
            self::BUILT_IN_ADMIN
        );
    }
	/**
	 * Check if this current row (group) is built-in group? 
	 * @return bool
	 */
	public function isBuiltInGroup() {
		// Return
		return in_array($this->code, self::returnBuiltInGroupsCode());
	}
	
	/**
	 * Encode ACL data
	 * 
	 * @param array $aclData ACL Data
	 * @return string
	 */
	public static function encodeACLData($aclData) {
		return is_array($aclData) ? serialize((array)$aclData) : $aclData;
	}
	
	/**
	 * Decode ACL data
	 * 
	 * @param string $aclData ACL Data
	 * @return array
	 */
	public static function decodeACLData($aclData) {
		$return = (@unserialize((string)$aclData));
		return (false === $return) ? array() : $return;
	}
	
	/**
	 * Get acl (decoded)
	 * @return array
	 */
	public function getAcl() {
		if (is_string($this->_data['acl'])) {
			return self::decodeACLData((string)$this->_data['acl']);	
		}
		return $this->_data['acl']; 
	}
	
	/**
	 * Set acl (encode)
	 * 
	 * @param array|string $aclData ACL data
	 * @param string $site Site name
	 * @return array
	 */
	public function setAcl($acl, $site = null) {
		// Format input data;
		// +++ 
		$acl = is_array($acl) ? $acl : (array)$acl;
		// +++ 
		$site = trim($site);
		
		// Case set acl data by site?
		if ($site) {
			$aclData = $this->getAcl();
			$aclData[$site] = $acl;
			$acl = $aclData;
			unset($aclData);
		}
		// Encode data;
		if (is_array($acl)) {
			$acl = self::encodeACLData($acl);
		}
		$this->modifyData('acl', $acl);
				
		return $this;
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
			$date = new DateTime();
		    // +++
		    $this->created_time = $date->format('Y-m-d H:i:s');
	    }
	}
}