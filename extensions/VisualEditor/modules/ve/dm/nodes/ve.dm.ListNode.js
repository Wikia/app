/**
 * Creates an ve.dm.ListNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {Object} element Document data element of this node
 * @param {ve.dm.ListItemNode[]} contents List of child nodes to initially add
 */
ve.dm.ListNode = function( element, contents ) {
	// Inheritance
	ve.dm.BranchNode.call( this, 'list', element, contents );
};

/* Methods */

/**
 * Creates a list view for this model.
 * 
 * @method
 * @returns {ve.es.ListNode}
 */
ve.dm.ListNode.prototype.createView = function() {
	return new ve.es.ListNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.list = ve.dm.ListNode;

ve.dm.DocumentNode.nodeRules.list = {
	'parents': null,
	'children': ['listItem']
};

/* Inheritance */

ve.extendClass( ve.dm.ListNode, ve.dm.BranchNode );
