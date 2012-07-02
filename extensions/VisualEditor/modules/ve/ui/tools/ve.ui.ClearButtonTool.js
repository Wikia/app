/**
 * Creates an ve.ui.ClearButtonTool object.
 * 
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 * @param {String} name
 */
ve.ui.ClearButtonTool = function( toolbar, name, title ) {
	// Inheritance
	ve.ui.ButtonTool.call( this, toolbar, name, title );

	// Properties
	this.$.addClass( 'es-toolbarButtonTool-disabled' );
	this.pattern = /(textStyle\/|link\/).*/;
};

/* Methods */

ve.ui.ClearButtonTool.prototype.onClick = function() {
	var surfaceView = this.toolbar.getSurfaceView(),
		surfaceModel = surfaceView.getModel(),
		tx =surfaceModel.getDocument().prepareContentAnnotation(
			surfaceView.currentSelection,
			'clear',
			this.pattern
		);
	surfaceModel.transact( tx );
	surfaceView.clearInsertionAnnotations();
	surfaceView.getContextView().closeInspector();
};

ve.ui.ClearButtonTool.prototype.updateState = function( annotations ) {
	var matchingAnnotations = ve.dm.DocumentNode.getMatchingAnnotations(
		annotations.all, this.pattern
	);
	if ( matchingAnnotations.length === 0 ) {
		this.$.addClass( 'es-toolbarButtonTool-disabled' );
	} else {
		this.$.removeClass( 'es-toolbarButtonTool-disabled' );
	}
};

/* Registration */

ve.ui.Tool.tools.clear = {
	'constructor': ve.ui.ClearButtonTool,
	'name': 'clear',
	'title': 'Clear formatting'
};

/* Inheritance */

ve.extendClass( ve.ui.ClearButtonTool, ve.ui.ButtonTool );