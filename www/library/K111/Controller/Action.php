<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Controller
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * @category   K111
 * @package    K111_Controller
 * @copyright  Free
 * @license    
 */
abstract class K111_Controller_Action extends Zend_Controller_Action
{
	/**
	 * @var stdClass
	 */
    protected $_authIdentity;
    
    /**
     * Get authenticate identity
     * @return null|stdClass
     */
    public function getAuthIdentity() {
        return $this->_authIdentity;
    } 
	
	/**
	 * @proxy Zend_Controller_Action::__construct
	 * 
	 * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array $invokeArgs Any additional invocation arguments
     * @return void
	 */
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
	    // Call to parent's constructor 
	    parent::__construct($request, $response, $invokeArgs);
	    
	    // 
	    $this->_authIdentity = Zend_Auth::getInstance()->getIdentity();
	    
	    // Assign view's default vars
	    $this->view->assign(array(
	        'curController' => $this,
	        'curRequest' => $this,
	        'curResponse' => $this
	    ));
	}
	
	/**
	 * @proxy Proxy to $this->getFrontController()->getParam('bootstrap');
	 */
	public function getBootstrap() {
	    return $this->getFrontController()->getParam('bootstrap');
	}
}