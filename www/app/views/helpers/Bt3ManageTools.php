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
     * @var array
     */
    public static $_urlParamsActive = array('action' => 'active');
	
	/**
     * @var array
     */
    public static $_urlParamsEdit = array('action' => 'edit',  'id' => '__id__');
	
	/**
     * @var array
     */
    public static $_urlParamsDetail = array('action' => 'detail',  'id' => '__id__');
	
	/**
     * @var array
     */
    public static $_urlParamsDelete = array('action' => 'delete',  'id' => '__id__');
	
    /**
     * 
     * @return App_View_Helper_Bt3ManageTools
     */
    public function Bt3ManageTools() {
        return $this;
    }
	
	/**
     * @var string
     */
    public static $_mToolSorterHtml = '<div class="clearfix">
    <div class="pull-left">
    	<a href="?{{href}}">{{label}}</a> {{btn_reset}}
    </div>
    <div class="pull-right">
    	<i class="{{icon_sort}}"></i>
    </div>
</div>';
	/**
	 * Manage tool # checker toggler
	 * @return string
	 */
	public function mToolSorter($label, $sortField, $icon = array(
		'ASC' => 'glyphicon glyphicon-sort-by-attributes', 
		'DESC' => 'glyphicon glyphicon-sort-by-attributes-alt'
	)) {
		// Format data;
		$sortKey = '__sort'; $spliter = '-.-';
		// +++ 
		$href = $_GET;
		// +++
		$sortBy = explode($spliter, (string)$href[$sortKey]);
		$isEmptySort = !!($sortBy = (string)array_pop($sortBy));
		$sortBy = ('ASC' == $sortBy) ? 'DESC' : 'ASC';
		if (!$isEmptySort) {
			$hrefReset = $_GET;
			unset($hrefReset[$sortKey]);
			$hrefReset = http_build_query($hrefReset);
		}
		// +++>
		$href[$sortKey] = "{$sortField}{$spliter}{$sortBy}";
		
		return str_replace(
			array('{{href}}', '{{label}}', '{{btn_reset}}', '{{icon_sort}}'),
			array(
				http_build_query($href),
				htmlspecialchars($label),
				!$hrefReset ? '' 
					: "<a href=\"?{$hrefReset}\"></a>",
				$icon[$sortBy]
			), 
			self::$_mToolSorterHtml
		);
	}
	
	/**
     * @var string
     */
    public static $_mToolCheckerTogglerHtml = '<input id="{{id}}" type="checkbox" class="{{class}}" onchange="(function(jQ){
	var checked = jQ(this).is(\':checked\');
	jQ(this).parents(\'table\').find(\'>tbody>tr>td :checkbox.mtool-checker\')
		.attr(\'checked\', checked)
		.prop(\'checked\', checked)
	;
}).call(this, jQuery);" />';
	/**
	 * Manage tool # checker toggler
	 * @return string
	 */
	public function mToolCheckerToggler(array $attrs = array()) {
		return str_replace(
			array('{{id}}', '{{class}}'), 
			array(
				htmlspecialchars($attrs['id']),
				'mtool-checker-toggler ' . htmlspecialchars($attrs['class'])
			), 
			self::$_mToolCheckerTogglerHtml
		);
	}
	
	/**
     * @var string
     */
    public static $_mToolCheckerHtml = '<div class="checkbox">
	<label><input id="{{id}}" name="{{name}}" type="checkbox" class="{{class}}" value="{{value}}" />
	<i class="input-helper"></i></label>
</div>';
	/**
	 * Manage tool # checker
	 * @return string
	 */
	public function mToolChecker($value, array $attrs = array()) {
		return str_replace(
			array('{{value}}', '{{name}}', '{{id}}', '{{class}}'), 
			array(
				htmlspecialchars($value ? $value : $attrs['value']),
				htmlspecialchars($attrs['name'] ? $attrs['name'] : 'id[]'),
				htmlspecialchars($attrs['id']),
				'mtool-checker ' . htmlspecialchars($attrs['class'])
			), 
			self::$_mToolCheckerHtml
		);
	}
    
    /**
     * @var string Manage tool's html template
     */
    public static $_mBtnHtml = '<a href="{{href}}" class="{{class}}" {{a_attrs}}><i class="{{icon}}"></i></a>';
    
    /**
     * Render manage tool
     * @param array $attrs An array of attrs
     * @return string  
     */
    public function mBtn($attrs) {
        // Tag # A;
        $href = $attrs['href'] ? $attrs['href'] : 'javascript:void(0);';
        $class = "manage-btn btn btn-primary btn-sm {$attrs['class']}";
        $icon = $attrs['icon'];
        unset($attrs['href'], $attrs['class'], $attrs['icon']);
        // +++ 
        $aAttrs = array();
        foreach ((array)$attrs as $k => $v) {
            $aAttrs[] = $k . '="' . htmlspecialchars($v) . '"';
        }
        
        // Return
        return str_replace(
            array('{{href}}', '{{class}}', '{{icon}}', '{{a_attrs}}'), 
            array($href, $class, $icon, implode(' ', $aAttrs)), 
            self::$_mBtnHtml
        ); 
    }
	
	/**
     * Manage tool # active toggler
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string 
     */
    public function mBtnActiveToggler($active, $href = null, $icon = array('glyphicon glyphicon-record', 'glyphicon glyphicon-ok-sign'), $attrs = array()) {
    	// Format data;
    	// +++ Active
    	$active = (1 * $active);
    	// +++ Href
    	$href = $href ? $href : $this->view->url(self::$_urlParamsActive);
		// +++ Icons
		$icon = (array)$icon;
		$attrs['icon'] = $icon[$active];
        // Return;
        return $this->mBtn(array_merge($attrs, array(
        	'href' => $href,
        	'icon' => $icon[$active],
        	'data-active' => $active,
        	'data-icon_unactive' => $icon[0],
        	'data-icon_active' => $icon[1]
		)));
    }
    
    /**
     * Manage tool # edit
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string 
     */
    public function mBtnEdit($href = null, $icon = 'glyphicon glyphicon-edit', $attrs = array()) {
    	// Format data;
    	// +++ Href
    	$href = $href ? $href : $this->view->url(self::$_urlParamsEdit);
        // Return;
        return $this->mBtn(array_merge($attrs, array('href' => $href, 'icon' => $icon)));
    }
    
    /**
     * Manage tool delete
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function mBtnDelete($href = null, $icon = 'glyphicon glyphicon-minus-sign', $attrs = array()) {
    	// Format data;
    	// +++ Href
    	$href = $href ? $href : $this->view->url(self::$_urlParamsDelete);
        // Return;
        return $this->mBtn(array_merge($attrs, array('href' => $href, 'icon' => $icon)));
    }
    
    /**
     * Manage tool detail
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string
     */
    public function mBtnDetail($href = null, $icon = 'glyphicon glyphicon-exclamation-sign', $attrs = array()) {
    	// Format data;
    	// +++ Href
    	$href = $href ? $href : $this->view->url(self::$_urlParamsDetail);
        // Return;
        return $this->mBtn(array_merge($attrs, array('href' => $href, 'icon' => $icon)));
    }
}