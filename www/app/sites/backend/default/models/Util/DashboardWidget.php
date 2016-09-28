<?php
/**
 * Dashboard widget item
 * @author khanhdtp
 */
class Default_Model_Util_DashboardWidget
{
	/**
	 * Constructor
	 */
	public function __construct(array $options = array()){
		// Format options
		foreach ($options as $key => $value) {
			switch (strtolower($key)) {
			// lang
				case 'lang': {
					$this->setLang($value); 
				} break;
			// name
				case 'name': {
					$this->setName($value); 
				} break;
			// note
				case 'note': {
					$this->setNote($value); 
				} break;
			// module name
				case 'module': {
					$this->setModule($value); 
				} break;
			// controller name
				case 'controller': {
					$this->setController($value); 
				} break;
			// action name
				case 'action': {
					$this->setAction($value); 
				} break;
			// params
				case 'params': {
					$this->setParams($value); 
				} break;
			// content
				case 'content': {
					$this->setContent($value); 
				} break;
			// offset
				case 'offset': {
					$this->setOffset($value); 
				} break;
			}
		}
	}
	
	/**
	 * @var string Language key
	 */
	protected $_lang;
	/**
	 * Get language key
	 * @return string
	 */
	public function getLang() {
		return $this->_lang;
	}
	/**
	 * Set language key
	 * 
	 * @param $lang string Language key
	 * @return DashboardWidget
	 */
	public function setLang($lang) {
		$this->_lang = $lang;
		return $this;
	}
	
	/**
	 * @var array Widget's name
	 */
	protected $_name;
	/**
	 * Get widget's name
	 * 
	 * @param $lang string Language key
	 * @return string
	 */
	public function getName($lang = null) {
		$name = (array)$this->_name;
		return $name[trim($lang ?: $this->_lang)];
	}
	/**
	 * Set widget's name
	 * 
	 * @param $name string|array Widget's name
	 * @param $lang string Language key
	 * @return DashboardWidget
	 */
	public function setName($name, $lang = null) {
		$this->_name = (array)$this->_name;
		$this->_name[trim($lang ?: $this->_lang)] = $name;
		return $this;
	}
	
	/**
	 * @var array Widget's note
	 */
	protected $_note;
	/**
	 * Get widget's note
	 * 
	 * @param $lang string Language key
	 * @return string
	 */
	public function getNote($lang = null) {
		$note = (array)$this->_note;
		return $note[trim($lang ?: $this->_lang)];
	}
	/**
	 * Set widget's note
	 * 
	 * @param $note string|array Widget's note
	 * @param $lang string Language key
	 * @return DashboardWidget
	 */
	public function setNote($note, $lang = null) {
		$this->_note = (array)$this->_note;
		$this->_note[trim($lang ?: $this->_lang)] = $note;
		return $this;
	}
	
	/**
	 * @var string Widget's module name
	 */
	protected $_module;
	/**
	 * Get widget's module name
	 * @return string
	 */
	public function getModule() {
		return $this->_module;
	}
	/**
	 * Set widget's module name
	 * @param $module string Widget's module name
	 * @return DashboardWidget
	 */
	public function setModule($module) {
		$this->_module = trim($module);
		return $this;
	}
	
	/**
	 * @var string Widget's controller name
	 */
	protected $_controller;
	/**
	 * Get widget's controller name
	 * @return string
	 */
	public function getController() {
		return $this->_controller;
	}
	/**
	 * Set widget's controller name
	 * @param $module string Widget's controller name
	 * @return DashboardWidget
	 */
	public function setController($controller) {
		$this->_controller = trim($controller);
		return $this;
	}
	
	/**
	 * @var string Widget's action name
	 */
	protected $_action;
	/**
	 * Get widget's action name
	 * @return string
	 */
	public function getAction() {
		return $this->_action;
	}
	/**
	 * Set widget's action name
	 * @param $action string Widget's action name
	 * @return DashboardWidget
	 */
	public function setAction($action) {
		$this->_action = trim($action);
		return $this;
	}
	
	/**
	 * @var array Request params
	 */
	protected $_params;
	/**
	 * Get request params
	 * @return array
	 */
	public function getParams() {
		return $this->_params;
	}
	/**
	 * Set request params
	 * @param $params array An array of request params
	 * @return DashboardWidget
	 */
	public function setParams(array $params) {
		$this->_params = $params;
		return $this;
	}
	
	/**
	 * @var string Widget's content
	 */
	protected $_content;
	/**
	 * Get widget's content
	 * @return string
	 */
	public function getContent() {
		return $this->_content;
	}
	/**
	 * Set widget's content
	 * @param $content string Widget content
	 * @return DashboardWidget
	 */
	public function setContent($content) {
		$this->_content = $content;
		return $this;
	}
	
	/**
	 * @var int Widget's offset
	 */
	protected $_offset;
	/**
	 * Get widget's offset
	 * @return int
	 */
	public function getOffset() {
		return $this->_offset;
	}
	/**
	 * Set widget's offset
	 * @param $offset int Widget offset
	 * @return DashboardWidget
	 */
	public function setOffset($offset) {
		$this->_offset = $offset;
		return $this;
	}
	
	/**
	 * Get widget's id
	 * @return string
	 */
	public function getId() {
		return "DSW{$this->_offset}";
	}
}