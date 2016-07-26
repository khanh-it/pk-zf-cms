<?php
/**
 * 
 * @author khanh-it
 */
class Default_Form_Account_Crud extends Twitter_Bootstrap3_Form
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
        $elements[] = $element = $this->createElement('text', 'username', array(
            'label' => $txt = $view->translate('Tên đăng nhập'),
            'placeholder' => $txt,
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('password', 'password', array(
            'label' => $txt = $view->translate('Mật khẩu'),
            'placeholder' => $txt,
            'maxlength' => 50,
            'required' => true,
            'order' => ($eleOrder += 100),
            'addon_append' => '<label class="control-label">'
            	. '<input type="checkbox" id="show-password" /> ' 
            	. $view->translate('Show password?')
            . '</label>',
        ));
        // +++ 
        $elements[] = $element = $this->createElement('text', 'fullname', array(
            'label' => $txt = $view->translate('Tên tài khoản'),
            'placeholder' => $txt,
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'avatar', array(
            'label' => $txt = $view->translate('Ảnh đại diện'),
            'placeholder' => $txt,
            'attribs' => array(
            	'readonly' => 'readonly',
            	'data-kcfinder' => 'default.account.avatars'
			),
            'order' => ($eleOrder += 100),
            'addon_prepend' => FORM_HTML_KCFINDER_PICKER,
            'addon_append' => FORM_HTML_KCFINDER_CLEAR
        ));
        // +++ 
        $elements[] = $element = $this->createElement('textarea', 'note', array(
            'label' => $txt = $view->translate('Ghi chú'),
            'placeholder' => $txt,
            'rows' => 4,
            'order' => ($eleOrder += 100)
        ));
        // +++ 
        $elements[] = $element = $this->createElement('radio', 'active', array(
            'label' => $txt = $view->translate('Kích hoạt?'),
            'multiOptions' => Default_Model_DbTable_Row_Account::returnBitStats(array(
            	'prepend_label' => FORM_HTML_INPUT_HELPER,
            	//'append_label' => '',
			)),
			'attribs' => array('escape' => false),
            'value' => Default_Model_DbTable_Row_Account::STAT_YES,
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}