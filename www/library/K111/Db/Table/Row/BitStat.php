<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Db
 * @subpackage K111_Db_Table_Row
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * @category   K111
 * @package    K111_Db
 * @subpackage K111_Db_Table_Row
 * @copyright  Free
 * @license    
 */
class K111_Db_Table_Row_BitStat extends K111_Db_Table_Row_Abstract
{
    /**
     * @var int (zero)
     */
    const STAT_YES = 1;
    /**
     * @var int (one)
     */
    const STAT_NO = 0;
    
    /**
     * Return bit stat
     * @return array
     */
    public static function returnBitStats() {
        return array(
            self::STAT_YES => 'Yes',
            self::STAT_NO => 'No'
        );
    }
}