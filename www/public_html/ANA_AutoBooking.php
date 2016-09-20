<?php
// Define path to project directory
define('PROJECT_ROOT', realpath(dirname(__FILE__)) . '/..');

// Define path to library directory
define('LIB_PATH', PROJECT_ROOT . '/library');

// Define application environment
define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'development'));

// Typically, you will also want to add your library directory
// to the include_path, particularly if it contains your ZF installed
set_include_path(implode(PATH_SEPARATOR, array(LIB_PATH, get_include_path())));

// --- Require files ---
require_once 'Requests/Requests.php';
// Next, make sure Requests can load internal classes
Requests::register_autoloader();

/**
 * @author khanhdtp
 * @MCAInfo({
 	"name" => "Error controller",
	"info" => "Error page"
})
 */
class AutoBooking_ANA {
	/**
	 * @var ANA's auto booking url..!
	 */
	protected $_url = 'https://aswbe-d.ana.co.jp';
	/**
	 * @var array Default request headers! 
	 */
	protected $_headers = array(
		'Host' => 'aswbe-d.ana.co.jp',
		'Origin' => 'https://aswbe-d.ana.co.jp',
		'Upgrade-Insecure-Requests' => 1
	);
	/**
	 * @var array Default request data! 
	 */
	protected $_data = array();
	/**
	 * @var array Default request options! 
	 */
	protected $_options = array(
		'useragent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36'
	);
	/**
	 * @var stdClass Session data 
	 */
	protected $_session;
	
	/**
	 * @var Requests_Session
	 */
	protected $_req;
	
