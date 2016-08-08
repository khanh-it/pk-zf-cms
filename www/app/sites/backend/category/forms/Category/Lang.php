<?php
/**
 * 
 * @author khanh-it
 */
class Category_Form_Category_Lang extends Twitter_Bootstrap3_Form
{
    /**
     * (non-PHPdoc)
     * @see Zend_Form::init()
     */
    public function init()
    {
        // Get VIEW;
        $view = $this->getView();
        
        // Define elements
        $eleOrder = 0; $elements = array();
        // +++ 
        $elements[] = $element = $this->createElement('text', 'name', array(
            'label' => $txt = $view->translate('Tên danh mục'),
            'placeholder' => $txt,
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'alias', array(
            'label' => $txt = $view->translate('Alias - Tên danh mục'),
            'placeholder' => $txt,
            'maxlength' => 250,
            'order' => ($eleOrder += 100),
            'addon_append' => FORM_HTML_ALIAS_REMOVE,
            'description' => $view->translate('(Lấy theo tên danh mục nếu để trống)'),
        )); 
		$element->getDecorator('description')
			->setOption('tag', 'small')
		;
        
        // Add elements
        $this->addElements($elements);
    }
}