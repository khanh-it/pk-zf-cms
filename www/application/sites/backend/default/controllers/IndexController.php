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
	 * 
	 */
	public function indexAction()
	{
		//
		$this->view->readme = file_get_contents($READMEPath = APPLICATION_PATH . '/../README.txt');
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
	   'breadcrumb' => '',
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
	    // Layout's components;
	    $vData['components'] = $this->_getParam('components');
	    if (!is_array($vData['components'])) {
	        $vData['components'] = self::$_LAYOUT_COMPONENTS;
	    }

	    // Render VIEW;
	    $this->view->assign($vData);
	}
// End.+++ Layout +++ //
}