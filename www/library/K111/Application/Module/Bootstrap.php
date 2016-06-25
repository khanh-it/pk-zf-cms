<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Application
 * @subpackage Module
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * Base bootstrap class for modules
 *
 * @category   K111
 * @package    K111_Application
 * @subpackage Module
 * @copyright  Free
 * @license    
 */
class K111_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * @var K111_EventManager_EventManager
     */
    protected $_eventManager;
    
    /**
     * Constructor
     *
     * @param Zend_Application|Zend_Application_Bootstrap_Bootstrapper $application
     */
    public function __construct($application)
    {
        // 
        parent::__construct($application);
        
        //
        $this->_eventManager = K111_EventManager_EventManager::getInstance();
    }
}