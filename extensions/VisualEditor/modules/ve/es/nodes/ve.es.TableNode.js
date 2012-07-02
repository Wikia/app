/**
 * Creates an ve.es.TableNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.BranchNode}
 * @param {ve.dm.TableNode} model Table model to view
 */
ve.es.TableNode = function( model ) {
	// Inheritance
	ve.es.BranchNode.call( this, model, $( '<table>' ) );
	
	// DOM Changes
	this.$
		.attr( 'style', model.getElementAttribute( 'html/style' ) )
		.addClass( 'es-tableView' );
};

/* Registration */

ve.es.DocumentNode.splitRules.table = {
	'self': false,
	'children': false
};

/* Inheritance */

ve.extendClass( ve.es.TableNode, ve.es.BranchNode );
