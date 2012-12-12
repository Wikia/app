/**
 * VisualEditor data model CenterNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a center tag.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.CenterNode = function VeDmCenterNode( children, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'center', children, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.CenterNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.CenterNode.rules = {
	'isWrapped': true,
	'isContent': false,
	'canContainContent': false,
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
ve.dm.CenterNode.converters = {
	'domElementTypes': ['center'],
	'toDomElement': function () {
		return document.createElement( 'center' );
	},
	'toDataElement': function () {
		return {
			'type': 'center'
		};
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'center', ve.dm.CenterNode );
