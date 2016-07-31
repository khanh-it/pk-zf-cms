<?php
/**
 *  pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Filter
 * @subpackage 
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * @category   K111
 * @package    K111_Filter
 * @subpackage 
 * @copyright  Free
 * @license    
 */
class K111_Filter_ConvertCamelCase implements Zend_Filter_Interface
{

    /**
     * Defined by Zend_Filter_Interface
     *
     * Returns the string $value, converted from camel case to... 
     *
     * @param  string $value
	 * @param  string $joiner
     * @return string
     */
    public function filter($value, $joiner = '-')
    {
		return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1' . $joiner, $value));
	}
}