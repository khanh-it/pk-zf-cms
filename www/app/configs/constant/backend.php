<?php
/**
 * Site `backend` constants;
 */
// ===== FORM =====/
//
//
//
define('FORM_HTML_INPUT_HELPER', '<i class="input-helper"></i>');

//
//
//
define('FORM_HTML_KCFINDER_PICKER', '<a href="#" class="btn btn-sm btn-primary kcfinder-picker">'
	. '<i class="glyphicon glyphicon-download-alt"></i>' 
. '</a>');

//
//
//
define('FORM_HTML_KCFINDER_PREVIEW', '<a href="#" class="btn btn-sm btn-success kcfinder-preview">'
	. '<i class="glyphicon glyphicon-eye-open"></i>' 
. '</a>');
//
//
//
define('FORM_HTML_KCFINDER_REMOVE', '<a href="#" class="btn btn-sm btn-danger kcfinder-remove">'
	. '<i class="glyphicon glyphicon-remove"></i>' 
. '</a>');
//
//
//
define('FORM_HTML_KCFINDER_PREVIEW_N_REMOVE', FORM_HTML_KCFINDER_PREVIEW . '&nbsp;' . FORM_HTML_KCFINDER_REMOVE);

//
//
//
define('FORM_HTML_ALIAS_REMOVE', '<a href="javascript:void(0);" onclick="jQuery(this).parents(\'.input-group\').find(\'input[name]\').val(\'\');" class="btn btn-sm btn-danger alias-remove">'
	. '<i class="glyphicon glyphicon-remove"></i>' 
. '</a>');
// ===== ./FORM =====/


// ===== LANGUAGE =====/
//
//
define('LANG_SELECT', '-- Chọn --');

//
//
define('LANG_USE_TAGS_HELP', 'Phân cách các tags bởi dấu phẩy `,`. VD: tag-1, tag_2.');


// ===== ./LANGUAGE =====/