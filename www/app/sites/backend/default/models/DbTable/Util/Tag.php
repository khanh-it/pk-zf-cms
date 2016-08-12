<?php
/**
 * @author khanhdtp
 */
class Default_Model_DbTable_Util_Tag extends Default_Model_DbTable_Util_Abstract
{
	/**
	 * @var Default_Model_DbTable_Tag 
	 */
	protected $_repo;
	
	/**
	 * @var string 
	 */
	const PHR_DATA_PREFIX = 'phr_data__';
	
	/**
	 * Constructor
	 */
	protected function __construct(){
		// Initialize
		$this->_repo = new Default_Model_DbTable_Tag();  
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
	 * Build form form elements for SEO TOOL(s)
	 * 
	 * @param $_form null|Zend_Form From instance
	 * @param $options array An array of options
	 * @return array An array of SEO TOOL elements
	 */
	public function buildFormSEOToolsElements($_form = null, $options = array()) {
		// Elements
		$elements = array();
		// +++ 
		$form = ($_form instanceof Zend_Form) ? $_form : new Zend_Form();
		// +++ 
		$view = $form->getView();
		// +++ Element's orders
		$_order = (int)(PHP_INT_MAX / 2);
		// +++
		
		// Format, get options
		$options['element_name_prefix'] = is_null($options['element_name_prefix']) 
			? self::PHR_DATA_PREFIX
			: $options['element_name_prefix']
		; 
		
		// dummy element, used as label spliter
		$elements[] = $element = $form->createElement('text', '_SEOToolsLabel_', array(
			'label' => $txt = ('--- <u>' . $view->translate("SEO TOOLS:") . '</u> ---'),
			'ignore' => true,
			'attribs' => array(
				'style' => 'display:none;',
			),
			'order' => ($_order += 100)
		));
		$element->getDecorator('label')
			->setOption('class', 'h3')
			->setOption('escape', false)
			->setOption('style', 'margin:0')
		;
		
		// page's title
		$elements[] = $element = $form->createElement('text', "{$options['element_name_prefix']}seo_title", array(
			'label' => $txt = $view->translate("Page's title"),
			'attribs' => array(
				'class' => 'form-control input-sm',
				'maxlength' => '255',
				'placeholder' => $txt
			),
			'order' => ($_order += 100)
		));
		
		// meta keywords
		$elements[] = $element = $form->createElement('text', "{$options['element_name_prefix']}seo_meta_keywords", array(
			'label' => $txt = $view->translate("Page's meta keywords"),
			'attribs' => array(
				'class' => 'form-control input-sm',
				'maxlength' => '250',
				'placeholder' => $txt
			),
			'order' => ($_order += 100)
		));
		
		// meta description
		$elements[] = $element = $form->createElement('text', "{$options['element_name_prefix']}seo_meta_description", array(
			'label' => $txt = $view->translate("Page's meta description"),
			'attribs' => array(
				'class' => 'form-control input-sm',
				'maxlength' => '255',
				'placeholder' => $txt
			),
			'order' => ($_order += 100)
		));
		
		// html_meta 
		$elements[] = $element = $form->createElement('textarea', "{$options['element_name_prefix']}seo_html_meta", array(
			'label' => $txt = $view->translate("Page's html meta"),
			'attribs' => array(
				'class' => 'form-control input-sm',
				'rows' => 6,
				'placeholder' => $txt
			),
			'order' => ($_order += 100)
		));
		
		// Add elements
		$form->addElements($elements);
		
		// Return
		return $elements;
	}

	/**
	 * Extract tag data from array (remove keys)
	 * 
	 * @param $data array An array data
	 * @return array
	 */
	public function extractPhrData(array &$data) {
		// Tag data
		$phrData = array();
		// +++ 
		$phrDataPrefix = self::PHR_DATA_PREFIX;
		// 
		foreach ($data as $key => $value) {
			if (0 === strpos($key, $phrDataPrefix)) {
				$phrData[
					str_replace($phrDataPrefix, '', $key)
				] = $value;
				// Remove key(s)
				unset($data[$key]);
			}
		}
		
		// Return
		return $phrData;
	}
	
	/**
	 * Change array data keys by prepend prefix 
	 * 
	 * @param $data array An array data
	 * @return array
	 */
	public function prefixPhrData(array $data) {
		// Prefix 
		$phrDataPrefix = self::PHR_DATA_PREFIX;
		// 
		foreach ($data as $key => $value) {
			if (0 !== strpos($key, $phrDataPrefix)) {
				$data["{$phrDataPrefix}{$key}"] = $value;
				// Remove old key(s)
				unset($data[$key]);
			}
		}
		
		// Return
		return $data;
	}
	
	/**
	 * Save tag(s) data
	 * 
	 * @param $context string Context string
	 * @param $relId int|string Relative object's id
	 * @param $lang 
	 * @return array
	 */
	public function saveTag($context, $relId, $lang, array $data) {
		// Build selector
		$select = $this->_repo->buildFetchDataSelector($options = array(
			'context' => $context,
			'rel_id' => $relId,
			'lang' => $lang
		));
		
		// Fetch data, +get output data grouped 
		$phrColumns = (array)$this->_repo->fetchAll($select)
			->getGroupedData($context, $relId, $lang, array(
				'get_data_only' => false
			))
		;
		// Loop
		foreach ($data as $phrColumn => $phrData) {
			// Create new row (if not any)
			$row = $phrColumns[$phrColumn];
			if (!$row) {
				$row = $this->_repo->createRow();
				$row->setFromArray(array(
					'phr_context' => $context,
					'phr_rel_id' => $relId,
					'phr_lang' => $lang,
					'phr_column' => $phrColumn
				));
			}
			// Set data
			$row->phr_data = $phrData;
			
			// Save data to database
			$row->save();
		}
		
		// Return
		return $this;
	}

	/**
	 * Get available languages by context and relative id(s)
	 * 
	 * @param $context string Context string 
	 * @param relIds array An array of object's relative id(s)
	 * @return array
	 */
	public function getAvailableLanguages($context, $relIds) {
		// Format data
		// +++ 
		$context = trim($context);
		// +++ 
		$relIds = ($isRelIdsArr = is_array($relIds)) ? $relIds : (array)$relIds;
		
		// Empty data?
		if (!$context || empty($relIds)) {
			return array();
		}
		// Return data
		$return = array();
		// Build selector
		$selector = $this->_repo->buildFetchDataSelector(array(
			'phr_context' => $context,
			'phr_rel_id' => $relIds,
		));
		// Fetch data
		$phrData = (array)$this->_repo->fetchAll($selector)->getGroupedData($context);
		foreach ($phrData as $relId => $phrDataItem) {
			foreach ($phrDataItem as $lang => $phrColumns) {
				$phrColumns = array_filter($phrColumns);
				if (!empty($phrColumns)) {
					$return[$relId][] = $lang;
				}
			}
		}
		// Return;
		return $isRelIdsArr ? $return : current($return);
	}
}