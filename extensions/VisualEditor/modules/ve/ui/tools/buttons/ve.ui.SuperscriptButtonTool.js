/*!
 * VisualEditor UserInterface SuperscriptButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface superscript button tool.
 *
 * @class
 * @extends ve.ui.AnnotationButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.SuperscriptButtonTool = function VeUiSuperscriptButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.AnnotationButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.SuperscriptButtonTool, ve.ui.AnnotationButtonTool );

/* Static Properties */

ve.ui.SuperscriptButtonTool.static.name = 'textStyle/superscript';

ve.ui.SuperscriptButtonTool.static.icon = 'superscript';

ve.ui.SuperscriptButtonTool.static.titleMessage =
	'visualeditor-annotationbutton-superscript-tooltip';

ve.ui.SuperscriptButtonTool.static.annotation = { 'name': 'textStyle/superscript' };

/* Registration */

ve.ui.toolFactory.register( 'textStyle/superscript', ve.ui.SuperscriptButtonTool );

ve.ui.commandRegistry.register(
	'textStyle/superscript', 'annotation', 'toggle', 'textStyle/superscript'
);
