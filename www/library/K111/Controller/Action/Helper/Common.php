<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Controller_Action
 * @subpackage Helper
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * @category   K111
 * @package    K111_Controller_Action
 * @subpackage Helper
 * @copyright  Free
 * @license    
 */
class K111_Controller_Action_Helper_Common extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * @var K111_Filter_NoSpecialChar
	 */
	protected $_filterNoSpecialChar;
	
	/**
	 *
	 * @var ZF_Filter_Unicode
	 */
	protected $_filterNoMark;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		// @var K111_Filter_NoSpecialChar
		$this->_filterNoSpecialChar = new K111_Filter_NoSpecialChar();
		// @var K111_Filter_NoMark
		$this->_filterNoMark = new K111_Filter_NoMark();
	}
	
	/**
	 * Remove all special characters
	 * 
	 * @param string $value Filter string
	 * @param string $replacement Replacement char for special chars
	 * @return string
	 */
	public function noSpecialChar($value, $replacement = null) {
		return $this->_filterNoSpecialChar->filter($value, $replacement);
	}
	
	/**
	 * Create string alias
	 * 
	 * @param string $value Filter string
	 * @param string $replacement Replacement char for special chars        	
	 * @return string
	 */
	public function str2Alias($value, $replacement = '-') {
		return strtolower(str_replace(
			array(' '), 
			array($replacement), 
			$this->_filterNoSpecialChar->filter(
				$this->_filterNoMark->filter($value),
				$replacement
			)
		));
	}
	
	/**
	 * Get start time of day as tring
	 * @param int|string $time
	 */
	public function timeStartTimeOfDay($time) {
		if(is_string($time)) {
			$time = strtotime($time);
		}
		return mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time));
	}
	
	/**
	 * Get end time of day as string
	 * @param int|string $time
	 */
	public function timeEndTimeOfDay($time) {
		if(is_string($time)) {
			$time = strtotime($time);
		}
		return mktime(23, 59, 59, date('m', $time), date('d', $time), date('Y', $time));
	}
	
	/**
	 * Random string
	 * @param number $length
	 * @param bool $useSpecialChar
	 * @return string
	 */
	public function generateRandomString($length = 10, $useSpecialChar = false) {
	    $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" . ($useSpecialChar ?  '@#&*' : '');
	    return substr(str_shuffle($string), 0, $length);
	}
	
	/**
	 * Split words
	 * 
	 * @param string $string String of words
	 * @param int $limit Limit number of words will return
	 * @return string
	 */
	public function splitWord($string = '', $limit = 255) {
        $strArr = preg_split('/\s+/', $string, $limit);
        if (count($strArr) > 0){
	        array_pop($strArr);
	        return implode(' ', $strArr);
        }
	    return $string;
	}
	
	/**
	 * Number format based on locale
	 * 
	 * @param $number int|double Number to format
	 * @param decimals int[optional] Sets the number of decimal points. 
	 * @return string
	 */
	public function numberFormat($number, $decimals = null) {
		return number_format($number, $decimals);
	} 
}