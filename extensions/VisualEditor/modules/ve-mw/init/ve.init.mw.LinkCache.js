/*!
 * VisualEditor MediaWiki Initialization LinkCache class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

( function () {

/*global mw */

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

	this.cache = {}; // Keys are page names, values are deferreds
	this.queue = []; // Array of page names queued to be looked up
	this.schedule = ve.debounce( ve.bind( this.processQueue, this ), 0 );
};

OO.mixinClass( ve.init.mw.LinkCache, OO.EventEmitter );

// TODO maybe factor out generic parts into ve.StatusCache or whatever
// TODO unit tests

/**
 * @event add
 * Fired when a new entry is added to the cache.
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
	if ( !Object.prototype.hasOwnProperty.call( this.cache, name ) ) {
		this.cache[name] = $.Deferred();
		this.queue.push( name );
		this.schedule();
	}
	return this.cache[name].promise();
};

/**
 * Add entries to the cache.
 * @param {Object} entries Object keyed by page title, with the values being data objects
 * @fires add
 */
ve.init.mw.LinkCache.prototype.set = function ( entries ) {
	var name;
	for ( name in entries ) {
		if ( !Object.prototype.hasOwnProperty.call( this.cache, name ) ) {
			this.cache[name] = $.Deferred();
		}
		this.cache[name].resolve( entries[name] );
	}
	this.emit( 'add', ve.getObjectKeys( entries ) );
};

// TODO should reuse ve.dm.MWInternalLinkAnnotation#getLookupTitle once factored out
function normalizeTitle( name ) {
	var title = mw.Title.newFromText( name );
	if ( !title ) {
		return name;
	}
	return title.getPrefixedText();
}

/**
 * Perform any scheduled API requests.
 * @private
 * @fires add
 */
ve.init.mw.LinkCache.prototype.processQueue = function () {
	var subqueue, queue, queueCopy, linkCache = this;

	function rejectSubqueue() {
		var i, len;
		for ( i = 0, len = subqueue.length; i < len; i++ ) {
			linkCache.cache[subqueue[i]].reject();
		}
	}

	function processData( data ) {
		var pageid, info, dfd, pages = data.query && data.query.pages || {};
		for ( pageid in pages ) {
			info = {
				'missing': pages[pageid].missing !== undefined
			};
			dfd = linkCache.cache[pages[pageid].title];
			if ( dfd ) {
				dfd.resolve( info );
			}
		}
		// Reject everything in subqueue; this will only reject the ones
		// that weren't already resolved above, because .reject() on an
		// already resolved Deferred is a no-op.
		rejectSubqueue();
	}

	queue = this.queue;
	queueCopy = queue.slice();
	this.queue = [];
	while ( queue.length ) {
		subqueue = queue.splice( 0, 50 ).map( normalizeTitle );
		ve.init.target.constructor.static.apiRequest( {
				'action': 'query',
				'prop': 'info',
				'titles': subqueue.join( '|' )
		} )
			.done( processData )
			.fail( rejectSubqueue );
	}
	this.emit( 'add', queueCopy );
};

} () );
