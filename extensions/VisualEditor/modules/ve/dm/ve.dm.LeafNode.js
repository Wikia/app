/**
 * VisualEditor data model LeafNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node that can not have children.
 *
 * @class
 * @abstract
 * @constructor
 * @extends {ve.dm.Node}
 * @param {String} type Symbolic name of node type
 * @param {Number} [length] Length of content data in document
 * @param {Object} [attributes] Reference to map of attribute key/value pairs
 */
ve.dm.LeafNode = function VeDmLeafNode( type, length, attributes ) {
	// Mixin constructor
	ve.LeafNode.call( this );

	// Parent constructor
	ve.dm.Node.call( this, type, length, attributes );
};

/* Inheritance */

ve.inheritClass( ve.dm.LeafNode, ve.dm.Node );

ve.mixinClass( ve.dm.LeafNode, ve.LeafNode );

/* Methods */
