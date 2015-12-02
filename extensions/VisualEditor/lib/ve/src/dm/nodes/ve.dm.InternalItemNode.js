/*!
 * VisualEditor DataModel InternalItemNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel internal item node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.InternalItemNode = function VeDmInternalItemNode() {
	// Parent constructor
	ve.dm.InternalItemNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.InternalItemNode, ve.dm.BranchNode );

/* Static members */

ve.dm.InternalItemNode.static.name = 'internalItem';

ve.dm.InternalItemNode.static.matchTagNames = [];

ve.dm.InternalItemNode.static.handlesOwnChildren = true;

ve.dm.InternalItemNode.static.isInternal = true;

/* Registration */

ve.dm.modelRegistry.register( ve.dm.InternalItemNode );
