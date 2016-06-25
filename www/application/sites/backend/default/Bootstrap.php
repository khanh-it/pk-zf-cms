<?php
/**
 */
class Default_Bootstrap extends K111_Application_Module_Bootstrap
{
    /**
     * Init Access Control List (check account acess permission)
     * @return void
     */
    protected function _initACL() {
        $this->_eventManager->attach('__SYSTEM__.routeStartup', function(){
            // Load ACL class;
            require_once __DIR__ . '/../_class/ACL.php';
            // Call function for checking access permission;
            ACL::checkAccessPermission();
        });
    }
}