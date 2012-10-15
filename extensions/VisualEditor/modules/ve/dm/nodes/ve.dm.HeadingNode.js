/**
 * Creates an ve.dm.HeadingNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.LeafNode}
 * @param {Object} element Document data element of this node
 * @param {Integer} length Length of document data element
 */
ve.dm.HeadingNode = function( element, length ) {
	// Inheritance
	ve.dm.LeafNode.call( this, 'heading', element, length );
};

/* Methods */

/**
 * Creates a heading view for this model.
 * 
 * @method
 * @returns {ve.es.ParagraphNode}
 */
ve.dm.HeadingNode.prototype.createView = function() {
	return new ve.es.HeadingNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.heading = ve.dm.HeadingNode;

ve.dm.DocumentNode.nodeRules.heading = {
	'parents': null,
	'children': []
};

/* Inheritance */

ve.extendClass( ve.dm.HeadingNode, ve.dm.LeafNode );
