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
 * Gallery popup
 * @author khanhdtp
 */
(function($){
	// @var {Object} Templates
	var tmpl = {
		'popup': '<div class="gallery-popup-overlay hidden"><div class="card gallery-popup">'
				+ '<div class="clearfix card-header">'
					+ '<a href="#" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-remove"></span></a>'
				+ '</div>'
				+ '<a href="{{src}}" target="_blank">'
					+ '<img src="{{src}}" class="img-responsive" alt="">'
				+ '</a>'
				+ '<div class="clearfix">{{body}}</div>'
			+ '</div></div>'
		,
		'popupItem': '<div class="col-xs-3">'
				+ '<a href="{{src}}" target="_blank">'
					+ '<img src="{{src}}" class="img-responsive" alt="">'
				+ '</a>'
			+ '</div>'
	}; 
	
	// Class 'gallery popup'. 
	$.fn.GalleryPopup = $.fn.GalleryPopup || function(options){
		// Format options
		options = $.extend(true, {
			
		}, options || {});
		
		// 
		$eles = $(this).each(function(idx){
			var $this = $(this);
			// Get images data
			var imgs = $this.data('imgs') || [];
			// Build gallery popup;
			var html = '';
			if (imgs.length) {
				html = {'popup': '', 'popupItem': ''};
				html['popup'] = tmpl.popup.replace(/{{src}}/g, imgs[0]);
				for (var i = 1; i < imgs.length; i++) {
					html['popupItem'] += tmpl.popupItem.replace(/{{src}}/g, imgs[i]);
				}
				html = html['popup'].replace(/{{body}}/g, html['popupItem']);
			}
			if (html) {
				$this.data('gallery-popup', $(html).appendTo(document.body));
			}
			//  
			$this.on('click', function(evt){
				// Prevent default
				evt.preventDefault();
				//
				var $galleryPopup = $this.data('gallery-popup');
				if ($galleryPopup) {
					$galleryPopup.removeClass('hidden').fadeIn('slow');
				}
			});
		});
	};
	
	// Auto trigger gallery popup for dom elements
	$(document).on('click', '.gallery-popup-trigger', function(evt){
		// Prevent default
		evt.preventDefault();
		//
		var $this = $(this);
		//
		if ($this.data('gallery-popup')) {
			return;
		} else {
			// 
			$this.GalleryPopup({});
			//
			$this.triggerHandler('click');	
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
	 * @param cb {Function} A callback funciton
	 * @param isMulti {Boolean} Flag is pick multi files?
	 * @return void
	 */
	var openKCFinder = function openKCFinder(type, cb, isMulti) {
		window.KCFinder = {};
		window.KCFinder[
			isMulti ? 'callBackMultiple' : 'callBack'
		] = function(files) {
			// Format data
			files = ('string' == typeof files) ? [files] : $.makeArray(files);
			// Actions with url parameter here 
			(cb || $.noop())(files);
			// Clear memory
			window.KCFinder = null;
		};
		window.open(
			KCFinderLibraryPath + '?_KCFinderType=' + type, '_blank', 
			'fullscreen=0,width=640,height=480,top=10,left=10,location=0,menubar=0,resizable=1,scrollbars=1,status=0,titlebar=0,toolbar=0'
		);
	};
	/**
	 * Help auto pick files using kcfinder for input, textarea elements
	 */
	$(document).on('click', '.kcfinder-picker, .kcfinder-remove', function(evt){
		// Prevent default;
		evt.preventDefault();
		// Define vars, get elements
		var $this = $(this), $parent = $this, $input;
		for (var i = 1; i <= 3; i++) {
			$input = ($parent = $parent.parent()).find('input[data-kcfinder], textarea[data-kcfinder]').eq(0);
			if ($input.length) { break; }
		}
		if ($input.length && !$input.is(':disabled')) {
			var isRemove = $this.is('.kcfinder-remove'), 
				isMulti = $input.is('textarea')
			;
			// Case: remove
			if (isRemove) {
				$input.val('');
			// Case: pick file(s)
			} else {
				// Open KCFinder, get files...
				var type = $input.data('kcfinder');
				openKCFinder($input.data('kcfinder'), function(files){
					// set values...
					files = $.map(files, function(file){
						return file.substr(file.indexOf(type) + type.length);
					});
					$input.val(isMulti ? files.join('\n') : files.pop());
				}, isMulti);
			}
		}
	});
// ./KCFinder //	
})(jQuery);