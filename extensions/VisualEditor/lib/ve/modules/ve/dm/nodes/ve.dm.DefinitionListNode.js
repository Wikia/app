/*!
 * VisualEditor DataModel DefinitionListNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel definition list node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.DefinitionListNode = function VeDmDefinitionListNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.DefinitionListNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.DefinitionListNode.static.name = 'definitionList';

ve.dm.DefinitionListNode.static.childNodeTypes = [ 'definitionListItem' ];

ve.dm.DefinitionListNode.static.matchTagNames = [ 'dl' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DefinitionListNode );
