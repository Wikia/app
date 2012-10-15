/**
 * Creates an es.TableCellView object.
 * 
 * @class
 * @constructor
 * @extends {es.DocumentViewBranchNode}
 * @param {es.TableCellModel} model Table cell model to view
 */
es.TableCellView = function( model ) {
	// Inheritance
	es.DocumentViewBranchNode.call( this, model, $( '<td>' ) );

	var _this = this;

	// DOM Changes
	this.$
		.attr( 'style', model.getElementAttribute( 'html/style' ) )
		.addClass( 'es-tableCellView' );
	
	/* Table interaction experiment */
	/*			
	this.$.mousedown( function( e ) { 
		_this.mousedown( e );			
	} );
	this.$.mouseup( function( e ) {
		_this.mouseup( e );
	} );
	*/
	
};

/* Registration */

es.DocumentView.splitRules.tableCell = {
	'self': false,
	'children': true
};

/* Inheritance */

es.extendClass( es.TableCellView, es.DocumentViewBranchNode );


/* Table interaction experiment */
/*
es.TableCellView.prototype.mousedown = function( e ) {
	
	if ( this.$.hasClass('selected') ) {
		$(document.body).css('-webkit-user-select', 'auto');
		this.giveCursor = true;
	} else {
		e.preventDefault();
		window.getSelection().removeAllRanges();
		this.giveCursor = false;
		$(document.body).css('-webkit-user-select', 'none');
		if ( e.metaKey ) {
		
		} else if ( e.shiftKey ) {
		
		} else {
			this.getParent().getParent().$.find('.es-tableCellView.selected').removeClass('selected');
		}
	}
		this.$.addClass('selected');
}

es.TableCellView.prototype.mouseup = function( e ) {
	if ( this.giveCursor ) {
		this.getParent().getParent().$.find('.es-tableCellView.selected').removeClass('selected');
	} else {
	}
}
*/