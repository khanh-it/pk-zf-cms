/**
 * Class: simple translator
 * @author khanhdtp
 */
(function($){
	// 
	$.simpleTranslate = $.simpleTranslate || function(phrase){
		return phrase; 
	};
})(jQuery);

/**
 * Force numeric input for textbox elements.
 * @author khanhdtp
 */
(function($) {
	// Check helpers
	//if (!$.phpjs) { return !console.log('Missing lib `$.phpjs`.'); }
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
			    isCmdKey = ($.inArray(evt.which, [8, 9, 13, 0]) != -1)
			;
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
			return;
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
					if (!changed && (lastVal != this.value)) {
						$(this).trigger(new jQuery.Event('change', {originalEvent: evt.originalEvent}));
					}
				})
			;
		})
	;
})(jQuery);

/**
 * Gallery popup
 * @author khanhdtp
 */
(function($){
	// @var {Object} Templates
	var tmpl = {
		'popup': '<div class="gallery-popup-overlay hidden"><div class="card gallery-popup z-depth-3">'
			+ '<div class="clearfix gallery-popup-header">'
				+ '<h5 class="pull-left"></h5>'
				+ '<a href="#" class="btn btn-sm btn-danger pull-right gallery-popup-x"><span class="glyphicon glyphicon-remove"></span></a>'
			+ '</div>'
			+ '<a class="gallery-popup-fimg" href="{{src}}" target="_blank">'
				+ '<img src="{{src}}" class="z-depth-2">'
			+ '</a>'
			+ '<div class="clearfix gallery-popup-body"></div>'
		+ '</div></div>',
		'popupItemRow': ['<div class="row">', '</div>'],
		'popupItemCol': '<div class="col col-xs-4">'
			+ '<a href="{{src}}" target="_blank">'
				+ '<img src="{{src}}" class="img-responsive z-depth-2">'
			+ '</a>'
		+ '</div>'
	};
	// @var {Object} Gallery popup
	var $galleryPopup = $(tmpl.popup).appendTo(document.body)
	// Set data
		.on('setData', function(evt, obj){
			obj = $.isPlainObject(obj) ? obj: {};
			$galleryPopup
			// Title
				.find('.gallery-popup-header > h5').html(obj.title).end()
			// Src
				.find('a.gallery-popup-fimg')
					.attr('href', obj.img_src)
					.find('> img').attr('src', obj.img_src).end()
				.end()
			// Body
				.find('.gallery-popup-body').html(obj.body).end()
			;
		})
	// Show popup
		.on('show', function(evt, options){
			$galleryPopup.hide().removeClass('hidden').fadeIn('fast');
		})
	// Close popup
		.on('click', '.gallery-popup-x', function(evt){
			// Prevent default
			evt.preventDefault();
			// Hide popup
			$galleryPopup.fadeOut('fast');
		})
	;

	// Class 'gallery popup'. 
	$.GalleryPopup = $.GalleryPopup || {
		/**
		 * Show popup gallery
		 * @param {Object} Options
		 */
		show: function(options) {
			// Format optionsdiv
			options = $.extend(true, {
			// +++ popup title
				'title': 'View images (gallery)',
			// +++ images
				'imgs': []
			}, options || {});
			
			// Build gallery popup body;
			var html = [];
			if (options.imgs.length) {
				var cols = 3;
				for (var i = 1; i < options.imgs.length; i++) {
					if (((i - 1) % cols) == 0) {
						html.push(tmpl.popupItemRow[1] + tmpl.popupItemRow[0]);	
					}
					html.push(tmpl.popupItemCol.replace(/{{src}}/g, options.imgs[i]));
				}
				//
				html = tmpl.popupItemRow[0] + html.join('') + tmpl.popupItemRow[1];
				// Set data
				$galleryPopup.triggerHandler('setData', [{
					'title': options.title,
					'img_src': options.imgs[0],
					'body': html
				}]);
				// Show popup
				$galleryPopup.triggerHandler('show', [options]);
			}
			// Return
			return this;
		}
	};
	// Auto trigger gallery popup for dom elements
	$(document).on('click', '.gallery-popup-trigger', function(evt){
		// Prevent default
		evt.preventDefault();
		// Define vars
		var $this = $(this);
		// Widget created?
		if ($.GalleryPopup) {
			$.GalleryPopup.show({
				'title': $this.attr('title') || $this.data('title'),
				'imgs': $this.data('imgs')
			});
		}
	});
})(jQuery);

