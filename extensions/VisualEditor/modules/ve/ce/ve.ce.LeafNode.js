/**
 * VisualEditor content editable LeafNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node that can not have any children.
 *
 * @class
 * @abstract
 * @constructor
 * @extends {ve.ce.Node}
 * @param {String} type Symbolic name of node type
 * @param {ve.dm.LeafNode} model Model to observe
 * @param {jQuery} [$element] Element to use as a container
 */
ve.ce.LeafNode = function VeCeLeafNode( type, model, $element ) {
	// Mixin constructor
	ve.LeafNode.call( this );

	// Parent constructor
	ve.ce.Node.call( this, type, model, $element );

	// DOM Changes
	if ( model.isWrapped() ) {
		this.$.addClass( 've-ce-leafNode' );
	}
};

/* Inheritance */

ve.inheritClass( ve.ce.LeafNode, ve.ce.Node );

ve.mixinClass( ve.ce.LeafNode, ve.LeafNode );
