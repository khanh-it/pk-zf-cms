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
		// 
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
	 * Parse (moodule)/controller/action info from string
	 * #pattern : @MCAInfo({
 	"name": "Group controller",
	"description": "Group of accounts"
})
	 * @param $str string MCA info string
	 * @return array
	 */
	public function parseMCAInfo($str = null) {
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
	 * List module/controller/action
	 *
	 * @param $siteName string Site name
	 * @param $options array An array of options
	 * @return array 
	 */
	public function listMCA($siteName = 'backend', array $options = array()) {
		//
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
		$controllerClassLoaded = array();
		// +++ 
		$actionNameSubfix = 'Action';
		
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
			if ($controllerPath = realpath("{$moduleDirPath}/{$controllerDirName}")) {
				foreach ((new DirectoryIterator($controllerPath)) as $controllerDir) {
					if (!$controllerDir->isFile()) {
						continue;
					}
					// Load controller classes //
					$controllerFile = $controllerDir->getFilename();
					if (0 === strpos($controllerFile, '_')) {
						continue;
					}
					if ((strlen($controllerFile) - strlen($controllerNameSubfixPHP)) 
							!== strpos($controllerFile, $controllerNameSubfixPHP)
					) {
						continue;
					}
					// +++ Require controller class file.
					require_once ("{$controllerPath}/{$controllerFile}");
				}
				foreach (get_declared_classes() as $controllerName) {
					// Set data //
					if ((strlen($controllerName) - strlen($controllerNameSubfix)) 
							!== strpos($controllerName, $controllerNameSubfix)
					) {
						continue;
					}
					if ($controllerClassLoaded[$controllerName]) {
						continue;
					}
					$controllerClassLoaded[$controllerName] = true;
					// +++ Get controller info
					$controllerRef = new ReflectionClass($controllerName);
					
					$controllers[
						$controllerName = str_replace($controllerNameSubfix, '', $controllerName)
					] = array_merge(
						$this->parseMCAInfo($controllerRef->getDocComment()), array(
						// +++ File path
							'path' => $controllerRef->getFileName()
						)
					);
					// ./Set data //
					
					// Action //
					$actions = array();
					foreach (($controllerRef->getMethods()) as $methodRef) {
						// +++ Set data //
						if (!$methodRef->isPublic()) {
							continue;
						}
						$actionName = $methodRef->getName();
						if (0 === strpos($actionName, '_')) {
							continue;
						}
						if ((strlen($actionName) - strlen($actionNameSubfix)) 
								!== strpos($actionName, $actionNameSubfix)
						) {
							continue;
						}
						// +++ +++ 
						$actions[
							str_replace($actionNameSubfix, '', $actionName)
						] = $this->parseMCAInfo($methodRef->getDocComment());
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