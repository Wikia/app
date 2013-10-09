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
	this.pagesPanel = new ve.ui.PagedLayout( { '$$': this.$$, 'attachPagesPanel': true } );
	this.suggestions = new ve.ui.SelectWidget( { '$$': this.$$ } );
	this.$suggestions = this.$$( '<div>' );
	this.queryTimeout = null;
	this.queryMediaCallback = ve.bind( this.queryMedia, this );

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
	var value = this.query.getValue(),
		request;

	if ( value.trim().length === 0 ) {
		this.pagesPanel.setPage( 'suggestions' );
	} else {
		request = $.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': {
				'format': 'json',
				'action': 'apimediasearch',
				'query': value,
				'type': 'photo|video',
				'mixed': true
			}
		} )
		.done( ve.bind( this.onQueryMediaDone, this ) );
	}
};

ve.ui.WikiaMediaSearchWidget.prototype.onQueryMediaDone = function ( data ) {
	console.log( data.response.results.mixed.items );
};

ve.ui.WikiaMediaSearchWidget.prototype.onQueryChange = function () {
	// Parent method
	ve.ui.SearchWidget.prototype.onQueryChange.call( this );
	
	clearTimeout( this.queryTimeout );

	if ( this.query.getValue().trim().length === 0 ) {
		this.pagesPanel.setPage( 'suggestions' );
	} else {
		this.queryTimeout = setTimeout( this.queryMediaCallback, 100 );
	}
};