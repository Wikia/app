/**
 * VisualEditor data model TextNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a document.
 *
 * @class
 * @constructor
 * @extends {ve.dm.LeafNode}
 * @param {Number} [length] Length of content data in document
 */
ve.dm.TextNode = function VeDmTextNode( length ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 'text', length );
};

/* Inheritance */

ve.inheritClass( ve.dm.TextNode, ve.dm.LeafNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.TextNode.rules = {
	'isWrapped': false,
	'isContent': true,
	'canContainContent': false,
	'hasSignificantWhitespace': false,
	'childNodeTypes': [],
	'parentNodeTypes': null
};

// This is a special node, no converter registration is required
ve.dm.TextNode.converters = null;

/* Registration */

ve.dm.nodeFactory.register( 'text', ve.dm.TextNode );
