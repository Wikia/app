/**
 * Creates an ve.dm.TableRowNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {Object} element Document data element of this node
 * @param {ve.dm.Node[]} contents List of child nodes to initially add
 */
ve.dm.TableRowNode = function( element, contents ) {
	// Inheritance
	ve.dm.BranchNode.call( this, 'tableRow', element, contents );
};

/* Methods */

/**
 * Creates a table row view for this model.
 * 
 * @method
 * @returns {ve.es.TableRowNode}
 */
ve.dm.TableRowNode.prototype.createView = function() {
	return new ve.es.TableRowNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.tableRow = ve.dm.TableRowNode;

ve.dm.DocumentNode.nodeRules.tableRow = {
	'parents': ['table'],
	'children': ['tableCell']
};

/* Inheritance */

ve.extendClass( ve.dm.TableRowNode, ve.dm.BranchNode );
