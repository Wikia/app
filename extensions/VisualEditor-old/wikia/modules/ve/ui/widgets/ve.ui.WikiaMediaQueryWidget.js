/*!
 * VisualEditor UserInterface WikiaMediaQueryWidget class.
 */

/* global mw */

/**
 * @class
 * @extends OO.ui.Widget
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
	ve.ui.WikiaMediaQueryWidget.super.call( this, config );

	// Properties
	this.batch = 1;
	this.input = new OO.ui.TextInputWidget( {
		$: this.$,
		icon: 'search',
		placeholder: config.placeholder,
		value: config.value
	} );
	this.request = null;
	this.requestMediaCallback = this.requestMedia.bind( this );
	this.timeout = null;
	this.upload = new ve.ui.WikiaUploadWidget( { $: this.$, icon: true } );
	this.$outerWrapper = this.$( '<div>' );
	this.$inputWrapper = this.$( '<div>' );
	this.$uploadWrapper = this.$( '<div>' );

	// Events
	this.input.connect( this, { change: 'onInputChange' } );

	// Initialization
	this.$inputWrapper
		.addClass( 've-ui-wikiaMediaQueryWidget-queryWrapper' )
		.append( this.input.$element );
	this.$uploadWrapper
		.addClass( 've-ui-wikiaMediaQueryWidget-uploadWrapper' )
		.append( this.upload.$element );
	this.$outerWrapper
		.addClass( 've-ui-wikiaMediaQueryWidget-wrapper' )
		.append( this.$inputWrapper, this.$uploadWrapper );
	this.$element
		.addClass( 've-ui-wikiaMediaQueryWidget' )
		.append( this.$outerWrapper );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaQueryWidget, OO.ui.Widget );

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
 * @returns {OO.ui.TextInputWidget} Query input
 */
ve.ui.WikiaMediaQueryWidget.prototype.getInput = function () {
	return this.input;
};

ve.ui.WikiaMediaQueryWidget.prototype.getUpload = function () {
	return this.upload;
};

/**
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.requestMedia = function () {
	this.input.pushPending();

	// Check if the value in the input could be possibly an a URL to video
	if (
		this.value.length >= 10 &&
		this.value.indexOf( '.' ) !== -1 &&
		this.value.lastIndexOf( '/' ) > this.value.indexOf( '.' )
	) {
		this.requestVideo();
	} else {
		this.requestSearch();
	}
};

/**
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.requestVideo = function () {
	this.request = $.ajax( {
		url: mw.util.wikiScript( 'api' ),
		data: {
			format: 'json',
			action: 'addmediatemporary',
			url: this.value
		}
	} )
		.always( this.onRequestVideoAlways.bind( this ) )
		.done( this.onRequestVideoDone.bind( this ) );
};

/**
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.requestSearch = function () {
	this.request = $.ajax( {
		url: mw.util.wikiScript( 'api' ),
		data: {
			format: 'json',
			action: 'apimediasearch',
			query: this.value,
			type: 'photo|video',
			mixed: true,
			batch: this.batch,
			limit: 16
		}
	} )
		.always( this.onRequestSearchAlways.bind( this ) )
		.done( this.onRequestSearchDone.bind( this ) );
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
 * Handle search request promise.always
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.onRequestSearchAlways = function () {
	this.request = null;
	this.input.popPending();
};

/**
 * Handle search request promise.done
 *
 * @method
 * @param {Object} data The response Object from the server.
 * @fires requestSearchDone
 */
ve.ui.WikiaMediaQueryWidget.prototype.onRequestSearchDone = function ( data ) {
	var items;

	if ( !data.response || !data.response.results ) {
		return;
	}

	// TODO: this logic will need to change when we have different types of results to display.
	items = data.response.results.mixed.items;

	this.batch++;
	this.emit( 'requestSearchDone', items );
};

/**
 * Handle video request promise.always
 *
 * @method
 */
ve.ui.WikiaMediaQueryWidget.prototype.onRequestVideoAlways = function () {
	this.request = null;
	this.input.popPending();
};

/**
 * Handle video request promise.done
 *
 * @method
 * @param {Object} data The response Object from the server.
 * @fires requestVideoDone
 */
ve.ui.WikiaMediaQueryWidget.prototype.onRequestVideoDone = function ( data ) {
	var errorMsg,
		BannerNotification;

	// Send errors to the user
	if ( data.error ) {
		errorMsg = this.displayMessages[data.error.code] || this.displayMessages.mediaqueryfailed;
		BannerNotification = mw.config.get('BannerNotification');
		new BannerNotification(
			errorMsg,
			'error',
			$( '.ve-ui-frame' ).contents().find( '.ve-ui-window-body' )
		).show();

		this.requestSearch();
	} else {
		this.emit( 'requestVideoDone', data.addmediatemporary );
	}
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

/**
 * Map API error message to human readable messages
 *
 * @property
 */
ve.ui.WikiaMediaQueryWidget.prototype.displayMessages = {
	mustbeloggedin: ve.msg( 'wikia-visualeditor-notification-media-must-be-logged-in' ),
	onlyallowpremium: ve.msg( 'wikia-visualeditor-notification-media-only-premium-videos-allowed' ),
	permissiondenied: ve.msg( 'wikia-visualeditor-notification-media-permission-denied' ),
	mediaqueryfailed: ve.msg( 'wikia-visualeditor-notification-media-query-failed' )
};
