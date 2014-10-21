/*!
 * VisualEditor DataModel WikiaGalleryItemNode class.
 */

/* global mw */

/**
 * DataModel Wikia gallery item node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaGalleryItemNode = function VeDmWikiaGalleryItemNode() {
	// Parent constructor
	ve.dm.WikiaGalleryItemNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaGalleryItemNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.WikiaGalleryItemNode.static.name = 'wikiaGalleryItem';

ve.dm.WikiaGalleryItemNode.static.tagName = 'figure';

ve.dm.WikiaGalleryItemNode.static.handlesOwnChildren = true;

ve.dm.WikiaGalleryItemNode.static.matchTagNames = [ 'figure' ];

ve.dm.WikiaGalleryItemNode.static.getMatchRdfaTypes = function () {
	return [ 'mw:Image/Thumb' ];
};

ve.dm.WikiaGalleryItemNode.static.matchFunction = function ( element ) {
	return $( element ).parent().attr( 'typeof' ) === 'mw:Extension/gallery';
};

ve.dm.WikiaGalleryItemNode.static.toDataElement = function ( domElements, converter ) {
	var $figure = $( domElements[0] ),
	$caption = $figure.children( 'figcaption' ).eq( 0 ),
	$image = $figure.find( 'img' ).eq(0),
	imageSrc = $image.attr( 'src' ),
	imageName = $image.attr( 'resource' ).split( ':' )[1],
	mwImageTitle = mw.Title.newFromText( imageName ),
	thumbUrl = ve.dm.WikiaGalleryItemNode.static.getThumbUrl( imageSrc, imageName, 480, 480 ),
	thumbHtmlParts,
	embedData;

	thumbHtmlParts = [
		'<a href="' + mwImageTitle.getUrl() + '" class="image image-thumbnail">',
		'<picture>',
		/*
		'<source media="(max-width: 1024px)" srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/384/height/384?cb=20071025105224&amp;fill=transparent&amp;format=webp" type="image/webp">',
		'<source media="(max-width: 1024px)" srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/384/height/384?cb=20071025105224&amp;fill=transparent">',
		'<source srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent&amp;format=webp" type="image/webp">',
		'<source srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent">',
		*/
		'<img src="' + thumbUrl + '" alt="' + imageName + '" class="" data-image-key="' + imageName + '" data-image-name="' + imageName + '">',
		'</picture>',
		'</a>'
	];

	embedData = {
		'caption': $caption.html(),
		'dbKey': imageName,
		'linkHref': mwImageTitle.getUrl(),
		'thumbHtml': thumbHtmlParts.join( '' ),
		'thumbUrl': thumbUrl,
		'title': imageName
	};

	return [ { 'type': this.name, 'attributes': { 'embedData': embedData } } ].
		concat( converter.getDataFromDomClean( $caption[0], { 'type': 'wikiaGalleryItemCaption' } ) ).
		concat( [ { 'type': '/' + this.name } ] );
};

ve.dm.WikiaGalleryItemNode.static.getThumbUrl = function ( url, name, width, height, webp ) {
	var thumbUrlParts = [
		url.substr( 0, url.indexOf( name ) + name.length ),
		'/revision/latest/fixed-aspect-ratio-down',
		'/width/' + width + '/height/' + height,
		'?' + url.match( /cb=\d*/gm ) + '&fill=transparent'
	];

	if ( webp ) {
		thumbUrlParts.push( '&format=webp' );
	}

	return thumbUrlParts.join( '' );
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryItemNode );
