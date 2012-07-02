/**
 * Creates an ve.dm.TableNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {Object} element Document data element of this node
 * @param {ve.dm.TableCellNode[]} contents List of child nodes to initially add
 */
ve.dm.TableNode = function( element, contents ) {
	// Inheritance
	ve.dm.BranchNode.call( this, 'table', element, contents );
};

/* Methods */

/**
 * Creates a table view for this model.
 * 
 * @method
 * @returns {ve.es.TableNode}
 */
ve.dm.TableNode.prototype.createView = function() {
	return new ve.es.TableNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.table = ve.dm.TableNode;

ve.dm.DocumentNode.nodeRules.table = {
	'parents': null,
	'children': ['tableRow']
};

/* Inheritance */

ve.extendClass( ve.dm.TableNode, ve.dm.BranchNode );
