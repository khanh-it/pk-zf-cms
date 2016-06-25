<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Controller
 * @subpackage K111_Controller_Plugin
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * @category   K111
 * @package    K111_Controller
 * @subpackage K111_Controller_Plugin
 * @copyright  Free
 * @license    
 */
class K111_Controller_Plugin_SystemHooks extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var string Hook's name prefix
     */
    const HOOK_NAME_PREFIX = '__SYSTEM__.';
    
    /**
     * @var K111_EventManager_EventManager
     */
    protected $_eventManager;
    
    /**
     * Constructor
     * @return void
     */
    public function __construct() {
        $this->_eventManager = K111_EventManager_EventManager::getInstance();
    }
    
    /**
     * Helper: check current request (module/controller/action) is matched?
     * @return bool
     */
    public function isMCAMatch(Zend_Controller_Request_Abstract $request, array $params = array()) {
        die();
    }
    
    /**
     * Called before Zend_Controller_Front begins evaluating the
     * request against its routes.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_eventManager->trigger(self::HOOK_NAME_PREFIX . __FUNCTION__, $this, array(
            'hook' => __FUNCTION__, 'request' => $request
        ));
    }

    /**
     * Called after Zend_Controller_Router exits.
     *
     * Called after Zend_Controller_Front exits from the router.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $this->_eventManager->trigger(self::HOOK_NAME_PREFIX . __FUNCTION__, $this, array(
            'hook' => __FUNCTION__, 'request' => $request
        ));
    }

    /**
     * Called before Zend_Controller_Front enters its dispatch loop.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_eventManager->trigger(self::HOOK_NAME_PREFIX . __FUNCTION__, $this, array(
            'hook' => __FUNCTION__, 'request' => $request
        ));
    }

    /**
     * Called before an action is dispatched by Zend_Controller_Dispatcher.
     *
     * This callback allows for proxy or filter behavior.  By altering the
     * request and resetting its dispatched flag (via
     * {@link Zend_Controller_Request_Abstract::setDispatched() setDispatched(false)}),
     * the current action may be skipped.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->_eventManager->trigger(self::HOOK_NAME_PREFIX . __FUNCTION__, $this, array(
            'hook' => __FUNCTION__, 'request' => $request
        ));
    }

    /**
     * Called after an action is dispatched by Zend_Controller_Dispatcher.
     *
     * This callback allows for proxy or filter behavior. By altering the
     * request and resetting its dispatched flag (via
     * {@link Zend_Controller_Request_Abstract::setDispatched() setDispatched(false)}),
     * a new action may be specified for dispatching.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->_eventManager->trigger(self::HOOK_NAME_PREFIX . __FUNCTION__, $this, array(
            'hook' => __FUNCTION__, 'request' => $request
        ));
    }

    /**
     * Called before Zend_Controller_Front exits its dispatch loop.
     *
     * @return void
     */
    public function dispatchLoopShutdown()
    {
        $this->_eventManager->trigger(self::HOOK_NAME_PREFIX . __FUNCTION__, $this, array(
            'hook' => __FUNCTION__
        ));
    }
}
    