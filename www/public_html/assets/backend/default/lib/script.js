/**
 * jQuery bootstrap addon popover.
 * @author Mr.Phap
 * @since *07.04.2015*
 * @version 1.0.0
 * @copyright: (c)copyleft.
 */
(function($) {
	if ($.fn && $.fn.popover) {
		/**
		 * @param wapperEle jQuery Element
		 * @param itemsSelector StringType
		 * @return void
		 */
		$.togglePopover = $.togglePopover ||
		function(wapperEle, itemsSelector) {
			// Kiem tra neu wapper co ton tai thi moi thuc hien
			wapperEle = $(wapperEle);
			if (!wapperEle || wapperEle.size() <= 0) {
				console.log('Content element not found!');
				return false;
			}
			// ham tim kiem danh sach item
			var getItems = function(selector) {
				return wapperEle.find(selector);
			};
			// An di popover
			var hideEvent = function(selector) {
				getItems(selector + '[aria-describedby^="popover"]').not(this).popover('hide');
			};
			// ham tim kiem danh sach item
			var customEventShow = function(selector) {
				// khi show 1 popover thi an di cac popover khach
				/*getItems(selector).on('show.bs.popover', function () {
				// tim kiem cac popover khach dang hien thi
				hideEvent(selector);
				});*/
				// tim kiem cac popover khach dang hien thi
				wapperEle.delegate(selector, 'show.bs.popover', function() {
					hideEvent(selector);
				});
				// esc
				$(document.body).bind('keydown', function(event) {
					if (event.which == 27) {
						hideEvent(selector);
					}
				});
			};
			// dang ky su kien show
			customEventShow(itemsSelector);
		};
	}
})(jQuery);
/**
 * Project's scripts.
 * @author Mr.Khanh ???
 */
