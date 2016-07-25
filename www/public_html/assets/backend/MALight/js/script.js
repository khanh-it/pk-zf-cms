/**
 *
 */
(function($){
	
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
// ./Admin form /


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
	
})(jQuery);