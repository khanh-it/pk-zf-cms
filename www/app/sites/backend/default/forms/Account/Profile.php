<?php
/**
 * 
 * @author khanh-it
 */
class Default_Form_Account_Profile extends Twitter_Bootstrap3_Form
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
            'class' => 'form-control input-sm',
            'readonly' => 'readonly',
            'disabled' => 'disabled',
            'ignore' => true,
            'order' => ($eleOrder += 100),
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'fullname', array(
            'label' => $txt = $view->translate('Tên tài khoản'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
		// +++ 
        $elements[] = $element = $this->createElement('password', 'password', array(
            'label' => $txt = $view->translate('Mật khẩu'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 50,
            'description' => $view->translate('Nhập thông tin mật khảu mới nếu muốn thay đổi.'),
            'order' => ($eleOrder += 100),
            'addon_append' => '<label class="control-label">'
            	. '<input type="checkbox" id="show-password" /> ' 
            	. $view->translate('Show password?')
            . '</label>',
        ));
		// +++ 
		$kcfinderUploadDir = Default_Model_DbTable_Account::returnAvatarWebPath('/');
        $elements[] = $element = $this->createElement('text', 'avatar', array(
            'label' => $txt = $view->translate('Ảnh đại diện'),
            'placeholder' => $txt,
            'attribs' => array(
            	'readonly' => 'readonly',
            	'data-kcfinder-type' => Default_Model_DbTable_Account::AVATAR_FOLDER,
            	'data-kcfinder-exts' => '*img',
            	'data-kcfinder-upload_dir' => $kcfinderUploadDir
			),
			'class' => 'form-control input-sm kcfinder',
            'order' => ($eleOrder += 100),
            'addon_prepend' => FORM_HTML_KCFINDER_PICKER,
            'addon_append' => FORM_HTML_KCFINDER_PREVIEW_N_REMOVE
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}