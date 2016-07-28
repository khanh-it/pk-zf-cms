/**
 *
 */
(function($){
	/**
	 * 
	 */
	$.simpleTranslate = $.simpleTranslate || function(phrase){
		return phrase; 
	};
	
/* Filter form */
	$(document)
	// 
		.on('click', '#__btnreset', function(evt){
			evt.preventDefault();
			// 
			$('[name]', this.form).val('');
		})
	// ./ 
	;
/* ./Filter form */

// Admin panel //
	$(function(){
		// Define vars
		// 
		var $adminForm = $('#admin-form');
		// 
		var $tblDataList = $('#tbl-data-list');
		// 
		var $filterForm = $('#filter-form');
		
		/**
		 * Helper: check/uncheck all checkbox elements on ata list table.
		 */
		$adminForm.on('click', '#cbk-checkall', function(evt){
			var $this = $(this), isChecked = $this.is(':checked');
			//
			$(this).parents('table').find('> tbody input[type="checkbox"][name^="id"]')
				.attr('checked', isChecked)
				.prop('checked', isChecked)
			;
		});
		
		/**
		 * Notify, confim when delete data.
		 */
		$adminForm
			.on('click', 'a.mtool-btn-delete_all', function(evt){
				// preventDefault
				evt.preventDefault();
				// 
				var $ckbEles = $tblDataList.find('> tbody input[type="checkbox"][name^="id"]:checked');
				// Case: no elements checked. 
				if (!$ckbEles.length) {
					swal(
						$.EVATranslate('Delete confirmation!'),
						$.EVATranslate('Please check at least one item below!')
					);
					return false;
				}
				// Case: has elements checked
				var $this = $(this);
				swal({
					title: $.EVATranslate('Delete confirmation!'),
					text: $.EVATranslate('Do you want to remove the checked item(s)?'),
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
			.on('click', 'a.mtool-btn-delete', function(evt){
				// preventDefault
				evt.preventDefault();
				// Confirm
				var $this = $(this);
				swal({
					title: $.EVATranslate('Delete confirmation!'),
					text: $.EVATranslate('Do you want to remove the checked item?'),
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
		;
		
		
		/**
		 * Helper: reset form's elements values;
		 */
		$filterForm.on('click', 'a.mtool-btn-reseter', function(evt){
			// preventDefault
			evt.preventDefault();
			//
			$(this).parents('form').find('[name]').val('');	
		});
		
// Admin form /
	// Define, get elements 
	// +++ 
	var $adminForm = $('#admin-form');
	// +++ 
	var $tblDataList = $('#tbl-data-list');

	$adminForm
	// Delete all
		
	// ./Delete all
	
	
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
	;
	// ./Active/Unactive
	
// ./Admin form /
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
		if ($input.length) {
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