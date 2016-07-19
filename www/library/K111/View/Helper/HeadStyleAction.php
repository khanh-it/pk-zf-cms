<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_View_Helper
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * Append (or prepend) css content (from string or file) using headStyle helper.
 *
 * @category   K111
 * @package    K111_View_Helper
 * @copyright  Free
 * @license    
 */
class App_View_Helper_HeadStyleAction extends Zend_View_Helper_Abstract {
	
	/**
	 * @var string Default css asset subfix. 
	 */
	public static $suffix = '.css';
	
	/**
	 * @var string Default css asset folder name.
	 */
	public static $folderAssets = 'assets';
	
	/**
	 * @var object Css minifier
	 */
	protected static $_minifier = null;
	 
	/**
	 * Set class's css minifier
	 * @return void
	 */
	public static function setMinifier($minifier) {
		self::$_minifier = $minifier;
	}
	
	/**
	 * Proxy helper, minify css assets
	 * @param $content string Css file content
	 * @return string
	 */
	public static function minify($content) {
		if (self::$_minifier) {
			return call_user_func(self::$_minifier, $content);
		}
		return $content;
	}
	
	/**
	 * @var Zend_Controller_Front
	 */
	protected $_front = null;
	
	/**
	 * Constructor
	 * @return void
	 */
	public function __construct() {
		$this->_front = Zend_Controller_Front::getInstance();
	}
	
	/**
	 * Append (or prepend) css content (from string or file) using headStyle helper. 
	 * 
	 * @param $request Zend_Controller_Request_Abstract||string|array        	
	 * @param array $data 
	 * @param array $options
	 * @param array $append
	 * @return mixed
	 */
	public function headStyleAction($request = null, $data = array(), $options = array(), $append = true) 
	{
		// Style content
		$style = '';
		
		// Case: $request is string
		if (is_string($request)) {
	        $style = $request;
		// Case: get, + format options by request (if any) 
	    } elseif ($request instanceof Zend_Controller_Request_Abstract) {
			// Get, + format options
    		$options['module'] 		= $options['module'] ? $options['module'] : $request->getModuleName();
    		$options['controller'] 	= $options['controller'] ? $options['controller'] : $request->getControllerName();
    		$options['action'] 		= $options['action'] ? $options['action'] : $request->getActionName();
			
        } elseif (is_array($request)) {
			$options = $request;
		}
		// Get asset file content.
		if ($options['module'] && $options['controller'] &&  $options['action']) 
		{
			// Get asset file content.
			$style = $this->getFileContent($options['module'], $options['controller'], $options['action']);
			// Add extra params
			if (count($data)) {
				$style = str_replace(array_keys($data), array_values($data), $style);
			}
			// Neu lay noi dung => tra ve chuoi
			if (true === $options['getContent']) {
				return $style;
			}
		}
		
		// Set content, + minify (if any)
		if ($style) {
			if ($append) {
				$this->view->headStyle()->appendStyle(self::minify($style), array('media' => 'all'));	
			} else {
				$this->view->headStyle()->prependStyle(self::minify($style), array('media' => 'all'));
			}
		}
		
		// Return
		return $this;
	}
	
	/**
	 * Get asset css file content
	 *
	 * @param string $moduleName Module's name
	 * @param string $controllerName Controller's name
	 * @param string $actionName Action's name
	 * @return string
	 */
	public function getFileContent($moduleName, $controllerName, $actionName) 
	{
		// Get file's directory.
		$fileDir = $this->_front->getControllerDirectory();
		$fileDir = $fileDir[$moduleName];
		
		// Get file's fullpath, + read file's content.
		$file = "{$fileDir}/../views/" . self::$folderAssets . "/{$controllerName}/{$actionName}" . self::$suffix;
		if (!realpath($file)) {
			trigger_error("[HSA] File `$file` not found!", E_USER_WARNING);
		} else {
			return file_get_contents($file);	
		}
	}
}