/*!
 * VisualEditor DataModel LeafNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel leaf node.
 *
 * Leaf nodes can not have any children.
 *
 * @abstract
 * @extends ve.dm.Node
 * @mixins ve.LeafNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.LeafNode = function VeDmLeafNode( element ) {
	// Mixin constructor
	ve.LeafNode.call( this );

	// Parent constructor
	ve.dm.Node.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.LeafNode, ve.dm.Node );

OO.mixinClass( ve.dm.LeafNode, ve.LeafNode );

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
