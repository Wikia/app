/*!
 * VisualEditor UserInterface SubscriptButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface subscript button tool.
 *
 * @class
 * @extends ve.ui.AnnotationButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.SubscriptButtonTool = function VeUiSubscriptButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.AnnotationButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.SubscriptButtonTool, ve.ui.AnnotationButtonTool );

/* Static Properties */

ve.ui.SubscriptButtonTool.static.name = 'textStyle/subscript';

ve.ui.SubscriptButtonTool.static.icon = 'subscript';

ve.ui.SubscriptButtonTool.static.titleMessage = 'visualeditor-annotationbutton-subscript-tooltip';

ve.ui.SubscriptButtonTool.static.annotation = { 'name': 'textStyle/subscript' };

/* Registration */

ve.ui.toolFactory.register( 'textStyle/subscript', ve.ui.SubscriptButtonTool );

ve.ui.commandRegistry.register(
	'textStyle/subscript', 'annotation', 'toggle', 'textStyle/subscript'
);
