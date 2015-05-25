/*!
 * VisualEditor DataModel ListNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel list node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.ListNode = function VeDmListNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.ListNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.ListNode.static.name = 'list';

ve.dm.ListNode.static.childNodeTypes = [ 'listItem' ];

ve.dm.ListNode.static.defaultAttributes = {
	'style': 'bullet'
};

ve.dm.ListNode.static.matchTagNames = [ 'ul', 'ol' ];

ve.dm.ListNode.static.toDataElement = function ( domElements ) {
	var style = domElements[0].nodeName.toLowerCase() === 'ol' ? 'number' : 'bullet';
	return { 'type': this.name, 'attributes': { 'style': style } };
};

ve.dm.ListNode.static.toDomElements = function ( dataElement, doc ) {
	var tag = dataElement.attributes && dataElement.attributes.style === 'number' ? 'ol' : 'ul';
	return [ doc.createElement( tag ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.ListNode );
