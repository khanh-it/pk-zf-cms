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
        // Load ACL class;
        require_once __DIR__ . '/../_class/ACL.php';
        // Init ACL instance;
        ACL::checkAccessPermission(array(
        // +++ 
        	'skip_mca' => array(),
        // +++
        	'skip_credentials' => array(
        		//'admin'
			), 
        // +++ Redirect login : module/controller/action
        	'url_no_login_params' => array(
        		'module' => 'default',
        		'controller' => 'account',
        		'action' => 'login'
			),
		// +++ 
			'url_access_denied_params' => array(
        		'module' => 'default',
        		'controller' => 'error',
        		'action' => 'access-denied'
			) 
		));
    }
}