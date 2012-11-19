/**
 * VisualEditor data model TableNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a table.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.TableNode = function VeDmTableNode( children, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'table', children, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.TableNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.TableNode.rules = {
	'isWrapped': true,
	'isContent': false,
	'canContainContent': false,
	'hasSignificantWhitespace': false,
	'childNodeTypes': ['tableSection'],
	'parentNodeTypes': null
};

/**
 * Node converters.
 *
 * @see {ve.dm.Converter}
 * @static
 * @member
 */
ve.dm.TableNode.converters = {
	'domElementTypes': ['table'],
	'toDomElement': function () {
		return document.createElement( 'table' );
	},
	'toDataElement': function () {
		return {
			'type': 'table'
		};
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'table', ve.dm.TableNode );
