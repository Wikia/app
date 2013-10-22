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
	this.request = null;
	this.requestMediaCallback = ve.bind( this.requestMedia, this );
	this.timeout = null;

	// Events
	this.input.connect( this, {
		'change': 'onInputChange',
		//'enter': 'onInputEnter'
	} );

	// Initialization
	this.$
		.addClass( 've-ui-wikiaMediaQueryWidget' )
		.append( this.input.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaQueryWidget, ve.ui.Widget );

/* Methods */

ve.ui.WikiaMediaQueryWidget.prototype.focus = function () {
	this.input.$input.focus();
};

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
			'data': ve.extendObject( {
				'format': 'json',
				'action': 'apimediasearch',
				'query': value,
				'type': 'photo|video',
				'mixed': true,
				'limit': 16
			}, data )
		} )
			.always( ve.bind( this.onRequestMediaAlways, this ) )
			.done( ve.bind( this.onRequestMediaDone, this ) );
	}

	this.emit( 'request', value, this.request );
};

ve.ui.WikiaMediaQueryWidget.prototype.onInputChange = function () {
	var value = this.input.getValue();

	clearTimeout( this.timeout );

	if ( value.trim().length !== 0 ) {
		this.timeout = setTimeout( this.requestMediaCallback, 250 );
	}

	this.emit( 'change', value );
};

ve.ui.WikiaMediaQueryWidget.prototype.onRequestMediaAlways = function () {
	this.request = null;
	this.input.popPending();
};

ve.ui.WikiaMediaQueryWidget.prototype.onRequestMediaDone = function ( data ) {
	this.emit( 'media', data );
};
