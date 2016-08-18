<?php
/**
 * 
 * @author khanh-it
 */
class Default_Form_Group_Index extends Twitter_Bootstrap3_Form_Inline
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
        $elements[] = $element = $this->createElement('select', 'active', array(
            'label' => $txt = $view->translate('Kích hoạt?'),
            'class' => 'form-control input-sm',
            'addon_prepend' => $txt,
            'multiOptions' => array('' => $view->translate('- Chọn -')) + Default_Model_DbTable_Row_Group::returnBitStats(),
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}