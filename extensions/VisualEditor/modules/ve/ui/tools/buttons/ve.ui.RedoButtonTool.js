/**
 * VisualEditor user interface RedoButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.RedoButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.RedoButtonTool = function VeUiRedoButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar );

	// Events
	this.toolbar.getSurface().getModel().addListenerMethod( this, 'history', 'onUpdateState' );

	// Initialization
	this.setDisabled( true );
};

/* Inheritance */

ve.inheritClass( ve.ui.RedoButtonTool, ve.ui.ButtonTool );

/* Static Members */

ve.ui.RedoButtonTool.static.name = 'redo';

ve.ui.RedoButtonTool.static.titleMessage = 'visualeditor-historybutton-redo-tooltip';

/* Methods */

/**
 * Responds to the button being clicked.
 *
 * @method
 */
ve.ui.RedoButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute( 'history', 'redo' );
};

/**
 * Responds to the toolbar state being updated.
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

ve.ui.toolFactory.register( 'redo', ve.ui.RedoButtonTool );
