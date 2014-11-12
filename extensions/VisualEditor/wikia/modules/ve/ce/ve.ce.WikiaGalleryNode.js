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

	// DOM changes
	this.$element.addClass( 'media-gallery-wrapper' );

	// Initialization
	this.rebuild();

	// Events
	this.model.connect( this, { 'update': 'onUpdate' } );
	this.$element.on( 'mediaLoaded', ve.bind( function () {
		var focusWidget = this.surface.getSurface().getFocusWidget();
		if ( focusWidget ) {
			focusWidget.adjustLayout();
		}
		if ( this.isFocused() ) {
			this.redrawHighlights();
		}
	}, this ) );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaGalleryNode, ve.ce.BranchNode );

OO.mixinClass( ve.ce.WikiaGalleryNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.WikiaGalleryNode.static.handlesOwnRendering = true;

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
};

/**
 * @method
 */
ve.ce.WikiaGalleryNode.prototype.rebuild = function () {
	var i, item, itemModel, galleryData = [], title, titleUrl, titleName, thumbUrl;

	for ( i = 0; i < this.children.length; i++ ) {
		item = this.children[i];
		if ( item.getType() !== 'wikiaGalleryItem' ) {
			continue;
		}
		itemModel = item.getModel();
		title = mw.Title.newFromText( ve.dm.MWImageNode.static.getFilenameFromResource( itemModel.getAttribute( 'resource' ) ) );
		titleUrl = title.getUrl();
		titleName = title.getMainText();
		thumbUrl = ve.ce.WikiaGalleryNode.static.getThumbUrl( itemModel.getAttribute( 'src' ) );

		galleryData.push( {
			'title': titleName,
			'thumbUrl': thumbUrl,
			'thumbHtml': ve.ce.WikiaGalleryNode.static.getThumbHtml(
					titleUrl,
					thumbUrl,
					titleName
				),
			'linkHref': titleUrl,
			'dbKey': titleName,
			'caption': item.children[0] && item.children[0].getLength() > 0 ? item.children[0].$element.html() : null
		} );
	}

	this.setupGallery( galleryData );
};

/**
 * @method
 */
ve.ce.WikiaGalleryNode.prototype.setupGallery = function ( galleryData ) {
	require([ 'mediaGallery.views.gallery' ], ve.bind( function ( Gallery ) {
		var galleryOptions = {
				$el: this.$( '<div></div>' ),
				$wrapper: this.$element,
				model: { media: galleryData },
				index: -1,
				// 100 and 8 are constant for MediaGallery extension. I could export them
				// but I'm not going to because ultimetly "client" of Gallery should not have
				// to know about it and just pass some boolean expand parameter to get desired
				// effect.
				origVisibleCount: this.model.getAttribute( 'expand' ) ? 100 : 8
			},
			gallery = new Gallery( galleryOptions ).init();

		this.$element
			.removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)count-\S+/g ) || [] ).join( ' ' );
			} )
			.addClass( 'count-' + galleryData.length )
			.append( gallery.render().$el );

		// TODO: Remove after https://wikia-inc.atlassian.net/browse/VID-2112 is done
		gallery.$el.trigger('galleryInserted');
	}, this ) );
};

ve.ce.WikiaGalleryNode.static.getThumbUrl = function ( url ) {
	var vignettePathPrefix = mw.config.get( 'VignettePathPrefix' ),
		height = 480,
		width = 480,
		parts = [
			url.substr( 0, url.indexOf( '/revision/' ) ),
			'/revision/latest/zoom-crop',
			'/width/' + width + '/height/' + height,
			'?' + url.match( /cb=\d*/gm ) + '&fill=transparent'
		];
	if ( vignettePathPrefix ) {
		parts.push( '&path-prefix=' + vignettePathPrefix );
	}
	return parts.join( '' );
};

ve.ce.WikiaGalleryNode.static.getThumbHtml = function ( linkUrl, imageUrl, name ) {
	return [
		'<a href="' + linkUrl + '" class="image image-thumbnail">',
		'<picture>',
		'<img src="' + imageUrl + '" alt="' + name + '" class="" data-image-key="' + name + '" data-image-name="' + name + '">',
		'</picture>',
		'</a>'
	].join( '' );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaGalleryNode );
