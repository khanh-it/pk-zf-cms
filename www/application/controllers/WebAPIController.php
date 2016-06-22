<?php
// application/controllers/WebAPIController.php
class WebAPIController extends Zend_Controller_Action
{
	/* @var Zend_Log */
	protected $_logger;
	
	/* Initialize action controller here */
	public function init()
	{
		// Log for access;
		$this->_log(array(
			'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
			'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
			'SERVER_NAME' => $_SERVER['SERVER_NAME'],
			'REQUEST_TIME' => $_SERVER['REQUEST_TIME']
		));
	}
	
/* Errors */
	const RES_STATUS_SUCCESS = 1;
	
	const RES_STATUS_FAILED = 0;
/* End.Errors */

/* Helpers */
	/**
	 * Helper: log for WebAPI accesses
	 * @return this
	 */
	protected function _log($data = null) {
		// Init logger to log for WebAPI access;
		if (!$this->_logger) {
			// +++ Define path;
			$logPath = APPLICATION_PATH . '/../data/access.log';
			// +++ Init logger;
			$this->_logger = new Zend_Log(
				new Zend_Log_Writer_Stream($logPath)
			);
		}
		// +++ Log
		$this->_logger->info(json_encode($data));
	}
	/**
	 * Helper: respone success as JSON to client
	 * @param mixed $data Respone data;
	 * @return string JSON
	 */
	protected function _resSuccessJSON($data) {
		$rtn = array(
			'status' => self::RES_STATUS_SUCCESS,
			'data' => $data
		);
		// Log for respone;
		$this->_log($rtn);
		// 
		return $this->_helper->json($rtn);
	}
	/**
	 * Helper: respone error as JSON to client
	 * @param string $msg Error message;
	 * @return string JSON
	 */
	protected function _resFailedJSON($msg) {
		$rtn = array(
			'status' => self::RES_STATUS_FAILED,
			'message' => $msg
		);
		// Log for respone;
		$this->_log($rtn);
		//
		return $this->_helper->json($rtn);
	}
/* End.Helpers */
	
/* Public WebAPI(s) goes here */
	/** 
	 * API: booking
	 * @param string $user Username used to access API.
	 * @param string $pass Password used to access API.	 
	 * @param int|string $building_id Building id
	 * @param string $building_name Building name
	 * @param string $building_address Building adress
	 * @param string $room_number Room number
	 * @return string JSON
	 */
	public function bookingAction()
	{
		// Get params
		$request = $this->getRequest();
		// 
		$params = $request->getQuery();
		// +++ Username
		$user = trim(strip_tags($params['user']));
		// +++ Password
		$pass = trim(strip_tags($params['pass']));
		// +++ Building id
		$buildingId = trim(strip_tags($params['building_id']));
		// +++ Building name
		$buildingName = trim(strip_tags($params['building_name']));
		// +++ Building 
		$buildingAddress = trim(strip_tags($params['building_address']));
		// +++ Building id
		$roomNumber = trim(strip_tags($params['room_number']));
		
		// Check for data validation;
		// *** Trong trường hợp [※1] đã được chỉ định thì [※2] không phải là trường bắt buộc. Trong trường hợp hai trường [※2] đã được chỉ định thì [※1] không phải là trường bắt buộc.							
		// *** Trong trường hợp [※1] và [※2] đều đã được chỉ định thì ưu tiên [※1].
		// +++ 
		if (!$buildingId && (!$buildingName || !$buildingAddress)) {
			return $this->_resFailedJSON('Missing required params. Param `building_id` must be supplied or 2 params `building_name` and `building_address`!');
		}
		// +++ 
		if (!$roomNumber) {
			return $this->_resFailedJSON('Missing required params. Param `room_number` must be supplied!');
		}
		
		// *** Trong trường hợp [※1] và [※2] đều đã được chỉ định thì ưu tiên [※1].
		if ($buildingId) {
			$buildingName = $buildingAddress = '';
		}
		
		// Define model;
		$bookingModel = new Application_Model_Booking();
		
		// Check booking duplicate by building_id;
		$isBookingDuplicate = $buildingId && $bookingModel->checkBookingDuplicate($roomNumber, $buildingId);
		if ($isBookingDuplicate) {
			return $this->_resFailedJSON("Booking with room number: `{$roomNumber}` by building id is duplicated!");
		}
		// Check booking duplicate by building_name, building_address;
		$isBookingDuplicate = ($buildingName && $buildingAddress) && $bookingModel->checkBookingDuplicate($roomNumber, null, $buildingName, $buildingAddress);
		if ($isBookingDuplicate) {
			return $this->_resFailedJSON("Booking with room number: `{$roomNumber}` by building name, and building address is duplicated!");
		}
		
		// All check for logic was done, insert data to database
		try {
			$bookingModel->insert($roomNumber, $buildingId, $buildingName, $buildingAddress);
			
			// Inform booking success;
			return $this->_resSuccessJSON("Booking with room number: `{$roomNumber}` is succeed!");
			
		} catch (Exception $e) {
			return $this->_resFailedJSON($e->getMessage());
		}
		// Exit on web api calls;
		die('');
	}
/* End.Public WebAPI(s) goes here */
}