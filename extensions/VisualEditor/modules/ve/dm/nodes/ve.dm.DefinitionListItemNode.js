/*!
 * VisualEditor DataModel DefinitionListItemNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel definition list item node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.DefinitionListItemNode = function VeDmDefinitionListItemNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.DefinitionListItemNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.DefinitionListItemNode.static.name = 'definitionListItem';

ve.dm.DefinitionListItemNode.static.parentNodeTypes = [ 'definitionList' ];

ve.dm.DefinitionListItemNode.static.defaultAttributes = {
	'style': 'term'
};

ve.dm.DefinitionListItemNode.static.matchTagNames = [ 'dt', 'dd' ];

ve.dm.DefinitionListItemNode.static.toDataElement = function ( domElements ) {
	var style = domElements[0].nodeName.toLowerCase() === 'dt' ? 'term' : 'definition';
	return { 'type': 'definitionListItem', 'attributes': { 'style': style } };
};

ve.dm.DefinitionListItemNode.static.toDomElements = function ( dataElement, doc ) {
	var tag = dataElement.attributes && dataElement.attributes.style === 'term' ? 'dt' : 'dd';
	return [ doc.createElement( tag ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DefinitionListItemNode );
