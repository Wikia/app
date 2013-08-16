/*!
 * VisualEditor UserInterface ListButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface list button tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.ButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.ListButtonTool = function VeUiListButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.ListButtonTool, ve.ui.ButtonTool );

/**
 * List style the button applies.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.ListButtonTool.static.style = '';

/* Methods */

/**
 * Handle the button being clicked.
 *
 * @method
 */
ve.ui.ListButtonTool.prototype.onClick = function () {
	if ( !this.active ) {
		this.toolbar.surface.execute( 'list', 'wrap', this.constructor.static.style );
	} else {
		this.toolbar.surface.execute( 'list', 'unwrap' );
	}
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.ListButtonTool.prototype.onUpdateState = function ( nodes ) {
	var i, len,
		style = this.constructor.static.style,
		all = true;
	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if ( !nodes[i].hasMatchingAncestor( 'list', { 'style': style } ) ) {
			all = false;
			break;
		}
	}
	this.setActive( all );
};
