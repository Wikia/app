/*!
 * VisualEditor DataModel MWInternalLinkAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * DataModel MediaWiki internal link annotation.
 *
 * Example HTML sources:
 *
 *     <a rel="mw:WikiLink">
 *
 * @class
 * @extends ve.dm.LinkAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.MWInternalLinkAnnotation = function VeDmMWInternalLinkAnnotation( element ) {
	// Parent constructor
	ve.dm.LinkAnnotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWInternalLinkAnnotation, ve.dm.LinkAnnotation );

/* Static Properties */

ve.dm.MWInternalLinkAnnotation.static.name = 'link/mwInternal';

ve.dm.MWInternalLinkAnnotation.static.matchRdfaTypes = ['mw:WikiLink'];

ve.dm.MWInternalLinkAnnotation.static.toDataElement = function ( domElements ) {
	// Get title from href
	// The href is simply the title, unless we're dealing with a page that has slashes in its name
	// in which case it's preceded by one or more instances of "./" or "../", so strip those
	/*jshint regexp:false */
	var matches = domElements[0].getAttribute( 'href' ).match( /^((?:\.\.?\/)*)(.*)$/ ),
		// Normalize capitalisation and underscores
		normalizedTitle = ve.dm.MWInternalLinkAnnotation.static.normalizeTitle( matches[2] );
	return {
		'type': 'link/mwInternal',
		'attributes': {
			'hrefPrefix': matches[1],
			'title': decodeURIComponent( matches[2] ).replace( /_/g, ' ' ),
			'normalizedTitle': normalizedTitle,
			'origTitle': matches[2]
		}
	};
};

ve.dm.MWInternalLinkAnnotation.static.toDomElements = function ( dataElement, doc ) {
	var href,
		domElement = doc.createElement( 'a' ),
		title = dataElement.attributes.title,
		origTitle = dataElement.attributes.origTitle;
	if ( origTitle && decodeURIComponent( origTitle ).replace( /_/g, ' ' ) === title ) {
		// Restore href from origTitle
		href = origTitle;
		// Only use hrefPrefix if restoring from origTitle
		if ( dataElement.attributes.hrefPrefix ) {
			href = dataElement.attributes.hrefPrefix + href;
		}
	} else {
		href = encodeURIComponent( title );
	}
	domElement.setAttribute( 'href', href );
	domElement.setAttribute( 'rel', 'mw:WikiLink' );
	return [ domElement ];
};

/**
 * Normalize title for comparison purposes
 * @param {string} title Original title
 * @returns {string} Normalized title
 */
ve.dm.MWInternalLinkAnnotation.static.normalizeTitle = function ( title ) {
	var normalizedTitle = title;
	try {
		normalizedTitle = new mw.Title( title ).getPrefixedText();
	} catch ( e ) {}
	return normalizedTitle;
};

/* Methods */

/**
 * @returns {Object}
 */
ve.dm.MWInternalLinkAnnotation.prototype.getComparableObject = function () {
	return {
		'type': this.getType(),
		'normalizedTitle': this.getAttribute( 'normalizedTitle' )
	};
};

/** */
ve.dm.MWInternalLinkAnnotation.prototype.getComparableHtmlAttributes = function () {
	var attributes = ve.dm.Annotation.prototype.getComparableHtmlAttributes.call( this );
	delete attributes.href;
	delete attributes.rel;
	return attributes;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWInternalLinkAnnotation );
