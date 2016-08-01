<?php
/**
 * Simple access control list
 */
class ACL {
	
	/**
	 * @var K111_Filter_ConvertCamelCase 
	 */
	protected static $_camelCaseConverter;
	/**
	 * Get K111_Filter_ConvertCamelCase instance
	 * @return K111_Filter_ConvertCamelCase
	 */
	public static function getCamelCaseConverter() {
		if (!self::$_camelCaseConverter) {
			self::$_camelCaseConverter = new K111_Filter_ConvertCamelCase();
		}
		return self::$_camelCaseConverter;
	}
	
	/**
	 * Parse (moodule)/controller/action info from string
	 * #pattern : @MCAInfo({
 	"name": "Group controller",
	"description": "Group of accounts"
})
	 * @param $str string MCA info string
	 * @return array
	 */
	public static function parseMCAInfo($str = null) {
		//
		$MCAInfo = array();
		//
		$pattern = '/\@MCAInfo\s*\(\s*([^)]+)\s*\)/smu';
		preg_match($pattern, $str, $matchs);
		// 
		if (!empty($matchs)) {
			$MCAInfo = (array)@json_decode(trim($matchs[1]));
		}
		
		return $MCAInfo;
	}	
	
	/**
	 * Extract controller class file for class, + methods tokens...
	 * 
	 * @param string $fileName Controller class file
	 * @return array
	 */
	public static function parseControllerClassTokensFromFile($filename) {
		// Class tokens
		$classTokens = array();
		// Method tokens
		$methodTokens = array();
		// Parse file
		if (file_exists($filename) && is_readable($filename)) {
			// Get file's content.
			$fileContents = file_get_contents($filename);
			
			// // Extract class tokens
			$pattern = '/(\/\*\*(((?!\*\/).)*)?\*\/)\s*(abstract)?\s*class\s+([^ ]+)Controller\s*/smu';
			$result = preg_match($pattern, $fileContents, $matches);
			if ($result) {
				$classTokens = array(
					'name' => $matches[5],
					'doc_comment' => trim($matches[1]),
				);
				// Extract methods tokens
				$pattern = '/(\/\*\*(((?!\*\/).)*)?\*\/)\s*(public)?\s*function\s*([^ ]+Action)\s*/smu';
				if (preg_match_all($pattern, $fileContents, $matches)) {
					//\Zend_Debug::dump($matches);
					for ($i = 0; $i < count($matches[0]); $i++) {
						$methodTokens[] = array(
							'name' => $matches[5][$i],
							'doc_comment' => trim($matches[1][$i]),
						);
					}
				}
			};
		}
		
		// Return;
		return array($classTokens, $methodTokens);
	}

	/**
	 * Compile module/controller/action key
	 * 
	 * @param $moduleName string Module name 
	 * @param $controllerName string Controller name
	 * @param $actionName string Action name
	 */
	public static function compileMCAKey($moduleName, $controllerName, $actionName) {
		return "{$moduleName}/{$controllerName}/{$actionName}";
	}
	
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_dbA;
	
	/**
	 * @var Zend_Controller_Front
	 */
	protected $_front;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // @var Zend_Db_Adapter_Abstract
        $this->_dbA = Zend_Db_Table::getDefaultAdapter();
		
		// @var Zend_Controller_Front
		$this->_front = Zend_Controller_Front::getInstance();
    }
    
	/**
	 * @var array
	 */
	protected static $_checkAccessOptions;
	
	/**
	 * Set check access options
	 * 
	 * @param array $options An array of options
	 * @return void 
	 */
	public static function setCheckAccessOptions(array $options) {
		self::$_checkAccessOptions = (array)$options;
	} 
	
    /**
     * Handle account's access permission checking
	 * 
	 * @param $options array An array of options
     * @return void
     */
    public static function checkAccess() {
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
                // Call helper function to check account's access permission.
                $isAccessAllowed = ACL::isAccessAllowed($request);
				
				// Case: not login
				if (is_null($isAccessAllowed)) {
					// Get, +format params
					// +++ 
					$urlNoLoginParams = (array)self::$_checkAccessOptions['url_no_login_params'];
					
					// Forward request (redirect)
		            return $request
		                ->setModuleName($urlNoLoginParams['module'])
		                ->setControllerName($urlNoLoginParams['controller'])
		                ->setActionName($urlNoLoginParams['action'])
		                ->setDispatched(true)
		            ;
					
				// Case: dont has permission
				} elseif (false === $isAccessAllowed) {
					// Get, +format params
					// +++ 
					$urlAccessDeniedParams = (array)self::$_checkAccessOptions['url_access_denied_params'];
					
					// Forward request (redirect)
		            return $request
		                ->setModuleName($urlAccessDeniedParams['module'])
		                ->setControllerName($urlAccessDeniedParams['controller'])
		                ->setActionName($urlAccessDeniedParams['action'])
		                ->setDispatched(true)
		            ;			
				}
            }
        });
    }
	
    /**
     * Check account's access permission
     * 
     * @return this
     */
    public static function isAccessAllowed($request) {
		// Flag: has permission?
		$hasPermission = null;
    	// Get, + format params
		$params = $request;
		// +++ 
		if ($request instanceof Zend_Controller_Request_Abstract) {
			$params = array(
				'module' => $request->getModuleName(),
				'controller' => $request->getControllerName(),
				'action' => $request->getActionName()
			);
		}
		
        // Get Zend_Auth.
        $zAuth = Zend_Auth::getInstance();
        
        // Case: not login?
        if (!$zAuth->hasIdentity()) {
        	return $hasPermission;
        }
		
		// Get identity data
		$identity = $zAuth->getIdentity();
		
		// Check access permission by options
		// +++ Skip by skip_credentials
		$skipCredentials = (array)self::$_checkAccessOptions['skip_credentials'];
		if ($skipCredentials[$identity->username]) {
			return ($hasPermission = true);
		}
		// +++ Skip by skip_mca
		$skipMCA = (array)self::$_checkAccessOptions['skip_mca'];
		if (true === ($skipMCA = $skipMCA[$params['module']])) { // Module
			return ($hasPermission = true);
		}
		else if (true === ($skipMCA = $skipMCA[$params['controller']])) { // Controller
			return ($hasPermission = true);
		}
		else if (true === ($skipMCA = $skipMCA[$params['action']])) { // Action
			return ($hasPermission = true);
		}
		
		// Check access permission by group's acl
		// +++
		$MCAKey = self::compileMCAKey($params['module'], $params['controller'], $params['action']);
		// +++ 
		$acl = $identity->group_acl[APPLICATION_SITE];
		$hasPermission = (false !== strpos($acl, ",{$MCAKey},"));
		
		// Return;
		return $hasPermission;
    }
	
	/**
	 * Helper: get site root path
	 * @return string|bool
	 */
	public function getSitePath() {
		return realpath(dirname(dirname(
			$this->_front->getModuleDirectory($this->_front->getDefaultModule()))
		));
	}
	
	/**
	 * List module/controller/action
	 *
	 * @param $options array An array of options
	 * @return array 
	 */
	public function listSite(array $options = array()) {
		// An array of site(s).
		$listSite = array();
		// Get site folder root path 
		$sitePath = $this->getSitePath();
		if (!$sitePath) {
			return $listSite;
		}
		// Loop, get site(s) + info 
		foreach ((new DirectoryIterator($sitePath)) as $siteDir) {
			if (!$siteDir->isDir() || $siteDir->isDot()) {
				continue;
			}
			// +++ Set data //
			$siteName = $siteDir->getFilename();
			if (0 === strpos($siteName, '_')) {
				continue;
			}
			// +++ +++ Get site info
			$siteInfo = array();
			$siteDirPath = "{$sitePath}/{$siteName}";
			$packageFile = realpath("{$siteDirPath}/package.json");
			if ($packageFile) {
				$siteInfo = (array)@(json_decode(file_get_contents($packageFile)));
			}
			$listSite[$siteName] = array_merge($siteInfo, array(
			// +++ Path
				'path' => $siteDirPath
			));
			// +++ ./Set data //
		}
		
		return $listSite;
	}
	
	/**
	 * List module/controller/action
	 *
	 * @param $siteName string Site name
	 * @param $options array An array of options
	 * @return array 
	 */
	public function listMCA($siteName, array $options = array()) {
		// List of module/controller/action
		$listMCA = array(
			'module' => array(),
			'controller' => array(),
			'action' => array()
		);
		// Get list site, + info
		$siteInfo = $this->listSite();
		$siteInfo = $siteInfo[$siteName];
		if (!$siteInfo) {
			return $listMCA;
		}
		// +++ 
		$defaultModuleName = $this->_front->getDefaultModule();
		// +++ 
		$controllerDirName = $this->_front->getModuleControllerDirectoryName();
		// +++
		$controllerNameSubfix = 'Controller'; 
		$controllerNameSubfixPHP = "{$controllerNameSubfix}.php";
		// +++ 
		$actionNameSubfix = 'Action';
		// +++ 
		$camelCaseConverter = self::getCamelCaseConverter();
		
		// Module //
		$modules = array();
		if (!($modulePath = realpath($siteInfo['path']))) {
			continue;
		}
		foreach ((new DirectoryIterator($modulePath)) as $moduleDir) {
			if (!$moduleDir->isDir() || $moduleDir->isDot()) {
				continue;
			}
			// +++ Set data //
			$moduleName = $moduleDir->getFilename();
			if (0 === strpos($moduleName, '_')) {
				continue;
			}
			$moduleInfo = array();
			$moduleDirPath = "{$modulePath}/{$moduleName}";
			$packageFile = realpath("{$moduleDirPath}/package.json");
			if ($packageFile) {
				$moduleInfo = (array)@(json_decode(file_get_contents($packageFile)));
			}
			$modules[$moduleName] = array_merge($moduleInfo, array(
			// +++ Path
				'path' => $moduleDirPath
			));
			// +++ ./Set data //
			
			// Conroller //
			$controllers = array();
			if ($controllerPath = realpath("{$moduleDirPath}/{$controllerDirName}")) 
			{
				foreach ((new DirectoryIterator($controllerPath)) as $controllerDir) {
					if (!$controllerDir->isFile()) {
						continue;
					}
					// Load controller classes //
					$controllerName = $controllerDir->getFilename();
					if (0 === strpos($controllerName, '_')) { continue; }
					if ((strlen($controllerName) - strlen($controllerNameSubfixPHP)) 
							!== strpos($controllerName, $controllerNameSubfixPHP)
					) { continue; }
					// Parse controller class file.
					$controllerClassFilename = "{$controllerPath}/{$controllerName}";
					list($classTokens, $methodTokens) = self::parseControllerClassTokensFromFile($controllerClassFilename);
					//continue;
					// Set data //
					if (empty($classTokens)) { continue; }
					$controllerName = $camelCaseConverter->filter(
						str_replace($controllerNameSubfix, '', $classTokens['name'])
					); 
					$controllers[$controllerName] = array_merge(
						self::parseMCAInfo($classTokens['doc_comment']), array(
						// +++ File path
							'path' => $controllerClassFilename
						)
					);
					// ./Set data //
					
					// Action //
					if (empty($methodTokens)) { continue; }
					$actions = array();
					foreach ($methodTokens as $methodToken) {
						// +++ Set data //
						$actionName = $methodToken['name'];
						if (0 === strpos($actionName, '_')) { continue; }
						if ((strlen($actionName) - strlen($actionNameSubfix)) 
								!== strpos($actionName, $actionNameSubfix)
						) { continue; }
						// +++ 
						$actionName = $camelCaseConverter->filter(
							str_replace($actionNameSubfix, '', $actionName)
						);  
						$actions[$actionName] = $this->parseMCAInfo($methodToken['doc_comment']);
						// +++ ./Set data //
					}
					$listMCA['action'][$moduleName][$controllerName] = $actions;
					// ./Action //
				}
			}
			$listMCA['controller'][$moduleName] = $controllers;
			// ./Conroller //
		}
		$listMCA['module'] = $modules;
		// ./Module //
		
		// Return
		return $listMCA;
	}
}