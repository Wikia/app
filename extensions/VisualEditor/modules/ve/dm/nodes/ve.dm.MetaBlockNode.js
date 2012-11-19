/**
 * VisualEditor data model MetaBlockNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for an alien block node.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {Integer} [length] Length of content data in document
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.MetaBlockNode = function VeDmMetaBlockNode( length, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'metaBlock', 0, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.MetaBlockNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.MetaBlockNode.rules = {
	'isWrapped': true,
	'isContent': false,
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
ve.dm.MetaBlockNode.converters = {
	'domElementTypes': ['meta', 'link'],
	'toDomElement': function ( type, element ) {
		var isLink = element.attributes.style === 'link',
			domElement = document.createElement( isLink ? 'link' : 'meta' );
		if ( element.attributes.key !== null ) {
			domElement.setAttribute( isLink ? 'rel' : 'property', element.attributes.key );
		}
		if ( element.attributes.value ) {
			domElement.setAttribute( isLink ? 'href' : 'content', element.attributes.value );
		}
		return domElement;
	},
	'toDataElement': null // Special handling in ve.dm.Converter
};

/* Registration */

ve.dm.nodeFactory.register( 'metaBlock', ve.dm.MetaBlockNode );
