/**
 * Creates an ve.ui.IndentationButtonTool object.
 * 
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 * @param {String} name
 */
 ve.ui.IndentationButtonTool = function( toolbar, name, title, data ) {
	ve.ui.ButtonTool.call( this, toolbar, name, title );
	this.data = data;
};

/* Methods */

ve.ui.IndentationButtonTool.prototype.onClick = function() {
	if ( !this.$.hasClass( 'es-toolbarButtonTool-disabled' ) ) {
		var	listItems = [],
			listItem,
			i;
		for ( i = 0; i < this.nodes.length; i++ ) {
			listItem = this.nodes[i].getParent();
			if ( listItems.length > 0 ) {
				if (listItem != listItems[listItems.length - 1]) {
					listItems.push( listItem );
				}
			} else {
				listItems.push( listItem );
			}
		}
		if ( this.name === 'indent' ) {
			this.indent( listItems );
		} else if ( this.name === 'outdent' ) {
			this.outdent( listItems );
		}
	}
};

ve.ui.IndentationButtonTool.prototype.indent = function( listItems ) {
	var	surface = this.toolbar.surfaceView,
		styles,
		i;

	for ( i = 0; i < listItems.length; i++ ) {
		styles = listItems[i].getElementAttribute( 'styles' );
		if ( styles.length < 6 ) {
			styles.push( styles[styles.length - 1] );
			tx = surface.model.getDocument().prepareElementAttributeChange(
				surface.documentView.model.getOffsetFromNode( listItems[i], false ),
				'set',
				'styles',
				styles
			);
			surface.model.transact( tx );
		}
	}
	surface.emitCursor();
};

ve.ui.IndentationButtonTool.prototype.outdent = function( listItems ) {
	var	surface = this.toolbar.surfaceView,
		styles,
		i;

	for ( i = 0; i < listItems.length; i++ ) {
		styles = listItems[i].getElementAttribute( 'styles' );
		if ( styles.length > 1 ) {
			styles.splice( styles.length - 1, 1);
			tx = surface.model.getDocument().prepareElementAttributeChange(
				surface.documentView.model.getOffsetFromNode( listItems[i], false ),
				'set',
				'styles',
				styles
			);
			surface.model.transact( tx );
		}
	}
	surface.emitCursor();
};

ve.ui.IndentationButtonTool.prototype.updateState = function( annotations, nodes ) {
	function areListItems( nodes ) {
		for( var i = 0; i < nodes.length; i++ ) {
			if ( nodes[i].getParent().getElementType() !== 'listItem' ) {
				return false;
			}
		}
		return true;
	}

	this.nodes = nodes;
	if ( areListItems( this.nodes ) ) {
		this.$.removeClass( 'es-toolbarButtonTool-disabled' );
	} else {
		this.$.addClass( 'es-toolbarButtonTool-disabled' );
	}
};

/* Registration */

ve.ui.Tool.tools.indent = {
	'constructor': ve.ui.IndentationButtonTool,
	'name': 'indent',
	'title': 'Increase indentation'
};

ve.ui.Tool.tools.outdent = {
	'constructor': ve.ui.IndentationButtonTool,
	'name': 'outdent',
	'title': 'Reduce indentation'
};

/* Inheritance */

ve.extendClass( ve.ui.IndentationButtonTool, ve.ui.ButtonTool );