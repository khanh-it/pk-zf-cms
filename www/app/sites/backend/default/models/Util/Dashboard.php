<?php
// ----- Require files
require_once dirname(__FILE__) . '/DashboardWidget.php';

/**
 * @author khanhdtp
 */
class Default_Model_Util_Dashboard extends Default_Model_Util_Abstract
{
	/**
	 * @var K111_EventManager_EventManager
	 */
	protected $_eventManager;
	
	/**
	 * @var Default_Model_DbTable_Account
	 */
	protected $_repoAccount;
	
	/**
	 * @var Default_Model_Util_Dashboard
	 */
	protected static $_instance;
	
	/**
	 * Constructor
	 */
	protected function __construct(){
		// Initialize
		// @var K111_EventManager_EventManager
		$this->_eventManager = K111_EventManager_EventManager::getInstance();
		// @var Default_Model_DbTable_Account
		$this->_repoAccount = new Default_Model_DbTable_Account();
	}
	
	/**
	 * Get self instance
	 * 
	 * @return Default_Model_Util_Dashboard
	 */
	public static function getInstance() {
		if (!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Create widget item
	 * 
	 * @return Default_Model_Util_DashboardWidget
	 */
	public function createWidget(array $options = array()){
		return new Default_Model_Util_DashboardWidget($options);
	}
	
	/**
	 * @var array Widgets
	 */
	protected $_widgets;
	/**
	 * Register widgets
	 * 
	 * @param $widget Default_Model_Util_DashboardWidget Widget item
	 * @param $offset int|string Widget's offset
	 * @return Default_Model_Util_Dashboard
	 */
	public function registerWidget(Default_Model_Util_DashboardWidget $widget, $offset = null){
		if (is_null($offset)) {
			$offset = count($this->_widgets);
		}
		if (!is_null($offset) && $this->_widgets[$offset]) {
			throw new Exception("Widget with offset {$offset} has aldready exists!");
		}
		$this->_widgets[$offset] = $widget->setOffset($offset);
		// Return
		return $this;
	}
	/**
	 * Unregister widgets
	 * 
	 * @param $widget Default_Model_Util_DashboardWidget Widget item
	 * @return bool
	 */
	public function unregisterWidget(Default_Model_Util_DashboardWidget $widget) {
		if (!empty($this->_widgets)) {
			foreach ($this->_widgets as $offset => $_widget) {
				if ($_widget === $widget) {
					unset($this->_widgets[$offset]);
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * Get widgets
	 * 
	 * @return array
	 */
	public function getWidgets() {
		return $this->_widgets;
	}
	
	/**
	 * Save user's dashboard refs
	 *
	 * @param $refs array Refs
	 * @param $accountId int|string Account id
	 * @return Default_Model_Util_Dashboard
	 */
	public function saveUserRefs($refs, $accountId) {
		// Format, input
		$refs = (array)$refs;
		
		// Save refs
		$accountEnt = $this->_repoAccount->find($accountId)->current();
		$accountEnt->setSettings($refs, 'DWRefs')->save();
		
		// Return
		return $this;
	}
	
	/**
	 * Get user's dashboard refs
	 *
	 * @param $accountId int|string Account id
	 * @return array
	 */
	public function getUserRefs($accountId) {
		// Get refs
		$accountEnt = $this->_repoAccount->find($accountId)->current();
		return $accountEnt->getSettings('DWRefs');
	}
}