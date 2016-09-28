<?php
/**
 * Module default's bootstrap
 */
class Default_Bootstrap extends K111_Application_Module_Bootstrap
{
    /**
     * Load module's navigation?
     * @var bool
     */
    protected $_loadNavigation = true;
	
	/**
	 * Init dashboard widgets
	 * 
	 * @return void
	 */
	protected function _initDashboardWidgets() {
		// Assign self ref
		$bt = $this;
		// Attach event handler
		$this->_eventManager->attach(
			'Default.IndexIndex_beforeGetDashboardWidgets', 
			function(Zend_EventManager_Event $evt) use ($bt) {
				// Load widget configs
				$dbWidgets = require_once dirname(__FILE__) . '/configs/dashboard_widgets.php';
				if (!empty($dbWidgets)) {
					// Define vars
					// @var Default_Model_Util_Dashboard
					$dbUtil = Default_Model_Util_Dashboard::getInstance();
					
					// Register widgets
					foreach ((array)$dbWidgets as $offset => $data) {
						$dbUtil->registerWidget($dbUtil->createWidget($data), $offset);	
					}
				}
			}
		);
	}
}