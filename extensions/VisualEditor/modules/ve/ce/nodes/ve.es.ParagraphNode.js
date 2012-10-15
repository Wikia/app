/**
 * Creates an ve.es.ParagraphNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.LeafNode}
 * @param {ve.dm.ParagraphNode} model Paragraph model to view
 */
ve.es.ParagraphNode = function( model ) {
	// Inheritance
	ve.es.LeafNode.call( this, model, $( '<p></p>' ) );

	// DOM Changes
	this.$.addClass( 'es-paragraphView' );
};

/* Registration */

ve.es.DocumentNode.splitRules.paragraph = {
	'self': true,
	'children': null
};

/* Inheritance */

ve.extendClass( ve.es.ParagraphNode, ve.es.LeafNode );
