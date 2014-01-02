/*!
 * VisualEditor DataModel ListNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel list node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.ListNode = function VeDmListNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.ListNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.ListNode.static.name = 'list';

ve.dm.ListNode.static.childNodeTypes = [ 'listItem' ];

ve.dm.ListNode.static.defaultAttributes = {
	'style': 'bullet'
};

ve.dm.ListNode.static.matchTagNames = [ 'ul', 'ol' ];

ve.dm.ListNode.static.toDataElement = function ( domElements ) {
	var style = domElements[0].nodeName.toLowerCase() === 'ol' ? 'number' : 'bullet';
	return { 'type': 'list', 'attributes': { 'style': style } };
};

ve.dm.ListNode.static.toDomElements = function ( dataElement, doc ) {
	var tag = dataElement.attributes && dataElement.attributes.style === 'number' ? 'ol' : 'ul';
	return [ doc.createElement( tag ) ];
};


/* Registration */

ve.dm.modelRegistry.register( ve.dm.ListNode );
