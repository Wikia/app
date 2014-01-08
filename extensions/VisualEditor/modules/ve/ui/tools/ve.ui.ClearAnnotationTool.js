/*!
 * VisualEditor UserInterface ClearAnnotationTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface clear tool.
 *
 * @class
 * @extends OO.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.ClearAnnotationTool = function VeUiClearAnnotationTool( toolGroup, config ) {
	// Parent constructor
	OO.ui.Tool.call( this, toolGroup, config );

	// Initialization
	this.setDisabled( true );
};

/* Inheritance */

OO.inheritClass( ve.ui.ClearAnnotationTool, OO.ui.Tool );

/* Static Properties */

ve.ui.ClearAnnotationTool.static.name = 'clear';

ve.ui.ClearAnnotationTool.static.group = 'utility';

ve.ui.ClearAnnotationTool.static.icon = 'clear';

ve.ui.ClearAnnotationTool.static.titleMessage = 'visualeditor-clearbutton-tooltip';

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.ClearAnnotationTool.prototype.onSelect = function () {
	ve.track( 'tool.annotation.select', { name: this.constructor.static.name } );
	this.toolbar.getSurface().execute( 'annotation', 'clearAll' );
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.ClearAnnotationTool.prototype.onUpdateState = function ( nodes, full, partial ) {
	this.setDisabled( partial.isEmpty() );
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.ClearAnnotationTool );
