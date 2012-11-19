/**
 * VisualEditor user interface UndoButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.UndoButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.UndoButtonTool = function VeUiUndoButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar );

	// Events
	this.toolbar.getSurface().getModel().addListenerMethod( this, 'history', 'onUpdateState' );

	// Initialization
	this.setDisabled( true );
};

/* Inheritance */

ve.inheritClass( ve.ui.UndoButtonTool, ve.ui.ButtonTool );

/* Static Members */

ve.ui.UndoButtonTool.static.name = 'undo';

ve.ui.UndoButtonTool.static.titleMessage = 'visualeditor-historybutton-undo-tooltip';

/* Methods */

/**
 * Responds to the button being clicked.
 *
 * @method
 */
ve.ui.UndoButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute( 'history', 'undo' );
};

/**
 * Responds to the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.UndoButtonTool.prototype.onUpdateState = function () {
	this.setDisabled( !this.toolbar.getSurface().getModel().hasPastState() );
};

/* Registration */

ve.ui.toolFactory.register( 'undo', ve.ui.UndoButtonTool );
