/**
 * VisualEditor data model MetaInlineNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for an inline meta node.
 *
 * @class
 * @constructor
 * @extends {ve.dm.LeafNode}
 * @param {Integer} [length] Length of content data in document
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.MetaInlineNode = function VeDmMetaInlineNode( length, attributes ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 'metaInline', 0, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.MetaInlineNode, ve.dm.LeafNode );


/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.MetaInlineNode.rules = {
	'isWrapped': true,
	'isContent': true,
	'canContainContent': false,
	'hasSignificantWhitespace': false,
	'childNodeTypes': [],
	'parentNodeTypes': null
};

/**
 * Node converters.
 *
 * @see {ve.dm.Converter}
 * @static
 * @member
 */
ve.dm.MetaInlineNode.converters = ve.dm.MetaBlockNode.converters;

/* Registration */

ve.dm.nodeFactory.register( 'metaInline', ve.dm.MetaInlineNode );
