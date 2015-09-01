/*!
 * VisualEditor DataModel MWMediaResourceQueue class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki media resource queue.
 *
 * @class
 * @extends ve.dm.APIResultsQueue
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {number} maxHeight The maximum height of the media, used in the
 *  search call to the API.
 */
ve.dm.MWMediaResourceQueue = function VeDmMWMediaResourceQueue( config ) {
	config = config || {};

	// Parent constructor
	ve.dm.MWMediaResourceQueue.super.call( this, config );
	this.searchQuery = '';
	this.maxHeight = config.maxHeight || 200;
};

/* Inheritance */
OO.inheritClass( ve.dm.MWMediaResourceQueue, ve.dm.APIResultsQueue );

/**
 * Override parent method to set up the providers according to
 * the file repos
 *
 * @return {jQuery.Promise} Promise that resolves when the resources are set up
 */
ve.dm.MWMediaResourceQueue.prototype.setup = function () {
	var i, len,
		queue = this;

	return this.getFileRepos().then( function ( sources ) {
		if ( queue.providers.length === 0 ) {
			// Set up the providers
			for ( i = 0, len = sources.length; i < len; i++ ) {
				queue.providers.push( new ve.dm.MWMediaResourceProvider(
					sources[ i ].apiurl,
					{
						name: sources[ i ].name,
						local: sources[ i ].local,
						scriptDirUrl: sources[ i ].scriptDirUrl,
						userParams: {
							gsrsearch: queue.getSearchQuery()
						},
						staticParams: {
							action: 'query',
							iiurlheight: queue.getMaxHeight(),
							generator: 'search',
							gsrnamespace: 6,
							continue: '',
							iiprop: 'dimensions|url|mediatype|extmetadata|timestamp',
							prop: 'imageinfo'
						}
					} )
				);
			}
		}
	} );
};

/**
 * Fetch the file repos.
 *
 * @return {jQuery.Promise} Promise that resolves when the resources are set up
 */
ve.dm.MWMediaResourceQueue.prototype.getFileRepos = function () {
	var defaultSource = [ {
			url: mw.util.wikiScript( 'api' ),
			local: ''
		} ];

	if ( !this.fileRepoPromise ) {
		this.fileRepoPromise = new mw.Api().get( {
			action: 'query',
			meta: 'filerepoinfo'
		} ).then(
			function ( resp ) {
				return resp.query && resp.query.repos || defaultSource;
			},
			function () {
				return $.Deferred().resolve( defaultSource );
			}
		);
	}

	return this.fileRepoPromise;
};

/**
 * Get the search query
 *
 * @return {string} API search query
 */
ve.dm.MWMediaResourceQueue.prototype.getSearchQuery = function () {
	var params = this.getParams();
	return params.gsrsearch;
};

/**
 * Get image maximum height
 *
 * @return {string} Image max height
 */
ve.dm.MWMediaResourceQueue.prototype.getMaxHeight = function () {
	return this.maxHeight;
};
