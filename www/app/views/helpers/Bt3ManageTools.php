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
    public static $_urlParamsActive = array('action' => 'active', 'id' => '__id__');
	
	/**
     * @var array
     */
    public static $_urlParamsEdit = array('action' => 'update',  'id' => '__id__');
	
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
    	<a href="{{href}}">{{label}}</a> {{btn_reset}}
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
		'' => 'glyphicon glyphicon-sort',
		'ASC' => 'glyphicon glyphicon-sort-by-attributes-alt', 
		'DESC' => 'glyphicon glyphicon-sort-by-attributes'
	)) {
		// Format data;
		$sortKey = '__sort'; $spliter = '-.-';
		// +++
		$href = $_GET;
		// +++ 
		list($sortF, $sortBy) = explode($spliter, (string)$href[$sortKey]);
		$isEmptySort = ($sortF != $sortField);
		$sortBy = ('ASC' == $sortBy) ? 'DESC' : 'ASC';
		if (!$isEmptySort) {
			$btnReset = $_GET;
			unset($btnReset[$sortKey]);
			$btnReset = http_build_query($btnReset);
			$btnReset = ($btnReset ? '?' : '') . $btnReset;
			$btnReset = '<a href="' . $btnReset . '"><i class="glyphicon glyphicon-remove"></i></a>';
		}
		// +++>
		$href[$sortKey] = "{$sortField}{$spliter}{$sortBy}";
		// Return;
		return str_replace(
			array('{{href}}', '{{label}}', '{{btn_reset}}', '{{icon_sort}}'),
			array(
				!empty($href) ? ('?' . http_build_query($href)) : '',
				htmlspecialchars($label),
				$btnReset, $icon[$isEmptySort ? '' : $sortBy]
			), 
			self::$_mToolSorterHtml
		);
	}
	
	/**
     * @var string
     */
    public static $_mToolCheckerTogglerHtml = '<div class="checkbox">
    	<label><input id="{{id}}" type="checkbox" class="{{class}}" onchange="(function(jQ){
	var checked = jQ(this).is(\':checked\');
	jQ(this).parents(\'table\').find(\'>tbody>tr>td :checkbox.mtool-checker\')
		.attr(\'checked\', checked)
		.prop(\'checked\', checked)
	;
}).call(this, jQuery);" /><i class="input-helper"></i></label>
</div>';
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
    public static $_mToolActiveTogglerHtml = '<div class="toggle-switch">
	<input id="mtool-active-{{id}}" type="checkbox" class="hidden" name="active[{{id}}]" value="{{active}}" {{checked}} />
	<label for="mtool-active-{{id}}" class="ts-helper" {{data-href-attr}}></label>
</div>';
	/**
     * Manage tool # active toggler
     * @param nul|string $href A tag's href
     * @param nul|string $icon Icon's class
     * @param array $attrs An array of attrs
     * @return string 
     */
    public function mToolActiveToggler($id, $active, $href = null, $attrs = array()) {
    	// Format data;
    	// +++ Active
    	$active = (1 * $active);
		$checked = $active ? 'checked="checked"' : ''; 
    	// +++ Href
    	$href = !is_null($href) ? $href : str_replace(
    		array('__id__'),
    		array($id, $active), 
    		$this->view->url(self::$_urlParamsActive)
		);
		$href = $href ? "data-href=\"{$href}\"" : '';
        // Return;
        return str_replace(
    		array('{{id}}', '{{active}}', '{{checked}}', '{{data-href-attr}}'), 
    		array($id, $active, $checked, $href), 
    		self::$_mToolActiveTogglerHtml
		);
    }
    
    /**
     * @var string Manage tool's html template
     */
    public static $_mBtnHtml = '<a href="{{href}}" {{a_attrs}}><i class="{{icon}}"></i></a>';
    
    /**
     * Render manage tool
     * @param array $attrs An array of attrs
     * @return string  
     */
    public function mBtn($attrs) {
        // Tag # A;
        $href = $attrs['href'] ? $attrs['href'] : 'javascript:void(0);';
        $icon = $attrs['icon'];
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
            self::$_mBtnHtml
        ); 
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
		// ++++ A tag's atr
		$attrs['class'] = $attrs['class'] ?: 'btn btn-primary btn-sm waves-effect';
		$attrs['data-mtool'] = $attrs['data-mtool'] ?: 'update';
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
		// ++++ A tag's atr
		$attrs['class'] = $attrs['class'] ?: 'btn btn-danger btn-sm waves-effect';
		$attrs['data-mtool'] = $attrs['data-mtool'] ?: 'delete';
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
		// ++++ A tag's atr
		$attrs['class'] = $attrs['class'] ?: 'btn btn-default btn-sm waves-effect';
		$attrs['data-mtool'] = $attrs['data-mtool'] ?: 'detail';
        // Return;
        return $this->mBtn(array_merge($attrs, array('href' => $href, 'icon' => $icon)));
    }
}