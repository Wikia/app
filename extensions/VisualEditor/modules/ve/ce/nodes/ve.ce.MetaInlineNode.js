/**
 * VisualEditor content editable MetaInlineNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for a list.
 *
 * @class
 * @constructor
 * @extends {ve.ce.LeafNode}
 * @param model {ve.dm.MetaInlineNode} Model to observe
 */
ve.ce.MetaInlineNode = function VeCeMetaInlineNode( model ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, 'metaInline', model );

	// FIXME most of this is duplicated from MetaBlockNode, use a mixin or something
	// DOM Changes
	this.$.addClass( 've-ce-metaInlineNode' );
	this.$.attr( 'contenteditable', false );

	// Properties
	this.currentKey = null; // Populated by the first onUpdate() call
	this.currentValue = null; // Populated by the first onUpdate() call

	// Events
	this.model.addListenerMethod( this, 'update', 'onUpdate' );

	// Intialization
	this.onUpdate();
};

/* Inheritance */

ve.inheritClass( ve.ce.MetaInlineNode, ve.ce.LeafNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.MetaInlineNode.rules = {
	'canBeSplit': false
};

/* Methods */

/**
 * Responds to model update events.
 *
 * @method
 */
ve.ce.MetaInlineNode.prototype.onUpdate = ve.ce.MetaBlockNode.prototype.onUpdate;

/* Registration */

ve.ce.nodeFactory.register( 'metaInline', ve.ce.MetaInlineNode );
