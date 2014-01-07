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
 * @extends OO.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.DialogTool = function VeUiDialogTool( toolGroup, config ) {
	// Parent constructor
	OO.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.DialogTool, OO.ui.Tool );

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
 * Configuration options for setting up dialog.
 *
 * @abstract
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.DialogTool.static.config = {};

/**
 * Annotation or node models this tool is related to.
 *
 * Used by #isCompatibleWith.
 *
 * @static
 * @property {Function[]}
 * @inheritable
 */
ve.ui.DialogTool.static.modelClasses = [];

/**
 * @inheritdoc
 */
ve.ui.DialogTool.static.isCompatibleWith = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.DialogTool.prototype.onSelect = function () {
	ve.track( 'tool.dialog.select', {
		name: this.constructor.static.name,
		// HACK: which toolbar is this coming from?
		// TODO: this should probably be passed into the config or something
		toolbar: ( this.toolbar.constructor === ve.ui.Toolbar ? 'surface' : 'target' )
	} );
	this.toolbar.getSurface().execute(
		'dialog',
		'open',
		this.constructor.static.dialog,
		this.constructor.static.config
	);
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
