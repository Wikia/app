/**
 * Creates an es.TableRowView object.
 * 
 * @class
 * @constructor
 * @extends {es.DocumentViewBranchNode}
 * @param {es.TableRowModel} model Table row model to view
 */
es.TableRowView = function( model ) {
	// Inheritance
	es.DocumentViewBranchNode.call( this, model, $( '<tr>' ), true );
	
	// DOM Changes
	this.$
		.attr( 'style', model.getElementAttribute( 'html/style' ) )
		.addClass( 'es-tableRowView' );
};

/* Registration */

es.DocumentView.splitRules.tableRow = {
	'self': false,
	'children': false
};

/* Inheritance */

es.extendClass( es.TableRowView, es.DocumentViewBranchNode );
