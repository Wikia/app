/*!
 * VisualEditor DataModel MWInternalLinkAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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

OO.inheritClass( ve.dm.MWInternalLinkAnnotation, ve.dm.LinkAnnotation );

/* Static Properties */

ve.dm.MWInternalLinkAnnotation.static.name = 'link/mwInternal';

ve.dm.MWInternalLinkAnnotation.static.matchRdfaTypes = ['mw:WikiLink'];

ve.dm.MWInternalLinkAnnotation.static.toDataElement = function ( domElements, converter ) {

	function regexEscape( str ) {
		return str.replace( /([.?*+^$[\]\\(){}|-])/g, '\\$1' );
	}

	var matches, normalizedTitle, lookupTitle,
		doc = converter.getTargetHtmlDocument(),
		// Protocol relative base
		relativeBase = ve.resolveUrl( mw.config.get( 'wgArticlePath' ), doc ).toString().replace( /^https?:/, '' ),
		relativeBaseRegex = new RegExp( regexEscape( relativeBase ).replace( regexEscape( '$1' ), '(.*)' ) ),
		href = domElements[0].getAttribute( 'href' ),
		// Protocol relative href
		relativeHref = href.replace( /^https?:/, '' );

	// Check if this matches the server's article path
	matches = relativeHref.match ( relativeBaseRegex );
	if ( matches ) {
		// Take the relative path
		href = matches[1];
	}

	// The href is simply the title, unless we're dealing with a page that has slashes in its name
	// in which case it's preceded by one or more instances of "./" or "../", so strip those
	/*jshint regexp:false */
	matches = href.match( /^((?:\.\.?\/)*)(.*)$/ );
	// Normalize capitalisation and underscores
	normalizedTitle = this.normalizeTitle( matches[2] );
	lookupTitle = this.getLookupTitle( matches[2] );

	return {
		'type': this.name,
		'attributes': {
			'hrefPrefix': matches[1],
			'title': decodeURIComponent( matches[2] ).replace( /_/g, ' ' ),
			'normalizedTitle': normalizedTitle,
			'lookupTitle': lookupTitle,
			'origTitle': matches[2]
		}
	};
};

ve.dm.MWInternalLinkAnnotation.static.toDomElements = function ( dataElement, doc ) {
	var parentResult = ve.dm.LinkAnnotation.static.toDomElements.call( this, dataElement, doc );
	parentResult[0].setAttribute( 'rel', 'mw:WikiLink' );
	return parentResult;
};

ve.dm.MWInternalLinkAnnotation.static.getHref = function ( dataElement ) {
	var href,
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
	return href;
};

/**
 * Normalize title for comparison purposes.
 * @param {string} title Original title
 * @returns {string} Normalized title, or the original if it is invalid
 */
ve.dm.MWInternalLinkAnnotation.static.normalizeTitle = function ( original ) {
	var title = mw.Title.newFromText( original );
	if ( !title ) {
		return original;
	}
	return title.getPrefixedText() + ( title.getFragment() !== null ? '#' + title.getFragment() : '' );
};

/**
 * Normalize title for lookup (search suggestion, existence) purposes.
 * @param {string} title Original title
 * @returns {string} Normalized title, or the original if it is invalid
 */
ve.dm.MWInternalLinkAnnotation.static.getLookupTitle = function ( original ) {
	var title = mw.Title.newFromText( original );
	if ( !title ) {
		return original;
	}
	return title.getPrefixedText();
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
