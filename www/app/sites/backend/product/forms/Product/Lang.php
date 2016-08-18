<?php
/**
 * 
 * @author khanh-it
 */
class Product_Form_Product_Lang extends Twitter_Bootstrap3_Form
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
            'label' => $txt = $view->translate('Tên sản phẩm'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
		// +++ 
        $elements[] = $element = $this->createElement('text', 'alias', array(
            'label' => $txt = $view->translate('Alias - Tên sản phẩm'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 250,
            'order' => ($eleOrder += 100),
            'addon_append' => FORM_HTML_ALIAS_REMOVE,
            'description' => $view->translate('(Lấy theo tên sản phẩm nếu để trống)'),
        )); 
		$element->getDecorator('description')
			->setOption('tag', 'small')
		;
		// +++
		$elements[] = $element = $this->createElement('textarea', 'content', array(
            'label' => $txt = $view->translate('Thông tin sản phẩm'),
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
        
        // Add elements
        $this->addElements($elements);
    }
}