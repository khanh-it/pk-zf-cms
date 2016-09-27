<?php
/**
 * Requests for PHP
 *
 * Inspired by Requests for Python.
 *
 * Based on concepts from SimplePie_File, RequestCore and WP_Http.
 *
 * @package Requests
 */

// 
require_once dirname(__FILE__) . '/Requests.php';
Requests::register_autoloader();
 
/**
 * Requests for PHP
 *
 * Inspired by Requests for Python.
 *
 * Based on concepts from SimplePie_File, RequestCore and WP_Http.
 *
 * @package Requests
 */
class Requests_Proxy {
	/**
	 * @var array Default request headers! 
	 */
	protected $_headers = array(
		'Host' => '',
		//'Origin' => '',
		//'Upgrade-Insecure-Requests' => 1,
		'Referer' => '',
	);
	/**
	 * Get default request headers 
	 * @return array 
	 */
	public function getHeaders() {
		return $this->_headers;
	}
	
	/**
	 * @var array Default request data! 
	 */
	protected $_data = array(
		'GET' => null,
		'POST' => null,
	);
	/**
	 * Get default request data 
	 * @return array 
	 */
	public function getData() {
		return $this->_data;
	}
	
	/**
	 * @var array Default request options! 
	 */
	protected $_options = array();
	/**
	 * Get default request options 
	 * @return array 
	 */
	public function getOptions() {
		return $this->_options;
	}
	
	/**
	 * @var string Proxy url parts
	 */
	protected $_urlParts = array('protocol' => '', 'host' => '');
	
	/**
	 * @var string Proxy url
	 */
	protected $_url;
	/**
	 * Get proxy url
	 * @return string 
	 */
	public function getUrl() {
		return $this->_url;
	}
	/**
	 * Set proxy url
	 * 
	 * @param $url string Proxy url (exp: https://google.com)
	 * @return string 
	 */
	public function setUrl($url) {
		$pattern = '/((https?):\/\/([^\/]+)).*/i';
		if (!preg_match($pattern, $url, $matches)) {
			throw new Exception('Invalid $url provided!');
		}
		//
		$this->_url = $matches[1];
		$this->_urlParts['protocol'] = $matches[2];
		$this->_urlParts['host'] = $matches[3];
		//
		$this->_headers['Host'] = $this->_urlParts['host'];
		$this->_headers['Referer'] = $this->_urlParts['host'];
		//
		return $this;
	}
	
	/**
	 * @var string Base url
	 */
	protected $_baseUrl;
	/**
	 * Get proxy url
	 * @return string 
	 */
	public function getBaseUrl() {
		return $this->_baseUrl;
	}
	
	/**
	 * @var stdClass Session data 
	 */
	protected $_session;
	
	/**
	 * @var Requests_Session
	 */
	protected $_req;
	
	/**
	 * @var Requests_Response
	 */
	protected $_res;
	
	/**
	 * Construct
	 * Initialize action controller here
 	 */
	public function __construct($url, array $options = array())
	{
		//
		$this->setUrl($url);
		
		// 
		foreach ($options as $key => $value) {
			switch (strtolower($key)) {
			// Request headers
				case 'headers': {
					$this->_headers = array_merge($this->_headers, (array)$value);
				} break;
			// Request data
				case 'data': {
					$this->_data = array_merge($this->_data, (array)$value);
				} break;
			// Request options
				case 'options': {
					$this->_options = array_merge($this->_options, (array)$value);
				} break;
			// Base url
				case 'base_url': {
					$this->_baseUrl = trim($value);
				} break;
			}
		}
		
		// Init session data
		session_start();
		if (!isset($_SESSION[__CLASS__])) {
			$_SESSION[__CLASS__] = new stdClass();
		}
		$this->_session = $_SESSION[__CLASS__];
		
		// Init cookies
		if ($this->_session->cookiesJar) {
			$cookies = unserialize($this->_session->cookiesJar);
			// Set cookies.
			$this->_req->options['cookies'] = $cookies;
		}
		
		// Init Requests_Session
		$this->_req = new Requests_Session($this->getUrl(), $this->_headers, $this->_data, $this->_options);
	}
	
