/**
 * VisualEditor user interface BoldButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.BoldButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.AnnotationButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.BoldButtonTool = function VeUiBoldButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.AnnotationButtonTool.call( this, toolbar );
};

/* Inheritance */

ve.inheritClass( ve.ui.BoldButtonTool, ve.ui.AnnotationButtonTool );

/* Static Members */

ve.ui.BoldButtonTool.static.name = 'bold';

ve.ui.BoldButtonTool.static.titleMessage = 'visualeditor-annotationbutton-bold-tooltip';

ve.ui.BoldButtonTool.static.annotation = { 'name': 'textStyle/bold' };

/* Registration */

ve.ui.toolFactory.register( 'bold', ve.ui.BoldButtonTool );
