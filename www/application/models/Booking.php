<?php
// application/models/Booking.php
class Application_Model_Booking
{
	/** Table name */
	protected $_tableName = 'tbl_building';
	
	/** Database adapter */
	protected $_dbAdapter;
	
	/** Constructor */
	public function __construct() {
		
		// Init database adapter;
		$this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
	}

	/**
	 * Check booking duplicate?
	 * @param string $roomNumber Room number
	 * @param int|string $buildingId Building id
	 * @param string $buildingName Building name
	 * @param string $buildingAddress Building adress
	 * @return int
	 */
	public function checkBookingDuplicate ($roomNumber, $buildingId, $buildingName = null, $buildingAddress = null)
	{
		$sql = $this->_dbAdapter->select()
			->from($this->_tableName, '(COUNT(*))')
			->where('room_number = ?', $roomNumber)
		;
		if ($buildingId) {
			$sql->where('building_id = ?', $buildingId);
		}
		if ($buildingName) {
			$sql->where('building_name = ?', $buildingName);
		}
		if ($buildingAddress) {
			$sql->where('building_address = ?', $buildingAddress);
		}
		//die($sql);
		
		// Return
		return 1 * $this->_dbAdapter->fetchOne($sql);
	}
	
	/**
	 * Check booking duplicate?
	 * @param string $roomNumber Room number
	 * @param int|string $buildingId Building id
	 * @param string $buildingName Building name
	 * @param string $buildingAddress Building adress
	 * @return int last insert id
	 */
	public function insert ($roomNumber, $buildingId = null, $buildingName = null, $buildingAddress = null)
	{
		return $this->_dbAdapter->insert($this->_tableName, array(
			'building_id' => (string)$buildingId,
			'building_name' => (string)$buildingName,
			'building_address' => (string)$buildingAddress,
			'room_number' => (string)$roomNumber
			
		));
	}
}