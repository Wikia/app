/*!
 * VisualEditor DataModel ListItemNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel list item node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.ListItemNode = function VeDmListItemNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.ListItemNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.ListItemNode.static.name = 'listItem';

ve.dm.ListItemNode.static.parentNodeTypes = [ 'list' ];

ve.dm.ListItemNode.static.matchTagNames = [ 'li' ];

ve.dm.ListItemNode.static.toDataElement = function () {
	return { 'type': 'listItem' };
};

ve.dm.ListItemNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'li' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.ListItemNode );
