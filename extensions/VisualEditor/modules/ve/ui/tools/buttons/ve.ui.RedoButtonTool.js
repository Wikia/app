/*!
 * VisualEditor UserInterface RedoButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface redo button tool.
 *
 * @class
 * @extends ve.ui.ButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.RedoButtonTool = function VeUiRedoButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar, config );

	// Events
	this.toolbar.getSurface().getModel().connect( this, { 'history': 'onUpdateState' } );

	// Initialization
	this.setDisabled( true );
};

/* Inheritance */

ve.inheritClass( ve.ui.RedoButtonTool, ve.ui.ButtonTool );

/* Static Properties */

ve.ui.RedoButtonTool.static.name = 'history/redo';

ve.ui.RedoButtonTool.static.icon = 'redo';

ve.ui.RedoButtonTool.static.titleMessage = 'visualeditor-historybutton-redo-tooltip';

/* Methods */

/**
 * Handle the button being clicked.
 *
 * @method
 */
ve.ui.RedoButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute( 'history', 'redo' );
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.RedoButtonTool.prototype.onUpdateState = function () {
	this.setDisabled( !this.toolbar.getSurface().getModel().hasFutureState() );
};

/* Registration */

ve.ui.toolFactory.register( 'history/redo', ve.ui.RedoButtonTool );

ve.ui.commandRegistry.register( 'history/redo', 'history', 'redo' );

ve.ui.triggerRegistry.register(
	'history/redo',
	{ 'mac': new ve.ui.Trigger( 'cmd+shift+z' ), 'pc': new ve.ui.Trigger( 'ctrl+shift+z' ) }
);
