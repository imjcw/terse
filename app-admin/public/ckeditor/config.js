/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.language = 'zh-cn'; 
	config.codeSnippet_theme = 'zenburn';
	config.filebrowserImageUploadUrl = "/image-setting/upload";
	config.height = 450;
	config.extraPlugins += (config.extraPlugins ? ',myplugin' : 'myplugin');
	config.contentsCss = '../../../public/app-front/white/css/style.css';
	config.allowedContent = true;
};