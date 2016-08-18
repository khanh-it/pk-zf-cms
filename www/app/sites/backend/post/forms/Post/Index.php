<?php
/**
 * 
 * @author khanh-it
 */
class Post_Form_Post_Index extends Twitter_Bootstrap3_Form_Inline
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
            'class' => 'form-control input-sm',
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'category_id[]', array(
            'label' => $txt = $view->translate('Danh mục'),
            'addon_prepend' => $txt,
            'multiple' => 'multiple',
            'class' => 'form-control input-sm selectpicker show-tick',
            'data-live-search' => 'true',
            'data-width' => '',
            'order' => ($eleOrder += 100),
        ));
        // +++ 
        $elements[] = $element = $this->createElement('select', 'active', array(
            'label' => $txt = $view->translate('Kích hoạt?'),
            'addon_prepend' => $txt,
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => $view->translate('- Chọn -')) + Post_Model_DbTable_Row_Post::returnBitStats(),
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}