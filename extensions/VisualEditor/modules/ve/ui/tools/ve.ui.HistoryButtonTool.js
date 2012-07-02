/**
 * Creates an ve.ui.HistoryButtonTool object.
 * 
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 * @param {String} name
 */
ve.ui.HistoryButtonTool = function( toolbar, name, title, data ) {
	// Inheritance
	ve.ui.ButtonTool.call( this, toolbar, name, title );

	// Properties
	this.data = data;
	this.enabled = false;
};

/* Methods */

ve.ui.HistoryButtonTool.prototype.onClick = function() {
	switch ( this.name ) {
		case 'undo':
			this.toolbar.surfaceView.model.undo( 1 );
			break;
		case 'redo':
			this.toolbar.surfaceView.model.redo( 1 );
			break;
	}
};

ve.ui.HistoryButtonTool.prototype.updateState = function( annotations ) {
	var surfaceModel = this.toolbar.surfaceView.model;
	switch( this.name ) {
		case 'undo':
			this.enabled = surfaceModel.bigStack.length - surfaceModel.undoIndex > 0; 
			break;
		case 'redo':
			this.enabled = surfaceModel.undoIndex > 0;
			break;
	}

	this.updateEnabled();
}


/* Registration */

ve.ui.Tool.tools.undo = {
	'constructor': ve.ui.HistoryButtonTool,
	'name': 'undo',
	'title': 'Undo (ctrl/cmd + Z)'
};

ve.ui.Tool.tools.redo = {
	'constructor': ve.ui.HistoryButtonTool,
	'name': 'redo',
	'title': 'Redo (ctrl/cmd + shift + Z)'
};

/* Inhertiance */

ve.extendClass( ve.ui.HistoryButtonTool, ve.ui.ButtonTool );
