/*!
 * VisualEditor UserInterface InspectorButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface inspector button tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.ButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.InspectorButtonTool = function VeUiInspectorButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.InspectorButtonTool, ve.ui.ButtonTool );

/* Static Properties */

/**
 * Symbolic name of inspector the button opens.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.InspectorButtonTool.static.inspector = '';

/**
 * Annotation or node models this tool is related to.
 *
 * Used by #canEditModel.
 *
 * @static
 * @property {Function[]}
 */
ve.ui.InspectorButtonTool.static.modelClasses = [];

/**
 * @inheritdoc
 */
ve.ui.InspectorButtonTool.static.canEditModel = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * Handle the button being clicked.
 *
 * @method
 */
ve.ui.InspectorButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute( 'inspector', 'open', this.constructor.static.inspector );
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.InspectorButtonTool.prototype.onUpdateState = function ( nodes, full ) {
	this.setActive(
		ve.ui.toolFactory.getToolsForAnnotations( full ).indexOf( this.constructor ) !== -1
	);
};
