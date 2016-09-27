<?php
/**
 * 
 * @author khanh-it
 */
class Product_Form_Cart_Crud extends Twitter_Bootstrap3_Form
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
        $elements[] = $element = $this->createElement('text', 'code', array(
            'label' => $txt = $view->translate('Mã đơn hàng'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'payment_method', array(
            'label' => $txt = $view->translate('Hình thức thanh toán'),
            'multiple' => 'multiple',
            'class' => 'form-control input-sm selectpicker show-tick',
            'data-live-search' => 'true',
            'data-width' => '',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnPaymentMethods(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'payment_note', array(
            'label' => $txt = $view->translate('Ghi chú hình thức thanh toán'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'rows' => 4,
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'transport_method', array(
            'label' => $txt = $view->translate('Hình thức vận chuyển'),
            'multiple' => 'multiple',
            'class' => 'form-control input-sm selectpicker show-tick',
            'data-live-search' => 'true',
            'data-width' => '',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnTransportMethods(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'transport_note', array(
            'label' => $txt = $view->translate('Ghi chú hình thức vận chuyển'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'rows' => 4,
            'order' => ($eleOrder += 100),
        ));
        // +++ 
        $elements[] = $element = $this->createElement('select', 'gift', array(
            'label' => $txt = $view->translate('Gói quà?'),
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnGifts(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'gift_note', array(
            'label' => $txt = $view->translate('Ghi chú gói quà'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'rows' => 4,
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'invoice', array(
            'label' => $txt = $view->translate('Hóa đơn?'),
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnInvoices(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'gift_note', array(
            'label' => $txt = $view->translate('Ghi chú xuất hóa đơn'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'rows' => 4,
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'transport_price', array(
            'label' => $txt = $view->translate('Cước phí vận chuyển'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm text-right numeric positive',
            'addon_prepend' => '<i class="glyphicon glyphicon-usd"></i>',
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'total_promotion', array(
            'label' => $txt = $view->translate('Tổng tiền khuyến mãi'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm text-right numeric positive',
            'addon_prepend' => '<i class="glyphicon glyphicon-usd"></i>',
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'total_qty', array(
            'label' => $txt = $view->translate('Tổng số lượng'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm text-right numeric positive',
            'addon_prepend' => '<i class="glyphicon glyphicon-usd"></i>',
            'order' => ($eleOrder += 100),
        ));
		
		// +++ 
        $elements[] = $element = $this->createElement('text', 'total_price', array(
            'label' => $txt = $view->translate('Tổng tiền'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm text-right numeric positive',
            'addon_prepend' => '<i class="glyphicon glyphicon-usd"></i>',
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'status', array(
            'label' => $txt = $view->translate('Trạng thái đơn hàng?'),
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnStatuses(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('select', 'process_status', array(
            'label' => $txt = $view->translate('Trạng thái xử lý?'),
            'class' => 'form-control input-sm',
            'multiOptions' => array('' => LANG_SELECT) + Product_Model_DbTable_Cart::returnProcessStatuses(),
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'process_log', array(
            'label' => $txt = $view->translate('Nội dung xử lý'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'rows' => 4,
            'order' => ($eleOrder += 100),
        ));
		
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'note', array(
            'label' => $txt = $view->translate('Ghi chú'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'rows' => 4,
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}