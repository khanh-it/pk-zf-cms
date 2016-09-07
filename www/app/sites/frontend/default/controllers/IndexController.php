<?php
//app/sites/frontend/default/controllers/IndexController.php

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
class IndexController extends Zend_Controller_Action
{
	/**
	 * @var ANA's url..!
	 */
	protected $_anaURL = 'https://aswbe-d.ana.co.jp';
	
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
	 	"name" => "Index action",
		"info" => "Index page"
	})
	 */
	public function indexAction()
	{
		set_time_limit(0);
		
		//$url = 'http://proxylist.hidemyass.com/';
		//$respone = Requests::post($url);
		
		//
		$this->_helper->layout->disableLayout(true);
		/*
		$url = 'http://www.xroxy.com/proxyrss.xml';
		$xml = file_get_contents($url);
		$xml = str_replace(array('prx:'), array(''), $xml);
		$xml = new Zend_Config_Xml($xml);
		$xml = $xml->channel->item->toArray();
		
		$proxyList = array();
		foreach ($xml as $item) {
			foreach ($item['proxy'] as $proxy) {
				$proxyList[] = $proxy;
			}
		}*/
		//require_once "\Zend\Debug.php";
		//Zend_Debug::dump($proxyList);
		//die();
		
		//
		//$queryStr = date('YmdHis');
		$url = 'https://aswbe-d.ana.co.jp/Axkow23/rsvp/dyc_en/ASWVacant.do?rand=' . $queryStr;
		$session = new Requests_Session($url);
		$session->useragent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/56.3.120 Chrome/50.3.2661.120 Safari/537.36';
		
		$data = array(
			'segConditionForm.selectedDepApo' => 'HND',
			'segConditionForm.selectedArrApo' => 'AKJ',
			'paxCountConditionForm.selectedAdultCount' => 1,
			'paxCountConditionForm.selectedChildCount' => 0,
			'paxCountConditionForm.selectedInfantCount' => 0,
			'btnSubmit:mapping=success' => '',
			'segConditionForm.seatKind' => 'Y',
			'segConditionForm.selectedDepTime' => '-',
			'segConditionForm.ttwCalFlg' => 0,
			'segConditionForm.selectedEmbMonth' => '08',
			'segConditionForm.selectedEmbDay' => 31,
			'segConditionForm.nowSegIndex' => 1,
			'CONNECTION_KIND' => 'TOP'
		);
		
		$success = 0;
		foreach ($proxyList as $proxy) {
			$options = array(
				'proxy' => "{$proxy['ip']}:{$proxy['port']}"
			); 
			
			$response = $session->post('', $options, $data);
			
			Zend_Debug::dump("Proxy: {$proxy['ip']}:{$proxy['port']}.<br/>");
			echo "{$response->status_code}<br/><br/>";
			if ($response->success) {
				//echo $response->body;
				++$success;
			}
		}
		
		require_once "\Zend\Debug.php";
		Zend_Debug::dump(count($proxyList));
		Zend_Debug::dump($success);
		die();
	}

	/**
	 * 
	 */
	public function anaAction()
	{
		//
		set_time_limit(0);
		//
		$this->_helper->layout->disableLayout(true);
		
		//
		$url = 'https://aswbe-d.ana.co.jp/9Eile48/dms/dyc/be/pages/res/reservation/reservationPaxInformationInput.xhtml?aswdcid=1&browser-cache-disable=true';
		//		
		//$cookiesStr = 'O:19:"Requests_Cookie_Jar":1:{s:10:"*cookies";a:1:{s:4:"aswd";O:15:"Requests_Cookie":3:{s:4:"name";s:4:"aswd";s:5:"value";s:63:"mw9S9D8oO5WsTee2azMb01qFDSk81M86UAcEgJpWkQ68wqauUf4X!1837811549";s:10:"attributes";O:42:"Requests_Utility_CaseInsensitiveDictionary":1:{s:7:"*data";a:3:{s:4:"path";s:1:"/";s:6:"secure";b:1;s:8:"httponly";b:1;}}}}}';
		//$cookies = unserialize($cookiesStr);
		$cookies = new Requests_Cookie_Jar();
		$cookies->offsetSet(0, new Requests_Cookie('aswd', 'mw9S9D8oO5WsTee2azMb01qFDSk81M86UAcEgJpWkQ68wqauUf4X', array(
			'path' => '/',
			'secure' => true,
			'httponly' => true,
		)));
		//require_once "\Zend\Debug.php";
		//Zend_Debug::dump($cookies);die();
		//
		//
		//$queryStr = date('YmdHis');
		$req = new Requests_Session($url, array(), array(), array(
			'cookies' => $cookies
		));
		// 
		// +++ 
		$req->headers = array_merge($req->headers, array(
			'Host' => 'aswbe-d.ana.co.jp',
			'Origin' => 'https://aswbe-d.ana.co.jp',
			'Upgrade-Insecure-Requests' => 1
		));
		// +++
		$req->useragent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/56.3.120 Chrome/50.3.2661.120 Safari/537.36';
		
		$respone = $req->get($url);
		//die($this->_anaRenderHtml($respone->body));
		
		$this->_anaStep3($req, $respone);
		
		//
		//$this->_anaStep1($req);
	}
	/**
	 * 
	 */
	protected function _anaGetURL($uri = '/') {
		//
		$url = $this->_anaURL;
		//
		return $url . str_replace($url, '', $uri);
	}
	/**
	 * 
	 */
	protected function _anaRenderHtml($html) {
		//
		$url = $this->_anaGetURL();
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
	protected function _anaParseHtmlFormData($html, $skip = array()) {
		//
		$return = array();
		//
		$pattern = '/<[^>]*name\s*=\s*[\'"]([^"]+)[\'"][^>]*value\s*=\s*[\'"]([^"]+)[\'"][^>]*\/?>/si';
		if (preg_match_all($pattern, $html, $matches)) {
			foreach ($matches[1] as $key => $val) {
				if ($skip[$val]) {
					 continue; 
				}
				$return[$val] = $matches[2][$key];
			}
		}
		
		return $return;
	}
	/**
	 * 
	 */
	protected function _anaParseHtmlFormAction($html) {
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
	protected function _anaStep1(Requests_Session $req, array $_data = array()) {
		// ===== 1.1 ===== //
		/*$url = $this->_anaGetURL();
		$response = $req->get($url);
		
		require_once "\Zend\Debug.php";
		Zend_Debug::dump($response->cookies);
		die();*/ 
		
		//
		$url = $this->_anaGetURL('/9Eile48/dms/dyc/be/pages/res/search/vacantEntranceDispatch.xhtml');
		//
		$params = $this->_request->getQuery();
		//
		$data = array_merge(array(
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
		), $_data);
		unset($_data);
		//require_once "\Zend\Debug.php";
		//Zend_Debug::dump($data);die();
		// 
		$response = $req->post($url, array(), $data);
		if (!$response->success) {
			die('Step 1: failed. Status code: ' . $response->status_code . '.');
		}
		//die($this->_anaRenderHtml($response->body));
		//
		$this->_anaStep2($req, $response);
	}
	/**
	 * 
	 */
	protected function _anaStep2(Requests_Session $req, Requests_Response $response) {
		//
		$url = $this->_anaGetURL($this->_anaParseHtmlFormAction($response->body));
		$_data = (array)$this->_anaParseHtmlFormData($response->body, array(
			'departureMultiAirportButton' => true,
			'arrivalMultiAirportButton' => true,
			'addFlightButton' => true,
			'nextFlightButton' => true
		));
		//require_once "\Zend\Debug.php";
		//Zend_Debug::dump($url);Zend_Debug::dump($_data);die();
		//
		//ANJ_11_05_461_HND_OKA_SG50K
		$fareCode = array(
			'ANJ', '11', '05', '461', $_data['selectedDepartureAirport'], $_data['selectedArrivalAirport'], 'SG50K'
		);
		$fareTime = array(
			'0610', '0905', '738'
		);
		$farePrice = 23190;
		//
		$data = array_merge(array(
			'fromPageName' => '',
			'vacantResultForm' => '',
			'2tkzAk16' => '',
			'asw.transaction.token' => '',
			'selectedOutwardEmbarkationDate' => '',
			'selectedDepartureAirport' => '',
			'selectedArrivalAirport' => '',
			'selectedCompartmentClass' => '',
			'selectedAdultCount' => '',
			'selectedChildCount' => '',
			'selectedInfantCount' => '',
			'selectedSearchMode' => '',
			'pageInfomationData' => '0',
			'selectFare' => implode('_', $fareCode),
			'selectionPrice' => $farePrice,
			'javax.faces.ViewState' => '',
			'confirmButton' => '',
			'fromButtonName' => $_data['nextFlightButton'],
			'SelectSegmentInfo:0:boardingYear' => '2016',
			'SelectSegmentInfo:0:boardingMonth' => $fareCode[1],
			'SelectSegmentInfo:0:boardingDay' => $fareCode[2],
			'SelectSegmentInfo:0:carrierCode' => $fareCode[0],
			'SelectSegmentInfo:0:flightNumber' => $fareCode[3],
			'SelectSegmentInfo:0:compartmentClass' => 'Y',
			'SelectSegmentInfo:0:bookingClass' => 'X',
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
			'SelectSegmentInfo:1:boardingYear' => '',
			'SelectSegmentInfo:1:boardingMonth' => '',
			'SelectSegmentInfo:1:boardingDay' => '',
			'SelectSegmentInfo:1:carrierCode' => '',
			'SelectSegmentInfo:1:flightNumber' => '',
			'SelectSegmentInfo:1:compartmentClass' => '',
			'SelectSegmentInfo:1:bookingClass' => '',
			'SelectSegmentInfo:1:deptAirportCode' => '',
			'SelectSegmentInfo:1:arvlAirportCode' => '',
			'SelectSegmentInfo:1:deptTime' => '',
			'SelectSegmentInfo:1:arvlTime' => '',
			'SelectSegmentInfo:1:awardSeasonality' => '',
			'SelectSegmentInfo:1:fareType' => '',
			'SelectSegmentInfo:1:price' => '',
			'SelectSegmentInfo:1:waitingFlg' => '',
			'SelectSegmentInfo:1:connectTime' => '',
			'SelectSegmentInfo:1:modelCode' => '',
			'SelectSegmentInfo:2:boardingYear' => '',
			'SelectSegmentInfo:2:boardingMonth' => '',
			'SelectSegmentInfo:2:boardingDay' => '',
			'SelectSegmentInfo:2:carrierCode' => '',
			'SelectSegmentInfo:2:flightNumber' => '',
			'SelectSegmentInfo:2:compartmentClass' => '',
			'SelectSegmentInfo:2:bookingClass' => '',
			'SelectSegmentInfo:2:deptAirportCode' => '',
			'SelectSegmentInfo:2:arvlAirportCode' => '',
			'SelectSegmentInfo:2:deptTime' => '',
			'SelectSegmentInfo:2:arvlTime' => '',
			'SelectSegmentInfo:2:awardSeasonality' => '',
			'SelectSegmentInfo:2:fareType' => '',
			'SelectSegmentInfo:2:price' => '',
			'SelectSegmentInfo:2:waitingFlg' => '',
			'SelectSegmentInfo:2:connectTime' => '',
			'SelectSegmentInfo:2:modelCode' => ''
		), (array)$_data);
		unset($_data);
		//require_once "\Zend\Debug.php";
		//Zend_Debug::dump($data);die();
		// 
		$response = $req->post($url, array(), $data, array('follow_redirects' => false));
		if (!$response->success && 302 != $response->status_code) {
			die('Step 2.1: failed. Status code: ' . $response->status_code . '.');
		}
		//die($this->_anaRenderHtml($response->body));
		
		// ==== 2.2 === //
		//
		$url = $this->_anaGetURL($this->_anaParseHtmlFormAction($response->body));
		$data = (array)$this->_anaParseHtmlFormData($response->body, array(
			'modalMember' => true,
			'modalNext' => true,
			'dialogNextConf:j_idt453' => true,
			'dialogNextConf:j_idt457' => true,
			'dialogMemberConf:j_idt453' => true,
			'dialogMemberConf:j_idt457' => true,
			'dialogGeneralConf:j_idt453' => true,
			'dialogGeneralConf:j_idt457' => true,
			'j_idt63' => true,
			'j_idt165:0:j_idt191' => true,
			'j_idt252' => true
		));
		//require_once "\Zend\Debug.php";
		//Zend_Debug::dump($url);Zend_Debug::dump($data);die();
		// 
		$response = $req->post($url, array(), $data, array('follow_redirects' => false));
		if (!$response->success && 302 != $response->status_code) {
			die('Step 2.1: failed. Status code: ' . $response->status_code . '.');
		}
		$url = $response->headers->getValues('location');
		$response = $req->get($url = current($url));
		
		//echo $url; 
		die(serialize($response->cookies));
		die($this->_anaRenderHtml($response->body));
		
		//
		$this->_anaStep3($req, $response);
	}

	protected function _anaStep3(Requests_Session $req, Requests_Response $response) {
		//
		$url = $this->_anaGetURL($this->_anaParseHtmlFormAction($response->body));
		$_data = (array)$this->_anaParseHtmlFormData($response->body, array(
			'dialogNextButton:j_idt674' => true,
			'dialogNextButton:j_idt678' => true,
			'dialogNextButtonIM:j_idt674' => true,
			'dialogNextButtonIM:j_idt678' => true,
			'j_idt371' => true,
			'j_idt63' => true
		));
		$n = '4'; $char = 'D';
		$data = array_merge((array)$_data, array(
			//'fromPageName' => '',
			//'j_idt149' => '',
			//'2tkzAk16' => '',
			//'asw.transaction.token' => '',
			'j_idt167:0:paxLastName' => "khanh{$char}",
			'j_idt167:0:paxFirstName' => "phi{$char}",
			'j_idt167:0:age' => '28',
			'j_idt167:0:radioSexCode' => 'M',
			'j_idt167:0:memberNumber' => '',
			'telKind' => 'K',
			'telNo' => "0937-984-90{$n}",
			'telephoneNumberEditFlagField' => 'true',
			'mailReceivePaxNo' => '1',
			'assistMailAddress' => "phikhanh.8x@gmail.com",
			'mailSendHopeDiscrimination' => 'd',
			//'javax.faces.ViewState' => '',
			'j_idt371' => 'j_idt371',
			'fromButtonName' => '予約する',
			'aswbedCaptchaAuthText' => '17075',
			'consentConfirmFlag' => 'on'
		));
		unset($_data);
		/*foreach ($data as $key => $value) {
			$uKey = urlencode($key);
			unset($data[$key]);
			$data[$uKey] = urlencode($value);
		}*/
		require_once "\Zend\Debug.php";
		Zend_Debug::dump($url);Zend_Debug::dump($data);//die();
		
		// 
		$response = $req->post($url, array(), $data, array('follow_redirects' => false));
		if (!$response->success && 302 != $response->status_code) {
			die('Step 3.1: failed. Status code: ' . $response->status_code . '.');
		}
		$url = $response->headers->getValues('location');
		$response = $req->get($url = current($url));
		require_once "\Zend\Debug.php";
		Zend_Debug::dump($url);
		die($this->_anaRenderHtml($response->body));
	}

	public function regxAction() {
		$html = file_get_contents(__DIR__ . '/regx.html');
		
		die($html);
	}
}
//end.app/sites/frontend/default/controllers/IndexController.php