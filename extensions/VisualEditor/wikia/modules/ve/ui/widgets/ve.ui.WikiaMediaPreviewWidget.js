/*!
 * VisualEditor UserInterface WikiaMediaPreviewWidget class.
 *
 * @todo: fill in rest of docs
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

ve.ui.WikiaMediaPreviewWidget.prototype.onImageLoad = function () {
	// TODO: Add image aspect ratio to model (sorta the same comment from WikiaMediaPageWidget)
	// thumbnailer.js only let's you restrict by width, not by height, so we'll do that here.
	if ( this.$image.height() > this.maxImgHeight ) {
		this.$image.height( this.maxImgHeight );
	}
};


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
 * Handle video preview request promise.done
 * @method
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
 * Handle subsequent opens
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.reOpen = function() {
	this.$.show();
	if( this.model.type === 'video' ){
		this.embedVideo();
	}
};

ve.ui.WikiaMediaPreviewWidget.prototype.onCloseButtonClick = function() {
	this.$.remove();
};