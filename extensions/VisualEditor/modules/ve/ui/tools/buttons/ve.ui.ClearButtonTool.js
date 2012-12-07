/**
 * VisualEditor user interface ClearButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.ClearButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.ClearButtonTool = function VeUiClearButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.ButtonTool.call( this, toolbar );

	// Initialization
	this.setDisabled( true );
};

/* Inheritance */

ve.inheritClass( ve.ui.ClearButtonTool, ve.ui.ButtonTool );

/* Static Members */

ve.ui.ClearButtonTool.static.name = 'clear';

ve.ui.ClearButtonTool.static.titleMessage = 'visualeditor-clearbutton-tooltip';

/* Methods */

/**
 * Responds to the button being clicked.
 *
 * @method
 */
ve.ui.ClearButtonTool.prototype.onClick = function () {
	this.toolbar.getSurface().execute( 'annotation', 'clearAll' );
};

/**
 * Responds to the toolbar state being updated.
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

ve.ui.toolFactory.register( 'clear', ve.ui.ClearButtonTool );
