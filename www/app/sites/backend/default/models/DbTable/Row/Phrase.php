<?php
/**
 * 
 * @author khanhdtp
 */
class Default_Model_DbTable_Row_Phrase extends K111_Db_Table_Row_Abstract
{
	// /**
	 // * Encode data
	 // * 
	 // * @param array $data Data
	 // * @return string
	 // */
	// public static function encodeData($data) {
		// return is_string($data) ? $data : json_encode($data);
	// }
// 	
	// /**
	 // * Decode data
	 // * 
	 // * @param string $data Data
	 // * @return array
	 // */
	// public static function decodeData($data) {
		// return (array)(@json_decode((string)$data, JSON_OBJECT_AS_ARRAY));
	// }
// 	
	// /**
	 // * Get data (decoded)
	 // * @return array
	 // */
	// public function getPhr_data() {
		// if (is_string($this->_data['phr_data'])) {
			// return self::decodeData((string)$this->_data['phr_data']);	
		// }
		// return $this->_data['phr_data']; 
	// }
// 	
	// /**
	 // * Set data (encode)
	 // * 
	 // * @param array|string $data data
	 // * @return array
	 // */
	// public function setPhr_data($data) {
		// // Format input data;
		// // +++ 
// 		
		// // Encode data;
		// if (is_array($data)) {
			// $data = self::encodeData($data);
		// }
		// $this->modifyData('phr_data', $data);
// 				
		// return $this;
	// }
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{}
}