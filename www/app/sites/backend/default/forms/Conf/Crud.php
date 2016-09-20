<?php
/**
 * 
 * @author khanh-it
 */
class Default_Form_Conf_Crud extends Twitter_Bootstrap3_Form
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
        $elements[] = $element = $this->createElement('text', 'code', array(
            'label' => $txt = $view->translate('Mã cấu hình'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 50,
            'required' => true,
            'order' => ($eleOrder += 100),
        ));
        // +++ 
        $elements[] = $element = $this->createElement('text', 'name', array(
            'label' => $txt = $view->translate('Tên cấu hình'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
		// +++ 
		$inputModes = Default_Model_DbTable_Conf::returnInputs(); 
        $elements[] = $element = $this->createElement('select', 'input', array(
            'label' => $txt = $view->translate('Chế độ nhập'),
            'class' => 'form-control input-sm',
            'required' => true,
            'multiOptions' => $inputModes,
            'order' => ($eleOrder += 100)
        ));
		// +++
		$elements[] = $element = $this->createElement('text', 'value_plaintext', array(
            'label' => $txt = $view->translate('Giá trị (plaintext)'),
            'placeholder' => $txt,
			'class' => 'form-control input-sm',
            'order' => ($eleOrder += 100)
        ));
		$element->getDecorator('Container')
			->setOption('id', 'value_plaintext_fg')
		;
		// +++
		$elements[] = $element = $this->createElement('textarea', 'value_html', array(
            'label' => $txt = $view->translate('Giá trị (html)'),
            'placeholder' => $txt,
            'attribs' => array(
            	'rows' => 4,
            	'data-ckeditor' => json_encode(array(
            		//'toolbar' => '' // Use default toolbar
				))
			),
			'class' => 'form-control input-sm',
            'order' => ($eleOrder += 100)
        ));
		$element->getDecorator('Container')
			->setOption('id', 'value_html_fg')
		;
		
		// +++ 
        $elements[] = $element = $this->createElement('textarea', 'note', array(
            'label' => $txt = $view->translate('Ghi chú'),
            'placeholder' => $txt,
            'rows' => 4,
            'order' => ($eleOrder += 100)
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}