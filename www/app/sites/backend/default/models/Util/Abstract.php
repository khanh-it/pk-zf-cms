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
	
	/**
	 * @var array An array of class/child class instances
	 */
	protected static $_instances = array();
	
	/**
	 * Helper, get class/child class instance
	 * 
	 * @return void 
	 */
	public static function getInstance() {
		// Get class/child class
		$class = get_called_class();
		
		// Get class/child class instance
		$instance = self::$_instances[$class];
		if (!$instance) {
			self::$_instances[$class] = ($instance = new $class());
		}
		
		// Return;
		return $instance;
	}
}