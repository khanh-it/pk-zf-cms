<?php
/**
 * 
 * @author khanh-it
 */
class Product_Form_Cart_Index extends Twitter_Bootstrap3_Form_Inline
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
        $elements[] = $element = $this->createElement('select', 'payment_method', array(
            'label' => $txt = $view->translate('H.T Thanh toán'),
            'addon_prepend' => $txt,
            'multiple' => 'multiple',
            'class' => 'form-control input-sm selectpicker show-tick',
            'data-live-search' => 'true',
            'data-width' => '',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnPaymentMethods(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'transport_method', array(
            'label' => $txt = $view->translate('H.T Vận chuyển'),
            'addon_prepend' => $txt,
            'multiple' => 'multiple',
            'class' => 'form-control input-sm selectpicker show-tick',
            'data-live-search' => 'true',
            'data-width' => '',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnTransportMethods(),
            'order' => ($eleOrder += 100),
        ));
        // +++ 
        $elements[] = $element = $this->createElement('select', 'gift', array(
            'label' => $txt = $view->translate('Gói quà?'),
            'addon_prepend' => $txt,
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnGifts(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'invoice', array(
            'label' => $txt = $view->translate('Hóa đơn?'),
            'addon_prepend' => $txt,
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnInvoices(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'status', array(
            'label' => $txt = $view->translate('T.Thái Đ.Hàng?'),
            'addon_prepend' => $txt,
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnStatuses(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'process_status', array(
            'label' => $txt = $view->translate('T.Thái Xử lý?'),
            'addon_prepend' => $txt,
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnProcessStatuses(),
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}