/*!
 * VisualEditor DataModel MWMediaResourceProvider class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki media resource provider.
 *
 * @class
 * @extends ve.dm.APIResultsProvider
 *
 * @constructor
 * @param {string} apiurl The API url
 * @param {Object} [config] Configuration options
 * @cfg {string} [scriptDirUrl] The url of the API script
 */
ve.dm.MWMediaResourceProvider = function VeDmMWMediaResourceProvider( apiurl, config ) {
	config = config || {};

	// Parent constructor
	ve.dm.MWMediaResourceProvider.super.call( this, apiurl, config );

	// Fetching configuration
	this.scriptDirUrl = config.scriptDirUrl;
	this.isLocal = config.local !== undefined;

	if ( this.isLocal ) {
		this.setAjaxSettings( {
			url: mw.util.wikiScript( 'api' ),
			// If the url is local use json
			dataType: 'json'
		} );
	} else {
		this.setAjaxSettings( {
			// If 'apiurl' is set, use that. Otherwise, build the url
			// from scriptDirUrl and /api.php suffix
			url: this.getAPIurl() || ( this.scriptDirUrl + '/api.php' ),
			// If the url is not the same origin use jsonp
			dataType: 'jsonp',
			// JSON-P requests are not cached by default and get a &_=random trail.
			// While setting cache=true will still bypass cache in most case due to the
			// callback parameter, at least drop the &_=random trail which triggers
			// an API warning (invalid parameter).
			cache: true
		} );
	}
	this.siteInfoPromise = null;
	this.thumbSizes = [];
	this.imageSizes = [];
};

/* Inheritance */
OO.inheritClass( ve.dm.MWMediaResourceProvider, ve.dm.APIResultsProvider );

/* Methods */

/**
 * Initialize the source and get the site info.
 *
 * Connect to the api url and retrieve the siteinfo parameters
 * that are required for fetching results.
 *
 * @return {jQuery.Promise} Promise that resolves when the class
 * properties are set.
 */
ve.dm.MWMediaResourceProvider.prototype.loadSiteInfo = function () {
	var provider = this;

	if ( !this.siteInfoPromise ) {
		this.siteInfoPromise = new mw.Api().get( {
			action: 'query',
			meta: 'siteinfo'
		} )
			.then( function ( data ) {
				provider.setImageSizes( data.query.general.imagelimits || [] );
				provider.setThumbSizes( data.query.general.thumblimits || [] );
				provider.setUserParams( {
					// Standard width per resource
					iiurlwidth: provider.getStandardWidth()
				} );
			} );
	}
	return this.siteInfoPromise;
};

/**
 * Override parent method and get results from the source
 *
 * @param {number} [howMany] The number of items to pull from the API
 * @return {jQuery.Promise} Promise that is resolved into an array
 * of available results, or is rejected if no results are available.
 */
ve.dm.MWMediaResourceProvider.prototype.getResults = function ( howMany ) {
	var xhr,
		aborted = false,
		provider = this;

	return this.loadSiteInfo()
		.then( function () {
			if ( aborted ) {
				return $.Deferred().reject();
			}
			xhr = provider.fetchAPIresults( howMany );
			return xhr;
		} )
		.then(
			function ( results ) {
				if ( !results || results.length === 0 ) {
					provider.toggleDepleted( true );
					return [];
				}
				return results;
			},
			// Process failed, return an empty promise
			function () {
				provider.toggleDepleted( true );
				return $.Deferred().resolve( [] );
			}
		)
		.promise( { abort: function () {
			aborted = true;
			if ( xhr ) {
				xhr.abort();
			}
		} } );
};

/**
 * Call the API for search results.
 *
 * @param {number} howMany The number of results to retrieve
 * @return {jQuery.Promise} Promise that resolves with an array of objects that contain
 *  the fetched data.
 */
