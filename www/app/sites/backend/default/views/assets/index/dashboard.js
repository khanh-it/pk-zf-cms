
/**
 * File default/views/assets/index/dashboard.js
 */
(function($, hplData, hplOptions){
	/**
	 * Dashboard widgets manager
	 * @author khanhdtp 
	 */
	var dashboardWidgetManager = function($eles, options) {
		if (!(this instanceof dashboardWidgetManager)) {
			return new dashboardWidgetManager($eles, options);
		}
		
		// Format options
		this._options = $.extend(this._options, options);
		
		//
		this._$eles = $eles;
		
		// 
		this._handleSize();
		
		// 
		this._handlePos();
	};
	dashboardWidgetManager.prototype = {
		/**
		 * Default options
		 * @var {Object}
		 */
		_options: {
			// min cols
			'minCols': 1,
			// max cols
			'maxCols': 12
		},
		/**
		 * DOM elements: 
		 * @var {object} jQuery
		 */
		_$eles: null,
		/**
		 * Helper: get widget elements
		 * @return {Object} jQuery elements
		 */
		_getWidgetEles: function(){
			return $(this._$eles && this._$eles.find('.db-widget'));
		},
		/**
		 * Helper: get widget size (cols) by class attrib
		 * @return this
		 */
		_getColByClassAttr: function(clsAttr, options){
			var minCols = this._options.minCols, 
				maxCols = this._options.maxCols,
				pattern = /(col-sm-)(\d+)/i,
				colCls = '', colsStr = '', col = 0,
				options = $.extend({}, options)
			;
			if ((colCls = $.trim(clsAttr).match(/(col-sm-)(\d+)/i))
				&& (col = 1 * colCls[2]) 
				&& (colsStr = colCls[1])
				&& (colCls = colCls[0])
			) {
				if (options.added) {
					col += options.added;	
				}
				col = (col < minCols) ? minCols : col; 
				col = (col > maxCols) ? maxCols : col;
				// Return
				return [col, colsStr, colCls];
			}
			// Return
			return false;
		},
		/**
		 * Handle resize of widgets?
		 * @return this
		 */
		_handleSize: function(){
			var minCols = 1, maxCols = 12; dbwMan = this;
			this._$eles
				.off('click.dbwidgets_handleSize')
				.on('click.dbwidgets_handleSize', 'button.dbwidget-btn-minus, button.dbwidget-btn-plus', function(evt){
					var $this = $(this), colData, 
						isMinus = $this.hasClass('dbwidget-btn-minus'),
						isPlus = $this.hasClass('dbwidget-btn-plus'),
						$dbWidget = dbwMan._getWidgetEles().has(this)
					;
					if ($dbWidget.length) {
						colData = dbwMan._getColByClassAttr($dbWidget.attr('class'), {
							'added': (isMinus ? -1 : 1)
						});
						if (colData) {
							$dbWidget.removeClass(colData[2]).addClass(colData[1] + colData[0]);
							// Save refs
							dbwMan._saveRefs();	
						}
					}
				})
			;
			// Return
			return this;
		},
		/**
		 * Handle position of widgets?
		 * @return this
		 */
		_handlePos: function(){
			var dbwMan = this;
			this._$eles
				.off('click.dbwidgets_handlePos')
				.on('click.dbwidgets_handlePos', 'button.dbwidget-btn-left, button.dbwidget-btn-right', function(evt){
					var $this = $(this), 
						isLeft = $this.hasClass('dbwidget-btn-left'),
						isRight = $this.hasClass('dbwidget-btn-right'),
						$dbWidgets = dbwMan._getWidgetEles(),
						$dbWidget = $dbWidgets.has(this)
					;
					if ($dbWidgets.length > 1 && $dbWidget.length) {
						if (isLeft) {
							$dbWidgets.eq($dbWidgets.index($dbWidget) - 1).insertAfter($dbWidget);
						}
						if (isRight) {
							$dbWidgets.eq($dbWidgets.index($dbWidget) + 1).insertBefore($dbWidget);
						}
						// Save refs
						dbwMan._saveRefs();
					}
				})
			;
			// Return
			return this;
		},
		/**
		 * Last user's refs?
		 * @var {Object}
		 */
		_lastRefs: null,
		/**
		 * Helper get user's refs?
		 * @return this
		 */
		_getRefs: function(){
			var dbwMan = this, refs = {};
			// 
			var $dbWidgets = dbwMan._getWidgetEles().each(function(idx){
				var $dbWidget = $(this),
					id = $dbWidget.data('id'),
					offset = 1 * $dbWidget.data('offset'),
					colData = dbwMan._getColByClassAttr($dbWidget.attr('class')),
					size = 1 * colData[0]
				;
				refs[id] = {'offset': offset, 'size': size};
			});
			// Return
			return refs;
		},
		/**
		 * Save user's refs?
		 * @return this
		 */
		_saveRefs: function(){
			var dbwMan = this, refs = this._getRefs(), lastRefs = JSON.stringify(refs);
			// Refs changed?
			if (this._lastRefs != lastRefs) {
				// Save refs
				$.get($.trim(this._options.save_refs_url), {'DBW_save_refs': refs})
					.done(function(rs){
						console && console.log('[dashboardWidgetManager] Save refs OK.');
						// Save last refs
						dbwMan._lastRefs = lastRefs;
					})
					.fail(function(rs){
						throw new Error('[dashboardWidgetManager] Error: ' + rs + '.');
					})
				;
			}
			// Return
			return this;
		}
	}; 
	/**
	 * Register jQuery widget
	 */
	$.fn.dashboardWidgetManager = $.fn.dashboardWidgetManager || function(options){
		return new dashboardWidgetManager($(this), options);
	};
	
	// Auto init 
	$('#dashboard').dashboardWidgetManager({});
	 
})(jQuery, [['_DATA_']], [['_OPTIONS_']]);
/** ./File default/views/assets/index/dashboard.js */