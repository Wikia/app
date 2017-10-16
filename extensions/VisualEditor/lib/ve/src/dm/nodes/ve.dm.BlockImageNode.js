/*!
 * VisualEditor DataModel BlockImageNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel block image node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @mixins ve.dm.ImageNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.BlockImageNode = function VeDmBlockImageNode() {
	// Parent constructor
	ve.dm.BlockImageNode.super.apply( this, arguments );

	// Mixin constructor
	ve.dm.ImageNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.BlockImageNode, ve.dm.BranchNode );

OO.mixinClass( ve.dm.BlockImageNode, ve.dm.ImageNode );

/* Static Properties */

ve.dm.BlockImageNode.static.name = 'blockImage';

ve.dm.BlockImageNode.static.storeHtmlAttributes = {
	blacklist: [ 'typeof', 'class', 'src', 'resource', 'width', 'height', 'href', 'rel' ]
};

ve.dm.BlockImageNode.static.handlesOwnChildren = true;

ve.dm.BlockImageNode.static.childNodeTypes = [ 'imageCaption' ];

ve.dm.BlockImageNode.static.matchTagNames = [ 'figure' ];

//ve.dm.BlockImageNode.static.blacklistedAnnotationTypes = [ 'link' ];

ve.dm.BlockImageNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement,
		$figure = $( domElements[0] ),
		$img = $figure.children( 'img' ).eq( 0 ),
		$caption = $figure.children( 'figcaption' ).eq( 0 ),
		attributes = {
			src: $img.attr( 'src' )
		},
		width = $img.attr( 'width' ),
		height = $img.attr( 'height' ),
		altText = $img.attr( 'alt' );

	if ( altText !== undefined ) {
		attributes.alt = altText;
	}

	attributes.width = width !== undefined && width !== '' ? Number( width ) : null;
	attributes.height = height !== undefined && height !== '' ? Number( height ) : null;

	dataElement = { type: this.name, attributes: attributes };

	if ( $caption.length === 0 ) {
		return [
			dataElement,
			{ type: 'imageCaption' },
			{ type: 'imageCaption' },
			{ type: '/' + this.name }
		];
	} else {
		return [ dataElement ].
			concat( converter.getDataFromDomClean( $caption[0], { type: 'imageCaption' } ) ).
			concat( [ { type: '/' + this.name } ] );
	}
};

// TODO: Consider using jQuery instead of pure JS.
// TODO: At this moment node is not resizable but when it will be then adding defaultSize class
// should be more conditional.
ve.dm.BlockImageNode.static.toDomElements = function ( data, doc, converter ) {
	var dataElement = data[0],
		width = dataElement.attributes.width,
		height = dataElement.attributes.height,
		figure = doc.createElement( 'figure' ),
		img = doc.createElement( 'img' ),
		wrapper = doc.createElement( 'div' ),
		captionData = data.slice( 1, -1 );

	img.setAttribute( 'src', dataElement.attributes.src );
	img.setAttribute( 'width', width );
	img.setAttribute( 'height', height );
	if ( dataElement.attributes.alt !== undefined ) {
		img.setAttribute( 'alt', dataElement.attributes.alt );
	}
	figure.appendChild( img );

	// If length of captionData is smaller or equal to 2 it means that there is no caption or that
	// it is empty - in both cases we are going to skip appending <figcaption>.
	if ( captionData.length > 2 ) {
		converter.getDomSubtreeFromData( data.slice( 1, -1 ), wrapper );
		while ( wrapper.firstChild ) {
			figure.appendChild( wrapper.firstChild );
		}
	}
	return [ figure ];
};

/* Methods */

/**
 * Get the caption node of the image.
 *
 * @method
 * @returns {ve.dm.BlockImageCaptionNode|null} Caption node, if present
 */
ve.dm.BlockImageNode.prototype.getCaptionNode = function () {
	var node = this.children[0];
	return node instanceof ve.dm.BlockImageCaptionNode ? node : null;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.BlockImageNode );
