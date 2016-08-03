<?php
/**
 * 
 */
abstract class Default_Model_Util_Abstract
{
	/**
	 * @var array options
	 */
	protected $_options;
	
	/**
	 * Set options
	 * 
	 * @param array $options An array of options
	 * @return this
	 */
	public function setOptions(array $options) {
		// Set options
		$this->_options = $options;
		
		return $this;
	}
}