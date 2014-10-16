/*!
 * VisualEditor DataModel TextNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel text node.
 *
 * @class
 * @extends ve.dm.LeafNode
 *
 * @constructor
 * @param {number} [length] Length of content data in document
 */
ve.dm.TextNode = function VeDmTextNode( length ) {
	// Parent constructor
	ve.dm.LeafNode.call( this );

	// TODO: length is only set on construction in tests
	this.length = length || 0;
};

/* Inheritance */

OO.inheritClass( ve.dm.TextNode, ve.dm.LeafNode );

/* Static Properties */

ve.dm.TextNode.static.name = 'text';

ve.dm.TextNode.static.isWrapped = false;

ve.dm.TextNode.static.isContent = true;

ve.dm.TextNode.static.matchTagNames = [];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TextNode );
