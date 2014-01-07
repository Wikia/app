/*!
 * VisualEditor UserInterface InspectorTool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface inspector tool.
 *
 * @abstract
 * @class
 * @extends OO.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.InspectorTool = function VeUiInspectorTool( toolGroup, config ) {
	// Parent constructor
	OO.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.InspectorTool, OO.ui.Tool );

/* Static Properties */

/**
 * Symbolic name of inspector the tool opens.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.InspectorTool.static.inspector = '';

/**
 * Configuration options for setting up inspector.
 *
 * @abstract
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.InspectorTool.static.config = {};

/**
 * Annotation or node models this tool is related to.
 *
 * Used by #isCompatibleWith.
 *
 * @static
 * @property {Function[]}
 * @inheritable
 */
ve.ui.InspectorTool.static.modelClasses = [];

/**
 * @inheritdoc
 */
ve.ui.InspectorTool.static.isCompatibleWith = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.InspectorTool.prototype.onSelect = function () {
	ve.track( 'tool.inspector.select', {
		name: this.constructor.static.name,
		// HACK: which toolbar is this coming from?
		// TODO: this should probably be passed into the config or something
		toolbar: ( this.toolbar.constructor === ve.ui.Toolbar ? 'surface' : 'target' )
	} );
	this.toolbar.getSurface().execute(
		'inspector',
		'open',
		this.constructor.static.inspector,
		this.constructor.static.config
	);
	this.setActive( true );
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.InspectorTool.prototype.onUpdateState = function ( nodes, full ) {
	var toolFactory = this.toolbar.getToolFactory(),
		tools = toolFactory.getToolsForAnnotations( full );

	this.setActive(
		// This tool is compatible with one of the annotations
		tools.indexOf( this.constructor.static.name ) !== -1
	);
};

/**
 * UserInterface link tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkInspectorTool = function VeUiLinkInspectorTool( toolGroup, config ) {
	ve.ui.InspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.LinkInspectorTool, ve.ui.InspectorTool );
ve.ui.LinkInspectorTool.static.name = 'link';
ve.ui.LinkInspectorTool.static.group = 'meta';
ve.ui.LinkInspectorTool.static.icon = 'link';
ve.ui.LinkInspectorTool.static.titleMessage = 'visualeditor-annotationbutton-link-tooltip';
ve.ui.LinkInspectorTool.static.inspector = 'link';
ve.ui.LinkInspectorTool.static.modelClasses = [ ve.dm.LinkAnnotation ];
ve.ui.toolFactory.register( ve.ui.LinkInspectorTool );
