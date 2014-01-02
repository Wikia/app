/*!
 * VisualEditor DataModel InternalItemNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel internal item node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.InternalItemNode = function VeDmInternalItemNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.InternalItemNode, ve.dm.BranchNode );

/* Static members */

ve.dm.InternalItemNode.static.name = 'internalItem';

ve.dm.InternalItemNode.static.matchTagNames = [];

ve.dm.InternalItemNode.static.handlesOwnChildren = true;

ve.dm.InternalItemNode.static.isInternal = true;

/* Registration */

ve.dm.modelRegistry.register( ve.dm.InternalItemNode );