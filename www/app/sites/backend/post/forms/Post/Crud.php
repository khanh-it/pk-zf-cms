<?php
/**
 * 
 * @author khanh-it
 */
class Post_Form_Post_Crud extends Twitter_Bootstrap3_Form
{
    /**
     * (non-PHPdoc)
     * @see Zend_Form::init()
     */
    public function init()
    {
        // Get VIEW;
        $view = $this->getView();
		
		// Get controller options
		$contOpts = (array)$this->getAttrib('controllerOptions');
		$this->removeAttrib('controllerOptions');
        
        // Define elements
        $eleOrder = 0; $elements = array();
		// +++ 
        $elements[] = $element = $this->createElement('select', 'category_id[]', array(
            'label' => $txt = $view->translate('Danh mục'),
            'multiple' => 'multiple',
			'class' => 'form-control input-sm selectpicker show-tick',
			'data-live-search' => 'true',
			'registerInArrayValidator' => false,
            'order' => ($eleOrder += 100),
        ));
        // +++ 
        $elements[] = $element = $this->createElement('text', 'name', array(
            'label' => $txt = $view->translate('Tiêu đề'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'alias', array(
            'label' => $txt = $view->translate('Alias - Tiêu đề'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 250,
            'order' => ($eleOrder += 100),
            'addon_append' => FORM_HTML_ALIAS_REMOVE,
            'description' => $view->translate('(Lấy theo tiêu đề nếu để trống)'),
        )); 
		$element->getDecorator('description')
			->setOption('tag', 'small')
		;
		// +++ 
		$kcfinderUploadDir = current(
			Post_Model_DbTable_Post::returnImgsWebPath('/', $contOpts['type'])
		);
		$kcfinderType = Post_Model_DbTable_Post::returnImgFolder($contOpts['type']);
        $elements[] = $element = $this->createElement('textarea', 'imgs', array(
            'label' => $txt = $view->translate('Hình ảnh'),
            'placeholder' => $txt,
            'attribs' => array(
            	//'readonly' => 'readonly',
            	'rows' => 6,
            	'data-kcfinder-type' => $kcfinderType,
            	'data-kcfinder-exts' => '*img',
            	'data-kcfinder-upload_dir' => $kcfinderUploadDir,
			),
			'class' => 'form-control input-sm kcfinder',
            'order' => ($eleOrder += 100),
            'addon_prepend' => FORM_HTML_KCFINDER_PICKER,
            'addon_append' => FORM_HTML_KCFINDER_PREVIEW_N_REMOVE
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'viewed', array(
            'label' => $txt = $view->translate('Lượt xem'),
            'placeholder' => '0',
            'class' => 'form-control input-sm text-right numeric',
            'maxlength' => 15,
            'value' => 0,
            'order' => ($eleOrder += 100),
            'addon_append' => FORM_HTML_VIEWED_ADDON,
            'description' => $view->translate('(Tổng số lượt xem trên website)'),
        )); 
		$element->getDecorator('description')
			->setOption('tag', 'small')
		;
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'content_short', array(
            'label' => $txt = $view->translate('Nội dung rút gọn'),
            'placeholder' => $txt,
            'attribs' => array(
            	'rows' => 4,
            	'data-ckeditor' => json_encode(array(
            		'toolbar' => 'Basic' // Use toolbar `basic`
				))
			),
			'class' => 'form-control input-sm',
            'order' => ($eleOrder += 100)
        ));
		// +++
		$elements[] = $element = $this->createElement('textarea', 'content_full', array(
            'label' => $txt = $view->translate('Nội dung đầy đủ'),
            'placeholder' => $txt,
            'attribs' => array(
            	'rows' => 6,
            	'data-ckeditor' => json_encode(array(
            		//'toolbar' => '' // Use default toolbar
            		'filebrowser' => $kcfinderType 
				))
			),
			'class' => 'form-control input-sm',
            'order' => ($eleOrder += 100)
        ));
        // +++ 
        $elements[] = $element = $this->createElement('textarea', 'note', array(
            'label' => $txt = $view->translate('Ghi chú'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'rows' => 4,
            'order' => ($eleOrder += 100)
        ));
        // +++ 
        $elements[] = $element = $this->createElement('radio', 'active', array(
            'label' => $txt = $view->translate('Kích hoạt?'),
            'multiOptions' => Post_Model_DbTable_Row_Post::returnBitStats(array(
            	'prepend_label' => FORM_HTML_INPUT_HELPER,
            	//'append_label' => '',
			)),
			'attribs' => array('escape' => false),
            'value' => Post_Model_DbTable_Row_Post::STAT_YES,
            'order' => ($eleOrder += 100),
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}