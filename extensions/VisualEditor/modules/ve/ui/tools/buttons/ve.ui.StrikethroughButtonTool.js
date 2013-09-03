/*!
 * VisualEditor UserInterface StrikethroughButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface code button tool.
 *
 * @class
 * @extends ve.ui.AnnotationButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.StrikethroughButtonTool = function VeUiStrikethroughButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.AnnotationButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.StrikethroughButtonTool, ve.ui.AnnotationButtonTool );

/* Static Properties */

ve.ui.StrikethroughButtonTool.static.name = 'textStyle/strikethrough';

ve.ui.StrikethroughButtonTool.static.icon = {
	'default': 'strikethrough-a',
	'en': 'strikethrough-s'
};

ve.ui.StrikethroughButtonTool.static.titleMessage =
	'visualeditor-annotationbutton-strikethrough-tooltip';

ve.ui.StrikethroughButtonTool.static.annotation = { 'name': 'textStyle/strike' };

/* Registration */

ve.ui.toolFactory.register( 'textStyle/strikethrough', ve.ui.StrikethroughButtonTool );

ve.ui.commandRegistry.register(
	'textStyle/strikethrough', 'annotation', 'toggle', 'textStyle/strike'
);
