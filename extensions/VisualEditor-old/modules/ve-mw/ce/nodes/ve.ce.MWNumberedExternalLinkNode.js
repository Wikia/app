/*!
 * VisualEditor ContentEditable MWNumberedExternalLinkNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki numbered external link node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @constructor
 * @param {ve.dm.MWNumberedExternalLinkNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWNumberedExternalLinkNode = function VeCeMWNumberedExternalLinkNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );

	// DOM changes
	this.$element
		.addClass( 've-ce-mwNumberedExternalLinkNode' )
		// Need CE=false to prevent selection issues
		.prop( 'contentEditable', 'false' );

	// Add link
	this.$link = this.$( '<a>' )
		// CSS for numbering needs rel=mw:ExtLink
		.attr( 'rel', 'mw:ExtLink' )
		.addClass( 'external' )
		.appendTo( this.$element );

	// Events
	this.model.connect( this, { update: 'onUpdate' } );

	// Initialization
	this.onUpdate();
};

/* Inheritance */

OO.inheritClass( ve.ce.MWNumberedExternalLinkNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.MWNumberedExternalLinkNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.MWNumberedExternalLinkNode.static.name = 'link/mwNumberedExternal';

ve.ce.MWNumberedExternalLinkNode.static.tagName = 'span';

ve.ce.MWNumberedExternalLinkNode.static.primaryCommandName = 'link';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.MWNumberedExternalLinkNode.static.getDescription = function ( model ) {
	return model.getAttribute( 'href' );
};

/* Methods */

/**
 * Handle model update events.
 *
 * If the source changed since last update the image's src attribute will be updated accordingly.
 *
 * @method
 */
ve.ce.MWNumberedExternalLinkNode.prototype.onUpdate = function () {
	this.$link.attr( 'href', this.model.getAttribute( 'href' ) );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWNumberedExternalLinkNode );
