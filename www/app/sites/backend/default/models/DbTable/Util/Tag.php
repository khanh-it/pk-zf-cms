<?php
/**
 * @author khanhdtp
 */
class Default_Model_DbTable_Util_Tag extends Default_Model_DbTable_Util_Abstract
{
	/**
	 * @var K111_Filter_NoSpecialChar
	 */
	protected $_filterNoSpecialChar;
	
	/**
	 *
	 * @var ZF_Filter_Unicode
	 */
	protected $_filterNoMark;
	
	/**
	 * @var Default_Model_DbTable_Tag 
	 */
	protected $_repo;
	
	/**
	 * @var Default_Model_DbTable_TagItem 
	 */
	protected $_repoTagItem;
	
	/**
	 * Constructor
	 */
	protected function __construct(){
		// Initialize
		// @var Default_Model_DbTable_Tag
		$this->_repo = new Default_Model_DbTable_Tag();
		// @var Default_Model_DbTable_TagItem
		$this->_repoTagItem = new Default_Model_DbTable_TagItem();
		// @var K111_Filter_NoSpecialChar
		$this->_filterNoSpecialChar = new K111_Filter_NoSpecialChar();
		// @var K111_Filter_NoMark
		$this->_filterNoMark = new K111_Filter_NoMark();
	}
	
	/**
	 * @var Default_Model_DbTable_Util_Tag
	 */
	protected static $_instance;
	
	/**
	 * Helper, get class instance
	 * 
	 * @return this 
	 */
	public static function getInstance() {
		// Get class instance
		$instance = self::$_instance;
		if (!self::$_instance) {
			self::$_instance = new self();
		}
		// Return;
		return self::$_instance;
	}
	
	/**
	 * Create string alias
	 * 
	 * @param string $value Filter string
	 * @param string $replacement Replacement char for special chars        	
	 * @return string
	 */
	public function str2Alias($value, $replacement = '-') {
		return strtolower(str_replace(
			array(' '), 
			array($replacement), 
			$this->_filterNoSpecialChar->filter(
				$this->_filterNoMark->filter($value),
				$replacement
			)
		));
	}
	
	/**
	 * Helper: convert tags string (commas seperated into array)
	 * 
	 * @param $data string Tags string
	 * @return array 
	 */
	public function str2Arr($data) {
		// Format data
		$data = trim($data);
		
		// Format output data
		$tags = array_map(function($val){
			return trim($val);
		}, explode(',', $data));
		
		// Return
		return array_filter($tags);
	}
	
	/**
	 * Helper: format tag string
	 * 
	 * @param $data string Tag string
	 * @return array 
	 */
	public function formatTagName($data) {
		return strtolower($data);
	}
	
	/**
	 * Save tag(s) data
	 * 
	 * @param $context string Context string
	 * @param $itemId int|string Item object's id
	 * @param $data string Commas seperated tags
	 * @return array
	 */
	public function saveTag($context, $itemId, $data, array $options = array()) {
		// Format data
		$data = $this->str2Arr($data);
		
		// Format options
		
		// Keep old data?
		if (!$options['keep_old_data']) {
			$this->_repoTagItem->delete(array(
				'context = ?' => $context,
				'item_id = ?' => $itemId
			));
		}
		
		// Return data
		$tagRows = array();
		
		if (!empty($data)) {
			foreach ($data as $tagName) {
				// Format data
				$tagName = $this->formatTagName($tagName);
				//
				$row = $this->_repo->fetchRow(array(
					'name = ?' => $tagName
				));
				if (!$row) {
					$row = $this->_repo->createRow(array(
					// +++ name 
						'name' => $tagName,
					// +++ alias
						'alias' => $this->str2Alias($tagName),
					));
					$row->save();
				}
				// 
				$rowTagItem = $this->_repoTagItem->createRow(array(
				// +++  
					'tag_id' => $row->id,
				// +++ 
					'item_id' => $itemId,
				// +++ 
					'context' => $context,
				));
				$rowTagItem->save();
				
				//
				$tagRows[] = $row;
			}
		}
		
		// Return
		return $tagRows;
	}
}