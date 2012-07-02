/**
 * Creates an ve.es.PreNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.LeafNode}
 * @param {ve.dm.PreNode} model Pre model to view
 */
ve.es.PreNode = function( model ) {
	// Inheritance
	ve.es.LeafNode.call( this, model );

	// DOM Changes
	this.$.addClass( 'es-preView' );
};

/* Registration */

ve.es.DocumentNode.splitRules.pre = {
	'self': true,
	'children': null
};

/* Inheritance */

ve.extendClass( ve.es.PreNode, ve.es.LeafNode );
