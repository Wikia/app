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
	var galleryDataModelAttr;

	// Parent constructor
	ve.ce.WikiaGalleryNode.super.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );

	// Initialization
	// TODO: Iterate through gallery images and generate this mocked data for real:
	galleryDataModelAttr = [ {
		'caption': '',
		'dbKey': 'Captainwoof.jpg',
		'linkHref': '/wiki/File:Captainwoof.jpg',
		'thumbHtml': '<a href="/wiki/File:Captainwoof.jpg" class="image image-thumbnail"><picture><source media="(max-width: 1024px)" srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/384/height/384?cb=20071025105224&amp;fill=transparent&amp;format=webp" type="image/webp"><source media="(max-width: 1024px)" srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/384/height/384?cb=20071025105224&amp;fill=transparent"><source srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent&amp;format=webp" type="image/webp"><source srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent"><img src="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent" alt="Captainwoof.jpg" class="" data-image-key="Captainwoof.jpg" data-image-name="Captainwoof.jpg"></picture></a>',
		'thumbUrl': 'http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&fill=transparent',
		'title': 'Captainwoof.jpg'
	} ];

	this.$element
		.addClass( 'media-gallery-wrapper count-' + this.model.getAttribute( 'itemCount' ) )
		.attr( {
			'data-visible-count': 8,
			'data-expanded': 0,
			'data-model': JSON.stringify( galleryDataModelAttr )
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
