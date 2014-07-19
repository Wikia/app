/*!
 * VisualEditor DataModel MWBlockImageNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
/*global mw */

/**
 * DataModel MediaWiki image node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @mixins ve.dm.MWImageNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.MWBlockImageNode = function VeDmMWBlockImageNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );

	// Mixin constructors
	ve.dm.MWImageNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWBlockImageNode, ve.dm.BranchNode );

// Need to mixin base class as well
OO.mixinClass( ve.dm.MWBlockImageNode, ve.dm.GeneratedContentNode );

OO.mixinClass( ve.dm.MWBlockImageNode, ve.dm.MWImageNode );

/* Static Properties */

ve.dm.MWBlockImageNode.static.rdfaToType = {
	'mw:Image/Thumb': 'thumb',
	'mw:Image/Frame': 'frame',
	'mw:Image/Frameless': 'frameless',
	'mw:Image': 'none'
};

ve.dm.MWBlockImageNode.static.name = 'mwBlockImage';

ve.dm.MWBlockImageNode.static.storeHtmlAttributes = {
	'blacklist': [ 'typeof', 'class', 'src', 'resource', 'width', 'height', 'href', 'rel' ]
};

ve.dm.MWBlockImageNode.static.handlesOwnChildren = true;

ve.dm.MWBlockImageNode.static.childNodeTypes = [ 'mwImageCaption' ];

ve.dm.MWBlockImageNode.static.captionNodeType = 'mwImageCaption';

ve.dm.MWBlockImageNode.static.matchTagNames = [ 'figure' ];

ve.dm.MWBlockImageNode.static.blacklistedAnnotationTypes = [ 'link' ];

ve.dm.MWBlockImageNode.static.getMatchRdfaTypes = function () {
	return ve.getObjectKeys( this.rdfaToType );
};

ve.dm.MWBlockImageNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement,
		$figure = $( domElements[0] ),
		// images with link='' have a span wrapper instead
		$imgWrapper = $figure.children( 'a, span' ).eq( 0 ),
		$img = $imgWrapper.children( 'img' ).eq( 0 ),
		$caption = $figure.children( 'figcaption' ).eq( 0 ),
		typeofAttr = $figure.attr( 'typeof' ),
		classes = $figure.attr( 'class' ),
		recognizedClasses = [],
		attributes = {
			type: this.rdfaToType[typeofAttr],
			href: $imgWrapper.attr( 'href' ) || '',
			src: $img.attr( 'src' ),
			resource: $img.attr( 'resource' ),
			originalClasses: classes
		},
		width = $img.attr( 'width' ),
		height = $img.attr( 'height' ),
		altText = $img.attr( 'alt' ),
		defaultThumbWidth = mw.config.get( 'wgVisualEditorConfig' )
			.defaultUserOptions.defaultthumbsize;

	if ( altText !== undefined ) {
		attributes.alt = altText;
	}

	// Extract individual classes
	classes = typeof classes === 'string' ? classes.trim().split( /\s+/ ) : [];

	// Deal with border flag
	if ( classes.indexOf( 'mw-image-border' ) !== -1 ) {
		attributes.borderImage = true;
		recognizedClasses.push( 'mw-image-border' );
	}

	// Horizontal alignment
	if ( classes.indexOf( 'mw-halign-left' ) !== -1 ) {
		attributes.align = 'left';
		recognizedClasses.push( 'mw-halign-left' );
	} else if ( classes.indexOf( 'mw-halign-right' ) !== -1 ) {
		attributes.align = 'right';
		recognizedClasses.push( 'mw-halign-right' );
	} else if ( classes.indexOf( 'mw-halign-center' ) !== -1 ) {
		attributes.align = 'center';
		recognizedClasses.push( 'mw-halign-center' );
	} else if ( classes.indexOf( 'mw-halign-none' ) !== -1 ) {
		attributes.align = 'none';
		recognizedClasses.push( 'mw-halign-none' );
	} else {
		attributes.align = 'default';
	}

	attributes.width = width !== undefined && width !== '' ? Number( width ) : null;
	attributes.height = height !== undefined && height !== '' ? Number( height ) : null;

	// Default-size
	if ( classes.indexOf( 'mw-default-size' ) !== -1 ) {
		// Flag as default size
		attributes.defaultSize = true;
		recognizedClasses.push( 'mw-default-size' );
		// Force wiki-default size for thumb and frameless
		if (
			attributes.type === 'thumb' ||
			attributes.type === 'frameless'
		) {
			// We're gonna change .width and .height, store the original
			// values so we can restore them later.
			// FIXME "just" don't modify .width and .height instead
			attributes.originalWidth = attributes.width;
			attributes.originalHeight = attributes.height;
			// Parsoid hands us images with default Wikipedia dimensions
			// rather than default MediaWiki configuration dimensions.
			// We must force local wiki default in edit mode for default
			// size images.
			// Only change the image size to default if the image isn't
			// smaller than the default size
			if (
				attributes.width > defaultThumbWidth
			) {
				if ( attributes.height !== null ) {
					attributes.height = Math.round( ( attributes.height / attributes.width ) * defaultThumbWidth );
				}
				attributes.width = defaultThumbWidth;
			}
		}
	}

	// Store unrecognized classes so we can restore them on the way out
	attributes.unrecognizedClasses = OO.simpleArrayDifference( classes, recognizedClasses );

	dataElement = { 'type': this.name, 'attributes': attributes };

	this.storeGeneratedContents( dataElement, dataElement.attributes.src, converter.getStore() );

	if ( $caption.length === 0 ) {
		return [
			dataElement,
			{ 'type': this.captionNodeType },
			{ 'type': '/' + this.captionNodeType },
			{ 'type': '/' + this.name }
		];
	} else {
		return [ dataElement ].
			concat( converter.getDataFromDomClean( $caption[0], { 'type': this.captionNodeType } ) ).
			concat( [ { 'type': '/' + this.name } ] );
	}
};

