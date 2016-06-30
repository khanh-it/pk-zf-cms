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
class App_View_Helper_Bt3ManageTools extends Zend_View_Helper_Abstract {
    
    /**
     * 
     * @return App_View_Helper_Bt3ManageTools
     */
    public function Bt3ManageTools() {
        return $this;
    }
    
    /**
     * @var string Manage tool's html template
     */
    public static $_mToolHtml = '<a href="{{href}}" {{a_attrs}}><i class="{{icon}}"></i></a>';
    
    /**
     * Render manage tool
     * @param array $attrs An array of attrs
     * @return string  
     */
    public function mTool($attrs) {
        // Tag # A;
        $href = $attrs['href'] ? $attrs['href'] : 'javascript:void(0);';
        $icon = $attrs['icon'] ? "glyphicon glyphicon-{$attrs['icon']}" : '';
        unset($attrs['href'], $attrs['icon']);
        // +++ 
        $aAttrs = array();
        foreach ((array)$attrs as $k => $v) {
            $aAttrs[] = $k . '="' . htmlspecialchars($v) . '"';
        }
        
        // Return
        return str_replace(
            array('{{href}}', '{{icon}}', '{{a_attrs}}'), 
            array($href, $icon, implode(' ', $aAttrs)), 
            self::$_mToolHtml
        ); 
    }
    
    /**
     * Manage tool edit
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string 
     */
    public function mToolEdit($href = null, $icon = 'edit', $attrs = array()) {
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'icon' => $icon)));
    }
    
    /**
     * Manage tool delete
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function mToolDelete($href = null, $icon = 'minus-sign', $attrs = array()) {
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'icon' => $icon)));
    }
    
    /**
     * Manage tool detail
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function mToolDetail($href = null, $icon = 'info', $attrs = array()) {
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'icon' => $icon)));
    }
}