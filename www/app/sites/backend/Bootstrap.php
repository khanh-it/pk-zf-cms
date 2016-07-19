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
	 * Cấu hình controller
	 */
	protected function _initScriptController() {
		
		return;
		$this->bootstrap('frontController');
		$front = $this->getResource('frontController');
	
		/* Dang ky plugin */
		$front->registerPlugin(new ZF_Controller_Plugin_RemoveExtensionDefault());
		// Plugin phan quyen
		$front->registerPlugin(new ZF_Controller_Plugin_CheckPermission(array(
		    'ignoreSMCA'	=> array(
		        'default'	=> array(
		            //'index'	=> true,
		            'error'	=> true
		        ),
		        'member' => array(
		            'index' => array(
		                'login' => true,
		                'logout' => true
		            )
		        )
		    ),
		    'ignoreIdentities' => array('')
		)));
		
		// Plugin phan quyen
		//$front->registerPlugin ( new ZF_Controller_Plugin_CheckPermission () );
		$front->registerPlugin ( new ZF_Controller_Plugin_Hook () );
		// $front->registerPlugin(new ZF_Controller_Plugin_SystemLog());
	}
}