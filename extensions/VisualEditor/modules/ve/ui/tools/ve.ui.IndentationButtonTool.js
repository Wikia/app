/*!
 * VisualEditor UserInterface IndentationButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface intentation button tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.ButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.IndentationButtonTool = function VeUiIndentationButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.IndentationButtonTool, ve.ui.ButtonTool );

/* Static Properties */

/**
 * Indentation method the button applies.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.IndentationButtonTool.static.method = '';

/* Methods */

/**
 * Handle the button being clicked.
 *
 * @method
 */
ve.ui.IndentationButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute( 'indentation', this.constructor.static.method );
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.IndentationButtonTool.prototype.onUpdateState = function ( nodes ) {
	var i, len,
		any = false;
	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if ( nodes[i].hasMatchingAncestor( 'listItem' ) ) {
			any = true;
			break;
		}
	}
	this.setDisabled( !any );
};
