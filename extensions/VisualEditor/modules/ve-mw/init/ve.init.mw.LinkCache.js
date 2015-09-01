/*!
 * VisualEditor MediaWiki Initialization LinkCache class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Caches information about titles.
 *
 * @class
 * @extends ve.init.mw.ApiResponseCache
 * @constructor
 */
ve.init.mw.LinkCache = function VeInitMwLinkCache() {
	ve.init.mw.LinkCache.super.call( this );

	// Keys are page names, values are link data objects
	// This is kept for synchronous retrieval of cached values via #getCached
	this.cacheValues = {};
};

/* Inheritance */

OO.inheritClass( ve.init.mw.LinkCache, ve.init.mw.ApiResponseCache );

/* Static methods */

/**
 * Get the icon name to use for a particular link type
 *
 * @param {Object} linkData Link data
 * @return {string} Icon name
 */
ve.init.mw.LinkCache.static.getIconForLink = function ( linkData ) {
	if ( linkData.missing ) {
		return 'page-not-found';
	}
	if ( linkData.redirect ) {
		return 'page-redirect';
	}
	if ( linkData.disambiguation ) {
		return 'page-disambiguation';
	}
	return 'page-existing';
};

/**
 * @inheritdoc
 */
ve.init.mw.LinkCache.static.processPage = function ( page ) {
	return {
		missing: page.missing !== undefined,
		redirect: page.redirect !== undefined,
		disambiguation: ve.getProp( page, 'pageprops', 'disambiguation' ) !== undefined,
		imageUrl: ve.getProp( page, 'thumbnail', 'source' ),
		description: ve.getProp( page, 'terms', 'description' )
	};
};

/* Methods */

/**
 * Requests information about the title, then adds classes to the provided element as appropriate.
 *
 * @param {string} title
 * @param {jQuery} $element Element to style
 */
ve.init.mw.LinkCache.prototype.styleElement = function ( title, $element ) {
	var promise,
		cachedMissingData = this.getCached( '_missing/' + title );

	// Use the synchronous missing link cache data if it exists
	if ( cachedMissingData ) {
		promise = $.Deferred().resolve( cachedMissingData ).promise();
	} else {
		promise = this.get( title );
	}

	promise.done( function ( data ) {
		if ( data.missing ) {
			$element.addClass( 'new' );
		} else {
			// Provided by core MediaWiki, no styles by default.
			if ( data.redirect ) {
				$element.addClass( 'mw-redirect' );
			}
			// Should be provided by the Disambiguator extension, but no one has yet written a suitably
			// performant patch to do it. It is instead implemented in JavaScript in on-wiki gadgets.
			if ( data.disambiguation ) {
				$element.addClass( 'mw-disambig' );
			}
		}
	} );
};

/**
 * Enable or disable automatic assumption of existence.
 *
 * While enabled, any get() for a title that's not already in the cache will return
 * { missing: false } and write that to the cache.
 *
 * @param {boolean} assume Assume all uncached titles exist
 */
ve.init.mw.LinkCache.prototype.setAssumeExistence = function ( assume ) {
	this.assumeExistence = !!assume;
};

/**
 * Set link missing data
 *
 * Stored separately from the full link data cache
 *
 * @param {Object} entries Object keyed by page title, with the values being data objects
 */
ve.init.mw.LinkCache.prototype.setMissing = function ( entries ) {
	var name, missingEntries = {};
	for ( name in entries ) {
		missingEntries[ '_missing/' + name ] = entries[ name ];
	}
	this.set( missingEntries );
};

/**
 * @inheritdoc
 */
ve.init.mw.LinkCache.prototype.get = function ( title ) {
	var data = {};
	if ( this.assumeExistence ) {
		data[ this.constructor.static.normalizeTitle( title ) ] = { missing: false };
		this.setMissing( data );
	}

	// Parent method
	return ve.init.mw.LinkCache.super.prototype.get.call( this, title );
};

/**
 * @inheritdoc
 */
ve.init.mw.LinkCache.prototype.getRequestPromise = function ( subqueue ) {
	return new mw.Api().get( {
		action: 'query',
		prop: 'info|pageprops|pageimages|pageterms',
		pithumbsize: 80,
		pilimit: subqueue.length,
		wbptterms: 'description',
		ppprop: 'disambiguation',
		titles: subqueue.join( '|' ),
		continue: ''
	} );
};
