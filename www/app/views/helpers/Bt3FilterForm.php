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
     * 
     */
    protected static $_html = '<div class="clearfix">
            <div class="pull-left">__left__</div>
            <div class="pull-right">__right__</div>
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
            $elementsLeft->addElement('button', '__btn-submit', array(
                'label' => '<span class="' . $this->_submitBtnIcon . '"></span>',
                'attribs' => array(
                    'class' => 'btn-primary',
                    'type' => 'submit',
                    'escape' => false
                ),
                'order' => --$eleOrder
            ));
            $elementsLeft->addElement('button', '__btn-reset', array(
                'label' => '<span class="' . $this->_resetBtnIcon . '"></span>',
                'attribs' => array(
                    'type' => 'reset',
                    'escape' => false
                ),
                'order' => PHP_INT_MAX
            ));
        }
        // Return;
        return str_replace(
            array('__left__', '__right__'), 
            array((string)$elementsLeft, (string)$elementsRight), 
            self::$_html
        ); 
    }
}