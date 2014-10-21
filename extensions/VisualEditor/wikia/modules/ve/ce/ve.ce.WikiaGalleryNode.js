/*!
 * VisualEditor ContentEditable WikiaGalleryNode class.
 */

/* global require */

/**
 * ContentEditable Wikia gallery node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @mixins ve.ce.FocusableNode
 *
 * @constructor
 * @param {ve.dm.WikiaGalleryNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.WikiaGalleryNode = function VeCeWikiaGalleryNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaGalleryNode.super.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );

	// Initialization
	this.$element
		.addClass( 'media-gallery-wrapper count-' + this.model.getAttribute( 'itemCount' ) )
		.attr( {
			'data-visible-count': 8,
			'data-expanded': 0,
			'data-model': JSON.stringify( this.model.getEmbedData() )
		} );

	this.$element.html('');
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaGalleryNode, ve.ce.BranchNode );

OO.mixinClass( ve.ce.WikiaGalleryNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.WikiaGalleryNode.static.name = 'wikiaGallery';

ve.ce.WikiaGalleryNode.static.tagName = 'div';

/* Methods */

ve.ce.WikiaGalleryNode.prototype.onSetup = function () {
	require([ 'mediaGallery.controllers.galleries' ], function ( GalleriesController ) {
		var controller = new GalleriesController({
			lightbox: false,
			lazyLoad: false
		});
		controller.init();
	} );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaGalleryNode );
