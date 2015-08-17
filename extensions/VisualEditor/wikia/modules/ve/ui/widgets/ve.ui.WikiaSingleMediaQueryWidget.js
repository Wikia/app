/*!
 * VisualEditor UserInterface WikiaSingleMediaQueryWidget class.
 */

/*global mw */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {string|jQuery} [config.placeholder] Placeholder text for query input
 * @param {string} [config.value] Initial query input value
 */
ve.ui.WikiaSingleMediaQueryWidget = function VeUiWikiaSingleMediaQueryWidget( config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.WikiaSingleMediaQueryWidget.super.call( this, config );

	// Properties
	//this.input = new OO.ui.ClearableTextInputWidget( {
	this.input = new OO.ui.TextInputWidget( {
		$: this.$,
		icon: 'search',
		placeholder: config.placeholder,
		value: config.value
	} );
	this.requestMediaCallback = this.requestMedia.bind( this );
	this.request = null;
	this.value = null;
	this.timeout = null;
	this.batch = null;

	// Events
	this.input.connect( this, { change: 'onInputChange' } );

	// Initialization
	this.$element
		.addClass( 've-ui-wikiaSingleMediaQueryWidget' )
		.append( this.input.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaSingleMediaQueryWidget, OO.ui.Widget );

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
 * Handle query input changes.
 *
 * @method
 */
ve.ui.WikiaSingleMediaQueryWidget.prototype.onInputChange = function () {
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
 * @method
 */
ve.ui.WikiaSingleMediaQueryWidget.prototype.requestMedia = function () {
	this.input.pushPending();
	this.request = $.ajax( {
		url: mw.util.wikiScript( 'api' ),
		data: {
			format: 'json',
			action: 'apimediasearch',
			query: this.value,
			type: 'photo',
			mixed: false,
			batch: this.batch,
			limit: 16
		}
	} )
		.always( this.onRequestMediaAlways.bind( this ) )
		.done( this.onRequestMediaDone.bind( this ) );
};

/**
 * Handle media request promise.always
 *
 * @method
 */
ve.ui.WikiaSingleMediaQueryWidget.prototype.onRequestMediaAlways = function () {
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
ve.ui.WikiaSingleMediaQueryWidget.prototype.onRequestMediaDone = function ( data ) {
	var items;
	if ( !data.response || !data.response.results ) {
		return;
	}
	items = data.response.results.photo.items;
	this.batch++;
	this.emit( 'requestMediaDone', items );
};

/**
 * Get the query input.
 *
 * @method
 * @returns {OO.ui.TextInputWidget} Query input
 */
ve.ui.WikiaSingleMediaQueryWidget.prototype.getInput = function () {
	return this.input;
};
