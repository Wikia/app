/**
 * VisualEditor data model ListItemNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a list item.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.ListItemNode = function VeDmListItemNode( children, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'listItem', children, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.ListItemNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.ListItemNode.rules = {
	'isWrapped': true,
	'isContent': false,
	'canContainContent': false,
	'hasSignificantWhitespace': false,
	'childNodeTypes': null,
	'parentNodeTypes': ['list']
};

/**
 * Node converters.
 *
 * @see {ve.dm.Converter}
 * @static
 * @member
 */
ve.dm.ListItemNode.converters = {
	'domElementTypes': ['li'],
	'toDomElement': function () {
		return document.createElement( 'li' );
	},
	'toDataElement': function () {
		return {
			'type': 'listItem'
		};
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'listItem', ve.dm.ListItemNode );
