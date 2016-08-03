<?php
/**
 * @author khanhdtp
 */
class Default_Model_Util_Phrase extends Default_Model_Util_Abstract
{
	/**
	 * Constructor
	 */
	protected function __construct(){}
	
	/**
	 * @var Default_Model_Util_Phrase
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
	 * 
	 */
	public function buildFormSEOElements($_form = null, $options = array()) {
		// Elements
		$elements = array();
		// +++ 
		$form = ($_form instanceof Zend_Form) ? $_form : new Zend_Form();
		// +++ 
		$view = $form->getView();
		// +++ Element's orders
		$_order = (int)(PHP_INT_MAX / 2);
		// +++ 
		
		// dummy element, used as label spliter
		$elements[] = $element = $form->createElement('text', 'phr_data__seo', array(
			'label' => $txt = ('--- <u>' . $view->translate("SEO TOOLS:") . '</u> ---'),
			'ignore' => true,
			'attribs' => array(
				'name' => '', 'style' => 'display:none;',
			),
			'order' => ($_order += 100)
		));
		$element->getDecorator('label')
			->setOption('class', 'h3')
			->setOption('escape', false)
			->setOption('style', 'margin:0')
		;
		
		// page's title
		$elements[] = $element = $form->createElement('text', 'phr_data__seo_title', array(
			'label' => $txt = $view->translate("Page's title"),
			'attribs' => array(
				'name' => 'phr_data[seo_title]',
				'class' => 'form-control input-sm',
				'maxlength' => '255',
				'placeholder' => $txt
			),
			'order' => ($_order += 100)
		));
		
		// meta keywords
		$elements[] = $element = $form->createElement('text', 'phr_data__seo_meta_keywords', array(
			'label' => $txt = $view->translate("Page's meta keywords"),
			'attribs' => array(
				'name' => 'phr_data[seo_meta_keywords]',
				'class' => 'form-control input-sm',
				'maxlength' => '250',
				'placeholder' => $txt
			),
			'order' => ($_order += 100)
		));
		
		// meta description
		$elements[] = $element = $form->createElement('text', 'phr_data__seo_meta_description', array(
			'label' => $txt = $view->translate("Page's meta description"),
			'attribs' => array(
				'name' => 'phr_data[seo_meta_description]',
				'class' => 'form-control input-sm',
				'maxlength' => '255',
				'placeholder' => $txt
			),
			'order' => ($_order += 100)
		));
		
		// html_meta 
		$elements[] = $element = $form->createElement('textarea', 'phr_data__seo_html_meta', array(
			'label' => $txt = $view->translate("Page's html meta"),
			'attribs' => array(
				'name' => 'phr_data[seo_html_meta]',
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
}