	/**
	 * Construct
	 * Initialize action controller here
 	 */
	public function __construct()
	{
		// Disable timeout.
		set_time_limit(0);
		
		// Init session data
		session_start();
		if (!isset($_SESSION[__CLASS__])) {
			$_SESSION[__CLASS__] = new stdClass();
		}
		$this->_session = $_SESSION[__CLASS__];
		
		// Init Requests_Session
		$this->_req = new Requests_Session($this->_url, $this->_headers, $this->_data, $this->_options);
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
	protected function _render($html) {
		//
		$url = $this->_getFullURL();
		//
		return str_replace(array(
			'<?xml version="1.0" encoding="UTF-8" ?>',
			'src="/', 'href="/', 'action="/'
		), array(
			'', 'src="' . $url, 'href="' . $url, 'action="' . $url
		), $html);
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
	 */
	protected function _getFeeContent($str){
		
		$matches_table = array(); $offset = 0;
		while (true) {
			$start = strpos($str, $tagStart = '<table>', $offset);
			$offset = $end = strpos($str, $tagEnd = '</table>', $start);
			
			if (false === $start || false === $end) { break; }
			
			$subStr = substr($str, $start, $end - $start + strlen($tagEnd));
			$matches_table[] = str_replace(array($tagStart, $tagEnd), array('', ''), $subStr); 
		}
		
		return implode('', $matches_table);
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
	 * @param $response Requests_Response Requests response
	 * @return string
	 */
	protected function _getCaptchaAuthText(Requests_Response $response) {
		// Captcha Auth Text
		$authText = '';

		// Check response for captcha...
		$pattern = '/<img[^>]*src\s*=\s*"([^"]+kaptcha[^"]+)"[^>]*\/?>/';
		if (preg_match($pattern, $response->body, $matches)) {
			// Captcha url
			if ($captchaUrl = $this->_getFullURL($matches[1])) {
				// Get system temp dir
				$tempDir = sys_get_temp_dir();
				// 
				$sessionID = @session_id();
				//
				@unlink($captchaFile = "{$tempDir}/{$sessionID}." . array_pop(explode('/', $captchaUrl)));
				@unlink($captchaTxt = "{$tempDir}/{$sessionID}.captcha.txt");
				// 
				$captchaRes = $this->_req->get($captchaUrl);
				file_put_contents($captchaFile, $captchaRes->body);
				// 
				while (true) {
					$authText = trim(@file_get_contents($captchaTxt));
					if ($authText) {
						//
						@unlink($captchaFile); @unlink($captchaTxt);
						//
						break; 
					}
					sleep(1);
				}
			}
		}
		// Return
		return $authText;
	}
	
	/**
	 * Main function
	 */
	public function run()
	{
		// Init cookies
		if ($this->_session->cookies) {
			$cookies = new Requests_Cookie_Jar();
			foreach ($this->_session->cookies as $offset => $cookie) {
				list($cookName, $cookValue, $cookAttrs) = (array)$cookie;
				$cookies->offsetSet($offset, new Requests_Cookie($cookName, $cookValue, array_merg(array(
					'path' => '/', 'secure' => true, 'httponly' => true,
				), $cookAttrs)));
			}
			unset($offset, $cookie, $cookName, $cookValue, $cookAttrs);
			// Set cookies.
			$this->_req->options['cookies'] = $cookies;
		}
		
		// Run step 1...
		$this->_step1();
	}
	/**
	 * 
	 */
	protected function _step1() {
		// Get, +format request params...
		$params = $_GET;
		
		// Request POST...
		// +++
		$url = $this->_getFullURL('/9Eile48/dms/dyc/be/pages/res/search/vacantEntranceDispatch.xhtml');
		// +++
		$data = array(
			'roundFlag' => $params['rFlag'] ?: '0',
			'adultCount' => $params['adult'] ?: '1',
			'childCount' => $params['child'] ?: '0',
			'infantCount' => $params['infant'] ?: '0',
			'compartmentClass' => $params['comClass'] ?: 'Y',
			'searchMode' => $params['sMode'] ?: '0',
			'departureAirport' => $params['dep'] ?: '',
			'arrivalAirport' => $params['des'] ?: '',
			'outboundBoardingDate' => $params['oBD'] ?: '',
			'inboundBoardingDate' => $params['iBD'] ?: '',
		);
		if ('step1' == $_GET['dump']) {
			echo '<pre>$url: ';var_dump($url);echo '</pre>';
			echo '<pre>$data: ';var_dump($data);echo '</pre>';
			die();
		}
		// +++ request
		$response = $this->_replace302Response(
			$this->_req->post($url, array(), $data, array('follow_redirects' => false))
		);
		if ('step1' == $_GET['stop']) {
			die($this->_render($response->body));
		}
		
		// Run step 1...
		$this->_step2($response);
	}
	/**
	 * 
	 */
	protected function _step2(Requests_Response $response) {
		// Request POST...
		// +++ 
		$url = $this->_getFullURL($this->_parseHtmlFormAction($response->body));
		// +++ 
		$data = $this->_parseHtmlFormData($response->body, array(
			'fromPageName',
			'vacantResultForm',
			'2tkzAk16',
			'asw.transaction.token',
			'selectedOutwardEmbarkationDate',
			'selectedDepartureAirport',
			'selectedArrivalAirport',
			'selectedCompartmentClass',
			'selectedAdultCount',
			'selectedChildCount',
			'selectedInfantCount',
			'selectedSearchMode',
			'selectedFareCode',
			'pageInfomationData',
			'selectFare',
			'selectionPrice',
			'SelectSegmentInfo:0:boardingYear',
			'SelectSegmentInfo:0:boardingMonth',
			'SelectSegmentInfo:0:boardingDay',
			'SelectSegmentInfo:0:carrierCode',
			'SelectSegmentInfo:0:flightNumber',
			'SelectSegmentInfo:0:compartmentClass',
			'SelectSegmentInfo:0:bookingClass',
			'SelectSegmentInfo:0:deptAirportCode',
			'SelectSegmentInfo:0:arvlAirportCode',
			'SelectSegmentInfo:0:deptTime',
			'SelectSegmentInfo:0:arvlTime',
			'SelectSegmentInfo:0:awardSeasonality',
			'SelectSegmentInfo:0:fareType',
			'SelectSegmentInfo:0:price',
			'SelectSegmentInfo:0:waitingFlg',
			'SelectSegmentInfo:0:connectTime',
			'SelectSegmentInfo:0:modelCode',
			'SelectSegmentInfo:1:boardingYear',
			'SelectSegmentInfo:1:boardingMonth',
			'SelectSegmentInfo:1:boardingDay',
			'SelectSegmentInfo:1:carrierCode',
			'SelectSegmentInfo:1:flightNumber',
			'SelectSegmentInfo:1:compartmentClass',
			'SelectSegmentInfo:1:bookingClass',
			'SelectSegmentInfo:1:deptAirportCode',
			'SelectSegmentInfo:1:arvlAirportCode',
			'SelectSegmentInfo:1:deptTime',
			'SelectSegmentInfo:1:arvlTime',
			'SelectSegmentInfo:1:awardSeasonality',
			'SelectSegmentInfo:1:fareType',
			'SelectSegmentInfo:1:price',
			'SelectSegmentInfo:1:waitingFlg',
			'SelectSegmentInfo:1:connectTime',
			'SelectSegmentInfo:1:modelCode',
			'SelectSegmentInfo:2:boardingYear',
			'SelectSegmentInfo:2:boardingMonth',
			'SelectSegmentInfo:2:boardingDay',
			'SelectSegmentInfo:2:carrierCode',
			'SelectSegmentInfo:2:flightNumber',
			'SelectSegmentInfo:2:compartmentClass',
			'SelectSegmentInfo:2:bookingClass',
			'SelectSegmentInfo:2:deptAirportCode',
			'SelectSegmentInfo:2:arvlAirportCode',
			'SelectSegmentInfo:2:deptTime',
			'SelectSegmentInfo:2:arvlTime',
			'SelectSegmentInfo:2:awardSeasonality',
			'SelectSegmentInfo:2:fareType',
			'SelectSegmentInfo:2:price',
			'SelectSegmentInfo:2:waitingFlg',
			'SelectSegmentInfo:2:connectTime',
			'SelectSegmentInfo:2:modelCode',
			'javax.faces.ViewState',
			'confirmButton',
			'fromButtonName'
		));
		
		
		//ADN_10_30_4743_HND_SPK_OW
		$fareCode = array('ANA', '10', '30', '4743', $data['selectedDepartureAirport'], $data['selectedArrivalAirport'], 'OW');
		$fareTime = array('2130', '2305', '73D');
		$farePrice = 37790;
		//
		$data = array_merge($data, array(
			'pageInfomationData' => '1',
			'selectFare' => implode('_', $fareCode),
			'selectionPrice' => $farePrice,
			'SelectSegmentInfo:0:boardingYear' => '2016',
			'SelectSegmentInfo:0:boardingMonth' => $fareCode[1],
			'SelectSegmentInfo:0:boardingDay' => $fareCode[2],
			'SelectSegmentInfo:0:carrierCode' => $fareCode[0],
			'SelectSegmentInfo:0:flightNumber' => $fareCode[3],
			'SelectSegmentInfo:0:compartmentClass' => 'Y',
			'SelectSegmentInfo:0:bookingClass' => 'Y',
			'SelectSegmentInfo:0:deptAirportCode' => $fareCode[4],
			'SelectSegmentInfo:0:arvlAirportCode' => $fareCode[5],
			'SelectSegmentInfo:0:deptTime' => $fareTime[0],
			'SelectSegmentInfo:0:arvlTime' => $fareTime[1],
			'SelectSegmentInfo:0:awardSeasonality' => '',
			'SelectSegmentInfo:0:fareType' => $fareCode[6],
			'SelectSegmentInfo:0:price' => $farePrice,
			'SelectSegmentInfo:0:waitingFlg' => 'FALSE',
			'SelectSegmentInfo:0:connectTime' => '',
			'SelectSegmentInfo:0:modelCode' => $fareTime[2],
			'confirmButton' => 'confirmButton',
			'fromButtonName' => $data['confirmButton'],
		));
		if ('step2' == $_GET['dump']) {
			echo '<pre>$url: ';var_dump($url);echo '</pre>';
			echo '<pre>$data: ';var_dump($data);echo '</pre>';
			die();
		}
		// +++
		$response = $this->_replace302Response(
			$this->_req->post($url, array(), $data, array('follow_redirects' => false))
		);
		if ('step2' == $_GET['stop']) {
			die($this->_render($response->body));
		}
		
		// Run step 3
		$this->_step3($response);
	}
	/**
	 * 
	 */
	protected function _step3(Requests_Response $response) {
		// +++ 
		$url = $this->_getFullURL($this->_parseHtmlFormAction($response->body));
		// +++ 
		$data = (array)$this->_parseHtmlFormData($response->body, array(
			'fromPageName',
			'j_idt149',
			'2tkzAk16',
			'asw.transaction.token',
			'displayFlightInfo',
			'javax.faces.ViewState',
			'modalGeneral',
			'fromButtonName'
		));
		$data = array_merge($data, array(
			'modalGeneral' => 'modalGeneral',
			'fromButtonName' => $data['modalGeneral'],
		));
		if ('step3' == $_GET['dump']) {
			echo '<pre>$url: ';var_dump($url);echo '</pre>';
			echo '<pre>$data: ';var_dump($data);echo '</pre>';
			die();
		}
		// +++ request
		$response = $this->_replace302Response(
			$this->_req->post($url, array(), $data, array('follow_redirects' => false))
		);
		if ('step3' == $_GET['stop']) {
			die($this->_render($response->body));
		}
		
		// Run step 4
		$this->_step4($response);
	}
	/**
	 * 
	 */
	protected function _step4(Requests_Response $response) {
		// +++ 
		$url = $this->_getFullURL($this->_parseHtmlFormAction($response->body));
		// +++ 
		$data = (array)$this->_parseHtmlFormData($response->body, array(
			'fromPageName',
			'j_idt149',
			'2tkzAk16',
			'asw.transaction.token',
			'j_idt167:0:paxLastName',
			'j_idt167:0:paxFirstName',
			'j_idt167:0:age',
			'j_idt167:0:radioSexCode',
			'j_idt167:0:memberNumber',
			'telKind',
			'telNo',
			'telephoneNumberEditFlagField',
			'mailReceivePaxNo',
			'assistMailAddress',
			'mailSendHopeDiscrimination',
			'aswbedCaptchaAuthText',
			'javax.faces.ViewState',
			'j_idt371',
			'fromButtonName',
		));
		$n = '7'; $char = 'G';
		$data = array_merge($data, array(
			'j_idt167:0:paxLastName' => "khanh{$char}",
			'j_idt167:0:paxFirstName' => "phi{$char}",
			'j_idt167:0:age' => '28',
			'j_idt167:0:radioSexCode' => 'M',
			'j_idt167:0:memberNumber' => '',
			'telKind' => 'K',
			'telNo' => "0937-984-90{$n}",
			'telephoneNumberEditFlagField' => 'true',
			'mailReceivePaxNo' => '1',
			'assistMailAddress' => "phikhanh{$char}.8x@gmail.com",
			'mailSendHopeDiscrimination' => 'd',
			'j_idt371' => 'j_idt371',
			'fromButtonName' => $data['j_idt371'],
			'consentConfirmFlag' => 'on',
			
		));
		if ($authText = $this->_getCaptchaAuthText($response)) {
			$data['aswbedCaptchaAuthText'] = $authText;
		}
		if ('step4' == $_GET['dump']) {
			echo '<pre>$url: ';var_dump($url);echo '</pre>';
			echo '<pre>$data: ';var_dump($data);echo '</pre>';
			die();
		}
		// +++ request
		$response = $this->_replace302Response(
			$this->_req->post($url, array(), $data, array('follow_redirects' => false))
		);
		//if ('step4' == $_GET['stop']) {
			die($this->_render($response->body));
		//}
	}
}

// 
$ab = new AutoBooking_ANA();
$ab->run();