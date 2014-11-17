/*!
 * VisualEditor DataModel ListItemNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel list item node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.ListItemNode = function VeDmListItemNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.ListItemNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.ListItemNode.static.name = 'listItem';

ve.dm.ListItemNode.static.parentNodeTypes = [ 'list' ];

ve.dm.ListItemNode.static.matchTagNames = [ 'li' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.ListItemNode );