//	Inline JS.
(function($) {
	/**
	 * Register helpers for jQuery
	 * @author Mr.Khanh
	 * @since *???*
	 *
	 * @author Mr.Phong copy
	 * @since *17.02.2014*
	 */
	$.helper = $.helper || {
		validator : {
			email_address : function(email) {
				var eReg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return eReg.test(email);
			}
		},
		filter : {
			_vnLetters : {
				'Á':'A', 'À':'A', 'Ả':'A', 'Ã':'A', 'Ạ':'A', 'Â':'A', 'Ấ':'A', 'Ầ':'A', 'Ẩ':'A', 'Ẫ':'A', 'Ậ':'A', 'Ắ':'A', 'Ằ':'A', 'Ẳ':'A', 'Ẵ':'A', 'Ặ':'A','Ă':'A',
				'á':'a', 'à':'a', 'ả':'a', 'ã':'a', 'ạ':'a', 'â':'a', 'ấ':'a', 'ầ':'a', 'ẩ':'a', 'ẫ':'a', 'ậ':'a', 'ắ':'a', 'ằ':'a', 'ẳ':'a', 'ẵ':'a', 'ặ':'a','ă':'a',
				'Đ':'D', 'đ':'d',
				'É':'E', 'È':'E', 'Ẻ':'E', 'Ẽ':'E', 'Ẹ':'E', 'Ê':'E', 'Ế':'E', 'Ề':'E', 'Ể':'E', 'Ễ':'E', 'Ệ':'E',
				'é':'e', 'è':'e', 'ẻ':'e', 'ẽ':'e', 'ẹ':'e', 'ê':'e', 'ế':'e', 'ề':'e', 'ể':'e', 'ễ':'e', 'ệ':'e',
				'Í':'I', 'Ì':'I', 'Ỉ':'I', 'Ĩ':'I', 'Ị':'I',
				'í':'i', 'ì':'i', 'ỉ':'i', 'ĩ':'i', 'ị':'i',
				'Ó':'O', 'Ò':'O', 'Ỏ':'O', 'Õ':'O', 'Ọ':'O', 'Ô':'O', 'Ố':'O', 'Ồ':'O', 'Ổ':'O', 'Ỗ':'O', 'Ộ':'O', 'Ơ':'O', 'Ớ':'O', 'Ờ':'O', 'Ở':'O', 'Ỡ':'O', 'Ợ':'O',
				'ó':'o', 'ò':'o', 'ỏ':'o', 'õ':'o', 'ọ':'o', 'ô':'o', 'ố':'o', 'ồ':'o', 'ổ':'o', 'ỗ':'o', 'ộ':'o', 'ơ':'o', 'ớ':'o', 'ờ':'o', 'ở':'o', 'ỡ':'o', 'ợ':'o',
				'Ú':'U', 'Ù':'U', 'Ủ':'U', 'Ũ':'U', 'Ụ':'U', 'Ư':'U', 'Ứ':'U', 'Ừ':'U', 'Ử':'U', 'Ữ':'U', 'Ự':'U',
				'ú':'u', 'ù':'u', 'ủ':'u', 'ũ':'u', 'ụ':'u', 'ư':'u', 'ứ':'u', 'ừ':'u', 'ử':'u', 'ữ':'u', 'ự':'u', 
				'Ý':'Y', 'Ỳ':'Y', 'Ỷ':'Y', 'Ỹ':'Y', 'Ỵ':'Y', 
				'ý':'y', 'ỳ':'y', 'ỷ':'y', 'ỹ':'y', 'ỵ':'y'
			},
			noMark : function(text) {
				var noMarkTxt = "";
				for (var i = 0; i < text.toString().length; i++) {
					noMarkTxt += (text[i] in this._vnLetters) ? this._vnLetters[text[i]] : text[i];
				}
				return noMarkTxt;
			}
		},
		nl2br : function(str, is_xhtml) {
			var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>';
			return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
		}
	};

	/**
	 * Khi submit form, tao mot layer an, ngan khong cho submit 2 lan.
	 * @author Mr.Khanh
	 * @since *???*
	 */
	$(window).bind("beforeunload", function(a) {
		var div = $("<div />").css({
			position : "absolute",
			"z-index" : 9999999,
			top : 0,
			left : 0,
			width : $(document).width(),
			height : $(document).height()
		}).appendTo(document.body);
		setTimeout(function() {
			div.remove();
		}, 1000);
	});
	/**
	 * Rang buoc dl so doi voi elements textbox.
	 * @author Mr.Khanh
	 * @since *???*
	 *
	 * @author Mr.Khanh
	 * @since *13.01.2014*
	 * 	[+] Khong can kiem tra du lieu nhap doi voi `decPoint` va `thousandPoint`.
	 */
	(function() {
		// Check helpers
		if (!$.phpjs) { return !console.log('Missing lib `$.phpjs`.'); }
		//  Selector.
		var numericInputsSelector = "input[type='text'].numeric:not([readonly]):not(:disabled)";
		//	Special chars.
		var decPoint = ",", thousandPoint = ".", minusSign = "-", plusSign = "+";
		// 	Bien: 
		// +++ dung kiem tra xem su kien change da duoc thuc thi?
		var inputLastKeydownVal = null;
		$(document)
			.on("keydown", numericInputsSelector, function(evt) {
				inputLastKeydownVal = this.value;
			})
			.on("keypress paste", numericInputsSelector, function(evt) {
				var kpTest = true,
				    isCmdKey = ($.inArray(evt.which, [8, 9, 13, 0]) != -1);
				if (!(evt.ctrlKey || isCmdKey)) {
					var jThis = $(this), curVal = jThis.val();
					//	Get charCode.
					var charCode = String.fromCharCode(evt.which).toLowerCase();
					if (// TH: trung dau so thap phan;
						( (curVal.indexOf(decPoint) >= 0) && (charCode == decPoint) )
						// TH: trung dau "-";
						|| ( (curVal.indexOf(minusSign) >= 0) && (charCode == minusSign) )
						// TH: trung dau "+"; 
						|| ( (curVal.indexOf(plusSign) >= 0) && (charCode == plusSign) )
					) {
						return false;
					}
					kpTest = new RegExp("["/* +  thousandPoint*/
					+ (jThis.hasClass("integer") ? "" : decPoint) + (jThis.hasClass("positive") ? "" : "\\-") + "0-9]").test(charCode);
				}
				//	Return;
				return kpTest;
			}).on("keyup", numericInputsSelector, function(evt) {
				var jThis = $(this), curVal = jThis.val();
				// Cho phep nhap dau "-" o dau;
				if (!jThis.hasClass("positive") && (minusSign == curVal)) { return true; }
				// Cho phep nhap dau phan cach thap phan o cuoi;
				if (!jThis.hasClass("integer") && (curVal.length > 1) &&  (decPoint == curVal[curVal.length - 1])) { return true; }
				// Cho phep nhap so "0" o cuoi;
				if ((curVal.indexOf(decPoint) >= 0) && ("0" == curVal[curVal.length - 1])) {
					if (curVal.split(decPoint).pop().length < $.phpjs.MAX_DECIMALS) { return true; }
				}
				//  Ko can format du lieu.
				    noFormat = jThis.hasClass('no-format __no-format__'),
				//  Gia tri nhap
				    newVal = (noFormat ? curVal : $.phpjs.escapeVnNumberFormat(curVal)),
				//  Ko cho nhap so 0 (zero).
				    noZero = jThis.hasClass('no-zero'),
				//  Gioi han min: toi thieu.
				    min = parseFloat(jThis.attr('data-min')),
				//  Gioi han max: toi da.
				    max = parseFloat(jThis.attr('data-max'))
				;
				//  Case: no zero allowed.
				if (noZero && ("" != newVal) && (0 == (1 * newVal))) {
					return !jThis.val("");
				}
				//  Case: min.
				if (!isNaN(min) && ("" != newVal) && ((1 * newVal) < min)) {
					return !jThis.val(noFormat ? min : $.phpjs.vnNumberFormat(min));
				}
				//  Case: max.
				if (!isNaN(max) && ("" != newVal) && ((1 * newVal) > max)) {
					return !jThis.val(noFormat ? max : $.phpjs.vnNumberFormat(max));
				}
				//  Format data output?
				if (!noFormat && (curVal != inputLastKeydownVal)) {
					var selectionEnd = 1 * (this && this.selectionEnd),
					    newVal = $.phpjs.vnNumberFormat(newVal)
					;
					if (curVal != newVal) {
						newVal = ((0 == (1 * newVal)) && noZero) ? "" : newVal;
						jThis.val(newVal).prop('selectionEnd', selectionEnd + ((newVal && newVal.length) - (curVal && curVal.length)));
					}
				}
			})
			.on("focusin", numericInputsSelector, function(evt) {
				var lastVal = this.value, changed = false;
				$(this).one("change", function(){ changed = true; })
					.one("focusout", function(evt){
						//console.log("changed: ", changed, ". lastVal:", lastVal, ". value: ", this.value);
						if (!changed && (lastVal != this.value)) {
							$(this).trigger(new jQuery.Event('change', {originalEvent: evt.originalEvent}));
						}
					})
				;
			})
		;
	})();
	/**
	 * Khi click vao bieu tuong `calendar`, mo dialog `calendar`.
	 * @author Mr.Khanh
	 * @since *06.01.2013*
	 */
	$(document).on('click', 'span.glyphicon.glyphicon-calendar', function(evt) {
		// 	Bien: dung luu input `calendar` element?
		var inputDom = $(this).data('inputDom');
		// 	Kiem tra xem: da co kiem tra thuc hien truoc do?
		if (!inputDom) {
			inputDom = $(this).prev('input[type="text"]').get(0) || $(this).next('input[type="text"]').get(0) || $(this).parent().prev('input[type="text"]').get(0) || $(this).parent().next('input[type="text"]').get(0);
		}
		// 	Luu lai input element da tim duoc.
		$(this).data('inputDom', inputDom);
		//	Neu co: focus vao input element de hien thi dialog `calendar`.
		if (inputDom) {
			inputDom.focus();
		}
	});
	/**
	 * Upper case / Lower case input
	 * @author Mr.Nhat
	 * @since *06/12/2013
	 *
	 * @author Mr.Khanh [18.02.2014]
	 * 	Chuyen sang delegate, vi khong chay voi cac element duoc tao sau.
	 *
	 * @author Mr.Hào (modifier)
	 * @since *28.03.2014*
	 *    [+] Fix bugs khong bat duoc su kien change
	 */
	(function() {
		var upperInputSelector = "input.uppercase, input.upper-case, textarea.uppercase, textarea.upper-case";
		var lowerInputSelector = "input.lowercase, input.lower-case, textarea.lowercase, textarea.lower-case";
		//	Bien: dung kiem tra xem su kien change da duoc thuc thi?
		$(document).on('keypress parse', [upperInputSelector, lowerInputSelector].join(', '), function(evt) {
			var isCmdKey = ($.inArray(evt.which, [8, 9, 13, 0]) != -1);
			if (!(evt.ctrlKey || isCmdKey)) {
				var input = this;
				setTimeout(function(){
					var jInput = $(input), selectionEnd = 1 * (input && input.selectionEnd), 
						newVal = jInput.is(upperInputSelector) ? input.value.toUpperCase() : input.value.toLowerCase() 
					; 
					jInput.val(newVal).prop('selectionEnd', selectionEnd);
				});
			}
		});
	})();
})(jQuery);

