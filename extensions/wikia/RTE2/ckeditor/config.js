/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
		
	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
//	config.plugins = 'wysiwygarea,button,autogrow,toolbar,indent,sourcearea';
	
	config.skin = 'moono-lisa';
	// %REMOVE_END%

	
//	config.toolbar = [
//		{ name: 'something', items: [ 'Bold','Italic','BulletedList','NumberedList','Indent','Outdent','Format','JustifyLeft','JustifyCenter','JustifyRight','Undo','Redo','Table','Underline','Strike','RemoveFormat' ] },
//		{name: 'somethink', items : [ "Link","Signature",'ModeWysiwyg','ModeSource','Template','Gallery','Image','Slider','Slideshow','Video' ] }
		 
//	];





	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for a single toolbar row.


	// The default plugins included in the basic setup define some buttons that
	// are not needed in a basic editor. They are removed here.
	//config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';

	// Dialog windows are also simplified.
	config.removeDialogTabs = 'link:advanced';
};
