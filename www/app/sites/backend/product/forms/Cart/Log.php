<?php
/**
 * 
 * @author khanh-it
 */
class Product_Form_Cart_Log extends Twitter_Bootstrap3_Form
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
        $elements[] = $element = $this->createElement('select', 'process_status', array(
            'label' => $txt = $view->translate('T.Thái Xử lý?'),
            'required' => true,
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnProcessStatuses(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'content', array(
            'label' => $txt = $view->translate('Nội dung xử lý'),
            'class' => 'form-control input-sm',
            'required' => true,
            'placeholder' => $txt,
            'rows' => 6,
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}