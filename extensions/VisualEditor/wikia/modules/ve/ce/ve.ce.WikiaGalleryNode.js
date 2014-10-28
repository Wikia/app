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
};

/**
 * @method
 */
ve.ce.WikiaGalleryNode.prototype.rebuild = function () {
	var i, item, itemModel, galleryData = [], title, titleUrl, titleName, thumbUrl;

	for ( i = 0; i < this.children.length; i++ ) {
		item = this.children[i];
		itemModel = item.getModel();
		title = mw.Title.newFromText( itemModel.getAttribute( 'resource' ).replace( /^(.+\/)*/, '' ) );
		titleUrl = title.getUrl();
		titleName = title.getMainText();
		thumbUrl = ve.ce.WikiaGalleryNode.static.getThumbUrl( itemModel.getAttribute( 'src' ), titleName );

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
			'caption': item.children[0].getLength() > 0 ? item.children[0].$element.html() : null
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
				origVisibleCount: Math.min( galleryData.length, 8 ),
			},
			gallery = new Gallery( galleryOptions ).init();

		this.$element
			.html( '' )
			.removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)count-\S+/g ) || [] ).join( ' ' );
			} )
			.addClass( 'count-' + galleryData.length )
			.append( gallery.render().$el );

		// TODO: Remove after https://wikia-inc.atlassian.net/browse/VID-2112 is done
		gallery.$el.trigger('galleryInserted');
	}, this ) );
};

ve.ce.WikiaGalleryNode.static.getThumbUrl = function ( url, name ) {
	var height = 480,
		width = 480;
	return [
		url.substr( 0, url.indexOf( '/revision/' ) ),
		'/revision/latest/zoom-crop',
		'/width/' + width + '/height/' + height,
		'?' + url.match( /cb=\d*/gm ) + '&fill=transparent'
	].join( '' );
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
