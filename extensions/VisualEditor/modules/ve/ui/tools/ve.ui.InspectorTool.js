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
 * @extends ve.ui.Tool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.InspectorTool = function VeUiInspectorTool( toolbar, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.InspectorTool, ve.ui.Tool );

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
 * Annotation or node models this tool is related to.
 *
 * Used by #canEditModel.
 *
 * @static
 * @property {Function[]}
 * @inheritable
 */
ve.ui.InspectorTool.static.modelClasses = [];

/**
 * @inheritdoc
 */
ve.ui.InspectorTool.static.canEditModel = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.InspectorTool.prototype.onSelect = function () {
	this.toolbar.getSurface().execute( 'inspector', 'open', this.constructor.static.inspector );
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
ve.ui.InspectorTool.prototype.onUpdateState = function ( nodes, full ) {
	var toolFactory = this.toolbar.getToolFactory();
	this.setActive( toolFactory.getToolsForAnnotations( full ).indexOf( this.constructor ) !== -1 );
};

/**
 * UserInterface link tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkInspectorTool = function VeUiLinkInspectorTool( toolbar, config ) {
	ve.ui.InspectorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.LinkInspectorTool, ve.ui.InspectorTool );
ve.ui.LinkInspectorTool.static.name = 'link';
ve.ui.LinkInspectorTool.static.group = 'meta';
ve.ui.LinkInspectorTool.static.icon = 'link';
ve.ui.LinkInspectorTool.static.titleMessage = 'visualeditor-annotationbutton-link-tooltip';
ve.ui.LinkInspectorTool.static.inspector = 'link';
ve.ui.LinkInspectorTool.static.modelClasses = [ ve.dm.LinkAnnotation ];
ve.ui.toolFactory.register( ve.ui.LinkInspectorTool );
