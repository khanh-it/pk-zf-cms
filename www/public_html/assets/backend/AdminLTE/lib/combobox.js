/**
 * jQuery UI addon combobox.
 * @author Mr.Khanh
 * @version 1.0.0
 * @copyright: (c)copyleft.
 */
(function($) {
	/**
	 * Register helper 'vnFilter' for jQuery.
	 */
	$.vnLettersFilter = $.vnLettersFilter || {
		_vnLetters: {
			'A' : '[Á|À|Ả|Ã|Ạ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|Ắ|Ằ|Ẳ|Ẵ|Ặ]',
			'a' : '[á|à|ả|ã|ạ|â|ấ|ầ|ẩ|ẫ|ậ|ắ|ằ|ẳ|ẵ|ặ]',
			'D' : '[Đ]',
			'd' : '[đ]',
			'E' : '[É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ]',
			'e' : '[é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ]',
			'I' : '[Í|Ì|Ỉ|Ĩ|Ị]',
			'i' : '[í|ì|ỉ|ĩ|ị]',
			'O' : '[Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ]',
			'o' : '[ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ]',
			'U' : '[Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự]',
			'u' : '[ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự]', 
			'Y' : '[Ý|Ỳ|Ỷ|Ỹ|Ỵ]', 
			'y' : '[ý|ỳ|ỷ|ỹ|ỵ]'
		},
		noMark: function(text){
			for (var letter in this._vnLetters) {
				text = text.toString().replace(new RegExp(this._vnLetters[letter], 'g'), letter);
			}
			return text;
		}
	};
	
	/**
	 * Define jQuery UI's addon combobox. 
	 */
	// 	Define combobox.
	$.widget("ui.combobox", {
		/**
		 * Options default
		 */
		options: {
			//  TH dac biet: empty value (-- chua co gia tri--)...
			specialEmptyValue: null,
			//	So luong item render toi da tren menu
			maxItems: 256,
			//	Bien co xac dinh co xoa tu khoa tim kiem khi khong tim thay khong?
			isRemoveInvalid: true,
			//	CSS Classes mac dinh dung format giao dien cho combobox.
			inputClass:'form-control input-sm',
			buttonClass:'input-group-addon',
			wrapperClass: 'input-group',
			//  Helper: ho tro kiem tra xem option co phai optgroup?
			isOptgroup: function(optEle){
				return $(optEle).hasClass('optgroup'); 
			},
			//  Helper: render items.
			renderItem: null,
			// 	Events
			onCreate: null,
			triggerBeforeGetSourceEvent: '',
			triggerAfterGetSourceEvent: '',
			onFocus: null,
			triggerFocusEvent: '',
			onSelect: null,
			triggerSelectEvent: '',
			onChange: null,
			triggerChangeEvent: ''
		},
		/**
		 * Helper: get select element's default option element.
		 * @author MrKhanh
		 * 
		 * @param selectEle Object DOM select element
		 * @return Object jQuery object 
		 */
		_getDefaultOpt: function(selectEle){
			return $(selectEle).find('option').not(':disabled').eq(0);
		},
		/**
		 * Helper: build autocomplete source item from option element.
		 * @author MrKhanh
		 * 
		 * @param jCurOpt Object DOM option element
		 * @param dfOptEle Object DOM option element
		 * @return Object 
		 */
		_buildAcSrcItem: function(jCurOpt, dfOptEle){
			var item = {};
			if (jCurOpt && jCurOpt.size()) {
				var isOptgroup = jCurOpt.is('optgroup') || this.options.isOptgroup(jCurOpt);
				//  Get data;
				item.id = isOptgroup ? null : jCurOpt.val(); 
				item.label = isOptgroup ? jCurOpt.attr('label') : jCurOpt.text(); 
				item.value = isOptgroup ? null : item.label;
				item.isDfOpt = jCurOpt.is(dfOptEle); 
				item.isOptgroup = isOptgroup;
				item.isDisabled = jCurOpt.is(':disabled');
			};
			return item;
		},
		/**
		 * Get ref to input element.
		 * @author MrKhanh
		 * @return Object DOM Element.
		 */
		getInput: function() { return $(this._refEles[0]); },
		/**
		 * Sync input's value with selected option.
		 * @author MrKhanh
		 * @return this
		 */
		sync: function() {
			this.getInput() && this.getInput().trigger('sync');
			// Return;
			return this;
		},
		/**
		 * Get ref to button element.
		 * @author MrKhanh
		 * @return Object DOM Element.
		 */
		getButton: function() { return $(this._refEles[1]); },
		/**
		 * Get ref to wrapper element.
		 * @author MrKhanh
		 * @return Object DOM Element.
		 */
		getWrapper: function() { return $(this._refEles[2]); },
		/**
		 * Get ref autocomplete widget.
		 * @author MrKhanh
		 * @return Object.
		 */
		getAcWidget: function(){
			return this.getInput() && this.getInput().data('ui-autocomplete');
		},
		/**
		 * Get ref autocomplete widget's components.
		 * @author MrKhanh
		 * @return Object.
		 */
		getAcWidgetMenu: function() {
			return this.getAcWidget() && this.getAcWidget().menu;
		},
		/**
		 * For backward compatibility.
		 * @proxy this::getAcWidgetMenu
		 * @author MrKhanh
		 * @return Object.
		 */
		getMenu: function() {
			return this.getAcWidgetMenu();
		},
		/**
		 * Set combobox's value.
		 * @author MrKhanh
		 * @param mixed value 
		 * @param Boolean fireChangeEvt Fire change on set value?
		 * @return mixed 
		 */
		val: function(value, fireChangeEvt){
			var jSelEle = this.element, widget = this;
			//  Case: get value.
			if (undefined === value) { return jSelEle.val(); }
			//  Case: set value.
			else {
				var jCurOpt = jSelEle.find('option[value="' + value + '"]').not(':disabled'); 
				if (jCurOpt) {
					jSelEle.one('cbxChange', function(event){
						// 	Fire event?
						fireChangeEvt = (true === fireChangeEvt) ? true : false;
						if (fireChangeEvt) {
							var ui = {item: widget._buildAcSrcItem(jCurOpt, widget._getDefaultOpt(jSelEle))}; 
							widget.getAcWidget()._trigger('select', event, ui);	
						} else {
							jSelEle.val(value);
						}
						//  Sync selected option's text. 
						widget.sync();
					}).triggerHandler('cbxChange');					
				}
			}
			//  Return;
			return this;
		},
		/**
		 * Get / Set sticky value for combobox element
		 * @param mixed value
		 * @return mixed
		 */
		stickyVal:function(value) {
			//  Case: set data.
			if (undefined != value) {
    			this.getInput().data({'cbx-sticky-val': value});
				// Return;
				return this;
   			}
   			//  Case: get data. 
			var data = this.getInput().data('cbx-sticky-val');
			return (undefined === data) ? null : data;
		},
		/**
		 * Enable combobox; 
		 * @return this
		 */
		enable: function() {
			$(this._refEles).add(this.element).attr({'readonly': false, 'disabled': false});
			return this;
		},
		/**
		 * Disable combobox; 
		 * @return this
		 */
		disable: function() {
			$(this._refEles).add(this.element).attr({'readonly': true, 'disabled': true});
			return this;
		},
		/**
		 * Create widget.
		 * @author MrKhanh
		 * @return void.
		 */
		_create: function() {
			var widget = this,
				// Select element used for create combobox.
				selectEle = widget.element.hide(),
				// Default option element.
				dfOptEle = widget._getDefaultOpt(selectEle)
			;
			// Store elements created when create combobox for later use.
			widget._refEles = [];
			
			// Input element used for searching values on select.
			var inputEle 	= widget._refEles[0] = $('<input type="text" />')
				.val(dfOptEle.text())
				.attr('readonly', selectEle.attr('readonly'))
				.attr('disabled', selectEle.attr('disabled'))
				.addClass("ui-combobox-input " + widget.options.inputClass)
				.get(0)
			;
			//	Make autocomplete.
			inputEle = $(inputEle).autocomplete({
				//	Options.
				delay: 0, minLength: 0,
				//	Source.
				source: function(request, response) {
					//  Fire custom event on get source.
					if (widget.options.triggerBeforeGetSourceEvent) {
						selectEle.trigger(widget.options.triggerBeforeGetSourceEvent);
					}
					// Khai bao bien;
					var // +++ List tat ca cac `option`, `optgroup` element: 
						jSelOpts = selectEle.find('option, optgroup'),
					// +++ Default option element: thuong dung cho option - Chon -
						jDfOpEle = widget._getDefaultOpt(selectEle),
					// +++ Tu khoa: chuyen sang lowercase vi ho tro tim kiem khong phan biet hoa - thuong;
						term = request.term.toLowerCase(),
					// +++ Mang chua data cua tat ca cac `optgroup`.  
						lstOptgroup = [],
					// +++ Mang chua tat ca cac `option` thoa dk tim kiem
						listOpts = [], 
					// +++ Bien dem so dong dl thoa dk <-- ho tro break pages;
					matchedCount = 0,
					// +++ Mang chua dl cuoi cung se dung de render ket qua;
						arrRtn = []
					;
					// Duyet
					for (var index = 0; index < jSelOpts.length; index++) {
						var // +++ @var {Object} Goi ham --> lay thong tin tu `option`, `optgroup` element;
							acSrc = widget._buildAcSrcItem(jSelOpts.eq(index), jDfOpEle),
						// +++ @var {Number} Bien: cho biet vi tri (position) cua ket qua tim kiem? Luu y: 0 based.
						// +++ Case: tim theo co dau.
							matched = acSrc.label.toLowerCase().indexOf(term),
						// +++ Case: tim theo khong dau.
							matched = (matched < 0) ? $.vnLettersFilter.noMark(acSrc.label.toLowerCase()).indexOf(term) : matched,
						// +++ Case: neu ket qua hok thoa, nhung day la default element <-- van dua vao;
							matched = (matched < 0 && !term && acSrc.isDfOpt) ? 0 : matched
						;
						// Case: la `optgroup` --> dua vao ds; 
						if (acSrc.isOptgroup) {
							lstOptgroup.push(acSrc);
						}
						// Case: la `option` va thoa dk tim kiem.
						else if (matched >= 0) {
							// Case: cac truong hop dac biet
							if (
							// +++ Default option element; 
								(acSrc.isDfOpt)
							// +++ Empty value (-- Chua co gia tri --)...
								|| (widget.options.specialEmptyValue == acSrc.id) 
							) {
								arrRtn.push(acSrc);
								continue;
							} else {
								// Tang bien dem, xac dinh so dong dl thoa dk tim kiem;
								++matchedCount;
								// Dua vao ds;
								listOpts.push([
								// +++ Index cua optgroup (neu co)
									lstOptgroup.length,
								// +++ Vi tri (position) kq tim kiem;
									matched,
								// +++ Kq tim kiem;
									acSrc
								]);								
							}
						}
						if (matchedCount > widget.options.maxItems) {break;}
					}
					//  Sap xep (sort) dl kq tim kiem;
					//  +++ Case: theo vi tri (position) cua tu khoa tim kiem;
					if (term && listOpts.length) {
						listOpts.sort(function(a, b){ return a[1] - b[1]; });
					}
					//  Duyet;
					var idx, opt, optGroup;
					for (idx in listOpts) {
						// Get data;
						opt = listOpts[idx];
						// Kiem tra: neu co optGroup thi chen vao kq tim kiem tra ve <-- tao `optgroup` element;
						if (lstOptgroup.length && (optGroup = lstOptgroup[opt[0]])) {
							// Dua vao ds;
							arrRtn.push(optGroup);
							// Xoa dl --> vi da ghi nhan, lan sau hok can ghi nhan nua;
							delete lstOptgroup[opt[0]];
						}
						// Ghi nhan `option` element vao ds;
						arrRtn.push(opt[2]);
					}
					//  Fire custom event on get source.
					if (widget.options.triggerAfterGetSourceEvent) {
						selectEle.trigger(widget.options.triggerAfterGetSourceEvent, [arrRtn]);
					}
					// 	Return;
					response(arrRtn);
				},
				//	Events.
				create: function(event, ui) {
					//	Add more css classes to menu.
					widget.getAcWidgetMenu().element.addClass("ui-combobox-list");
				},
				change: function(event, ui) {
					var acWidget = widget.getAcWidget(); 
					if (!ui.item) {
						var dfOptEle = selectEle.find('option:selected');
						//	Remove invalid value, as it didn't match anything.
						selectEle.val(dfOptEle.val());
						if (widget.options.isRemoveInvalid) {
							$(this).val(dfOptEle.text());
						}
					}
				},
				focus: function(event, ui) {
					if ($.isFunction(widget.options.onFocus)) {
						widget.options.onFocus.apply(selectEle, [inputEle, event, ui]);
					}
					//  Fire custom event on focus.
					if (widget.options.triggerFocusEvent) {
						selectEle.trigger(widget.options.triggerFocusEvent);
					}
				},
				select: function(event, ui) {
					//  Fire select event.
					if ($.isFunction(widget.options.onSelect)) {
						widget.options.onSelect.apply(selectEle, [inputEle, event, ui]);
					}
					//  Fire custom event on select.
					selectEle.trigger(widget.options.triggerSelectEvent);
					//  Fire change event.
					if (selectEle.val() != ui.item.id) {
						selectEle.val(ui.item.id);
						if ($.isFunction(widget.options.onChange)) {
							widget.options.onChange.apply(selectEle, [inputEle, event, ui]);
						}
						//  Fire custom event on change.
						selectEle.trigger(widget.options.triggerChangeEvent);
					}
				}
			});
			// 	Dropdown button.
			var cbbButtonEle = $(
				widget._refEles[1] = $('<span class="ui-combobox-button '+ widget.options.buttonClass + '">&#9660;</span>').get(0)
			);
			// 	Hidden wrapper element.
			var cbbWrapperEle= widget._refEles[2] = $('<span class="ui-combobox-wrapper"></span>').get(0);
			$(cbbWrapperEle)
				.addClass(widget.options.wrapperClass)
				//  Bind events;
				.on('sync focusin focusout keyup', '> input.ui-combobox-input', function(event){
					switch (event.type) {
						case 'sync': {
							$(this).val(selectEle.find('option:selected').text());
						} break;
						case 'focusin': {
							var dfOptEle = widget._getDefaultOpt(selectEle);
							if (selectEle.find('option:selected').is(dfOptEle)) {
								if (widget.options.isRemoveInvalid) {
									$(this).val("");
								}
							}
						} break;
						case 'focusout': {
							var dfOptEle = widget._getDefaultOpt(selectEle);
							if (selectEle.find('option:selected').is(dfOptEle)) {
								if (widget.options.isRemoveInvalid) { 
									$(this).val(dfOptEle.text());
								}
							}
						} break;
						case 'keyup' : { //	F4
							if (115 == event.which) { widget.getButton().trigger("click"); }
						} break;
					}
				})
				.on('click', '> span.ui-combobox-button', function(evt){
					// 	Is selectable?
					var isDisabled = inputEle.is('[readonly], :disabled')
						|| widget.element.is('[readonly], :disabled')
					;
					if (isDisabled) { return; }	
					//	Close if already visible
					if (inputEle.autocomplete("widget").is(":visible")) {
						inputEle.autocomplete("close");
						return;
					}
					//	Pass empty string as value to search for, displaying all results
					inputEle.autocomplete("search", "");
					inputEle.focus();
				})
				// 	Insert element to DOM.
				.append([inputEle, cbbButtonEle])
				.insertBefore(selectEle)
			;
			
			// 	Sync selected option's text.
			widget.sync();
			
			// 	Overwrite renders.
			widget.getAcWidget()._renderItem = function(ul, item){
				//  Flag: if this option is selected?
				var isSelected = item && ((widget.element.val() == item.id) && !item.isOptgroup);
				//  Render item.
				return widget.options.renderItem
					? widget.options.renderItem(ul, $.extend(item, {'isSelected': isSelected}))
					: $('<li></li>')
						.addClass(item.isOptgroup ? 'optgroup' : '')
						.addClass(item.isDfOpt ? 'dfopt' : '')
						.addClass(item.isDisabled ? 'disabled' : '')
						.addClass(isSelected ? 'selected' : '')
						.append($(item.isOptgroup ? '<b></b>' : (item.isDisabled ? '<span></span>' : '<a></a>')).text(item.label))
						.appendTo(ul)
					;
			}
			
			// Trigger events
			if ($.isFunction(widget.options.onCreate)) {
				setTimeout(function(){
					widget.options.onCreate.apply(selectEle, [inputEle, cbbButtonEle, cbbWrapperEle]);
				});
			}
		},
		/**
		 * Destroy widget.
		 * @author MrKhanh
		 */
		_destroy: function(){
			// 	Remove auto created elements.
			$(this._refEles).remove();
			this._refEles = [];
			
			// 	Show original select element.
			$(this.element).show();
		}
	});
})(jQuery);