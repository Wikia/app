/*!
 * VisualEditor UserInterface ClearButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface clear button tool.
 *
 * @class
 * @extends ve.ui.ButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.ClearButtonTool = function VeUiClearButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar, config );

	// Initialization
	this.setDisabled( true );
};

/* Inheritance */

ve.inheritClass( ve.ui.ClearButtonTool, ve.ui.ButtonTool );

/* Static Properties */

ve.ui.ClearButtonTool.static.name = 'utility/clear';

ve.ui.ClearButtonTool.static.icon = 'clear';

ve.ui.ClearButtonTool.static.titleMessage = 'visualeditor-clearbutton-tooltip';

/* Methods */

/**
 * Handle the button being clicked.
 *
 * @method
 */
ve.ui.ClearButtonTool.prototype.onClick = function () {
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
ve.ui.ClearButtonTool.prototype.onUpdateState = function ( nodes, full, partial ) {
	this.setDisabled( partial.isEmpty() );
};

/* Registration */

ve.ui.toolFactory.register( 'utility/clear', ve.ui.ClearButtonTool );

ve.ui.commandRegistry.register( 'utility/clear', 'annotation', 'clearAll' );

ve.ui.triggerRegistry.register(
	'utility/clear',
	{ 'mac': new ve.ui.Trigger( 'cmd+\\' ), 'pc': new ve.ui.Trigger( 'ctrl+\\' ) }
);
