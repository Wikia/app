/*!
 * VisualEditor DataModel InternalListNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel internal list node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.InternalListNode = function VeDmInternalListNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.InternalListNode, ve.dm.BranchNode );

/* Static members */

ve.dm.InternalListNode.static.name = 'internalList';

ve.dm.InternalListNode.static.childNodeTypes = [ 'internalItem' ];

ve.dm.InternalListNode.static.matchTagNames = [];

ve.dm.InternalListNode.static.isInternal = true;

/* Registration */

ve.dm.modelRegistry.register( ve.dm.InternalListNode );