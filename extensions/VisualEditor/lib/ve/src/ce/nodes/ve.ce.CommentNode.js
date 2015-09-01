/*!
 * VisualEditor ContentEditable CommentNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable comment node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins OO.ui.mixin.IconElement
 *
 * @constructor
 * @param {ve.dm.CommentNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.CommentNode = function VeCeCommentNode( model, config ) {
	// Parent constructor
	ve.ce.CommentNode.super.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this, this.$element, config );
	OO.ui.mixin.IconElement.call( this, $.extend( {}, config, {
		$icon: this.$element, icon: 'notice'
	} ) );

	// DOM changes
	this.$element
		.addClass( 've-ce-commentNode' )
		// Add em space for selection highlighting
		.text( '\u2003' );
};

/* Inheritance */

OO.inheritClass( ve.ce.CommentNode, ve.ce.LeafNode );
OO.mixinClass( ve.ce.CommentNode, ve.ce.FocusableNode );
OO.mixinClass( ve.ce.CommentNode, OO.ui.mixin.IconElement );

/* Static Properties */

ve.ce.CommentNode.static.name = 'comment';

ve.ce.CommentNode.static.primaryCommandName = 'comment';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.CommentNode.static.getDescription = function ( model ) {
	return model.getAttribute( 'text' );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.CommentNode );
