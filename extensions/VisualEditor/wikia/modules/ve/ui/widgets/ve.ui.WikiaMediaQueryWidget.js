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
	this.batch = 1;
	this.input = new ve.ui.TextInputWidget( {
		'$$': this.$$,
		'icon': 'search',
		'placeholder': config.placeholder,
		'value': config.value
	} );
	this.request = null;
	this.requestMediaCallback = ve.bind( this.requestMedia, this );
	this.timeout = null;

	// Events
	this.input.connect( this, { 'change': 'onInputChange' } );

	// Initialization
	this.$
		.addClass( 've-ui-wikiaMediaQueryWidget' )
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

ve.ui.WikiaMediaQueryWidget.prototype.requestMedia = function () {
	var value;

	if ( this.input.isPending() ) {
		return;
	}

	value = this.input.getValue();

	if ( this.request ) {
		this.request.abort();
	}

	if ( value.trim().length !== 0 ) {
		this.input.pushPending();
		this.request = $.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': {
				'format': 'json',
				'action': 'apimediasearch',
				'query': value,
				'type': 'photo|video',
				'mixed': true,
				'batch': this.batch,
				'limit': 16
			}
		} )
			.always( ve.bind( this.onRequestMediaAlways, this ) )
			.done( ve.bind( this.onRequestMediaDone, this ) );
	}

	this.emit( 'request', value, this.request );
};

ve.ui.WikiaMediaQueryWidget.prototype.onInputChange = function () {
	var value = this.input.getValue();

	this.batch = 1;
	clearTimeout( this.timeout );

	if ( value.trim().length !== 0 ) {
		// TODO/FIXME: requestMedia is called too often
		this.timeout = setTimeout( this.requestMediaCallback, 100 );
	}
};

ve.ui.WikiaMediaQueryWidget.prototype.onRequestMediaAlways = function () {
	this.request = null;
	this.input.popPending();
};

ve.ui.WikiaMediaQueryWidget.prototype.onRequestMediaDone = function ( data ) {
	if ( !data.response || !data.response.results || this.input.getValue().trim().length === 0 ) {
		return;
	}

	this.batch++;
	this.emit( 'media', data );
};
