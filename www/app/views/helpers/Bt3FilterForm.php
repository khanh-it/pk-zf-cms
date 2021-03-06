<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @copyright  Free
 * @license    
 */
class App_View_Helper_Bt3FilterForm extends Zend_View_Helper_Abstract {
    
    /**
     * @var string Template
     */
    protected static $_html = '<div id="filter-form-wrapper" class="row">
            <div class="col-xs-11">__left__</div>
            <div class="col-xs-1">__right__</div>
        </div>'
    ;
    
    /**
     * @var string
     */
    protected $_submitBtnIcon = 'glyphicon glyphicon-search';
    /**
     * @var string
     */
    protected $_resetBtnIcon = 'glyphicon glyphicon-refresh';
    
    /**
     * 
     * @return App_View_Helper_Bt3FilterForm
     */
    public function Bt3FilterForm() {
        return $this;
    }
    
    /**
     * Render
     * @return App_View_Helper_Bt3FilterForm
     */
    public function render($elementsLeft = null, $elementsRight = null) {
        // Case:         
        if ($elementsLeft instanceof Zend_Form) {
            //  
            $eleOrder = (int)(PHP_INT_MAX / 2);
            // 
            $elementsLeft->addElement(
	            $element = $elementsLeft->createElement('button', '__btn-submit', array(
	                'label' => '<span class="' . $this->_submitBtnIcon . '"></span>',
	                'attribs' => array(
	                	'name' => '',
	                    'class' => 'btn-primary btn-form-filter',
	                    'type' => 'submit',
	                    'escape' => false
	                ),
	                'order' => --$eleOrder
	            ))
			);
			$element->removeDecorator('container');
			// 
			$elementsLeft->addElement(
	            $element = $elementsLeft->createElement('button', '__btn-reset', array(
	                'label' => '<span class="' . $this->_resetBtnIcon . '"></span>',
	                'attribs' => array(
	                	'name' => '',
	                	'class' => 'btn-default btn-form-filter',
	                    'type' => 'reset',
	                    'escape' => false
	                ),
	                'order' => PHP_INT_MAX
	            ))
			);
			$element->removeDecorator('container');
        }
        // Return;
        return str_replace(
            array('__left__', '__right__'), 
            array((string)$elementsLeft, (string)$elementsRight), 
            self::$_html
        ); 
    }
}