/**
 * VisualEditor user interface AnnotationButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.AnnotationButtonTool object.
 *
 * @abstract
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.AnnotationButtonTool = function VeUiAnnotationButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar );
};

/* Inheritance */

ve.inheritClass( ve.ui.AnnotationButtonTool, ve.ui.ButtonTool );

/* Static Members */

/**
 * Annotation name and data this button applies.
 *
 * @abstract
 * @static
 * @member
 * @type {Object}
 */
ve.ui.AnnotationButtonTool.static.annotation = { 'name': '' };

/* Methods */

/**
 * Responds to the button being clicked.
 *
 * @method
 */
ve.ui.AnnotationButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute(
		'annotation', 'toggle', this.constructor.static.annotation.name
	);
};

/**
 * Responds to the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.AnnotationButtonTool.prototype.onUpdateState = function ( nodes, full ) {
	this.setActive( full.hasAnnotationWithName( this.constructor.static.annotation.name ) );
};
