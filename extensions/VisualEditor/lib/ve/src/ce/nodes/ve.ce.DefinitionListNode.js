/*!
 * VisualEditor ContentEditable DefinitionListNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable definition list node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.DefinitionListNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.DefinitionListNode = function VeCeDefinitionListNode() {
	// Parent constructor
	ve.ce.DefinitionListNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.DefinitionListNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.DefinitionListNode.static.name = 'definitionList';

ve.ce.DefinitionListNode.static.tagName = 'dl';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.DefinitionListNode );
