/**
 * File default/views/assets/account/crud.js
 */
(function($, hplData, hplOptions){
	// On document ready;
	$(function(){
		// Get elements
		// +++ Controller
		var $cont = $('#controller');
		// +++ 
		var $password = $cont.find('#password');
		// +++ 
		var $showPassword = $cont.find('#show-password');
		
		// Show/hide password?
		$showPassword.on('change', function(){
			$password.attr('type', $showPassword.is(':checked') ? 'text' : 'password');
		}).trigger('change');
	});
	// ./On document ready;
})(jQuery, [['_DATA_']], [['_OPTIONS_']]);
/** ./File default/views/assets/account/crud.js */