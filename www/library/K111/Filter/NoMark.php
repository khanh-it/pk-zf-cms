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
class K111_Filter_NoMark implements Zend_Filter_Interface {
	
	/**
	 * @var Special Vietnamese characters with marks
	 */
	protected $_chars = array(
		'a' => array('á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'), 
		'A' => array('Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ'), 
		'd' => array('đ'), 
		'D' => array('Đ'), 
		'e' => array('é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ề', 'ế', 'ể', 'ễ', 'ệ'), 
		'E' => array('É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ề', 'Ế', 'Ể', 'Ễ', 'Ệ'), 
		'i' => array('í', 'ì', 'ỉ', 'ĩ', 'ị'), 
		'I' => array('Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'), 
		'o' => array('ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'), 
		'O' => array('Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ'), 
		'u' => array('ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'), 
		'U' => array('Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự'), 
		'y' => array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'), 
		'Y' => array('Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ')
	);

	/**
	 * (non-PHPdoc)
	 *
	 * @see Zend_Filter_Interface::filter()
	 * @var string
	 * @return string
	 */
	public function filter($value) {
		// 
		foreach ($this->_chars as $key => $val) {
			$value = str_replace($val, $key, $value);
		}
		// Return;
		return $value;
	}
}