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