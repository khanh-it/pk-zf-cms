<?php
/**
 * Simple access control list
 */
class ACL {
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_dbA;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // @var Zend_Db_Adapter_Abstract
        $this->_dbA = Zend_Db_Table::getDefaultAdapter();
    }
    
    /**
     * Handle account's access permission checking
     * @return void
     */
    public static function checkAccessPermission() {
        // Get K111_EventManager_EventManager
        $eventManager = K111_EventManager_EventManager::getInstance();
        // Register hook:
        $eventManager->attach('__SYSTEM__.dispatchLoopStartup', function (Zend_EventManager_Event $e) {
            // Get Zend_Controller_Front
            $front = Zend_Controller_Front::getInstance();
            // @var Zend_Controller_Request_Http
            $request = $e->getTarget()->getRequest();
            // Is request dispatchable?
            if ($front->getDispatcher()->isDispatchable($request)) {
                // Init ACL instance;
                $acl = new ACL();
                // +++ Call helper function to check account's access permission.
                $acl->doCheckAccessPermission($request);
            }
        });
    }
    
    /**
     * Check account's access permission
     * 
     * 
     * @return this
     */
    public function doCheckAccessPermission(Zend_Controller_Request_Http $request) {
        // Get Zend_Auth.
        $zAuth = Zend_Auth::getInstance();
        
        // Case: not login?
        if (!$zAuth->hasIdentity()) {
            $request
                ->setModuleName('default')
                ->setControllerName('account')
                ->setActionName('login')
                ->setDispatched(true)
            ;
        }
    }
}