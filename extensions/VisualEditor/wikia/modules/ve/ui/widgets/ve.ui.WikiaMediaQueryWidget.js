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
	this.$outerWrapper = this.$$( '<div>' ).addClass( 've-ui-wikiaMediaQueryWidget-wrapper' );
	this.$inputWrapper = this.$$( '<div>' ).addClass( 've-ui-wikiaMediaQueryWidget-queryWrapper' );
	this.$uploadWrapper = this.$$( '<div>' ).addClass( 've-ui-wikiaMediaQueryWidget-uploadWrapper' );

	// Events
	this.input.connect( this, { 'change': 'onInputChange' } );

	// Initialization
	this.$inputWrapper.append( this.input.$ );
	this.$uploadWrapper.append( this.upload.$ );
	this.$outerWrapper.append( this.$inputWrapper ).append( this.$uploadWrapper );
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

	this.emit( 'requestMedia', value, this.request );
};

/**
 * Handle query input changes.
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.onInputChange = function () {
	var value = this.input.getValue();

	this.batch = 1;
	clearTimeout( this.timeout );

	if ( value.trim().length !== 0 ) {
		// TODO/FIXME: requestMedia is called too often
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

	if ( !data.response || !data.response.results || this.input.getValue().trim().length === 0 ) {
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
ve.ui.WikiaMediaQueryWidget.prototype.showUploadWrapper = function () {
	this.$uploadWrapper.show();
}

/**
 * Hide upload wrapper
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.hideUploadWrapper = function () {
	this.$uploadWrapper.hide();
}
