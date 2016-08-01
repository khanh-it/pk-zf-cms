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
class K111_Filter_NoSpecialChar implements Zend_Filter_Interface {
	/**
	 * @var array 
	 */
	protected $_chars = array("`", "~", "!", "@", "#", "$", "%", "^", "&", "*", "+", "(", ")", "|", "{", "}", "[", "]", "\\", "'", "\"", "/", ",", ".");

	/**
	 * (non-PHPdoc)
	 * @see Zend_Filter_Interface::filter()
	 * 
	 * @param string $value Filter value
	 * @param string $replacement Replacement char for special char
	 * @return string 
	 */
	public function filter($value, $replacement = '') {
		return str_replace($this->_chars, $replacement, $value);
	}
}