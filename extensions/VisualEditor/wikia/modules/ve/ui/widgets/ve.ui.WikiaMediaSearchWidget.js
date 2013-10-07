/*!
 * VisualEditor UserInterface WikiaMediaSearchWidget class.
 */

/*global mw*/

/**
 * Creates a ve.ui.WikiaMediaSearchWidget object.
 *
 * @class
 * @extends ve.ui.SearchWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {number} [size] Vertical size of thumbnails
 */
ve.ui.WikiaMediaSearchWidget = function VeUiWikiaMediaSearchWidget( config ) {
	// Configuration intialization
	config = ve.extendObject( {
		'placeholder': ve.msg( 'visualeditor-media-input-placeholder' )
		//'value': mw.config.get( 'wgTitle' )
	}, config );

	// Parent constructor
	ve.ui.SearchWidget.call( this, config );

	// Properties
	this.queryMediaSourcesCallback = ve.bind( this.queryMediaSources, this );
	this.queryTimeout = null;
	this.size = config.size || 150;
	this.sources = { 'url': mw.util.wikiScript( 'api' ) };
	this.titles = {};

	// Events
	this.$results.on( 'scroll', ve.bind( this.onResultsScroll, this ) );

	// Initialization
	this.$.addClass( 've-ui-wikiaMediaSearchWidget' );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaSearchWidget, ve.ui.SearchWidget );

/* Methods */

/**
 * Handle select widget select events.
 *
 * @param {string} value New value
 */
ve.ui.WikiaMediaSearchWidget.prototype.onQueryChange = function () {
	var i, len;

	// Parent method
	ve.ui.SearchWidget.prototype.onQueryChange.call( this );

	// Reset
	this.titles = {};
	for ( i = 0, len = this.sources.length; i < len; i++ ) {
		delete this.sources[i].batch;
	}

	// Queue
	clearTimeout( this.queryTimeout );
	this.queryTimeout = setTimeout( this.queryMediaSourcesCallback, 100 );
};

/**
 * Handle results scroll events.
 *
 * @param {jQuery.Event} e Scroll event
 */
ve.ui.WikiaMediaSearchWidget.prototype.onResultsScroll = function () {
	var position = this.$results.scrollTop() + this.$results.outerHeight(),
		threshold = this.results.$.outerHeight() - this.size;
	if ( !this.query.isPending() && position > threshold ) {
		this.queryMediaSources();
	}
};

/**
 * Query all sources for media.
 *
 * @method
 */
ve.ui.WikiaMediaSearchWidget.prototype.queryMediaSources = function () {
	var i, len, source,
		value = this.query.getValue();

	if ( value === '' ) {
		return;
	}

	for ( i = 0, len = this.sources.length; i < len; i++ ) {
		source = this.sources[i];
		if ( source.request ) {
			source.request.abort();
		}
		if ( !source.batch ) {
			source.batch = 1;
		}
		this.query.pushPending();
		source.request = $.ajax( {
			'url': source.url,
			'data': {
				'format': 'json',
				'action': 'query',
				'generator': 'search',
				'gsrsearch': value,
				'gsrnamespace': 6,
				'gsrlimit': 15,
				'gsroffset': source.gsroffset,
				'prop': 'imageinfo',
				'iiprop': 'dimensions|url',
				'iiurlheight': this.size
			},
			// This request won't be cached since the JSON-P callback is unique. However make sure
			// to allow jQuery to cache otherwise so it won't e.g. add "&_=(random)" which will
			// trigger a MediaWiki API error for invalid parameter "_".
			'cache': true,
			// TODO: Only use JSON-P for cross-domain.
			// jQuery has this logic built-in (if url is not same-origin ..)
			// but isn't working for some reason.
			'dataType': 'jsonp'
		} )
			.done( ve.bind( this.onMediaQueryDone, this, source ) )
			.always( ve.bind( this.onMediaQueryAlways, this, source ) );
		source.value = value;
	}
};

/**
 * Handle media query response events.
 *
 * @method
 * @param {Object} source Media query source
 */
ve.ui.WikiaMediaSearchWidget.prototype.onMediaQueryAlways = function ( source ) {
	source.request = null;
	this.query.popPending();
};

/**
 * Handle media query load events.
 *
 * @method
 * @param {Object} source Media query source
 * @param {Object} data Media query response
 */
ve.ui.WikiaMediaSearchWidget.prototype.onMediaQueryDone = function ( source, data ) {
	if ( !data.query || !data.query.pages ) {
		return;
	}

	var	page, title,
		items = [],
		pages = data.query.pages,
		value = this.query.getValue();

	if ( value === '' || value !== source.value ) {
		return;
	}

	if ( data['query-continue'] && data['query-continue'].search ) {
		source.gsroffset = data['query-continue'].search.gsroffset;
	}

	for ( page in pages ) {
		title = new mw.Title( pages[page].title ).getMainText();
		if ( !( title in this.titles ) ) {
			this.titles[title] = true;
			items.push(
				new ve.ui.MWMediaResultWidget(
					pages[page],
					{ '$$': this.$$, 'size': this.size }
				)
			);
		}
	}

	this.results.addItems( items );
};
