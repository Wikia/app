/*!
 * VisualEditor UserInterface WikiaMediaPreviewWidget class.
 */

/* global mw, require */

ve.ui.WikiaMediaPreviewWidget = function VeUiWikiaMediaPreviewWidget( model ) {

	// Parent constructor
	ve.ui.Widget.call( this );

	// Properties
	this.model = model;
	this.videoInstance = null;

	this.closeButton = new ve.ui.IconButtonWidget( {
		'$$': this.$$,
		'title': ve.msg( 'visualeditor-dialog-action-close' ),
		'icon': 'close'
	} );

	this.title = this.$$( '<div>' )
		.text( this.model.title )
		.addClass( 've-ui-wikiaMediaPreviewWidget-title' )
		.prependTo( this.$ );

	// Events
	this.closeButton.connect( this, { 'click': 'onCloseButtonClick' } );

	// DOM
	this.closeButton.$
		.addClass( 've-ui-wikiaMediaPreviewWidget-closeButton' )
		.prependTo( this.$ );

	this.$.addClass( 've-ui-wikiaMediaPreviewWidget-overlay' )
		.hide()
		.appendTo( $( 'body' ) );

	// Init media
	if( model.type === 'video' ) {
		this.handleVideo();
	} else {
		this.handleImage();
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaPreviewWidget, ve.ui.Widget );

/* Methods */

/**
 * Get larger image for preview and append it to overlay
 * @method
 */
ve.ui.WikiaMediaPreviewWidget.prototype.handleImage = function() {
	this.maxImgHeight = Math.round( $( window ).height() * 0.95 );
	this.maxImgWidth = Math.round( $( window ).width() * 0.95 );

	this.$image = $( '<img>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-image' );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'nocrop', this.maxImgWidth, this.maxImgHeight ) );
	}, this ) );

	this.$image.load( ve.bind( this.onImageLoad, this ) )
		.appendTo( this.$.show() );
};

/**
 * Resize image after it's loaded if it's too tall for the screen
 * @method
 */
ve.ui.WikiaMediaPreviewWidget.prototype.onImageLoad = function () {
	// TODO: Add image aspect ratio to model (sorta the same comment from WikiaMediaPageWidget)
	// thumbnailer.js only let's you restrict by width, not by height, so we'll do that here.
	if ( this.$image.height() > this.maxImgHeight ) {
		this.$image.height( this.maxImgHeight );
	}
};

/**
 * Do ajax request for video embed code
 * @method
 */
ve.ui.WikiaMediaPreviewWidget.prototype.handleVideo = function() {
	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'videopreview',
			'provider': this.model.provider,
			'videoId': this.model.videoId,
			'title': this.model.title
		}
	} )
		.done( ve.bind( this.onRequestVideoDone, this ) )
		.fail( ve.bind( this.onRequestVideoFail, this ) );
};

/**
 * Embed video preview
 * @param {Object} data Response data from ApiVideoPreview
 */
ve.ui.WikiaMediaPreviewWidget.prototype.embedVideo = function( data ) {
	var $videoWrapper = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-videoWrapper' )
		.appendTo( this.$.show() );

	require( ['wikia.videoBootstrap'], ve.bind( function( VideoBootstrap ) {
		this.videoInstance = new VideoBootstrap(
			$videoWrapper[0],
			window.JSON.parse( data.videopreview.embedCode ),
			've-preview'
		);
	}, this ) );
};


/**
 * Handle video preview request promise.done
 * @method
 */
ve.ui.WikiaMediaPreviewWidget.prototype.onRequestVideoDone = function( data ) {
	if( data.videopreview ) {
		this.embedVideo( data );
	} else {
		this.onRequestVideoFail( data );
	}
};

/**
 * Handle video preview request promise.fail
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.onRequestVideoFail = function() {
	mw.config.get( 'GlobalNotification' ).show(
		ve.msg( 'wikia-visualeditor-notification-video-preview-not-available' ),
		'error',
		$( '.ve-ui-frame' ).contents().find( '.ve-ui-window-body' )
	);
};

/**
 * Remove the preview overlay DOM object, effectively killing this instance.
 * @method
 */
ve.ui.WikiaMediaPreviewWidget.prototype.onCloseButtonClick = function() {
	this.$.remove();
};