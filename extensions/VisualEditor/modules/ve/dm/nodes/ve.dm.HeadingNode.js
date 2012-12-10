/**
 * VisualEditor data model HeadingNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a heading.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {ve.dm.LeafNode[]} [children] Child nodes to attach
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.HeadingNode = function VeDmHeadingNode( children, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'heading', children, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.HeadingNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.HeadingNode.rules = {
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
ve.dm.HeadingNode.converters = {
	'domElementTypes': ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
	'toDomElement': function ( type, element ) {
		return element.attributes && ( {
			1: document.createElement( 'h1' ),
			2: document.createElement( 'h2' ),
			3: document.createElement( 'h3' ),
			4: document.createElement( 'h4' ),
			5: document.createElement( 'h5' ),
			6: document.createElement( 'h6' )
		} )[element.attributes.level];
	},
	'toDataElement': function ( tag ) {
		return ( {
			'h1': { 'type': 'heading', 'attributes': { 'level': 1 } },
			'h2': { 'type': 'heading', 'attributes': { 'level': 2 } },
			'h3': { 'type': 'heading', 'attributes': { 'level': 3 } },
			'h4': { 'type': 'heading', 'attributes': { 'level': 4 } },
			'h5': { 'type': 'heading', 'attributes': { 'level': 5 } },
			'h6': { 'type': 'heading', 'attributes': { 'level': 6 } }
		} )[tag];
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'heading', ve.dm.HeadingNode );