/**
 * On document ready.
 */
jQuery(function($) {
	/**
	 * Lay element form chinh tren trang.
	 * @author Mr.Khanh
	 * @since *11.11.2013*
	 */
	var jAdminFrmEle = $('#adminForm');

	//	Phan xu ly su kien cho cac html controls.
	//	---
	jAdminFrmEle.on("change", "select.update_status", function() {
		jAdminFrmEle.find("input[type='checkbox']").removeAttr("checked");
		$(this).attr("name", "update_status").closest("tr").find("input[type='checkbox']").prop("checked", true);
		jAdminFrmEle.submit();
	});
	//	---
	jAdminFrmEle.on("click", "a.order", function() {
		$("#order").val($(this).attr("href"));
		jAdminFrmEle.submit();
		return false;
	});
	//	---
	$(document).on("click", "a[class^='toolbar-']", function() {
		if (jAdminFrmEle.find('input[name^="id"]:checked').length <= 0) {
			alert("Vui lòng chọn dòng cần thực hiện!");
			return false;
		}
		if ($(this).hasClass("toolbar-trash")) {
			if (!confirm("Bạn có muốn xóa (các) dòng đã chọn?")) {
				return false;
			}
		}
		if ($(this).hasClass("toolbar-restore")) {
			if (!confirm("Bạn có muốn khôi phục (các) dòng đã chọn?")) {
				return false;
			}
		}
		jAdminFrmEle.attr("action", $(this).attr("href")).submit();
		return false;
	});
	//	---
	jAdminFrmEle.on("change", "select.filters", function(evt) {
		jAdminFrmEle.submit();
	});
	//	---
	jAdminFrmEle.on("change", "#checkall", function() {
		jAdminFrmEle.find("input[name^='id']:not(:disabled)").prop("checked", $(this).is(":checked"));
	});
	//	---
	jAdminFrmEle.on("click", "a.manage-trash", function() {
		if (confirm("Bạn có đồng ý xóa dòng đang chọn?")) {
			jAdminFrmEle.find("input[type='checkbox']").removeAttr("checked");
			$(this).closest("tr").find("input[type='checkbox']").prop("checked", true);
			jAdminFrmEle.attr("action", $(this).attr("href")).submit();
		}
		return false;
	});
	//	---
	jAdminFrmEle.on("click", "a.manage-assign", function() {
		jAdminFrmEle.find("input[type='checkbox']").removeAttr("checked");
		$(this).closest("tr").find("input[type='checkbox']").prop("checked", true);
		jAdminFrmEle.attr("action", $(this).attr("href")).submit();
		return false;
	});
	//	---
	jAdminFrmEle.on("click", "a.manage-restore", function() {
		if (confirm("Bạn có đồng ý khôi phục dòng đang chọn?")) {
			jAdminFrmEle.find("input[type='checkbox']").removeAttr("checked");
			$(this).closest("tr").find("input[type='checkbox']").prop("checked", true);
			jAdminFrmEle.attr("action", $(this).attr("href")).submit();
		}
		return false;
	});
	//	---
	jAdminFrmEle.on("click", "a.manage-publish", function() {
		jAdminFrmEle.find("input[type='checkbox']").removeAttr("checked");
		$(this).closest("tr").find("input[type='checkbox']").prop("checked", true);
		jAdminFrmEle.attr("action", $(this).attr("href")).submit();
		return false;
	});
	//	---
	jAdminFrmEle.on("click", "a.manage-check", function() {
		if (confirm("Bạn có đồng ý thao tác với dòng đang chọn?")) {
			jAdminFrmEle.find("input[type='checkbox']").removeAttr("checked");
			$(this).closest("tr").find("input[type='checkbox']").prop("checked", true);
			jAdminFrmEle.attr("action", $(this).attr("href")).submit();
		}
		return false;
	});
	//	---
	$(document).on("click", "div.pagination a", function() {
		$("#page").val($(this).attr("href"));
		jAdminFrmEle.submit();
		return false;
	});
	//	---
	$(document).on("change", "div.pagination #limit", function() {
		jAdminFrmEle.submit();
		return false;
	});

	//	---
	//	--- Create datepicker, datetimepicker control on demand.
	if (jQuery.fn.datetimepicker || jQuery.fn.datepicker) {
		(function($){
			var datepickerOptions = {
				dateFormat : "dd.mm.yy",
				changeMonth : true,
				changeYear : true,
				monthNamesShort : ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
				dayNamesMin : ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
				yearRange : "c-90:c+10"
			};
			var datetimepickerOptions = $.extend({}, datepickerOptions);
			// Helper: khoi tao date picker + datetime picker;
			($.attachDatepicker= function(selectors, options){
				$(selectors)
					.datepicker($.extend({}, datepickerOptions, options))
					//	Clear value on Control + Click.
					.click(function(evt) {
						if (evt.ctrlKey) {
							$(this).val("").trigger('change');
							return false;
						}
					});
				;
			})(':text.datepicker:not(".timepicker")');
			($.attachDatetimepicker = function(selectors, options) {
				$(selectors)
					.datetimepicker($.extend({}, datetimepickerOptions, options))
					//	Clear value on Control + Click.
					.click(function(evt) {
						if (evt.ctrlKey) {
							$(this).val("").trigger('change');
							return false;
						}
					});
				;
			})(':text.datepicker.timepicker');
		})(jQuery);
	}
	//	--- Load CKEDITOR on demand
	if ( typeof (CKEDITOR) != 'undefined') {
		$("textarea[editor]").each(function(idx) {
			var toolbarPreset = $(this).attr("editor");
			CKEDITOR.replace(this, {
				height : 160,
				width : '100%',
				toolbar : toolbarPreset
			});
		});
	}
	/**
	 * Xu ly cap nhat trang thai, dung ajax...
	 * @author Mr.Khanh
	 * @since *???*
	 */
	jAdminFrmEle.find("a.jgrid.change-status").unbind("click").click(function(event) {
		//	Prevent default.
		event.preventDefault();
		//	Khai bao bien.
		var self = this,
		    thisData = null;
		try {
			thisData = $.parseJSON($(this).attr("data"));
		} catch (e) {
			//	Do nothing...
			thisData = {};
		}
		//	Call ajax
		$.ajax({
			url : $(self).attr("href"),
			type : "post",
			data : (thisData && thisData.sendData),
			async : false,
			dataType : "json",
			success : function(data, textStatus, jqXHR) {
				if ( typeof (thisData && thisData.onSuccess) == "function") {
					return thisData.onSuccess(data, textStatus, jqXHR);
				} else {
					//	Loi -> thong bao
					if (data && data.error) {
						alert(data.error);
						return false;
					}
					//	Thanh cong -> chuyen doi trang thai
					if (data && data.status) {
						$("span", self).removeClass("glyphicon-ok-sign glyphicon-record").addClass("glyphicon-ok-sign");
					} else {
						$("span", self).removeClass("glyphicon-ok-sign glyphicon-record").addClass("glyphicon-record");
					}
				}
			},
			error : function(jqXHR, textStatus, errorThrown) {
				if ( typeof (thisData && thisData.onError) == "function") {
					thisData.onError(jqXHR, textStatus, errorThrown);
				} else {
					alert(textStatus + ': ' + errorThrown);
				}
			}
		});
		return false;
	});

	/**
	 * Xu ly: tao combobox
	 * @author Mr.Khanh ???
	 */
	if ($.ui && $.ui.combobox) {
		$("select[combobox]", document.body).each(function(idx) {
			var options = $.trim($(this).attr("combobox"));
			if ("" != options) {
				try {
					eval('options = ' + options);
				} catch (e) {
					//	Do noting...
					console.log("error");
				}
			};
			if (!$.isPlainObject(options)) {
				options = {};
			}
			$(this).combobox(options);
		});
	}
	/**
	 * Xu ly: khong submit nhung element co gia tri rong tren form.
	 * @author Mr.Khanh
	 * @since *26.10.2013*
	 */
	$(document).on('submit', 'form[method="get"]:not(".skipCheckEmptyEles")', function(evt) {
		var frmEle = this;
		// Disable emtpy elements
		var jDisabledEles = $("*[name]", this).not(".ignored").each(function(index) {
			if ("" == $.trim($(this).val())) {
				$(this).attr("disabled", "disabled");
			}
		});
		// Trigger afterSubmit.
		setTimeout(function() {
			jDisabledEles.removeAttr("disabled");
		}, 0);
	});
	/**
	 * Ho tro tao nhanh KCFinder.
	 * @author Mr.Khanh
	 * @since *11.11.2013*
	 *
	 * @author Mr.Hào
	 * @since *30.12.2013*
	 * 	[+] Thêm phương thức _callBackFunc.
	 */
	window.KCFinder = window.KCFinder || {
		// 	Bien dung ghi nhan lai dom element vua goi.
		_lastCallDomEle : null,
		// 	Bien dung ghi nhan lai thu muc (type) vua goi.
		_lastCallType : '',
		//	Phuong thuc ho tro loai bo thu muc chua tap tin.
		_truncateType : function(url) {
			var substrLength = url.indexOf(this._lastCallType);
			substrLength = !(-1 == substrLength) ? (substrLength + this._lastCallType.length) : 0;
			return url.substr(substrLength);
			//.replace(this._lastCallType, '');
		},
		//	Phuong thuc ho tro tra ve ten file.
		_callBackFunc : function(files) {
			//	Neu khong phai la mang thi chuyen ve mang.
			if (!$.isArray(files)) {
				files = [files];
			}
			//	Mang chua ten file da duoc chon.
			var truncatedFiles = [];
			for (var i = 0; i < files.length; i++) {
				truncatedFiles.push(KCFinder._truncateType(files[i]));
			}
			//	Chuyen doi tuong DOOM ve doi tuong jQuery.
			var jLastCallDomEle = $(KCFinder._lastCallDomEle);
			//	Neu element la text thi lay file dau tien.
			if (jLastCallDomEle.is('input[type="text"]')) {
				jLastCallDomEle.val(truncatedFiles[0]);
			}
			//	Neu element la textarea thi lay het file.
			else if (jLastCallDomEle.is('textarea')) {
				jLastCallDomEle.val(truncatedFiles.join('\n'));
			}
			//	Trigger su kien change.
			jLastCallDomEle.trigger('change', [truncatedFiles]);
		},
		// 	Phuong thuc, ho tro mo cua so KCFinder.
		open : function(domEle, type) {
			// 	Xac dinh kich thuoc cua so.
			var maxWinWidth = 800,
			    maxWinHeight = 600,
			    winWidth = $(window).width(),
			    winHeight = $(window).height();
			winWidth = (winWidth > maxWinWidth) ? maxWinWidth : winWidth;
			winHeight = (winHeight > maxWinHeight) ? maxWinHeight : winHeight;
			// 	Mo cua so hien thi KCFinder.
			var KCFinderWin = window.open('/skins/default/sales/js/kcfinder/ver-2.51/browse.php?type=' + type, 'KCFinder', 'status=0, toolbar=0, location=0, menubar=0, directories=0, ' + 'resizable=1, scrollbars=0, width=' + winWidth + ', height=' + winHeight + '');
			//	Ghi nhan lai input dom element vua thuc hien goi.
			this._lastCallDomEle = domEle;
			///	Ghi nhan lai input dom element vua thuc hien goi.
			this._lastCallType = type;
		},
		// 	Callback ho tro bat su kien chon file cua KCFinder (chon 1 file).
		callBack : function(url) {
			KCFinder._callBackFunc(url);
		},
		//	Callback ho tro bat su kien chon file cua KCFinder (chon nhieu files).
		callBackMultiple : function(files) {
			KCFinder._callBackFunc(files);
		}
	};
	// 	Tim kiem nhung input elements can su dung KCFinder?
	jAdminFrmEle.find("textarea[finder], input[finder]").each(function(idx) {
		// 	Luu lai doi tuong element load KCFinder.
		var inputDom = this;
		//	Tao a element chon tap tin.
		var jATagFile = $('<a href="#" class="glyphicon glyphicon-eject" />').addClass('input-group-addon').click(function(evt) {
			//	Mo cua so
			KCFinder.open(inputDom, $(inputDom).attr('finder'));
			//	Prevent click event.
			return false;
		}).insertAfter(this);
		//	Tao a element clear noi dung.
		var jATagSelect = $('<a href="#" class="glyphicon glyphicon-remove" />').addClass('input-group-addon').click(function(evt) {
			//	Danh noi dung cua input element ve rong.
			$(inputDom).val('');
			//	Prevent click event.
			return false;
		}).insertAfter(jATagFile);
		//  Add them css classes vao element parent, ho tro format giao dien.
		$(inputDom).parent().addClass('input-group');
	});
	/**
	 * Xu ly : Limit text length in textarea
	 * @author Mr.Khanh ???
	 */
	$(document).on("keyup", "textarea[maxlength]", function(evt) {
		//get the limit from maxlength attribute
		var limit = parseInt($(this).attr('maxlength'));
		//get the current text inside the textarea
		var text = $(this).val();
		//count the number of characters in the text
		var chars = text.length;
		//check if there are more characters then allowed
		if (chars > limit) {
			//and if there are use substr to get the text before the limit
			var new_text = text.substr(0, limit);
			//and change the current text with the new text
			$(this).val(new_text);
		}
	});
	/**
	 * Xóa sự kiện onlick trong thẻ a của dropdown search trên toolbar
	 * @author Mr.Nhat
	 * @since ???
	 */
	$("span.dropdown-search").parents("a").removeAttr("onclick").click(function() {
		var objFilter = $("#filter-bar");
		if (objFilter.css("display") == "none") {
			objFilter.show();
		} else {
			objFilter.hide();
		}
	});
	/**
	 * Xu ly: toggle popover.
	 * @author Mr.Khanh 06.08.2015
	 */
	if ($.togglePopover) {
		$.togglePopover($(document.body).find('form'), 'a[data-toggle="popover"]');
	}

	//  Mr.Phong [10.04.2014] Bo sung xu ly cho form tim kiem thanh toolbar
	//  ---- Remove class panel
	$(".panel", ".toolbar-search").removeClass("panel");
	//  Remove btn `tu khoa`
	$(".filter-search", ".toolbar-search").find(".btn").eq(0).remove();
	//  Add class clearfix vao div co `id = 'filter-bar'`
	$("#filter-bar", ".toolbar-search").addClass("clearfix");
	//  Su kien click nut hien thi form Add class `search-keyword`
	$(".expand-search", "form.toolbar-search").click(function() {
		var parent = $(this).parents("form.toolbar-search");
		parent.find("#search-keyword").addClass("search-keyword");
	});
	//  Su kien click nut an form Remove class `search-keyword`
	$(".collapse-search", "form.toolbar-search").click(function(evt) {
		var parent = $(this).parents("form.toolbar-search");
		parent.find("#search-keyword").removeClass("search-keyword");
	});
	//  Quan trong `danh z-index cho toolbar tren`
	$("form.toolbar-search").parents(".toolbars-wrapper").eq(0).css("z-index", "2");
	//  End form tim kiem thanh toolbar

	/**
	 *Xử lý form search quick filter
	 * @author Mr.Nhat
	 * @since *01/11/2013*
	 */
	$(".filter-search button.reset").click(function() {
		$("input#keyword").val("");
		return false;
	});

	/**
	 * Mr.Phong 06.04.2015
	 * Reset form search
	 */
	//  reset Form search
	$(".reset.btn-reset", "#filterFormSearch").click(function(evt) {
		//  preventDefault
		evt.preventDefault();
		/// Reset form
		$("form#filterFormSearch").find("input, textarea, select, input:hidden").val('');

		$("#filterFormSearch").find("input.ui-combobox-input").trigger("sync");
	});
	/**
	 * End
	 */

	$("#fieldset-adminForm .form-control.btn").parents(".form-group").find("label").css({
		"visibility" : "hidden"
	});
	$("#dummy_submit_button").click(function() {
		$(this).parents("form").submit();
	});
	//	/**
	//	 * Mr.Phong
	//	 * 17.02.2014
	//	 *  Xu ly check box khi them moi o man hinh them nhanh
	//	 */
	//	// Href
	//	var href = window.location.href;
	//	// Tach chuoi
	//	var str = href.split("_tickid=");
	//	// Xu ly check box
	//	var jQCheckbox = $("input[type='checkbox'][value='" + str[1] + "']");
	//	jQCheckbox.attr("checked",true);
	
	
	/**
	 * SU DUNG GRID THEME CHO HIGHCHART
	 * Grid-light theme for Highcharts JS
	 * @author Torstein Honsi
	 */
	if (typeof(Highcharts) != 'undefined'){
		// Load the fonts
		Highcharts.createElement('link', {
		   href: '//fonts.googleapis.com/css?family=Dosis:400,600',
		   rel: 'stylesheet',
		   type: 'text/css'
		}, null, document.getElementsByTagName('head')[0]);
		
		Highcharts.theme = {
		   colors: ["#7cb5ec", "#f7a35c", "#90ee7e", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
		      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
		   chart: {
		      backgroundColor: null,
		      style: {
		         fontFamily: "Dosis, sans-serif"
		      }
		   },
		   title: {
		      style: {
		         fontSize: '16px',
		         fontWeight: 'bold',
		         textTransform: 'uppercase'
		      }
		   },
		   tooltip: {
		      borderWidth: 0,
		      backgroundColor: 'rgba(219,219,216,0.8)',
		      shadow: false
		   },
		   legend: {
		      itemStyle: {
		         fontWeight: 'bold',
		         fontSize: '13px'
		      }
		   },
		   xAxis: {
		      gridLineWidth: 1,
		      labels: {
		         style: {
		            fontSize: '12px'
		         }
		      }
		   },
		   yAxis: {
		      minorTickInterval: 'auto',
		      title: {
		         style: {
		            textTransform: 'uppercase'
		         }
		      },
		      labels: {
		         style: {
		            fontSize: '12px'
		         }
		      }
		   },
		   plotOptions: {
		      candlestick: {
		         lineColor: '#404048'
		      }
		   },
		
		
		   // General
		   background2: '#F0F0EA'
		   
		};
		
		// Apply the theme
		Highcharts.setOptions(Highcharts.theme);
	}
}); 