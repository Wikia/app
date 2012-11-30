/**
 * VisualEditor data model ParagraphNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a paragraph.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {ve.dm.LeafNode[]} [children] Child nodes to attach
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.ParagraphNode = function VeDmParagraphNode( children, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'paragraph', children, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.ParagraphNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.ParagraphNode.rules = {
	'isWrapped': true,
	'isContent': false,
	'canContainContent': true,
	'hasSignificantWhitespace': false,
	'childNodeTypes': null,
	'parentNodeTypes': null
};

/**
 * Node converters.
 *
 * @see {ve.dm.Converter}
 * @static
 * @member
 */
ve.dm.ParagraphNode.converters = {
	'domElementTypes': ['p'],
	'toDomElement': function () {
		return document.createElement( 'p' );
	},
	'toDataElement': function () {
		return {
			'type': 'paragraph'
		};
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'paragraph', ve.dm.ParagraphNode );
