<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Application
 * @subpackage Module
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * Base bootstrap class for modules
 *
 * @category   K111
 * @package    K111_Application
 * @subpackage Module
 * @copyright  Free
 * @license    
 */
class K111_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * Helper: convert a CamelCase string into a camel_case string 
     * @param unknown $str
     * @return string
     */
    public static function fromCamelCase($str) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
    
    /**
     * Module's name undercore
     * @var string
     */
    protected $_moduleNameUC = '';
	/**
     * Return current module name undercore
     *
     * @return string
     */
    public function getModuleNameUC()
    {
        return $this->_moduleNameUC;
    }
    
    /**
     * @var Default navigation's static file name.
     */
    protected $_nav_filename_static = 'nav.static.php';
	/**
     * Return default navigation's static file name.
     *
     * @return string
     */
    public function getNavFilenameStatic()
    {
        return $this->_nav_filename_static;
    }
    
    /**
     * @var Default navigation's dynamic file name.
     */
    protected $_nav_filename_dynamic = 'nav.dynamic.php';
	/**
     * Return default navigation's static file name.
     *
     * @return string
     */
    public function getNavFilenameDynamic()
    {
        return $this->_nav_filename_dynamic;
    }
    
    /**
     * Load navigation?
     * @var bool
     */
    protected $_loadNavigation = false;
    
    /**
     * Loaded navigation data.
     * @var array
     */
    protected static $_dataNavigation = array();
    
    /**
     * @var K111_EventManager_EventManager
     */
    protected $_eventManager;
    
    /**
     * @var array
     */
    protected static $_instances;
	
    /**
     * Constructor
     *
     * @param Zend_Application|Zend_Application_Bootstrap_Bootstrapper $application
     */
    public function __construct($application)
    {
        // Call to parent's constructor 
        parent::__construct($application);
        
        // Get K111_EventManager_EventManager
        $this->_eventManager = K111_EventManager_EventManager::getInstance();
        
        // Format module's name from CamelCase to camel_case.
        $this->_moduleNameUC = self::fromCamelCase($this->getModuleName());
        
        // Store module's bootstrap instances for later access.
        self::$_instances[get_called_class()] = $this;
        
        // Load navigation?
        if ($this->_loadNavigation) {
            $this->_loadNavigation();
        }
    }
    
    /**
     * Set navigation data.
     * 
     * @param array $dataNavigation Data navigation
     * @return void
     */
    public static function setDataNavigation($dataNavigation) {
        self::$_dataNavigation = array_replace_recursive(
            self::$_dataNavigation, $dataNavigation
        );
    }
    
    /**
     * Get navigation data.
     * @return array
     */
    public static function getDataNavigation() {
        return self::$_dataNavigation;
    }
    
    /**
     * Do load module's navigation
     * @return this
     */
    protected function _loadNavigation() {
        // Get navigation directory.
        $navDir = Zend_Controller_Front::getInstance()
            ->getModuleDirectory($this->_moduleNameUC)
            . '/configs/'
        ;
        
        // Load navigation's static file.
        self::setDataNavigation(require "{$navDir}/{$this->_nav_filename_static}");
		
		// Make ref to current bootstrap instance
		$bt = $this;

        // Load navigation's dynamic file.
        $this->_eventManager->attach('__SYSTEM__.dispatchLoopStartup', function(Zend_EventManager_Event $e) use ($bt, $navDir) {
            // Call helper: check if current request for current module?
            $isMCAMatch = $e->getTarget()->isMCAMatch(array(
                'module' => $bt->getModuleNameUC()
            ));
            if ($isMCAMatch) {
        		$bt::setDataNavigation(require "{$navDir}" . $bt->getNavFilenameDynamic());
            }
        });
        
        // Return
        return $this;
    }
}