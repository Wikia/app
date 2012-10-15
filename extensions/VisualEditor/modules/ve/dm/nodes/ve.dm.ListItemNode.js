/**
 * Creates an ve.dm.ListItemNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.LeafNode}
 * @param {Object} element Document data element of this node
 * @param {Integer} length Length of document data element
 */
ve.dm.ListItemNode = function( element, contents ) {
	// Inheritance
	ve.dm.BranchNode.call( this, 'listItem', element, contents );
};

/* Methods */

/**
 * Creates a list item view for this model.
 * 
 * @method
 * @returns {ve.es.ListItemNode}
 */
ve.dm.ListItemNode.prototype.createView = function() {
	return new ve.es.ListItemNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.listItem = ve.dm.ListItemNode;

ve.dm.DocumentNode.nodeRules.listItem = {
	'parents': ['list'],
	'children': null
};

/* Inheritance */

ve.extendClass( ve.dm.ListItemNode, ve.dm.BranchNode );
