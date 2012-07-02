/**
 * Creates an ve.dm.ParagraphNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.LeafNode}
 * @param {Object} element Document data element of this node
 * @param {Integer} length Length of document data element
 */
ve.dm.ParagraphNode = function( element, length ) {
	// Inheritance
	ve.dm.LeafNode.call( this, 'paragraph', element, length );
};

/* Methods */

/**
 * Creates a paragraph view for this model.
 * 
 * @method
 * @returns {ve.es.ParagraphNode}
 */
ve.dm.ParagraphNode.prototype.createView = function() {
	return new ve.es.ParagraphNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.paragraph = ve.dm.ParagraphNode;

ve.dm.DocumentNode.nodeRules.paragraph = {
	'parents': null,
	'children': []
};

/* Inheritance */

ve.extendClass( ve.dm.ParagraphNode, ve.dm.LeafNode );
