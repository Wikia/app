/**
 * Creates an ve.es.TableRowNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.BranchNode}
 * @param {ve.dm.TableRowNode} model Table row model to view
 */
ve.es.TableRowNode = function( model ) {
	// Inheritance
	ve.es.BranchNode.call( this, model, $( '<tr>' ), true );
	
	// DOM Changes
	this.$
		.attr( 'style', model.getElementAttribute( 'html/style' ) )
		.addClass( 'es-tableRowView' );
};

/* Registration */

ve.es.DocumentNode.splitRules.tableRow = {
	'self': false,
	'children': false
};

/* Inheritance */

ve.extendClass( ve.es.TableRowNode, ve.es.BranchNode );
