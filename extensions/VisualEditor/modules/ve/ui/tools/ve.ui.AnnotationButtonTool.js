/*!
 * VisualEditor UserInterface AnnotationButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface annotation button tool.
 *
 * @class
 * @abstract
 * @extends ve.ui.ButtonTool
 *
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.AnnotationButtonTool = function VeUiAnnotationButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.AnnotationButtonTool, ve.ui.ButtonTool );

/* Static Properties */

/**
 * Annotation name and data the button applies.
 *
 * @abstract
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.AnnotationButtonTool.static.annotation = { 'name': '' };

/* Methods */

/**
 * Handle the button being clicked.
 *
 * @method
 */
ve.ui.AnnotationButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute(
		'annotation', 'toggle', this.constructor.static.annotation.name
	);
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.AnnotationButtonTool.prototype.onUpdateState = function ( nodes, full ) {
	this.setActive( full.hasAnnotationWithName( this.constructor.static.annotation.name ) );
};
