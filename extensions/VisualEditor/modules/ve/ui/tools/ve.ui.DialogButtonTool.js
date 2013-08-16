/*!
 * VisualEditor UserInterface DialogButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface dialog button tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.ButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.DialogButtonTool = function VeUiDialogButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.DialogButtonTool, ve.ui.ButtonTool );

/* Static Properties */

/**
 * Symbolic name of dialog the button opens.
 *
 * @abstract
 * @static
 * @property
 * @type {string}
 * @inheritable
 */
ve.ui.DialogButtonTool.static.dialog = '';

/**
 * Annotation or node models this tool is related to.
 *
 * Used by #canEditModel.
 *
 * @static
 * @property {Function[]}
 */
ve.ui.DialogButtonTool.static.modelClasses = [];

/**
 * @inheritdoc
 */
ve.ui.DialogButtonTool.static.canEditModel = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * Handle the button being clicked.
 *
 * @method
 */
ve.ui.DialogButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().getDialogs().open( this.constructor.static.dialog );
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.DialogButtonTool.prototype.onUpdateState = function ( nodes ) {
	if ( nodes.length ) {
		this.setActive( ve.ui.toolFactory.getToolForNode( nodes[0] ) === this.constructor );
	}
};
