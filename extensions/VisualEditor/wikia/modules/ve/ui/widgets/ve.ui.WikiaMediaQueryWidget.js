/*!
 * VisualEditor UserInterface WikiaMediaQueryWidget class.
 */

/* global mw */

/**
 * Creates a ve.ui.WikiaMediaQueryWidget Object.
 *
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {string|jQuery} [config.placeholder] Placeholder text for query input
 * @param {string} [config.value] Initial query input value
 */
ve.ui.WikiaMediaQueryWidget = function VeUiWikiaMediaQueryWidget( config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.input = new ve.ui.TextInputWidget( {
		'$$': this.$$,
		'icon': 'search',
		'placeholder': config.placeholder,
		'value': config.value
	} );
	this.onRequestReadyCallback = ve.bind( this.onRequestReady, this );
	this.request = null;
	this.timeout = null;

	// Events
	this.input.connect( this, {
		'change': 'onInputChange',
		//'enter': 'onInputEnter'
	} );

	// Initialization
	this.$
		.addClass( 've-ui-WikiaMediaQueryWidget' )
		.append( this.input.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaQueryWidget, ve.ui.Widget );

/* Methods */

/**
 * Get the query input.
 *
 * @method
 * @returns {ve.ui.TextInputWidget} Query input
 */
ve.ui.WikiaMediaQueryWidget.prototype.getInput = function () {
	return this.input;
};

ve.ui.WikiaMediaQueryWidget.prototype.requestMedia = function ( data ) {
	var value = this.input.getValue();

	if ( this.request ) {
		this.request.abort();
	}

	this.input.pushPending();
	this.request = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': ve.extendObject( {
			'format': 'json',
			'action': 'apimediasearch',
			'query': value,
			'type': 'photo|video',
			'mixed': true,
			'limit': 16
		}, data )
	} )
		.always( ve.bind( this.onRequestAlways, this ) )
		.done( this.onQueryMediaDoneCallback );

	this.emit( 'request', value, this.request );
};

ve.ui.WikiaMediaQueryWidget.prototype.onInputChange = function () {
	var value = this.input.getValue();

	clearTimeout( this.timeout );

	if ( value.trim().length !== 0 ) {
		this.timeout = setTimeout( this.onRequestReadyCallback, 100 );
	}

	this.emit( 'change', value );
};

ve.ui.WikiaMediaQueryWidget.prototype.onRequestAlways = function () {
	this.request = null;
	this.input.popPending();
	this.emit( 'requestAlways' );
};

ve.ui.WikiaMediaQueryWidget.prototype.onRequestDone = function ( data ) {
/*
	var media;

	if ( !data.response || !data.response.results ) {
		return;
	}

	media = data.response.results.mixed.items;

	this.batch++;
*/

	this.emit( 'requestDone', data );

	//this.results.addItems( items );
	//this.pagesPanel.setPage( 'results' );
};

ve.ui.WikiaMediaQueryWidget.prototype.onRequestReady = function () {
	if ( !this.input.isPending() ) {
		this.emit( 'requestReady', this.input.getValue() );
	}
};
