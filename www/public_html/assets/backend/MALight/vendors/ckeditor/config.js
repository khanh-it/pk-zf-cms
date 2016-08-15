/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.toolbar_Basic = [
		['Source', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat', 'TextColor', 'BGColor'],
		['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr', 'BidiRtl', 'Link', 'Unlink', 'Anchor'],
		['Styles', 'Format', 'Font', 'FontSize'],
		['UIColor', 'Maximize', 'ShowBlocks']
	];
	
	config.toolbar_Full = [
		['Source', 'Preview', 'Print', 'Templates'],
		['CreatePlaceholder', 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'InsertPre', 'UIColor', 'Maximize', 'ShowBlocks'],
		['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat', 'TextColor', 'BGColor', 'Link', 'Unlink', 'Anchor'],
		['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr', 'BidiRtl'],
		['Styles', 'Format', 'Font', 'FontSize'],
	];
	
	config.toolbar_All = [
		['Source', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', 'Templates', 'document'],
		['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Undo', 'Redo'],
		['Find', 'Replace', 'SelectAll', 'Scayt'],
		['CreatePlaceholder', 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'InsertPre'],
		['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
		['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat'],
		['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr', 'BidiRtl'],
		['Link', 'Unlink', 'Anchor'],
		['Styles', 'Format', 'Font', 'FontSize'],
		['TextColor', 'BGColor'],
		['UIColor', 'Maximize', 'ShowBlocks'],
		['About']
	];

	/* config.toolbar_CompleteList = [{
		name : 'document',
		//groups : ['mode', 'document', 'doctools'],
		items : ['Source', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', 'Templates', 'document']
	},
	// On the basic preset, clipboard and undo is handled by keyboard.
	// Uncomment the following line to enable them on the toolbar as well.
	{
		name : 'clipboard',
		groups : ['clipboard', 'undo'],
		items : ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Undo', 'Redo']
	}, {
		name : 'editing',
		groups : ['find', 'selection', 'spellchecker'],
		items : ['Find', 'Replace', 'SelectAll', 'Scayt']
	}, {
		name : 'insert',
		items : ['CreatePlaceholder', 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'InsertPre']
	}, {
		name : 'forms',
		items : ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']
	}, '/', {
		name : 'basicstyles',
		groups : ['basicstyles', 'cleanup'],
		items : ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat']
	}, {
		name : 'paragraph',
		groups : ['list', 'indent', 'blocks', 'align'],
		items : ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr', 'BidiRtl']
	}, {
		name : 'links',
		items : ['Link', 'Unlink', 'Anchor']
	}, '/', {
		name : 'styles',
		items : ['Styles', 'Format', 'Font', 'FontSize']
	}, {
		name : 'colors',
		items : ['TextColor', 'BGColor']
	}, {
		name : 'tools',
		items : ['UIColor', 'Maximize', 'ShowBlocks']
	}, {
	 name : 'about',
	 items : ['About']
	 }];*/

	config.toolbar = "Full";
};