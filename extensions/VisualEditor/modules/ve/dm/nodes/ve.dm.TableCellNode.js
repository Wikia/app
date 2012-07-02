/**
 * Creates an ve.dm.TableCellNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {Object} element Document data element of this node
 * @param {ve.dm.Node[]} contents List of child nodes to initially add
 */
ve.dm.TableCellNode = function( element, contents ) {
	// Inheritance
	ve.dm.BranchNode.call( this, 'tableCell', element, contents );
};

/* Methods */

/**
 * Creates a table cell view for this model.
 * 
 * @method
 * @returns {ve.es.TableCellNode}
 */
ve.dm.TableCellNode.prototype.createView = function() {
	return new ve.es.TableCellNode( this );
};

/* Registration */

ve.dm.DocumentNode.nodeModels.tableCell = ve.dm.TableCellNode;

ve.dm.DocumentNode.nodeRules.tableCell = {
	'parents': ['tableRow'],
	'children': null
};

/* Inheritance */

ve.extendClass( ve.dm.TableCellNode, ve.dm.BranchNode );
