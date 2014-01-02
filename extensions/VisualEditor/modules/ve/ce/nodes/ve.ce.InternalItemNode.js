/*!
 * VisualEditor InternalItemNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable internal item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.InternalItemNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.InternalItemNode = function VeCeInternalItemNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.InternalItemNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.InternalItemNode.static.name = 'internalItem';

ve.ce.InternalItemNode.static.tagName = 'span';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.InternalItemNode );