	/**
	 * 
	 */
	protected function _getFullURL($uri = '/') {
		$url = $this->_url;
		return $url . str_replace($url, '', $uri);
	}
	
	
	/**
	 * 
	 */
	public function _renderProxyAssets($matches) {
		//Zend_Debug::dump('$matches: ');
		//Zend_Debug::dump($matches);
		
		list($eleStr, $tagName, $attrStr, $attrName, $attrOpen, $attrValue, $attrClose) = $matches;
		
		
		$attrValue = "?_prx[assets]=" . urlencode($attrValue);
		
		//if (fasle !== strpos($attrValue, '://')) {}
		
		// 
		return str_replace($attrStr, "{$attrName}={$attrOpen}{$attrValue}{$attrClose}", $eleStr);
	}
	
	/**
	 * 
	 */
	protected function _render() {
		//
		$url = $this->_getFullURL();
		
		$pattern = '/<(\w+)[^>]*((src|href|action)\s*=\s*([\'"])([^\'"]*)([\'"]))[^>]*\/?>/is';
		return preg_replace_callback($pattern, array($this, '_renderProxyAssets'), $this->_res->body);
		
		//
		return str_replace(array(
			'src="/', 'href="/', 'action="/'
		), array(
			'src="' . $url, 'href="' . $url, 'action="' . $url
		), $this->_res->body);
	}
	
	/**
	 * 
	 */
	protected function _parseHtmlFormData($html, $props = array()) {
		//
		$return = array();
		//
		$pattern = '/<[^>]*name\s*=\s*[\'"]([^"]+)[\'"][^>]*value\s*=\s*[\'"]([^"]+)[\'"][^>]*\/?>/si';
		if (preg_match_all($pattern, $html, $matches)) {
			$arr = array();
			foreach ($matches[1] as $idx => $key) {
				$arr[$key] = $matches[2][$idx];
			}
		}
		foreach ($props as $prop) {
			$return[$prop] = $arr[$prop];
		}
		
		return $return;
	}
	
	/**
	 * 
	 */
	protected function _parseHtmlFormAction($html) {
		//
		$action = '';
		//
		$pattern = '/<form[^>]*action\s*=\s*[\'"]([^"]+)[\'"][^>]*\/?>/si';
		if (preg_match($pattern, $html, $matches)) {
			$action = $matches[1];
		}
		
		return $action;
	}
	
	/**
	 * 
	 * @return Requests_Response
	 */
	protected function _replace302Response(Requests_Response $response) {
		if (!$response->success && 302 == $response->status_code) {
			$response = $this->_req->get($response->headers['location']);
		}
		return $response;
	}
	
	/**
	 * 
	 * @return Requests_Proxy
	 */
	protected function _writeCookie()
	{
		// Init cookies
		$this->_session->cookies = serialize($response->cookies);
		// Return
		return $this;
	}
	
	/**
	 * @return Requests_Proxy
	 */
	protected function _proxyHeaders() {
		$headers = $this->_res->headers->getAll();
		//unset($headers['content-encoding']);
		foreach ((array)$headers as $key => $value) {
			header("{$key}: " . implode('', $value));
		}
		//Zend_Debug::dump($headers);
		// Return
		return $this;
	}
	
	/**
	 * @return Requests_Proxy
	 */
	protected function _proxyAssets($assets) {
		$assetsFull = $this->_getFullURL($assets);
		//
		$this->_res = $this->_req->get($assetsFull);
		// 
		$this->_proxyHeaders();
		//
		echo $this->_res->body;
		//
		exit(0);
	}
	
	/**
	 * Main function
	 */
	public function run()
	{
		$_prx = (array)$_GET['_prx'];
		unset($_GET['_prx']);
		
		if ($_prx['assets']) {
			return $this->_proxyAssets($_prx['assets']);
		}
		
		
		// 
		$this->_res = $this->_req->get('/');
		
		//
		echo $this
			->_proxyHeaders()
			->_writeCookie()
			->_render()
		;
		
		return $this;
	}
}