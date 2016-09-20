<?php
/**
 * 
 * @author khanh-it
 */
class Default_Form_Conf_Lang extends Twitter_Bootstrap3_Form
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
        $elements[] = $element = $this->createElement('text', 'name', array(
            'label' => $txt = $view->translate('Tên cấu hình'),
            'placeholder' => $txt,
            'class' => 'form-control input-sm',
            'maxlength' => 250,
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
		// +++ 
		if (Default_Model_DbTable_Conf::INPUT_PLAINTEXT == $contOpts['input']) {
			// +++
			$elements[] = $element = $this->createElement('text', 'value', array(
	            'label' => $txt = $view->translate('Giá trị (plaintext)'),
	            'placeholder' => $txt,
				'class' => 'form-control input-sm',
	            'order' => ($eleOrder += 100)
	        ));
		}
        if (Default_Model_DbTable_Conf::INPUT_HTML == $contOpts['input']) {
			// +++
			$elements[] = $element = $this->createElement('textarea', 'value', array(
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
		}
		
        // Add elements
        $this->addElements($elements);
    }
}