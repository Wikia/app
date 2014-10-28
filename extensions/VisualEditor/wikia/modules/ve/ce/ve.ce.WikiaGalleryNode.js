/*!
 * VisualEditor ContentEditable WikiaGalleryNode class.
 */

/* global require, mw */

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
	this.rebuild();

	// Events
	this.model.connect( this, { 'update': 'onUpdate' } );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaGalleryNode, ve.ce.BranchNode );

OO.mixinClass( ve.ce.WikiaGalleryNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.WikiaGalleryNode.static.name = 'wikiaGallery';

ve.ce.WikiaGalleryNode.static.tagName = 'div';

/* Methods */

/**
 * Handle model update events.
 *
 * @method
 */
ve.ce.WikiaGalleryNode.prototype.onUpdate = function () {
	this.rebuild();
	this.runGalleryScript();
};

ve.ce.WikiaGalleryNode.prototype.rebuild = function () {
	var i, $item, imageName, href, thumbUrl, imageSrc,
		items = this.getChildren(),
		embedData = [];

	for ( i = 0; i < items.length; i++ ) {
		$item = items[i].$element;
		imageName = items[i].model.getAttribute( 'resource' ).split( ':' )[1];
		imageSrc = items[i].model.getAttribute( 'src' );
		href = mw.Title.newFromText( imageName ).getUrl();
		thumbUrl = this.getThumbUrl( imageSrc, imageName );

		embedData.push( {
			'caption': $item.children('figcaption').eq(0).html(),
			'dbKey': imageName,
			'linkHref': href,
			'thumbHtml': this.getThumbHtml( href, thumbUrl, imageName ),
			'thumbUrl': thumbUrl,
			'title': imageName
		} );
	}

	this.$element
		.addClass( 'media-gallery-wrapper count-' + items.length )
		.attr( {
			'data-visible-count': 8,
			'data-expanded': 0,
			'data-model': JSON.stringify( embedData )
		} )
		.html( '' );

	/*
	 * Wikia Gallery uses data 'initialized' to know if the gallery for this element has been generated.
	 * Because we're rebuilding, set 'initialized' to false.
	 */
	this.$element.data( 'initialized', false );
};

ve.ce.WikiaGalleryNode.prototype.getThumbHtml = function ( href, url, imageName ) {
	var thumbHtmlParts = [
		'<a href="' + href + '" class="image image-thumbnail">',
		'<picture>',
		'<img src="' + url + '" alt="' + imageName + '" class="" data-image-key="' + imageName + '" data-image-name="' + imageName + '">',
		'</picture>',
		'</a>'
	];

	return thumbHtmlParts.join( '' );
};

ve.ce.WikiaGalleryNode.prototype.getThumbUrl = function ( imageSrc, imageName ) {
	var height = 480,
		width = 480,
		thumbUrlParts = [
			imageSrc.substr( 0, imageSrc.indexOf( imageName ) + imageName.length ),
			'/revision/latest/zoom-crop',
			'/width/' + width + '/height/' + height,
			'?' + imageSrc.match( /cb=\d*/gm ) + '&fill=transparent'
		];

	return thumbUrlParts.join( '' );
};

ve.ce.WikiaGalleryNode.prototype.onSetup = function () {
	this.runGalleryScript();
};

ve.ce.WikiaGalleryNode.prototype.runGalleryScript = function () {
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
