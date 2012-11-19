/**
 * VisualEditor data model PreformattedNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a preformatted.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {ve.dm.LeafNode[]} [children] Child nodes to attach
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.PreformattedNode = function VeDmPreformattedNode( children, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'preformatted', children, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.PreformattedNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.PreformattedNode.rules = {
	'isWrapped': true,
	'isContent': false,
	'canContainContent': true,
	'hasSignificantWhitespace': true,
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
ve.dm.PreformattedNode.converters = {
	'domElementTypes': ['pre'],
	'toDomElement': function () {
		return document.createElement( 'pre' );
	},
	'toDataElement': function () {
		return {
			'type': 'preformatted'
		};
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'preformatted', ve.dm.PreformattedNode );
