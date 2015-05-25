/*!
 * VisualEditor ContentEditable LeafNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable leaf node.
 *
 * Leaf nodes can not have any children.
 *
 * @abstract
 * @extends ve.ce.Node
 * @mixins ve.LeafNode
 *
 * @constructor
 * @param {ve.dm.LeafNode} model
 * @param {Object} [config]
 */
ve.ce.LeafNode = function VeCeLeafNode( model ) {
	// Mixin constructor
	ve.LeafNode.call( this );

	// Parent constructor
	ve.ce.Node.apply( this, arguments );

	// DOM changes
	if ( model.isWrapped() ) {
		this.$element.addClass( 've-ce-leafNode' );
	}
};

/* Inheritance */

OO.inheritClass( ve.ce.LeafNode, ve.ce.Node );

OO.mixinClass( ve.ce.LeafNode, ve.LeafNode );

/* Static Properties */

ve.ce.LeafNode.static.tagName = 'span';

/* Methods */

/** */
ve.ce.LeafNode.prototype.onSetup = function () {
	ve.ce.Node.prototype.onSetup.call( this );
	this.$element.addClass( 've-ce-leafNode' );
};

/** */
ve.ce.LeafNode.prototype.onTeardown = function () {
	ve.ce.Node.prototype.onTeardown.call( this );
	this.$element.removeClass( 've-ce-leafNode' );
};

/**
 * Get annotated HTML fragments.
 *
 * @see ve.ce.ContentBranchNode
 *
 * An HTML fragment can be:
 * - a plain text string
 * - a jQuery object
 * - an array with a plain text string or jQuery object at index 0 and a ve.dm.AnnotationSet at index 1,
 *   i.e. ['textstring', ve.dm.AnnotationSet] or [$jQueryObj, ve.dm.AnnotationSet]
 *
 * The default implementation should be fine in most cases. A subclass only needs to override this
 * if the annotations aren't necessarily the same across the entire node (like in ve.ce.TextNode).
 *
 * @method
 * @returns {Array} Array of HTML fragments, i.e.
 *  [ string | jQuery | [string|jQuery, ve.dm.AnnotationSet] ]
 */
ve.ce.LeafNode.prototype.getAnnotatedHtml = function () {
	return [ [ this.$element, this.getModel().getAnnotations() ] ];
};
