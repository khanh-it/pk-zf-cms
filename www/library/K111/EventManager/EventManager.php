<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * Helper find asset's path info.
 *
 * @category   K111
 * @package    K111
 * @copyright  Free
 * @license    
 */
class K111_EventManager_EventManager extends Zend_EventManager_EventManager
{
    /**
     * @var K111_EventManager_EventManager 
     */
    protected static $_instance;
    
    /**
     * Constructor
     */
    public function __construct() {
        if (!(true === self::$_instance)) {
            throw new K111_EventManager_Exception('Direct call to class\'s construct is not allowed. Use `getInstance` instead!');
        }
        
        return parent::__construct(__CLASS__);
    }
    
    /**
     * Get K111_EventManager_EventManager
     * @return K111_EventManager_EventManager
     */
    public static function getInstance() {
        if (!self::$_instance) {
            // Mark flag: construct is allowed. 
            self::$_instance = true;
            // Self construct
            self::$_instance = new self();
        }
        return self::$_instance;;
    }
}