// TODO: Consider using jQuery instead of pure JS.
// TODO: At this moment node is not resizable but when it will be then adding defaultSize class
// should be more conditional.
ve.dm.MWBlockImageNode.static.toDomElements = function ( data, doc, converter ) {
	var rdfa, width, height,
		dataElement = data[0],
		figure = doc.createElement( 'figure' ),
		imgWrapper = doc.createElement( dataElement.attributes.href !== '' ? 'a' : 'span' ),
		img = doc.createElement( 'img' ),
		wrapper = doc.createElement( 'div' ),
		classes = [],
		originalClasses = dataElement.attributes.originalClasses,
		captionData = data.slice( 1, -1 );

	if ( !this.typeToRdfa ) {
		this.typeToRdfa = {};
		for ( rdfa in this.rdfaToType ) {
			this.typeToRdfa[this.rdfaToType[rdfa]] = rdfa;
		}
	}

	// Type
	figure.setAttribute( 'typeof', this.typeToRdfa[dataElement.attributes.type] );
	if ( dataElement.attributes.borderImage === true ) {
		classes.push( 'mw-image-border' );
	}

	// Apply classes if size is default
	if ( dataElement.attributes.defaultSize === true ) {
		classes.push( 'mw-default-size' );
	}

	// Horizontal alignment
	switch ( dataElement.attributes.align ) {
		case 'left':
			classes.push( 'mw-halign-left' );
			break;
		case 'right':
			classes.push( 'mw-halign-right' );
			break;
		case 'center':
			classes.push( 'mw-halign-center' );
			break;
		case 'none':
			classes.push( 'mw-halign-none' );
			break;
	}

	if ( dataElement.attributes.unrecognizedClasses ) {
		classes = OO.simpleArrayUnion( classes, dataElement.attributes.unrecognizedClasses );
	}

	if (
		originalClasses &&
		ve.compare( originalClasses.trim().split( /\s+/ ).sort(), classes.sort() )
	) {
		figure.className = originalClasses;
	} else if ( classes.length > 0 ) {
		figure.className = classes.join( ' ' );
	}
	if ( dataElement.attributes.href !== '' ) {
		imgWrapper.setAttribute( 'href', dataElement.attributes.href );
	}

	width = dataElement.attributes.width;
	height = dataElement.attributes.height;
	// If defaultSize is set, and was set on the way in, use the original width and height
	// we got on the way in.
	if ( dataElement.attributes.defaultSize ) {
		if ( dataElement.attributes.originalWidth !== undefined ) {
			width = dataElement.attributes.originalWidth;
		}
		if ( dataElement.attributes.originalHeight !== undefined ) {
			height = dataElement.attributes.originalHeight;
		}
	}

	img.setAttribute( 'src', dataElement.attributes.src );
	img.setAttribute( 'width', width );
	img.setAttribute( 'height', height );
	img.setAttribute( 'resource', dataElement.attributes.resource );
	if ( dataElement.attributes.alt !== undefined ) {
		img.setAttribute( 'alt', dataElement.attributes.alt );
	}
	figure.appendChild( imgWrapper );
	imgWrapper.appendChild( img );

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
 * @returns {ve.dm.MWImageCaptionNode|null} Caption node, if present
 */
ve.dm.MWBlockImageNode.prototype.getCaptionNode = function () {
	var node = this.children[0];
	return node instanceof ve.dm.MWImageCaptionNode ? node : null;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWBlockImageNode );
