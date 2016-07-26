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