/**
 * VisualEditor data model BreakNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a line break.
 *
 * @class
 * @constructor
 * @extends {ve.dm.LeafNode}
 * @param {Number} [length] Length of content data in document
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.BreakNode = function VeDmBreakNode( length, attributes ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 'break', 0, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.BreakNode, ve.dm.LeafNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.BreakNode.rules = {
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
ve.dm.BreakNode.converters = {
	'domElementTypes': ['br'],
	'toDomElement': function () {
		return document.createElement( 'br' );
	},
	'toDataElement': function () {
		return { 'type': 'break' };
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'break', ve.dm.BreakNode );
