/**
 * Creates an ve.dm.PreNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.LeafNode}
 * @param {Object} element Document data element of this node
 * @param {Integer} length Length of document data element
 */
ve.dm.PreNode = function( element, length ) {
	// Inheritance
	ve.dm.LeafNode.call( this, 'pre', element, length );
};

/* Methods */

/**
 * Creates a pre view for this model.
 * 
 * @method
 * @returns {ve.es.PreNode}
 */
ve.dm.PreNode.prototype.createView = function() {
	return new ve.es.PreNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.pre = ve.dm.PreNode;

ve.dm.DocumentNode.nodeRules.pre = {
	'parents': null,
	'children': []
};

/* Inheritance */

ve.extendClass( ve.dm.PreNode, ve.dm.LeafNode );
