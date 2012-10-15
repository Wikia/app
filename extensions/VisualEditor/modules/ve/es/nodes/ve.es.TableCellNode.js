/**
 * Creates an ve.es.TableCellNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.BranchNode}
 * @param {ve.dm.TableCellNode} model Table cell model to view
 */
ve.es.TableCellNode = function( model ) {
	// Inheritance
	ve.es.BranchNode.call( this, model, $( '<td>' ) );

	// DOM Changes
	this.$
		.attr( 'style', model.getElementAttribute( 'html/style' ) )
		.addClass( 'es-tableCellView' );
};

/* Registration */

ve.es.DocumentNode.splitRules.tableCell = {
	'self': false,
	'children': true
};

/* Inheritance */

ve.extendClass( ve.es.TableCellNode, ve.es.BranchNode );
