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
	this.size = config.size || 160;
	this.pagesPanel = new ve.ui.PagedLayout( { '$$': this.$$, 'attachPagesPanel': true } );
	this.suggestions = new ve.ui.SelectWidget( { '$$': this.$$ } );
	this.$suggestions = this.$$( '<div>' );
	this.queryTimeout = null;
	this.queryMediaCallback = ve.bind( this.queryMedia, this );
	this.request = null;
	this.batch = 1;

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
				'limit': 16,
				'batch': this.batch
			}
		} )
		.done( ve.bind( this.onQueryMediaDone, this ) )
		.always( ve.bind( this.onMediaQueryAlways, this ) );
	}
};

ve.ui.WikiaMediaSearchWidget.prototype.onQueryMediaDone = function ( data ) {
	var media = data.response.results.mixed.items,
		items = [],
		i;

	if ( !data.response || !data.response.results ) {
		return;
	}

	if ( data.response.batch < data.response.results.mixed.batches ) {
		this.batch++;
	}

	for( i = 0; i < media.length; i++ ) {
		items.push(
			new ve.ui.WikiaMediaResultWidget( media[i], { '$$': this.$$, 'size': this.size } )
		);
	}

	this.results.addItems( items );
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

ve.ui.WikiaMediaSearchWidget.prototype.onResultsSelect = function ( item ) {
	ve.ui.SearchWidget.prototype.onResultsSelect.call( this, item );
	if ( item !== null ) {
		this.results.selectItem( null );
	}
};