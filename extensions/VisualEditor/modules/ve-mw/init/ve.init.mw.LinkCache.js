/*!
 * VisualEditor MediaWiki Initialization LinkCache class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
( function () {
	var hasOwn = Object.prototype.hasOwnProperty;

	// TODO should reuse ve.dm.MWInternalLinkAnnotation#getLookupTitle once factored out
	function normalizeTitle( name ) {
		var title = mw.Title.newFromText( name );
		if ( !title ) {
			return name;
		}
		return title.getPrefixedText();
	}

	/**
	 * MediaWiki link status cache.
	 *
	 * Used to track how to style links to a given page based on their existence status etc.
	 *
	 * @class
	 *
	 * @constructor
	 */
	ve.init.mw.LinkCache = function VeInitMwLinkCache() {
		// Mixin constructor
		OO.EventEmitter.call( this );

		// Keys are page names, values are deferreds
		this.cache = {};

		// Keys are page names, values are link data objects
		// This is kept for synchronous retrieval of cached values via #getCached
		this.cacheValues = {};

		// Array of page names queued to be looked up
		this.queue = [];

		this.schedule = ve.debounce( this.processQueue.bind( this ), 0 );
	};

	OO.mixinClass( ve.init.mw.LinkCache, OO.EventEmitter );

	// TODO maybe factor out generic parts into ve.StatusCache or whatever
	// TODO unit tests

	/**
	 * Fired when a new entry is added to the cache.
	 * @event add
	 * @param {Object} entries Cache entries that were added. Object mapping names to data objects.
	 */

	/**
	 * Look up data about a page in the cache. If the data about this page is already in the cache,
	 * this returns an already-resolved promise. Otherwise, it returns a pending promise and schedules
	 * an API call to retrieve the data.
	 *
	 * @param {string} name Normalized page title
	 * @returns {jQuery.Promise} Promise that will be resolved with the data once it's available
	 */
	ve.init.mw.LinkCache.prototype.get = function ( name ) {
		if ( typeof name !== 'string' ) {
			// Don't bother letting things like undefined or null make it all the way through,
			// just reject them here. Otherwise they'll cause problems or exceptions at random
			// other points in this file.
			return $.Deferred().reject().promise();
		}
		if ( !hasOwn.call( this.cache, name ) ) {
			this.cache[name] = $.Deferred();
			this.queue.push( name );
			this.schedule();
		}
		return this.cache[name].promise();
	};

	/**
	 * Look up data about a page in the cache. If the data about this page is already in the cache,
	 * this returns that data. Otherwise, it returns undefined.
	 *
	 * @param {string} name Normalized page title
	 * @returns {Object|undefined} Cache data for this name.
	 */
	ve.init.mw.LinkCache.prototype.getCached = function ( name ) {
		if ( hasOwn.call( this.cacheValues, name ) ) {
			return this.cacheValues[name];
		}
	};

	/**
	 * Requests information about the title, then adds classes to the provided element as appropriate.
	 *
	 * @param {string} title
	 * @param {jQuery} $element Element to style
	 */
	ve.init.mw.LinkCache.prototype.styleElement = function ( title, $element ) {
		this.get( title ).done( function ( data ) {
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
	 * Add entries to the cache.
	 * @param {Object} entries Object keyed by page title, with the values being data objects
	 * @fires add
	 */
	ve.init.mw.LinkCache.prototype.set = function ( entries ) {
		var name;
		for ( name in entries ) {
			if ( !hasOwn.call( this.cache, name ) ) {
				this.cache[name] = $.Deferred();
			}
			this.cache[name].resolve( entries[name] );
			this.cacheValues[name] = entries[name];
		}
		this.emit( 'add', ve.getObjectKeys( entries ) );
	};

	/**
	 * Perform any scheduled API requests.
	 * @private
	 * @fires add
	 */
	ve.init.mw.LinkCache.prototype.processQueue = function () {
		var subqueue, queue, linkCache = this;

		function rejectSubqueue() {
			var i, len;
			for ( i = 0, len = subqueue.length; i < len; i++ ) {
				linkCache.cache[subqueue[i]].reject();
			}
		}

		function processData( data ) {
			var pageid, page, info,
				pages = data.query && data.query.pages,
				processed = {};
			if ( pages ) {
				for ( pageid in pages ) {
					page = pages[pageid];
					info = {
						missing: page.missing !== undefined,
						redirect: page.redirect !== undefined,
						// Disambiguator extension
						disambiguation: page.pageprops && page.pageprops.disambiguation !== undefined
					};
					processed[page.title] = info;
				}
				linkCache.set( processed );
			}

			// Reject everything in subqueue; this will only reject the ones
			// that weren't already resolved above, because .reject() on an
			// already resolved Deferred is a no-op.
			rejectSubqueue();
		}

		queue = this.queue;
		this.queue = [];
		while ( queue.length ) {
			subqueue = queue.splice( 0, 50 ).map( normalizeTitle );
			ve.init.target.constructor.static.apiRequest( {
				action: 'query',
				prop: 'info|pageprops',
				ppprop: 'disambiguation',
				titles: subqueue.join( '|' )
			} )
				.done( processData )
				.fail( rejectSubqueue );
		}
	};

} () );
