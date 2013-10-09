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
	// Parent constructor
	ve.ui.SearchWidget.call( this, config );

	// Properties
	this.size = config.size || 150;
	this.pagesPanel = new ve.ui.PagedLayout( { '$$': this.$$, 'attachPagesPanel': true } );
	this.suggestions = new ve.ui.SelectWidget( { '$$': this.$$ } );
	this.$suggestions = this.$$( '<div>' );
	this.queryTimeout = null;
	this.queryMediaCallback = ve.bind( this.queryMedia, this );
	this.batch = 1;
	this.request = null;

	// Events
	this.$results.on( 'scroll', ve.bind( this.onResultsScroll, this ) );

	// Initialization
	this.pagesPanel.addPage( 'results', { '$content': this.$results } );
	this.pagesPanel.addPage( 'suggestions', { '$content': this.$suggestions } );

	this.$suggestions
		.addClass( 've-ui-searchWidget-suggestions' )
		.append( this.suggestions.$ );
	this.$.prepend( this.pagesPanel.$ );

	this.queryMedia();
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaSearchWidget, ve.ui.SearchWidget );

/* Methods */

ve.ui.WikiaMediaSearchWidget.prototype.queryMedia = function () {
	var value = this.query.getValue();

	if ( value.trim().length === 0 ) {
		this.pagesPanel.setPage( 'suggestions' );
	} else {
		if ( this.request ) {
			this.request.abort();
		}
		this.query.pushPending();
		this.request = $.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': {
				'format': 'json',
				'action': 'apimediasearch',
				'query': value,
				'type': 'photo|video',
				'mixed': true,
				'limit': 20,
				'batch': this.batch
			}
		} )
		.done( ve.bind( this.onQueryMediaDone, this ) )
		.always( ve.bind( this.onMediaQueryAlways, this ) );
	}
};

ve.ui.WikiaMediaSearchWidget.prototype.onQueryMediaDone = function ( data ) {
	var items = data.response.results.mixed.items,
		widgets = [];

	if ( data.response.batch < data.response.results.mixed.batches ) {
		this.batch++;
	}

	for( var i = 0; i < items.length; i++ ) {
			widgets.push(
				new ve.ui.WikiaMediaResultWidget(
					items[i],
					{ '$$': this.$$, 'size': this.size }
				)
			);		
	}
	this.results.addItems( widgets );
	this.pagesPanel.setPage( 'results' );
};

ve.ui.WikiaMediaSearchWidget.prototype.onMediaQueryAlways = function () {
	this.request = null;
	this.query.popPending();
};

ve.ui.WikiaMediaSearchWidget.prototype.onQueryChange = function () {
	// Parent method
	ve.ui.SearchWidget.prototype.onQueryChange.call( this );
	
	this.batch = 1;

	clearTimeout( this.queryTimeout );

	if ( this.query.getValue().trim().length === 0 ) {
		this.pagesPanel.setPage( 'suggestions' );
	} else {
		this.queryTimeout = setTimeout( this.queryMediaCallback, 100 );
	}
};

ve.ui.WikiaMediaSearchWidget.prototype.onResultsScroll = function () {
	var position = this.$results.scrollTop() + this.$results.outerHeight(),
		threshold = this.results.$.outerHeight() - this.size;
	if ( !this.query.isPending() && position > threshold ) {
		this.queryMedia();
	}
};