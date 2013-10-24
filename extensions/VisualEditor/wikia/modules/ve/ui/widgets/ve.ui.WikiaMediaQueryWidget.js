/*!
 * VisualEditor UserInterface WikiaMediaQueryWidget class.
 */

/* global mw */

/**
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
	this.upload = new ve.ui.WikiaUploadWidget( { '$$': this.$$ } );
	this.$outerWrapper = this.$$( '<div>' );
	this.$inputWrapper = this.$$( '<div>' );
	this.$uploadWrapper = this.$$( '<div>' );

	// Events
	this.input.connect( this, { 'change': 'onInputChange' } );

	// Initialization
	this.$inputWrapper
		.addClass( 've-ui-wikiaMediaQueryWidget-queryWrapper' )
		.append( this.input.$ );
	this.$uploadWrapper
		.addClass( 've-ui-wikiaMediaQueryWidget-uploadWrapper' )
		.append( this.upload.$ );
	this.$outerWrapper
		.addClass( 've-ui-wikiaMediaQueryWidget-wrapper' )
		.append( this.$inputWrapper, this.$uploadWrapper );
	this.$
		.addClass( 've-ui-wikiaMediaQueryWidget' )
		.append( this.$outerWrapper );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaQueryWidget, ve.ui.Widget );

/* Events */

/**
 * @event requestMedia
 * @param {string} value The query input value.
 */

/**
 * @event requestMediaDone
 * @param {Object} data The response Object from the server.
 */

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

ve.ui.WikiaMediaQueryWidget.prototype.getUpload = function () {
	return this.upload;
};

/**
 * Request media from the server.
 *
 * @method
 * @fires requestMedia
 */
ve.ui.WikiaMediaQueryWidget.prototype.requestMedia = function () {
	this.input.pushPending();
	this.request = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'apimediasearch',
			'query': this.value,
			'type': 'photo|video',
			'mixed': true,
			'batch': this.batch,
			'limit': 16
		}
	} )
		.always( ve.bind( this.onRequestMediaAlways, this ) )
		.done( ve.bind( this.onRequestMediaDone, this ) );

	this.emit( 'requestMedia', this.value, this.request );
};

/**
 * Handle query input changes.
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.onInputChange = function () {
	if ( this.request ) {
		this.request.abort();
	}
	clearTimeout( this.timeout );
	this.batch = 1;
	this.value = this.input.getValue();
	if ( this.value.trim().length !== 0 ) {
		this.timeout = setTimeout( this.requestMediaCallback, 100 );
	}
};

/**
 * Handle media request promise.always
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.onRequestMediaAlways = function () {
	this.request = null;
	this.input.popPending();
};

/**
 * Handle media request promise.done
 *
 * @method
 * @param {Object} data The response Object from the server.
 * @fires requestMediaDone
 */
ve.ui.WikiaMediaQueryWidget.prototype.onRequestMediaDone = function ( data ) {
	var items;

	if ( !data.response || !data.response.results ) {
		return;
	}

	// TODO: this logic will need to change when we have different types of results to display.
	items = data.response.results.mixed.items;

	this.batch++;
	this.emit( 'requestMediaDone', items );
};

/**
 * Show upload wrapper
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.showUpload = function () {
	this.$uploadWrapper.show();
};

/**
 * Hide upload wrapper
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.hideUpload = function () {
	this.$uploadWrapper.hide();
};
