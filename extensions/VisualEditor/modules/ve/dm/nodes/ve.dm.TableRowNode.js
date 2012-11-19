/**
 * VisualEditor data model TableRowNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node for a table row.
 *
 * @class
 * @constructor
 * @extends {ve.dm.BranchNode}
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.TableRowNode = function VeDmTableRowNode( children, attributes ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, 'tableRow', children, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.TableRowNode, ve.dm.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.dm.NodeFactory
 * @static
 * @member
 */
ve.dm.TableRowNode.rules = {
	'isWrapped': true,
	'isContent': false,
	'canContainContent': false,
	'hasSignificantWhitespace': false,
	'childNodeTypes': ['tableCell'],
	'parentNodeTypes': ['tableSection']
};

/**
 * Node converters.
 *
 * @see {ve.dm.Converter}
 * @static
 * @member
 */
ve.dm.TableRowNode.converters = {
	'domElementTypes': ['tr'],
	'toDomElement': function () {
		return document.createElement( 'tr' );
	},
	'toDataElement': function () {
		return {
			'type': 'tableRow'
		};
	}
};

/* Registration */

ve.dm.nodeFactory.register( 'tableRow', ve.dm.TableRowNode );