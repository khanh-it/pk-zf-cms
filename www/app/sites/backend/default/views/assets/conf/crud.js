/**
 * File default/views/assets/conf/crud.js
 */
(function($, hplData, hplOptions){
	// On document ready;
	$(function(){
		// Get elements
		// +++ Controller
		var $cont = $('#controller');
		// +++ 
		var $input = $('#input');
		// +++ 
		var $valuePlaintextFg = $('#value_plaintext_fg');
		// +++ Controller
		var $valueHtmlFg = $('#value_html_fg');
		
		// Show/Hide elements based on input mode
		$input.on('change', function(evt){
			var input = $input.val();
			// Hide elements
			$valuePlaintextFg.add($valueHtmlFg).addClass('hidden');
			// Show elements
			if ('plaintext' == input) {
				$valuePlaintextFg.removeClass('hidden');
			}
			if ('html' == input) {
				$valueHtmlFg.removeClass('hidden');
			}
		}).trigger('change');
		// .end //
	});
	// ./On document ready;
})(jQuery, [['_DATA_']], [['_OPTIONS_']]);
/** ./File default/views/assets/conf/crud.js */