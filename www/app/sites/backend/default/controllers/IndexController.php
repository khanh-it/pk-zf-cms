<?php
/**
 * 
 * @author khanh-it
 *
 */
class IndexController extends K111_Controller_Action
{
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		/* Initialize action controller here */
	}

	/**
	 * Dashboard
	 */
	public function indexAction()
	{
		// Get params
		// +++ Save dashboard widget refs 
		$DBWSaveRefs = (array)$this->_getParam('DBW_save_refs');
		
		// Define vars 
		// @var Default_Model_Util_Dashboard
		$dbUtil = Default_Model_Util_Dashboard::getInstance();
		// +++ View data
		$vData = array();
		
		// Action: save refs
		if (!empty($DBWSaveRefs)) {
			try {
				$dbUtil->saveUserRefs($DBWSaveRefs, $this->_authIdentity->id);
				// 
				return $this->_helper->json(array(
					'status' => 1, 'message' => 'OK'
				));
			} catch (Exception $e) {
				return $this->_helper->json(array(
					'status' => 0, 'message' => $e->getMessage()
				));
			}
			exit(0);
		}
		
		// Trigger event, ready for register widgets...
		$evtRes = $this->_eventManager->trigger('Default.IndexIndex_beforeGetDashboardWidgets');
		
		// User's refs
		$userRefs = $dbUtil->getUserRefs($this->_authIdentity->id);
		
		// Get list of dashboard widgets
	    $widgets = $dbUtil->getWidgets();
		// +++ sort
		if (!empty($userRefs)) {
			$_widgets = array();
			foreach ($userRefs as $DBWId => $DBWRef) {
				$_widgets[$DBWRef['offset']] = $widgets[$DBWRef['offset']];
			}
			$widgets = $_widgets;
			unset($_widgets, $DBWId, $DBWRef);
		}
		
		 // Render VIEW;
	    $this->view->assign(array_merge($vData, array(
	    	'widgets' => $widgets,
	    	'userRefs' => $userRefs
		)));
	}

	
// ++++++++++++++ //
// +++ Layout +++ // 
// ++++++++++++++ //
    /**
     * Define layout's components
     * @var array
     */
	protected static $_LAYOUT_COMPONENTS = array(
    // +++ 
        'header' => '',
    // +++
        'messages' => '',
	// +++ 
	   'breadcrumb' => '',
    // +++
	    'toolbars' => '',
    // +++ 
        'left_sidebar' => '',
    // +++
	    'right_sidebar' => '',
    // +++
	    'footer' => '',
	);
	
	/**
	 * Action: render layout's components;
	 */
	public function layoutAction() {
	    // Get, define vars
	    $vData = array();
	    // +++ Layout's components;
	    $vData['components'] = $this->_getParam('components');
	    if (!is_array($vData['components'])) {
	        $vData['components'] = self::$_LAYOUT_COMPONENTS;
	    }
		// +++ Account's info
		$vData['authIdentity'] = $this->_authIdentity; 
	    
	    // Render VIEW;
	    $this->view->assign($vData);
	}
// End.+++ Layout +++ //
}