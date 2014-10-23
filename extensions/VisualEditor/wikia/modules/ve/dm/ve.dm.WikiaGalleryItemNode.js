/*!
 * VisualEditor DataModel WikiaGalleryItemNode class.
 */

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

OO.mixinClass( ve.dm.WikiaGalleryItemNode, ve.dm.GeneratedContentNode );

/* Static Properties */

ve.dm.WikiaGalleryItemNode.static.name = 'wikiaGalleryItem';

ve.dm.WikiaGalleryItemNode.static.tagName = 'figure';

ve.dm.WikiaGalleryItemNode.static.handlesOwnChildren = true;

ve.dm.WikiaGalleryItemNode.static.captionNodeType = 'wikiaGalleryItemCaption';

ve.dm.WikiaGalleryItemNode.static.matchTagNames = [ 'figure' ];

ve.dm.WikiaGalleryItemNode.static.rdfaToType = {
	'mw:Image/Thumb': 'thumb'
};

ve.dm.WikiaGalleryItemNode.static.getMatchRdfaTypes = function () {
	return [ 'mw:Image/Thumb' ];
};

ve.dm.WikiaGalleryItemNode.static.matchFunction = function ( element ) {
	return $( element ).parent().attr( 'typeof' ) === 'mw:Extension/nativeGallery';
};

ve.dm.WikiaGalleryItemNode.static.toDomElements = ve.dm.MWBlockImageNode.static.toDomElements;

/*
ve.dm.WikiaGalleryItemNode.static.toDomElements = function ( data, doc, converter ) {
	var dataElement = data[0],
		figure = doc.createElement( 'figure' ),
		anchor = doc.createElement( 'a' ),
		img = doc.createElement( 'img' ),
		wrapper = doc.createElement( 'div' ),
		classes = [],
		captionData = data.slice( 1, -1 );

	// Figure
	classes.push( 'mw-default-size');
	classes.push( 'mw-halign-none' );
	figure.className = classes.join( ' ' );
	figure.setAttribute( 'typeof', 'mw:Image/Thumb' );

	// Anchor
	anchor.setAttribute( 'href', dataElement.attributes.href );

	// Image
	img.setAttribute( 'resource', dataElement.attributes.resource );
	img.setAttribute( 'src', dataElement.attributes.src );
	img.setAttribute( 'height', dataElement.attributes.height );
	img.setAttribute( 'width', dataElement.attributes.width );

	figure.appendChild( anchor );
	anchor.appendChild( img );

	// Caption
	if ( captionData.length > 2 ) {
		converter.getDomSubtreeFromData( data.slice( 1, -1 ), wrapper );
		while ( wrapper.firstChild ) {
			figure.appendChild( wrapper.firstChild );
		}
	}

	return [ figure ];

	//return [ doc.createElement( 'figure' ) ];
};
*/

ve.dm.WikiaGalleryItemNode.static.toDataElement = ve.dm.MWBlockImageNode.static.toDataElement;

/*
ve.dm.WikiaGalleryItemNode.static.toDataElement = function ( domElements, converter ) {
	var $figure = $( domElements[0] ),
	$caption = $figure.children( 'figcaption' ).eq( 0 ),
	$image = $figure.find( 'img' ).eq(0),
	attributes = {
		'href': $figure.children( 'a' ).attr( 'href' ),
		'resource': $image.attr( 'resource' ),
		'src': $image.attr( 'src' ),
		'height': $image.attr( 'height' ),
		'width': $image.attr( 'width' )
	};

	return [ { 'type': this.name, 'attributes': attributes } ].
		concat( converter.getDataFromDomClean( $caption[0], { 'type': 'wikiaGalleryItemCaption' } ) ).
		concat( [ { 'type': '/' + this.name } ] );
};
*/

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryItemNode );
