/*!
 * VisualEditor DataModel DefinitionListNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel definition list node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.DefinitionListNode = function VeDmDefinitionListNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.DefinitionListNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.DefinitionListNode.static.name = 'definitionList';

ve.dm.DefinitionListNode.static.childNodeTypes = [ 'definitionListItem' ];

ve.dm.DefinitionListNode.static.matchTagNames = [ 'dl' ];

ve.dm.DefinitionListNode.static.toDataElement = function () {
	return { 'type': 'definitionList' };
};

ve.dm.DefinitionListNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'dl' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DefinitionListNode );
