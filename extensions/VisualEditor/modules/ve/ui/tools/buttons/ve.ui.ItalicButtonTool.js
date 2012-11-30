/**
 * VisualEditor user interface ItalicButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.ItalicButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.AnnotationButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.ItalicButtonTool = function VeUiItalicButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.AnnotationButtonTool.call( this, toolbar );
};

/* Inheritance */

ve.inheritClass( ve.ui.ItalicButtonTool, ve.ui.AnnotationButtonTool );

/* Static Members */

ve.ui.ItalicButtonTool.static.name = 'italic';

ve.ui.ItalicButtonTool.static.titleMessage = 'visualeditor-annotationbutton-italic-tooltip';

ve.ui.ItalicButtonTool.static.annotation = { 'name': 'textStyle/italic' };

/* Registration */

ve.ui.toolFactory.register( 'italic', ve.ui.ItalicButtonTool );
