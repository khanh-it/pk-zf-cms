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
class App_View_Helper_Bt3NavLinks extends Zend_View_Helper_Abstract {
    
    /**
     * @var string Default admin form id
     */
    //public static $adminFormSelector = '#adminForm';
    
    /**
     * @var string Default adminAction hidden element
     */
    public static $adminActionName = '_act';
    
    /**
     * @var string
     */
    public static $_urlParamsIndex = array('action' => null, 'id' => null, 'lang' => null);
    /**
     * @var string
     */
    public static $_urlParamsCreate = array('action' => 'create', 'id' => null, 'lang' => null);
    /**
     * @var string
     */
    public static $_urlParamsUpdate = array('action' => 'update');
    /**
     * @var string
     */
    public static $_urlParamsDelete = array('action' => 'delete');
    /**
     * @var string
     */
    public static $_urlParamsTrash = array('action' => 'trash');
    
    /**
     * @var array An array of icons
     */
    protected $_icons = array();

    /**
     * 
     * @return App_View_Helper_Bt3NavLinks
     */
    public function Bt3NavLinks($icons = null) {
        
        if (is_string($icons)) {
            $icons = array($icons);
        }
        
        if (is_array($icons)) {
            $this->_icons += $icons; 
        }
        
        return $this;
    }
    
    /**
     * @var string Icon's template
     */
    public static $_iconHtml = '<li {{li_attrs}}>
    <a href="{{href}}" {{a_attrs}}><span class="{{icon}}"></span> {{label}}</a>
</li>';
    
    /**
     * 
     * @param string $action
     * @return string
     */
    protected function _buildHrefAction ($action) {
        return "javascript:(function(jQ){"
            . " var jQFrm = jQ('form[action=&quot;&quot;][method=&quot;post&quot;]:last'); "
                . " var jQAct = jQFrm.find('input[type=&quot;hidden&quot;][name=&quot;" . self::$adminActionName . "&quot;]'); "
                . " jQ(jQAct.length ? jQAct : jQ('<input type=&quot;hidden&quot; name=&quot;" . self::$adminActionName . "&quot; />').prependTo(jQFrm)).val('{$action}'); "
                . " jQFrm.submit(); "
        . "})(jQuery);";
    }
    
    /**
     * Render icon
     * @param array $attrs An array of attrs
     * @return string  
     */
    public function icon($attrs) {
        // Tag # LI;
        $liAttrs = array();
        foreach ((array)$attrs['li_attrs'] as $k => $v) {
            $liAttrs[] = $k . '="' . htmlspecialchars($v) . '"';
        }
        unset($attrs['li_attrs']);
        //return implode(' ', $liAttrs);

        // Tag # A;
        $href = $attrs['href'] ? $attrs['href'] : 'javascript:void(0);';
        $label = $attrs['label'];
        $icon = $attrs['icon'];
        unset($attrs['href'], $attrs['label'], $attrs['icon']);
        // +++ 
        $aAttrs = array();
        foreach ((array)$attrs as $k => $v) {
            $aAttrs[] = $k . '="' . htmlspecialchars($v) . '"';
        }
        
        // Return
        return str_replace(
            array('{{href}}', '{{icon}}', '{{label}}', '{{a_attrs}}', '{{li_attrs}}'), 
            array($href, $icon, $label, implode(' ', $aAttrs), implode(' ', $liAttrs)), 
            self::$_iconHtml
        ); 
    }
    
    /**
     * Icon new
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string 
     */
    public function iconNew($href = null, $label = null, $icon = 'glyphicon glyphicon-plus-sign', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->view->url(self::$_urlParamsCreate);
        // +++ Label
        $label = $label ?: $this->view->translate('Thêm');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-success waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon delete
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconDelete($href = null, $label = null, $icon = 'glyphicon glyphicon-minus-sign', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->view->url(self::$_urlParamsDelete);
        // +++ Label
        $label = $label ?: $this->view->translate('Hủy');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-danger waves-effect';
		$attrs['data-nlink'] = $attrs['data-nlink'] ?: 'delete';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon edit
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconEdit($href = null, $label = null, $icon = 'glyphicon glyphicon-edit', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->view->url(self::$_urlParamsUpdate);
        // +++ Label
        $label = $label ?: $this->view->translate('Cập nhật');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-primary waves-effect';
        // Return;
       return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon trash
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string 
     */
    public function iconTrash($href = null, $label = null, $icon = 'glyphicon glyphicon-trash', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->view->url(self::$_urlParamsTrash);
        // +++ Label
        $label = $label ?: $this->view->translate('Thùng rác');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-warning waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon close
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconClose($href = null, $label = null, $icon = 'glyphicon glyphicon-remove-sign', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->view->url(self::$_urlParamsIndex);
        // +++ Label
        $label = $label ?: $this->view->translate('Đóng');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-default waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon back
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconBack($href = null, $label = null, $icon = 'glyphicon glyphicon-arrow-left', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = is_null($href) ? ($_SERVER['HTTP_REFERER']
            ? $_SERVER['HTTP_REFERER'] : 'javascript:history.back();'
        ) : $href;
        // +++ Label
        $label = $label ?: $this->view->translate('Trở lại');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-default waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon save
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconSave($href = null, $label = null, $icon = 'glyphicon glyphicon-floppy-saved', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->_buildHrefAction('save');
        // +++ Label
        $label = $label ?: $this->view->translate('Lưu');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-primary waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon save and new
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconSaveAndNew($href = null, $label = null, $icon = 'glyphicon glyphicon-floppy-open', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->_buildHrefAction('save_n_new');
        // +++ Label
        $label = $label ?: $this->view->translate('Lưu &amp; Thêm mới');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-primary waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Icon save and close
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconSaveAndClose($href = null, $label = null, $icon = 'glyphicon glyphicon-floppy-disk', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->_buildHrefAction('save_n_close');
        // +++ Label
        $label = $label ?: $this->view->translate('Lưu &amp; Đóng');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-primary waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
	
	/**
     * Icon apply
     * @param nul|string $href A tag's href
     * @param nul|string $label Icon's label
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function iconApply($href = null, $label = null, $icon = 'glyphicon glyphicon-floppy-saved', $attrs = array()) {
        // Format data;
        // +++ Href
        $href = $href ?: $this->_buildHrefAction('apply');
        // +++ Label
        $label = $label ?: $this->view->translate('Lưu');
		// ++++ A tag's atributes
		$attrs['class'] = $attrs['class'] ?: 'btn btn-primary waves-effect';
        // Return;
        return $this->icon(array_merge($attrs, array('href' => $href, 'label' => $label, 'icon' => $icon)));
    }
    
    /**
     * Render icons
     * @return string
     */
    public function __toString() {
        return implode("\n", $this->_icons);
    }
}