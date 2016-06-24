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
	 * @proxy Proxy to $this->getFrontController()->getParam('bootstrap'); 
	 */
	public function getBootstrap() {
		return $this->getFrontController()->getParam('bootstrap');
	}
}