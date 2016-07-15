<?php
/**
* @category   ZF
* @package    ZF_View
* @subpackage Helper
* @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
* @version    $Id: Url.php 23775 2011-03-01 17:25:24Z ralph $
* @license    http://framework.zend.com/license/new-bsd     New BSD License
*/

/**
 * Zend_View_Helper_Abstract.php
 */
require_once 'Zend/View/Helper/Abstract.php';

/**
 * Helper for making easy links and getting urls that depend on the routes and router
 *
 * @uses Zend_View_Helper_Abstract
 * @package ZF_View
 * @subpackage Helper
 * @copyright Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class ZF_View_Helper_HeadScriptAction extends Zend_View_Helper_Abstract {
	/**
	 * Hang so dinh dang file
	 * 
	 * @var string
	 */
	const _suffixFile = '.js';
	/**
	 * Hang so ten folder chua file
	 * 
	 * @var string
	 */
	const _folderAssest = 'assets';
	
	/**
	 * Lay noi dung file .
	 * js
	 * 
	 * @param Zend_Controller_Request_Abstract || string $request   	
	 * @param array $params        	
	 * @param array $options        	
	 * @return mixed
	 */
	public function headScriptAction( $request, $params = array(), $options = array(), $isPrepend = true) {
	    if ( is_string($request) ){
	        $fileContent = $request;
	    }else {
	        
	        if ( !($request instanceof Zend_Controller_Request_Abstract) ){
	            throw new Exception('Argument 1 passed to ZF_View_Helper_HeadScriptAction::headScriptAction() must be an instance of Zend_Controller_Request_Abstract', 500);
	        }
    		// Lay thong tin module, controller, action
    		$moduleName = $options ['module'] ? $options ['module'] : $request->getModuleName ();
    		$controllerName = $options ['controller'] ? $options ['controller'] : $request->getControllerName ();
    		$actionName = $options ['action'] ? $options ['action'] : $request->getActionName ();
    		
    		// Lay noi dung file
    		$fileContent = $this->getFileContent ( $moduleName, $controllerName, $actionName );
	    }
	    
	    // Truyen du lieu vao noi dung file
	    if (count ( $params )) {
	        $fileContent = str_replace ( array_keys ( $params ), array_values ( $params ), $fileContent );
	    }
	    
		// Neu lay noi dung => tra ve chuoi
		if (true === $options ['getContent']) {
			return $fileContent;
		}
		
		// Chen noi dung file vao js
		if ( true === $isPrepend )
    		$this->view->headScript ()->prependScript ( $fileContent, null, array (
    			'getContent' => true 
    		) );
    	else
    	    $this->view->headScript ()->appendScript ( $fileContent, null, array (
    	        'getContent' => true
    	    ) );
	}
	
	/**
	 * Lay noi dung file
	 *
	 * @param string $moduleName
	 *        	Ten module
	 * @param string $controllerName
	 *        	Ten controller
	 * @param string $actionName
	 *        	Ten action
	 *        	
	 * @return string
	 */
	public function getFileContent($moduleName, $controllerName, $actionName) {
		// Lay duong dan file
		$filePath = realpath ( APPLICATION_PATH . '/sites/' . APPLICATION_SITE . "/$moduleName/views/" . self::_folderAssest . "/$controllerName/$actionName" . self::_suffixFile );
		
		// Neu file ton tai lay noi dung file
		if ($filePath) {
			// Return
			return file_get_contents ( $filePath );
		}
		
		return '';
	}
}
?>