/*!
 * VisualEditor DataModel MWBlockImageNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki image node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @mixins ve.dm.MWImageNode
 * @mixins ve.dm.ClassAttributeNode
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
	ve.dm.ClassAttributeNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWBlockImageNode, ve.dm.BranchNode );

// Need to mixin base class as well
OO.mixinClass( ve.dm.MWBlockImageNode, ve.dm.GeneratedContentNode );

OO.mixinClass( ve.dm.MWBlockImageNode, ve.dm.MWImageNode );

OO.mixinClass( ve.dm.MWBlockImageNode, ve.dm.ClassAttributeNode );

/* Static Properties */

ve.dm.MWBlockImageNode.static.rdfaToType = {
	'mw:Image/Thumb': 'thumb',
	'mw:Image/Frame': 'frame',
	'mw:Image/Frameless': 'frameless',
	'mw:Image': 'none'
};

ve.dm.MWBlockImageNode.static.name = 'mwBlockImage';

ve.dm.MWBlockImageNode.static.preserveHtmlAttributes = function ( attribute ) {
	var attributes = [ 'typeof', 'class', 'src', 'resource', 'width', 'height', 'href', 'rel' ];
	return attributes.indexOf( attribute ) === -1;
};

ve.dm.MWBlockImageNode.static.handlesOwnChildren = true;

ve.dm.MWBlockImageNode.static.ignoreChildren = true;

ve.dm.MWBlockImageNode.static.childNodeTypes = [ 'mwImageCaption' ];

ve.dm.MWBlockImageNode.static.matchTagNames = [ 'figure' ];

ve.dm.MWBlockImageNode.static.blacklistedAnnotationTypes = [ 'link' ];

ve.dm.MWBlockImageNode.static.getMatchRdfaTypes = function () {
	return Object.keys( this.rdfaToType );
};

ve.dm.MWBlockImageNode.static.allowedRdfaTypes = [ 'mw:Error' ];

ve.dm.MWBlockImageNode.static.classAttributes = {
	'mw-image-border': { borderImage: true },
	'mw-halign-left': { align: 'left' },
	'mw-halign-right': { align: 'right' },
	'mw-halign-center': { align: 'center' },
	'mw-halign-none': { align: 'none' },
	'mw-default-size': { defaultSize: true }
};

ve.dm.MWBlockImageNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement, newDimensions, attributes,
		figure, imgWrapper, img, caption,
		classAttr, typeofAttrs, errorIndex, width, height, altText;

	// Workaround for jQuery's .children() being expensive due to
	// https://github.com/jquery/sizzle/issues/311
	function findChildren( parent, nodeNames ) {
		return Array.prototype.filter.call( parent.childNodes, function ( element ) {
			return nodeNames.indexOf( element.nodeName.toLowerCase() ) !== -1;
		} );
	}

	figure = domElements[ 0 ];
	imgWrapper = findChildren( figure, [ 'a', 'span' ] )[ 0 ] || null;
	img = imgWrapper && findChildren( imgWrapper, [ 'img' ] )[ 0 ] || null;
	caption = findChildren( figure, [ 'figcaption' ] )[ 0 ] || null;
	classAttr = figure.getAttribute( 'class' );
	typeofAttrs = figure.getAttribute( 'typeof' ).split( ' ' );
	errorIndex = typeofAttrs.indexOf( 'mw:Error' );
	width = img && img.getAttribute( 'width' );
	height = img && img.getAttribute( 'height' );
	altText = img && img.getAttribute( 'alt' );

	if ( errorIndex !== -1 ) {
		typeofAttrs.splice( errorIndex, 1 );
	}
	attributes = {
		type: this.rdfaToType[ typeofAttrs[ 0 ] ],
		href: imgWrapper && imgWrapper.getAttribute( 'href' ) || '',
		src: img && img.getAttribute( 'src' ),
		resource: img && img.getAttribute( 'resource' )
	};

	if ( altText !== null ) {
		attributes.alt = altText;
	}
	if ( errorIndex !== -1 ) {
		attributes.isError = true;
	}

	this.setClassAttributes( attributes, classAttr );

	attributes.align = attributes.align || 'default';

	attributes.width = width !== null && width !== '' ? Number( width ) : null;
	attributes.height = height !== null && height !== '' ? Number( height ) : null;

	// Default-size
	if ( attributes.defaultSize ) {
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
			newDimensions = ve.dm.MWImageNode.static.scaleToThumbnailSize( attributes );
			if ( newDimensions ) {
				attributes.width = newDimensions.width;
				attributes.height = newDimensions.height;
			}
		}
	}

	dataElement = { type: this.name, attributes: attributes };

	this.storeGeneratedContents( dataElement, dataElement.attributes.src, converter.getStore() );

	if ( caption ) {
		return [ dataElement ]
			.concat( converter.getDataFromDomClean( caption, { type: 'mwImageCaption' } ) )
			.concat( [ { type: '/' + this.name } ] );
	} else {
		return [
			dataElement,
			{ type: 'mwImageCaption' },
			{ type: '/mwImageCaption' },
			{ type: '/' + this.name }
		];
	}
};

// TODO: At this moment node is not resizable but when it will be then adding defaultSize class
// should be more conditional.
ve.dm.MWBlockImageNode.static.toDomElements = function ( data, doc, converter ) {
	var rdfa, width, height,
		dataElement = data[ 0 ],
		figure = doc.createElement( 'figure' ),
		imgWrapper = doc.createElement( dataElement.attributes.href !== '' ? 'a' : 'span' ),
		img = doc.createElement( 'img' ),
		wrapper = doc.createElement( 'div' ),
		classAttr = this.getClassAttrFromAttributes( dataElement.attributes ),
		captionData = data.slice( 1, -1 );

	if ( !this.typeToRdfa ) {
		this.typeToRdfa = {};
		for ( rdfa in this.rdfaToType ) {
			this.typeToRdfa[ this.rdfaToType[ rdfa ] ] = rdfa;
		}
	}

	// Type
	figure.setAttribute( 'typeof', this.typeToRdfa[ dataElement.attributes.type ] );

	if ( classAttr ) {
		figure.className = classAttr;
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
 * @return {ve.dm.MWImageCaptionNode|null} Caption node, if present
 */
ve.dm.MWBlockImageNode.prototype.getCaptionNode = function () {
	var node = this.children[ 0 ];
	return node instanceof ve.dm.MWImageCaptionNode ? node : null;
};

/* Registration */

ve.dm.modelRegistry.unregister( ve.dm.BlockImageNode );
ve.dm.modelRegistry.register( ve.dm.MWBlockImageNode );
