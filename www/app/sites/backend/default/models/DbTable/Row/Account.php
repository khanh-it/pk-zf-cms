<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Account extends K111_Db_Table_Row_BitStat
{
    /**
     * @var string A built-in group code
     */
    const BIG_ADMIN = 'ADMIN';
    /**
     * @var array An array of built-in groups
     */
    public static function returnBuiltInGroups() {
        return array(
            self::BIG_ADMIN 
        );
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