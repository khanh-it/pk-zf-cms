<?php
/**
 */
class Default_Bootstrap extends K111_Application_Module_Bootstrap
{
    /**
     * Load module's navigation?
     * @var bool
     */
    protected $_loadNavigation = true;
    
    /**
     * Init Access Control List (check account acess permission)
     * @return void
     */
    protected function _initACL() {
    	return;
        // Load ACL class;
        require_once __DIR__ . '/../_class/ACL.php';
        // Init ACL instance;
        ACL::checkAccessPermission();
    }
}