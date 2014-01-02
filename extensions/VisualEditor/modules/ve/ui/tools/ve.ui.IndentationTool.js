/*!
 * VisualEditor UserInterface IndentationTool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface intentation tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.IndentationTool = function VeUiIndentationTool( toolbar, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.IndentationTool, ve.ui.Tool );

/* Static Properties */

/**
 * Indentation method the tool applies.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.IndentationTool.static.method = '';

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.IndentationTool.prototype.onSelect = function () {
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
ve.ui.IndentationTool.prototype.onUpdateState = function ( nodes ) {
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

/**
 * UserInterface indent tool.
 *
 * @class
 * @extends ve.ui.IndentationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.IncreaseIndentationTool = function VeUiIncreaseIndentationTool( toolbar, config ) {
	ve.ui.IndentationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.IncreaseIndentationTool, ve.ui.IndentationTool );
ve.ui.IncreaseIndentationTool.static.name = 'indent';
ve.ui.IncreaseIndentationTool.static.group = 'structure';
ve.ui.IncreaseIndentationTool.static.icon = 'indent-list';
ve.ui.IncreaseIndentationTool.static.titleMessage = 'visualeditor-indentationbutton-indent-tooltip';
ve.ui.IncreaseIndentationTool.static.method = 'increase';
ve.ui.toolFactory.register( ve.ui.IncreaseIndentationTool );

/**
 * UserInterface outdent tool.
 *
 * TODO: Consistency between increase/decrease, indent/outdent and indent/unindent.
 *
 * @class
 * @extends ve.ui.IndentationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.DecreaseIndentationTool = function VeUiDecreaseIndentationTool( toolbar, config ) {
	ve.ui.IndentationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.DecreaseIndentationTool, ve.ui.IndentationTool );
ve.ui.DecreaseIndentationTool.static.name = 'outdent';
ve.ui.DecreaseIndentationTool.static.group = 'structure';
ve.ui.DecreaseIndentationTool.static.icon = 'outdent-list';
ve.ui.DecreaseIndentationTool.static.titleMessage =
	'visualeditor-indentationbutton-outdent-tooltip';
ve.ui.DecreaseIndentationTool.static.method = 'decrease';
ve.ui.toolFactory.register( ve.ui.DecreaseIndentationTool );
