/*!
 * VisualEditor DataModel MWInlineImage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki image node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @mixins ve.dm.MWImageNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWInlineImageNode = function VeDmMWInlineImageNode() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );

	// Mixin constructors
	ve.dm.MWImageNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWInlineImageNode, ve.dm.LeafNode );

// Need to mixin base class as well
OO.mixinClass( ve.dm.MWInlineImageNode, ve.dm.GeneratedContentNode );

OO.mixinClass( ve.dm.MWInlineImageNode, ve.dm.MWImageNode );

/* Static Properties */

ve.dm.MWInlineImageNode.static.rdfaToType = {
	'mw:Image': 'none',
	'mw:Image/Frameless': 'frameless'
};

ve.dm.MWInlineImageNode.static.isContent = true;

ve.dm.MWInlineImageNode.static.name = 'mwInlineImage';

ve.dm.MWInlineImageNode.static.storeHtmlAttributes = {
	blacklist: [ 'typeof', 'class', 'src', 'resource', 'width', 'height', 'href' ]
};

ve.dm.MWInlineImageNode.static.matchTagNames = [ 'span' ];

ve.dm.MWInlineImageNode.static.blacklistedAnnotationTypes = [ 'link' ];

ve.dm.MWInlineImageNode.static.getMatchRdfaTypes = function () {
	return ve.getObjectKeys( this.rdfaToType );
};

ve.dm.MWInlineImageNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement,
		$span = $( domElements[0] ),
		$firstChild = $span.children().first(), // could be <span> or <a>
		$img = $firstChild.children().first(),
		typeofAttr = $span.attr( 'typeof' ),
		classes = $span.attr( 'class' ),
		recognizedClasses = [],
		attributes = {
			type: this.rdfaToType[typeofAttr],
			src: $img.attr( 'src' ),
			resource: $img.attr( 'resource' ),
			originalClasses: classes
		},
		width = $img.attr( 'width' ),
		height = $img.attr( 'height' );

	attributes.width = width !== undefined && width !== '' ? Number( width ) : null;
	attributes.height = height !== undefined && height !== '' ? Number( height ) : null;

	attributes.isLinked = $firstChild.is( 'a' );
	if ( attributes.isLinked ) {
		attributes.href = $firstChild.attr( 'href' );
	}

	// Extract individual classes
	classes = typeof classes === 'string' ? classes.trim().split( /\s+/ ) : [];

	// Deal with border flag
	if ( classes.indexOf( 'mw-image-border' ) !== -1 ) {
		attributes.borderImage = true;
		recognizedClasses.push( 'mw-image-border' );
	}
	// Vertical alignment
	if ( classes.indexOf( 'mw-valign-middle' ) !== -1 ) {
		attributes.valign = 'middle';
		recognizedClasses.push( 'mw-valign-middle' );
	} else if ( classes.indexOf( 'mw-valign-baseline' ) !== -1 ) {
		attributes.valign = 'baseline';
		recognizedClasses.push( 'mw-valign-baseline' );
	} else if ( classes.indexOf( 'mw-valign-sub' ) !== -1 ) {
		attributes.valign = 'sub';
		recognizedClasses.push( 'mw-valign-sub' );
	} else if ( classes.indexOf( 'mw-valign-super' ) !== -1 ) {
		attributes.valign = 'super';
		recognizedClasses.push( 'mw-valign-super' );
	} else if ( classes.indexOf( 'mw-valign-top' ) !== -1 ) {
		attributes.valign = 'top';
		recognizedClasses.push( 'mw-valign-top' );
	} else if ( classes.indexOf( 'mw-valign-text-top' ) !== -1 ) {
		attributes.valign = 'text-top';
		recognizedClasses.push( 'mw-valign-text-top' );
	} else if ( classes.indexOf( 'mw-valign-bottom' ) !== -1 ) {
		attributes.valign = 'bottom';
		recognizedClasses.push( 'mw-valign-bottom' );
	} else if ( classes.indexOf( 'mw-valign-text-bottom' ) !== -1 ) {
		attributes.valign = 'text-bottom';
		recognizedClasses.push( 'mw-valign-text-bottom' );
	} else {
		attributes.valign = 'default';
	}

	// Border
	if ( classes.indexOf( 'mw-image-border' ) !== -1 ) {
		attributes.borderImage = true;
		recognizedClasses.push( 'mw-image-border' );
	}

	// Default-size
	if ( classes.indexOf( 'mw-default-size' ) !== -1 ) {
		attributes.defaultSize = true;
		recognizedClasses.push( 'mw-default-size' );
	}

	// Store unrecognized classes so we can restore them on the way out
	attributes.unrecognizedClasses = OO.simpleArrayDifference( classes, recognizedClasses );

	dataElement = { type: this.name, attributes: attributes };

	this.storeGeneratedContents( dataElement, dataElement.attributes.src, converter.getStore() );

	return dataElement;
};

ve.dm.MWInlineImageNode.static.toDomElements = function ( data, doc ) {
	var firstChild,
		span = doc.createElement( 'span' ),
		img = doc.createElement( 'img' ),
		classes = [],
		originalClasses = data.attributes.originalClasses,
		rdfa;

	ve.setDomAttributes( img, data.attributes, [ 'src', 'width', 'height', 'resource' ] );

	// Checking hasOwnProperty because subclasses may implement their own rdfaToType (Wikia VE-1533).
	if ( !this.hasOwnProperty( 'typeToRdfa' ) ) {
		this.typeToRdfa = {};
		for ( rdfa in this.rdfaToType ) {
			this.typeToRdfa[this.rdfaToType[rdfa]] = rdfa;
		}
	}

	span.setAttribute( 'typeof', this.typeToRdfa[data.attributes.type] );

	if ( data.attributes.defaultSize ) {
		classes.push( 'mw-default-size' );
	}

	if ( data.attributes.borderImage ) {
		classes.push( 'mw-image-border' );
	}

	if ( data.attributes.valign && data.attributes.valign !== 'default' ) {
		classes.push( 'mw-valign-' + data.attributes.valign );
	}

	if ( data.attributes.unrecognizedClasses ) {
		classes = OO.simpleArrayUnion( classes, data.attributes.unrecognizedClasses );
	}

	if (
		originalClasses &&
		ve.compare( originalClasses.trim().split( /\s+/ ).sort(), classes.sort() )
	) {
		span.className = originalClasses;
	} else if ( classes.length > 0 ) {
		span.className = classes.join( ' ' );
	}

	if ( data.attributes.isLinked ) {
		firstChild = doc.createElement( 'a' );
		firstChild.setAttribute( 'href', data.attributes.href );
	} else {
		firstChild = doc.createElement( 'span' );
	}

	span.appendChild( firstChild );
	firstChild.appendChild( img );

	return [ span ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWInlineImageNode );
