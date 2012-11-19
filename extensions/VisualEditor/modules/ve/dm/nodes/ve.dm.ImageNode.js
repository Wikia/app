/**
 * VisualEditor data model ImageNode class.
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
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.ImageNode = function VeDmImageNode( length, attributes ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 'image', 0, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.ImageNode, ve.dm.LeafNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.ImageNode.rules = {
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
ve.dm.ImageNode.converters = {
	'domElementTypes': ['img'],
	'toDomElement': function () {
		return document.createElement( 'img' );
	},
	'toDataElement': function () {
		return {
			'type': 'image'
		};
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'image', ve.dm.ImageNode );
