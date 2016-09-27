<?php
// application/controllers/IndexController.php

require_once 'Requests/Proxy.php';

/**
 * @author khanhdtp
 * @MCAInfo({
 	"name": "Error controller",
	"info": "Error page"
})
 */
class IndexController extends Zend_Controller_Action
{
	/**
	 * @author khanhdtp
 	 */
	public function init()
	{
		/* Initialize action controller here */
	}
	
	/**
	 * @author khanhdtp
	 * @MCAInfo({
	 	"name": "Index action",
		"info": "Index page"
	})
	 */
	public function indexAction()
	{}
	
	/**
	 * @author khanhdtp
	 * @MCAInfo({
	 	"name": "Index action",
		"info": "Index page"
	})
	 */
	public function proxyAction()
	{
		// 
		$this->_helper->layout->disableLayout(true);
		//
		$this->_helper->viewRenderer->setNoRender(true);
		
		$url = 'https://www.ana.co.jp';
		
		//
		$requestsProxy = new Requests_Proxy($url, array(
			'baseUrl' => $this->view->baseUrl('/index/proxy')
		));
		$requestsProxy->run();
	}
}