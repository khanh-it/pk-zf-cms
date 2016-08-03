<?php
/**
 * 
 * @author khanhdtp
 */
class Bootstrap extends K111_Application_Bootstrap_Bootstrap
{
    /**
     * 
     */
	protected function _initPaginator() {
	    //
	    Zend_Paginator::setDefaultScrollingStyle('Sliding');
	    //
	    Zend_Paginator::setDefaultItemCountPerPage($_GET['iccp'] ? $_GET['iccp'] : 128);
	    //
	    Zend_View_Helper_PaginationControl::setDefaultViewPartial('pager.phtml');
	}
	
    /**
     * 
     */
	protected function _initScriptView() 
	{
	    // Bootstrap resource view.
	    $this->bootstrap('view');
	    // Get container view.
	    $view = $this->getResource('view');
		
		// Get Zend_Controller_Front
		$front = Zend_Controller_Front::getInstance();
		// +++ MinifyHeadLink?,
		K111_View_Helper_HeadLink::$minify = !!$front->getParam('minifyHeadLink');
		// +++ MinifyHeadScript?,
		K111_View_Helper_HeadScript::$minify = !!$front->getParam('minifyHeadScript');  
		// +++ MinifyStyleAction?
		if ($front->getParam('minifyHeadStyleAction')) {
			die('min');
		}
		//App_View_Helper_HeadStyleAction::$minify = !!;
		// +++ MinifyScriptAction?,
		//K111_View_Helper_HeadScript::$minify = !!$front->getParam('minifyHeadScript');
	}
	
	/**
	 * Initilize font controller's plugins
	 * 
	 * @return void
	 */
	protected function _initScriptController() {
		return;
		$this->bootstrap('frontController');
		$front = $this->getResource('frontController');
	
		/* Dang ky plugin */
		$front->registerPlugin(new ZF_Controller_Plugin_RemoveExtensionDefault());
	}
	
	/**
     * Init Access Control List (check account acess permission)
     * @return void
     */
    protected function _initACL() {
        // Load ACL class;
        require_once __DIR__ . '/_class/ACL.php';
        // +++ Init check access options
        ACL::setCheckAccessOptions(array(
        // +++ 
        	'skip_mca' => array(),
        // +++
        	'skip_credentials' => array(
        		'admin' => true
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
		// +++ Register handler for handling checking access!  
        ACL::checkAccess();
    }
	
	/**
     * Init system's language
     * @return void
     */
    protected function _initLanguage() {
        // Load `Language` class;
        require_once __DIR__ . '/_class/Language.php';
        // +++ Set configs
        Language::setConfigs(
        	require_once __DIR__ . '/_lang/configs.php'
		);
		// +++ Init default language
		if (!Zend_Session::isStarted()) {
			Zend_Session::start();
		}
		if (!$_SESSION['CMS_LANG']) {
			list($topLang) = Language::getTop();
			$_SESSION['CMS_LANG'] = $topLang;
		}
		Language::setDefault($_SESSION['CMS_LANG']);
    }
}