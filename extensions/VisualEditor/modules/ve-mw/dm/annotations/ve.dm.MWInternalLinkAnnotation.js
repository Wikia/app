/*!
 * VisualEditor DataModel MWInternalLinkAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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
	var targetData = this.getTargetDataFromHref(
		domElements[0].getAttribute( 'href' ),
		converter.getTargetHtmlDocument()
	);

	return {
		type: this.name,
		attributes: {
			hrefPrefix: targetData.hrefPrefix,
			title: decodeURIComponent( targetData.title ).replace( /_/g, ' ' ),
			normalizedTitle: this.normalizeTitle( targetData.title ),
			lookupTitle: this.getLookupTitle( targetData.title ),
			origTitle: targetData.title
		}
	};
};

/**
 * Parse URL to get title it points to.
 * @param {string} href
 * @param {HTMLDocument|string} doc Document whose base URL to use, or base URL as a string.
 * @returns {Object} Plain object with 'title' and 'hrefPrefix' keys.
 */
ve.dm.MWInternalLinkAnnotation.static.getTargetDataFromHref = function ( href, doc ) {
	function regexEscape( str ) {
		return str.replace( /([.?*+^$[\]\\(){}|-])/g, '\\$1' );
	}

	var // Protocol relative base
		relativeBase = ve.resolveUrl( mw.config.get( 'wgArticlePath' ), doc ).toString().replace( /^https?:/, '' ),
		relativeBaseRegex = new RegExp( regexEscape( relativeBase ).replace( regexEscape( '$1' ), '(.*)' ) ),
		// Protocol relative href
		relativeHref = href.replace( /^https?:/, '' ),
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

	return { title: matches[2], hrefPrefix: matches[1] };
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
 * E.g. capitalisation and underscores.
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
 * @inheritdoc
 */
ve.dm.MWInternalLinkAnnotation.prototype.getComparableObject = function () {
	return {
		type: this.getType(),
		normalizedTitle: this.getAttribute( 'normalizedTitle' )
	};
};

/**
 * @inheritdoc
 */
ve.dm.MWInternalLinkAnnotation.prototype.getComparableHtmlAttributes = function () {
	var attributes = ve.dm.Annotation.prototype.getComparableHtmlAttributes.call( this );
	delete attributes.href;
	delete attributes.rel;
	return attributes;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWInternalLinkAnnotation );
