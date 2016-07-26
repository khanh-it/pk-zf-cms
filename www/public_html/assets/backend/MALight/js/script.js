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
	});
// ./Admin panel.

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
	
// KCFinder //
	/**
	 * 
	 */
	function openKCFinder_singleFile() {
		window.KCFinder = {};
		window.KCFinder.callBack = function(url) {
			// Actions with url parameter here
			window.KCFinder = null;
		};
		window.open('/assets/backend/MALight/vendors/kcfinder/browse.php', 'kcfinder_single');
	}
 	/**
	 * 
	 */
	function openKCFinder_multipleFiles() {
		window.KCFinder = {};
		window.KCFinder.callBackMultiple = function(files) {
			for (var i; i < files.length; i++) {
				// Actions with files[i] here
			}
			window.KCFinder = null;
	    };
		window.open('assets/backend/MALight/vendors/kcfinder/browse.php', 'kcfinder_multiple');
	}
	/**
	 * 
	 */
	$(document).on('click', '.kcfinder-picker, .kcfinder-clear', function(evt){
		//
		var $this = $(this), 
			$input = $(this).parent().find('[data-kcfinder]')
		;
		// 
		if ($this.is('.kcfinder-clear')) {
			$input.val('');
		// 
		} else if ($this.is('.kcfinder-picker')) {
			//KCFinderType
			if ($input.is('input[type="text"]')) {
				openKCFinder_singleFile();
			} else if ($input.is('textarea')) {
				
			}
			$input.val('');
			
		} 
	});
// ./KCFinder //	
})(jQuery);