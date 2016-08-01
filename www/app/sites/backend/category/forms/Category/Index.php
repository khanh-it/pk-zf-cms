<?php
/**
 * 
 * @author khanh-it
 */
class Category_Form_Category_Index extends Twitter_Bootstrap3_Form_Inline
{
    /**
     * (non-PHPdoc)
     * @see Zend_Form::init()
     */
    public function init()
    {
        // Get VIEW;
        $view = $this->getView();
        
        // Set form's attribs 
        $this->setAttribs(array(
            'method' => 'GET'
        ));
        
        // Define elements
        $eleOrder = 0; $elements = array();
        // +++ 
        $elements[] = $element = $this->createElement('text', 'keyword', array(
            'label' => $txt = $view->translate('Từ khóa'),
            'placeholder' => $txt,
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'parent_id', array(
            'label' => $txt = $view->translate('Danh mục cha'),
            'addon_prepend' => $txt,
            'class' => 'selectpicker show-tick',
            'data-live-search' => 'true',
            'data-width' => '',
            'order' => ($eleOrder += 100),
        ));
        // +++ 
        $elements[] = $element = $this->createElement('select', 'active', array(
            'label' => $txt = $view->translate('Kích hoạt?'),
            'addon_prepend' => $txt,
            'multiOptions' => array('' => $view->translate('- Chọn -')) + Category_Model_DbTable_Row_Category::returnBitStats(),
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}