/**
 * Admin panel
 */
(function($){
	// On document ready //
	$(function(){
		// Define, get elements 
		var $doc = $(document);
		// +++ 
		var $adminForm = $('#admin-form');
		// +++ 
		var $tblDataList = $('#tbl-data-list');
		// +++ 
		var $filterFormWrapper = $('#filter-form-wrapper');
		// +++ 
		var $filterForm = $filterFormWrapper.find('form');
		
		/* Layouts */
		$doc
		// Notify, confim when delete data. //
			.on('click', 'a[data-nlink="delete"]', function(evt){
				// preventDefault
				evt.preventDefault();
				// 
				var $ckbEles = $tblDataList.find('> tbody input[type="checkbox"][name^="id"]:checked');
				// Case: no elements checked. 
				if (!$ckbEles.length) {
					swal(
						$.simpleTranslate('Xác nhận xóa dữ liệu!'),
						$.simpleTranslate('Bạn phải chọn ít nhất 1 dòng dữ liệu để thực hiện!')
					);
					return false;
				}
				// Case: has elements checked
				var $this = $(this);
				swal({
					title: $.simpleTranslate('Xác nhận xóa dữ liệu!'),
					text: $.simpleTranslate('Bạn có muốn xóa (các) dòng dữ liệu đã chọn?'),
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					//confirmButtonText: "Yes, delete it!",
					closeOnConfirm: false
				}, function(){
					// Submit form
					$adminForm.attr({
						'action': $this.attr('href')
					}).submit();
				});
			})
		// ./end //
		;
		
		/* Filter form */
		$filterFormWrapper
			// Reset form's elements value
			.on('click', '#__btnreset', function(evt){
				evt.preventDefault();
				// 
				$('[name]', this.form).val('');
			})
			// ./end //
		;
		/* ./Filter form */
	
		/* Admin form */
		$adminForm
			// Helper: check/uncheck all checkbox elements on ata list table. //
			.on('click', '#cbk-checkall', function(evt){
				var $this = $(this), isChecked = $this.is(':checked');
				//
				$(this).parents('table').find('> tbody input[type="checkbox"][name^="id"]')
					.attr('checked', isChecked)
					.prop('checked', isChecked)
				;
			})
			// ./end //
			
			// Notify, confim when delete data.
			.on('click', 'a[data-mtool="delete"]', function(evt){
				// preventDefault
				evt.preventDefault();
				// Confirm
				var $this = $(this);
				swal({
					title: $.simpleTranslate('Xác nhận xóa dữ liệu!'),
					text: $.simpleTranslate('Bạn có muốn xóa (các) dòng dữ liệu đã chọn?'),
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					//confirmButtonText: "Yes, delete it!",
					closeOnConfirm: false
				}, function(){
					// 
					var ckbSelector = 'input[type="checkbox"][name^="id"]';
					var $ckbEles = $tblDataList.find('> tbody ' + ckbSelector)
						.attr('checked', false)
						.prop('checked', false)
					;
					$ckbEles.parents('tr').has($this).find(ckbSelector)
						.attr('checked', true)
						.prop('checked', true)
					;
					// Submit form
					$adminForm.attr({
						'action': $this.attr('href')
					}).submit();
				});
			})
			// ./end //
			
			// Active/Unactive
			.on('click', '.toggle-switch .ts-helper[data-href]', function(evt){
				var $this = $(this), href = $this.data('href'),
					$ckbEle = $this.parents('.toggle-switch').find('input[type="checkbox"]'),
					active = 1 * $ckbEle.is(':checked')
				;
				if (href) {
					$.get(href, {'active': active}, function(rs){
						// Case: fail
						if (rs.error) {
							alert('Error: ' + $.trim(error) + '!');
							//
							$ckbEle.attr('checked', !!active).prop('checked', !!active);
						// Done;
						} else {
							$ckbEle.attr('checked', !!(active = (1 - active))).prop('checked', !!active);
						}
					}, 'json')
					.fail(function(xhr, error, errtxt){
						alert(error + ': ' + errtxt + '!');
					});
					// 
					//evt.preventDefault();
					//evt.stopPropagation();
				}
			})
			// ./end //
		;
		
		/* ./Admin form */
	});
// ./Admin panel.
	
// KCFinder //
	// @var KCFinder library path 
	var KCFinderLibraryPath = '/assets/backend/MALight/vendors/kcfinder/browse.php';
	/**
	 * Open KCFinder library
	 * @param type {String} Sub folder name, used to store files...
	 * @param exts {String} Allowed files extensions...
	 * @param cb {Function} A callback funciton
	 * @param hasMultiFiles {Boolean} Flag is pick multi files?
	 * @return void
	 */
	var openKCFinder = function openKCFinder(type, exts, cb, hasMultiFiles) {
		window.KCFinder = {};
		window.KCFinder[
			hasMultiFiles ? 'callBackMultiple': 'callBack'
		] = function(files) {
			// Format data
			files = ('string' == typeof files) ? [files]: $.makeArray(files);
			// Actions with url parameter here 
			(cb || $.noop())(files);
			// Clear memory
			window.KCFinder = null;
		};
		window.open(
			KCFinderLibraryPath 
				+ '?_KCFinderType=' + encodeURIComponent(type)
				+ '&_KCFinderExts=' + encodeURIComponent(exts)
			, '_blank', 
			'fullscreen=0,width=640,height=480,top=10,left=10,location=0,menubar=0,resizable=1,scrollbars=1,status=0,titlebar=0,toolbar=0'
		);
	};
	/**
	 * Help auto pick, preview, remove files using kcfinder for input, textarea elements
	 */
	$(document).on('click', '.kcfinder-picker, .kcfinder-remove, .kcfinder-preview', function(evt){
		// Prevent default;
		evt.preventDefault();
		// Define vars, get elements
		var $this = $(this), $parent = $this, $input;
		for (var i = 1; i <= 3; i++) {
			$input = ($parent = $parent.parent()).find('input.kcfinder, textarea.kcfinder').eq(0);
			if ($input.length) { break; }
		}
		if ($input.length) {
			var isRemove = $this.is('.kcfinder-remove'),
				isPreview = $this.is('.kcfinder-preview'), 
				hasMultiFiles = $input.is('textarea')
			;
			// Case: preview
			if (isPreview) {
				// Check plugin(s)
				if (!$.GalleryPopup) {
					console && console.log('$.GalleryPopup is missing!');
					return;
				}
				// Get, format images
				var imgs = [], uploadDir = $input.data('kcfinder-upload_dir');
				$.each($.trim($input.val()).split('\n'), function(idx, val){
					if (val) { imgs.push(uploadDir + val); }
				});
				// Show popup?
				if (imgs.length) {
					$.GalleryPopup.show({'imgs': imgs});
				}
			// Case: 
			} else if (!$input.is(':disabled')) {
				// Case: remove
				if (isRemove) {
					$input.val('');
				// Case: pick file(s)
				} else {
					// Open KCFinder, get files...
					var type = $input.data('kcfinder-type'),
						exts = $input.data('kcfinder-exts')
					;
					openKCFinder(type, exts, function(files){
						// set values...
						files = $.map(files, function(file){
							return file.substr(file.indexOf(type) + type.length);
						});
						hasMultiFiles && files.unshift($input.val());
						$input.val($.trim(hasMultiFiles ? files.join('\n'): files.pop()));
					}, hasMultiFiles);
				}
			}
		}
	});
// ./KCFinder //

// CKEditor //
if (window.CKEDITOR) {
	// Auto init 
	$(document).find('textarea[data-ckeditor]').each(function(idx){
		// Get configs, +format config
		var $this = $(this), config = $this.data('ckeditor');
		// +++ KCFinder Integration?
		var KCFinderLibraryPath = '/assets/backend/MALight/vendors/kcfinder/';
		if (config.filebrowser) {
			$.extend(config, {
				filebrowserBrowseUrl: KCFinderLibraryPath + 'browse.php?opener=ckeditor&type=' + config.filebrowser,
				filebrowserImageBrowseUrl: KCFinderLibraryPath + 'browse.php?opener=ckeditor&type=' + config.filebrowser,
				filebrowserFlashBrowseUrl: KCFinderLibraryPath + 'browse.php?opener=ckeditor&type=' + config.filebrowser//,
				//filebrowserUploadUrl: KCFinderLibraryPath + 'upload.php?opener=ckeditor&type=' + config.filebrowser,
				//filebrowserImageUploadUrl: KCFinderLibraryPath + 'upload.php?opener=ckeditor&type=' + config.filebrowser,
				//filebrowserFlashUploadUrl: KCFinderLibraryPath + 'upload.php?opener=ckeditor&type=' + config.filebrowser
			});			
		}
		 
		// Init ckeditor instance(s);
		CKEDITOR.replace(this, config);
	});
}
// ./CKEditor //
})(jQuery);