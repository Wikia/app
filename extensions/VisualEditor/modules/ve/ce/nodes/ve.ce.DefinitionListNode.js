/*!
 * VisualEditor ContentEditable DefinitionListNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
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
ve.ce.DefinitionListNode = function VeCeDefinitionListNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.DefinitionListNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.DefinitionListNode.static.name = 'definitionList';

ve.ce.DefinitionListNode.static.tagName = 'dl';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.DefinitionListNode );
