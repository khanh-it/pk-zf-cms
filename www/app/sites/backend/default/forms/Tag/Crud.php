<?php
/**
 * 
 * @author khanh-it
 */
class Default_Form_Tag_Crud extends Twitter_Bootstrap3_Form
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
            'label' => $txt = $view->translate('Tag'),
            'placeholder' => $txt,
            'maxlength' => 250,
            'class' => 'form-control input-sm',
            'required' => true,
            'order' => ($eleOrder += 100)
        ));
        
        // Add elements
        $this->addElements($elements);
    }
}