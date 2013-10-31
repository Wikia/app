/*!
 * VisualEditor UserInterface DialogTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface dialog tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.DialogTool = function VeUiDialogTool( toolbar, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.DialogTool, ve.ui.Tool );

/* Static Properties */

/**
 * Symbolic name of dialog the tool opens.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.DialogTool.static.dialog = '';

/**
 * Annotation or node models this tool is related to.
 *
 * Used by #canEditModel.
 *
 * @static
 * @property {Function[]}
 * @inheritable
 */
ve.ui.DialogTool.static.modelClasses = [];

/**
 * @inheritdoc
 */
ve.ui.DialogTool.static.canEditModel = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.DialogTool.prototype.onSelect = function () {
	this.toolbar.getSurface().getDialogs().open( this.constructor.static.dialog );
	this.setActive( false );
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.DialogTool.prototype.onUpdateState = function ( nodes ) {
	if ( nodes.length ) {
		this.setActive(
			this.toolbar.getToolFactory().getToolForNode( nodes[0] ) === this.constructor
		);
	}
};
