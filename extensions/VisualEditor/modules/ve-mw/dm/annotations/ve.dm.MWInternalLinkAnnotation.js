/*!
 * VisualEditor DataModel MWInternalLinkAnnotation class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
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

ve.dm.MWInternalLinkAnnotation.static.matchRdfaTypes = [ 'mw:WikiLink' ];

ve.dm.MWInternalLinkAnnotation.static.toDataElement = function ( domElements, converter ) {
	var targetData = this.getTargetDataFromHref(
		domElements[ 0 ].getAttribute( 'href' ),
		converter.getTargetHtmlDocument()
	);

	return {
		type: this.name,
		attributes: {
			hrefPrefix: targetData.hrefPrefix,
			title: ve.safeDecodeURIComponent( targetData.title ).replace( /_/g, ' ' ),
			normalizedTitle: this.normalizeTitle( targetData.title ),
			lookupTitle: this.getLookupTitle( targetData.title ),
			origTitle: targetData.title
		}
	};
};

/**
 * Build a ve.dm.MWInternalLinkAnnotation from a given mw.Title.
 *
 * @param {mw.Title} title The title to link to.
 * @return {ve.dm.MWInternalLinkAnnotation} The annotation.
 */
ve.dm.MWInternalLinkAnnotation.static.newFromTitle = function ( title ) {
	var target = title.toText();

	if ( title.getNamespaceId() === 6 || title.getNamespaceId() === 14 ) {
		// File: or Category: link
		// We have to prepend a colon so this is interpreted as a link
		// rather than an image inclusion or categorization
		target = ':' + target;
	}

	return new ve.dm.MWInternalLinkAnnotation( {
		type: 'link/mwInternal',
		attributes: {
			title: target,
			normalizedTitle: ve.dm.MWInternalLinkAnnotation.static.normalizeTitle( title ),
			lookupTitle: ve.dm.MWInternalLinkAnnotation.static.getLookupTitle( title )
		}
	} );
};

/**
 * Parse URL to get title it points to.
 *
 * @param {string} href
 * @param {HTMLDocument|string} doc Document whose base URL to use, or base URL as a string.
 * @return {Object} Information about the given href
 * @return {string} return.title
 *    The title of the internal link, else the original href if href is external
 * @return {string} return.hrefPrefix
 *    Any ./ or ../ prefixes on a relative link
 * @return {boolean} return.isInternal
 *    True if the href pointed to the local wiki, false if href is external
 */
ve.dm.MWInternalLinkAnnotation.static.getTargetDataFromHref = function ( href, doc ) {
	var relativeBase, relativeBaseRegex, relativeHref, isInternal, matches;

	function regexEscape( str ) {
		return str.replace( /([.?*+^$[\]\\(){}|-])/g, '\\$1' );
	}

	// Protocol relative base
	relativeBase = ve.resolveUrl( mw.config.get( 'wgArticlePath' ), doc ).replace( /^https?:/, '' );
	relativeBaseRegex = new RegExp( regexEscape( relativeBase ).replace( regexEscape( '$1' ), '(.*)' ) );
	// Protocol relative href
	relativeHref = href.replace( /^https?:/, '' );
	// Paths without a host portion are assumed to be internal
	isInternal = !/^\/\//.test( relativeHref );
	// Check if this matches the server's article path
	matches = relativeHref.match( relativeBaseRegex );

	if ( matches ) {
		// Take the relative path
		href = matches[ 1 ];
		isInternal = true;
	}

	// The href is simply the title, unless we're dealing with a page that has slashes in its name
	// in which case it's preceded by one or more instances of "./" or "../", so strip those
	matches = href.match( /^((?:\.\.?\/)*)(.*)$/ );

	return { title: matches[ 2 ], hrefPrefix: matches[ 1 ], isInternal: isInternal };
};

ve.dm.MWInternalLinkAnnotation.static.toDomElements = function () {
	var parentResult = ve.dm.LinkAnnotation.static.toDomElements.apply( this, arguments );
	parentResult[ 0 ].setAttribute( 'rel', 'mw:WikiLink' );
	return parentResult;
};

ve.dm.MWInternalLinkAnnotation.static.getHref = function ( dataElement ) {
	var href,
		title = dataElement.attributes.title,
		origTitle = dataElement.attributes.origTitle;
	if ( origTitle !== undefined && ve.safeDecodeURIComponent( origTitle ).replace( /_/g, ' ' ) === title ) {
		// Restore href from origTitle
		href = origTitle;
		// Only use hrefPrefix if restoring from origTitle
		if ( dataElement.attributes.hrefPrefix ) {
			href = dataElement.attributes.hrefPrefix + href;
		}
	} else {
		// Don't escape slashes in the title; they represent subpages.
		href = title.split( '/' ).map( encodeURIComponent ).join( '/' );
	}
	return href;
};

/**
 * Normalize title for comparison purposes.
 * E.g. capitalisation and underscores.
 *
 * @param {string|mw.Title} original Original title
 * @return {string} Normalized title, or the original string if it is invalid
 */
ve.dm.MWInternalLinkAnnotation.static.normalizeTitle = function ( original ) {
	var title = original instanceof mw.Title ? original : mw.Title.newFromText( original );
	if ( !title ) {
		return original;
	}
	return title.getPrefixedText() + ( title.getFragment() !== null ? '#' + title.getFragment() : '' );
};

/**
 * Normalize title for lookup (search suggestion, existence) purposes.
 *
 * @param {string|mw.Title} original Original title
 * @return {string} Normalized title, or the original string if it is invalid
 */
ve.dm.MWInternalLinkAnnotation.static.getLookupTitle = function ( original ) {
	var title = original instanceof mw.Title ? original : mw.Title.newFromText( original );
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
	// Assume that wikitext never adds meaningful html attributes for comparison purposes,
	// although ideally this should be decided by Parsoid (Bug T95028).
	return {};
};

/**
 * @inheritdoc
 */
ve.dm.MWInternalLinkAnnotation.prototype.getDisplayTitle = function () {
	return this.getAttribute( 'normalizedTitle' );
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWInternalLinkAnnotation );
