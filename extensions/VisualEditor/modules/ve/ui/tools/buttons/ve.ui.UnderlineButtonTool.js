/*!
 * VisualEditor UserInterface UnderlineButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface underline button tool.
 *
 * @class
 * @extends ve.ui.AnnotationButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.UnderlineButtonTool = function VeUiUnderlineButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.AnnotationButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.UnderlineButtonTool, ve.ui.AnnotationButtonTool );

/* Static Properties */

ve.ui.UnderlineButtonTool.static.name = 'textStyle/underline';

ve.ui.UnderlineButtonTool.static.icon = {
	'default': 'underline-a',
	'en': 'underline-u'
};

ve.ui.UnderlineButtonTool.static.titleMessage = 'visualeditor-annotationbutton-underline-tooltip';

ve.ui.UnderlineButtonTool.static.annotation = { 'name': 'textStyle/underline' };

/* Registration */

ve.ui.toolFactory.register( 'textStyle/underline', ve.ui.UnderlineButtonTool );

ve.ui.commandRegistry.register(
	'textStyle/underline', 'annotation', 'toggle', 'textStyle/underline'
);
