/**
 * VisualEditor user interface IndentationButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.IndentationButtonTool object.
 *
 * @abstract
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.IndentationButtonTool = function VeUiIndentationButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar );
};

/* Inheritance */

ve.inheritClass( ve.ui.IndentationButtonTool, ve.ui.ButtonTool );

/* Static Members */

/**
 * Indentation method this button applies.
 *
 * @abstract
 * @static
 * @member
 * @type {String}
 */
ve.ui.IndentationButtonTool.static.method = '';

/* Methods */

/**
 * Responds to the button being clicked.
 *
 * @method
 */
ve.ui.IndentationButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute( 'indentation', this.constructor.static.method );
};

/**
 * Responds to the toolbar state being updated.
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
