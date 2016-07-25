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
    public static function returnBitStats(array $options = array()) {
        $return = array(
            self::STAT_YES => 'Yes',
            self::STAT_NO => 'No'
        );
		if ($options['prepend_label'] || $options['append_label']) {
			foreach ($return as $key => $value) {
				$return[$key] = ($options['prepend_label'] ? "{$options['prepend_label']} " : '') 
	            	. $value . ($options['append_label'] ? " {$options['append_label']}" : '')
	            ;
			}
		}
		
		return $return;
    }
}