ve.dm.MWMediaResourceProvider.prototype.fetchAPIresults = function ( howMany ) {
	var xhr,
		ajaxOptions = {},
		provider = this,
		apiCallConfig = $.extend(
			{},
			this.getUserParams(),
			{
				gsroffset: this.getOffset(),
				iiextmetadatalanguage: provider.getLang()
			} );

	// Number of images
	apiCallConfig.gsrlimit = howMany || this.getDefaultFetchLimit();

	if ( !this.isValid() ) {
		return $.Deferred().reject().promise( { abort: $.noop } );
	}

	ajaxOptions = this.getAjaxSettings();

	xhr = new mw.Api().get( $.extend( this.getStaticParams(), apiCallConfig ), ajaxOptions );
	return xhr
		.then( function ( data ) {
			var page, newObj, raw,
				results = [];

			if ( data.error ) {
				provider.toggleDepleted( true );
				return [];
			}

			if ( data.continue ) {
				// Update the offset for next time
				provider.setOffset( data.continue.gsroffset );
			} else {
				// This is the last available set of results. Mark as depleted!
				provider.toggleDepleted( true );
			}

			// If the source returned no results, it will not have a
			// query property
			if ( data.query ) {
				raw = data.query.pages;
				if ( raw ) {
					// Strip away the page ids
					for ( page in raw ) {
						if ( !raw[ page ].imageinfo ) {
							// The search may give us pages that belong to the File:
							// namespace but have no files in them, either because
							// they were deleted or imported wrongly, or just started
							// as pages. In that case, the response will not include
							// imageinfo. Skip those files.
							continue;
						}
						newObj = raw[ page ].imageinfo[ 0 ];
						newObj.title = raw[ page ].title;
						results.push( newObj );
					}
				}
			}
			return results;
		} )
		.promise( { abort: xhr.abort } );
};

/**
 * Set name
 *
 * @param {string} name
 */
ve.dm.MWMediaResourceProvider.prototype.setName = function ( name ) {
	this.name = name;
};

/**
 * Get name
 *
 * @return {string} name
 */
ve.dm.MWMediaResourceProvider.prototype.getName = function () {
	return this.name;
};

/**
 * Get standard width, based on the provider source's thumb sizes.
 *
 * @return {number|undefined} fetchWidth
 */
ve.dm.MWMediaResourceProvider.prototype.getStandardWidth = function () {
	return ( this.thumbSizes && this.thumbSizes[ this.thumbSizes.length - 1 ] ) ||
		( this.imageSizes && this.imageSizes[ 0 ] ) ||
		// Fall back on a number
		300;
};

/**
 * Get prop
 *
 * @return {string} prop
 */
ve.dm.MWMediaResourceProvider.prototype.getFetchProp = function () {
	return this.fetchProp;
};

/**
 * Set prop
 *
 * @param {string} prop
 */
ve.dm.MWMediaResourceProvider.prototype.setFetchProp = function ( prop ) {
	this.fetchProp = prop;
};

/**
 * Set thumb sizes
 *
 * @param {number[]} sizes Available thumbnail sizes
 */
ve.dm.MWMediaResourceProvider.prototype.setThumbSizes = function ( sizes ) {
	this.thumbSizes = sizes;
};

/**
 * Set image sizes
 *
 * @param {number[]} sizes Available image sizes
 */
ve.dm.MWMediaResourceProvider.prototype.setImageSizes = function ( sizes ) {
	this.imageSizes = sizes;
};

/**
 * Get thumb sizes
 *
 * @return {number[]} sizes Available thumbnail sizes
 */
ve.dm.MWMediaResourceProvider.prototype.getThumbSizes = function () {
	return this.thumbSizes;
};

/**
 * Get image sizes
 *
 * @return {number[]} sizes Available image sizes
 */
ve.dm.MWMediaResourceProvider.prototype.getImageSizes = function () {
	return this.imageSizes;
};

/**
 * Check if this source is valid and ready for search.
 *
 * @return {boolean} Source is valid
 */
ve.dm.MWMediaResourceProvider.prototype.isValid = function () {
	var params = this.getUserParams();
	return params.gsrsearch &&
		(
			this.isLocal ||
			// If we don't have either 'apiurl' or 'scriptDirUrl'
			// the source is invalid, and we will skip it
			this.apiurl !== undefined ||
			this.scriptDirUrl !== undefined
		);
};
