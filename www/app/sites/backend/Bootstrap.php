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
     * Cau hinh view
     */
	protected function _initScriptView() {
	    // Bootstrap resource view.
	    $this->bootstrap ( 'view' );
	    // Get container view.
	    $view = $this->getResource ( 'view' );
	    
	    /**
	     * *********************************
	     * KHAI BAO HANG SO CHO SESSION
	     * *********************************
	    */
	    // Define session name for language.
	    defined ( 'ZF_SESSION_LANGUAGE' ) || define ( 'ZF_SESSION_LANGUAGE', 'ZF_SESS_LANGUAGE' );
	    // Defind session name for Zend_Auth.
	    defined ( 'ZF_SESSION_AUTH' ) || define ( 'ZF_SESSION_AUTH', 'ZF_SESS_AUTH' );
	    
	    /**
	     * ********************************************
	     * KHAI BAO HANG SO CHO THONG BAO HE THONG
	     * ********************************************
	    */
	    // Tiep dau ngu thong bao.
	    define ( 'ZF_MSG_PREFIX_SUCCESS', '[message]' );
	    // Tiep dau ngu thong bao loi.
	    define ( 'ZF_MSG_PREFIX_ERROR', '[error]' );
	    
	    // Ngon ngu mac dinh
	    define ( 'ZF_LANGUAGE_DEFAULT', 'jp' );
	    
	    // Thong bao them du lieu thanh cong
	    define ( 'ZF_MSG_INSERT_SUCCESS', ZF_MSG_PREFIX_SUCCESS . $view->translate ( 'Thêm dữ liệu thành công.' ) );
	    // Thong bao cap nhat du lieu thang cong
	    define ( 'ZF_MSG_UPDATE_SUCCESS', ZF_MSG_PREFIX_SUCCESS . $view->translate ( 'Cập nhật dữ liệu thành công.' ) );
	    // Thong bao xoa du lieu thanh cong
	    define ( 'ZF_MSG_DELETE_SUCCESS', ZF_MSG_PREFIX_SUCCESS . $view->translate ( 'Xóa dữ liệu thành công.' ) );
	    // Thong bao xoa du lieu khong thanh cong
	    define ( 'ZF_MSG_DELETE_FAIL', ZF_MSG_PREFIX_ERROR . $view->translate ( 'Xóa dữ liệu không thành công.' ) );
	    // Xoa cache thanh cong
	    define ( 'ZF_MSG_REFRESH_CACHE_SUCCESS', ZF_MSG_PREFIX_SUCCESS . $view->translate ( 'Xóa dữ liệu trong cache thành công.' ) );
	    define ( 'ZF_MSG_REFRESH_CACHE_FAIL', ZF_MSG_PREFIX_ERROR . $view->translate ( 'Xóa dữ liệu trong cache không thành công.' ) );
	    // Thong bao khong co du lieu
	    //define ( 'ZF_MSG_EMPTY', $view->translate ( 'Không có dữ liệu!' ) );
	    // THong bao trang khong ton tai.
	    //define ( 'ZF_MSG_PAGE_NOT_FOUND', $view->translate ( 'Trang không tồn tại!' ) );
	    // Thong bao yeu cau khong hop le.
	    //define ( 'ZF_MSG_REQUEST_INVALID', $view->translate ( 'Yêu cầu không hợp lệ!' ) );
	    //	Thong bao du lieu khong ton tai
	    define('ZF_MSG_DATA_NOT_EXISTS', $view->translate('Dữ liệu không tồn tại!'));
	    // -- define session key
	    define('ZF_SYSTEM_MESSAGE', 'system-message');
	    
	    // -- defined date format
	    require APPLICATION_PATH . '/configs/sites-config.php';
	    
	    define('ZF_FORMAT_DATE', $dateFormat[APPLICATION_LANGUAGE]['date']);
	    
	    define('ZF_FORMAT_DATE_TIME', $dateFormat[APPLICATION_LANGUAGE]['date-time']);
	    
	    define('ZF_FORMAT_MONTH', $dateFormat[APPLICATION_LANGUAGE]['month']);
	    
	    /**
	     * **************************************
	     */
	    // Defind constant check have extension for url.
	    defined ( 'EXTENSION_URL' ) || define ( 'EXTENSION_URL', 'EXTENSION_URL' );
	    //
	    //Zend_Registry::set ( EXTENSION_URL, '.html' );
		// bootstrap resource view
		$this->bootstrap ( 'view' );
		// bootstrap resource publicresource
		$this->bootstrap ( 'publicResource' );
		
		// get container view
		$view = $this->getResource ( 'view' );
		
		// add helper path
		$view->addHelperPath ( LIBRARY_PATH . "/ZF/View/Helper", "ZF_View_Helper" );
		$view->addHelperPath ( LIBRARY_PATH . '/ZF/View/Helper/BootstrapToolbar', 'ZF_View_Helper_BootstrapToolbar' );
		$view->addHelperPath ( LIBRARY_PATH . '/ZF/View/Helper/BootstrapManage', 'ZF_View_Helper_BootstrapManage' );
	}
	
	/**
	 * Cấu hình controller
	 */
	protected function _initScriptController() {
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
	
	
	/**
	 * Định nghĩa hằng số cho hệ thống
	 */
	//protected function _initScriptConstant() {
		// Bootstrap resource view.
		//$this->bootstrap ( 'view' );
		// Get container view.
		//$view = $this->getResource ( 'view' );
		
		//	Thong bao du lieu khong ton tai
		//define('ZF_MSG_DATA_NOT_EXISTS', $view->translate('Dữ liệu không tồn tại!'));
		// Thong bao yeu cau khong hop le
		//define('ZF_MSG_REQUEST_INVALID', $view->translate ( 'Yêu cầu không hợp lệ!'));
	//}
}