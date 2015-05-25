/*!
 * VisualEditor DataModel InternalListNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel internal list node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.InternalListNode = function VeDmInternalListNode() {
	// Parent constructor
	ve.dm.InternalListNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.InternalListNode, ve.dm.BranchNode );

/* Static members */

ve.dm.InternalListNode.static.name = 'internalList';

ve.dm.InternalListNode.static.childNodeTypes = [ 'internalItem' ];

ve.dm.InternalListNode.static.matchTagNames = [];

ve.dm.InternalListNode.static.isInternal = true;

/* Registration */

ve.dm.modelRegistry.register( ve.dm.InternalListNode );
