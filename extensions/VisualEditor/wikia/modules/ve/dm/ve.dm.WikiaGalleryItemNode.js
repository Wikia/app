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
	imageName = $image.attr( 'resource' ).split( ':' )[1],
	mwImageTitle = mw.Title.newFromText( imageName ),
	attributes;

	// Stash all of this in attributes
	/*
	{
		'caption': '',
		'dbKey': 'Captainwoof.jpg',
		'linkHref': '/wiki/File:Captainwoof.jpg',
		'thumbHtml': '<a href="/wiki/File:Captainwoof.jpg" class="image image-thumbnail"><picture><source media="(max-width: 1024px)" srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/384/height/384?cb=20071025105224&amp;fill=transparent&amp;format=webp" type="image/webp"><source media="(max-width: 1024px)" srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/384/height/384?cb=20071025105224&amp;fill=transparent"><source srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent&amp;format=webp" type="image/webp"><source srcset="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent"><img src="http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&amp;fill=transparent" alt="Captainwoof.jpg" class="" data-image-key="Captainwoof.jpg" data-image-name="Captainwoof.jpg"></picture></a>',
		'thumbUrl': 'http://vignette.wikia-dev.com/muppet/a/a0/Captainwoof.jpg/revision/latest/fixed-aspect-ratio-down/width/480/height/480?cb=20071025105224&fill=transparent',
		'title': 'Captainwoof.jpg'
	}
	*/

	attributes = {
		'caption': $caption.html(),
		'dbKey': imageName,
		'linkHref': mwImageTitle.getUrl(),
		'title': imageName
	};

	return [ { 'type': this.name, 'attributes': attributes } ].
		concat( converter.getDataFromDomClean( $caption[0], { 'type': 'wikiaGalleryItemCaption' } ) ).
		concat( [ { 'type': '/' + this.name } ] );
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryItemNode );
