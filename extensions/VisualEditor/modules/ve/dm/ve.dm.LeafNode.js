/*!
 * VisualEditor DataModel LeafNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel leaf node.
 *
 * Leaf nodes can not have any children.
 *
 * @abstract
 * @extends ve.dm.Node
 * @mixins ve.LeafNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.LeafNode = function VeDmLeafNode( length, element ) {
	// Mixin constructor
	ve.LeafNode.call( this );

	// Parent constructor
	ve.dm.Node.call( this, length, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.LeafNode, ve.dm.Node );

ve.mixinClass( ve.dm.LeafNode, ve.LeafNode );

/* Static properties */

ve.dm.LeafNode.static.childNodeTypes = [];

/* Methods */

/**
 * Get the annotations that apply to the node.
 *
 * Annotations are grabbed directly from the linear model, so they are updated live. If the linear
 * model element doesn't have a .annotations property, an empty array is returned.
 *
 * @method
 * @returns {number[]} Annotation set indexes in the index-value store
 */
ve.dm.LeafNode.prototype.getAnnotations = function () {
	return this.element.annotations || [];
};
