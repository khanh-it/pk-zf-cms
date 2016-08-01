<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Phrase extends K111_Db_Table_Row_Abstract
{
	/**
	 * Encode data
	 * 
	 * @param array $data Data
	 * @return string
	 */
	public static function encodeData($data) {
		return is_array($data) ? serialize((array)$data) : $data;
	}
	
	/**
	 * Decode data
	 * 
	 * @param string $data Data
	 * @return array
	 */
	public static function decodeData($data) {
		$return = (@unserialize((string)$data));
		return (false === $return) ? array() : $return;
	}
	
	/**
	 * Get data (decoded)
	 * @return array
	 */
	public function getData() {
		if (is_string($this->_data['data'])) {
			return self::decodeData((string)$this->_data['data']);	
		}
		return $this->_data['data']; 
	}
	
	/**
	 * Set data (encode)
	 * 
	 * @param array|string $data data
	 * @return array
	 */
	public function setData($data) {
		// Format input data;
		// +++ 
		
		// Encode data;
		if (is_array($data)) {
			$data = self::encodeData($data);
		}
		$this->modifyData('data', $data);
				
		return $this;
	}
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{
	}
}