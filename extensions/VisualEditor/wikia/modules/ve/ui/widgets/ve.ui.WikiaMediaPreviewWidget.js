/*!
 * VisualEditor UserInterface WikiaMediaPreviewWidget class.
 *
 * @todo: fill in rest of docs
 */

/* global mw, require */

ve.ui.WikiaMediaPreviewWidget = function VeUiWikiaMediaPreviewWidget( model, config ) {
	// Parent constructor
	ve.ui.Widget.call( this );

	this.model = model;
	this.videoInstance = null;

	// Properties
	this.$.addClass( 've-ui-wikiaMediaPreviewWidget-overlay' );

	this.closeButton = new ve.ui.IconButtonWidget( {
		'$$': this.$$,
		'title': ve.msg( 'visualeditor-dialog-action-close' ),
		'icon': 'close'
	} );

	// Events
	this.closeButton.connect( this, { 'click': 'onCloseButtonClick' } );

	this.closeButton.$
		.addClass( 've-ui-wikiaMediaPreviewWidget-closeButton' )
		.prependTo( this.$ );

	if( model.type === 'video' ) {
		this.$videoWrapper = this.$$( '<div>' )
			.addClass( 've-ui-wikiaMediaPreviewWidget-videoWrapper' )
			.appendTo( this.$ );

		$.when( this.getVideoEmbedCode() )
			.done( ve.bind( this.embedVideo, this ) )
			.fail( ve.bind( this.onRequestFail, this ) );

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
		.appendTo( this.$ );
};

ve.ui.WikiaMediaPreviewWidget.prototype.onImageLoad = function () {
	// TODO: Add image aspect ratio to model (sorta the same comment from WikiaMediaPageWidget)
	// thumbnailer.js only let's you restrict by width, not by height, so we'll do that here.
	if ( this.$image.height() > this.maxImgHeight ) {
		this.$image.height( this.maxImgHeight );
	}
};


ve.ui.WikiaMediaPreviewWidget.prototype.getVideoEmbedCode = function() {
	var ret;

	if( this.embedCode ) {
		ret = this.embedCode;
	} else {
		ret = $.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': {
				'format': 'json',
				'action': 'mediapreview',
				'provider': this.model.provider,
				'videoId': this.model.videoId,
				'title': this.model.title
			}
		} )
			.done( ve.bind( function( data ) {
				this.embedCode = window.JSON.parse( data.mediapreview.embedCode );
			}, this ) );
	}

	return ret;
};

/**
 * Handle video preview request promise.done
 *
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.embedVideo = function() {
	require( ['wikia.videoBootstrap'], ve.bind( function( VideoBootstrap ) {
		this.videoInstance = new VideoBootstrap( this.$videoWrapper[0], this.embedCode, 've-preview' );
	}, this ) );
};

/**
 * Handle video preview request promise.error
 *
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.onRequestFail = function() {
	// TODO: handle error
	alert( 'error' );
};

/**
 * Handle subsequent opens
 */

ve.ui.WikiaMediaPreviewWidget.prototype.reOpen = function() {
	this.$.show();
	if( this.model.type === 'video' ){
		this.embedVideo();
	}
};

ve.ui.WikiaMediaPreviewWidget.prototype.onCloseButtonClick = function() {
	this.$.hide();
	if( this.videoInstance ) {
		this.videoInstance.destroy();
	}
};

ve.ui.WikiaMediaPreviewWidget.prototype.remove = function() {
	// TODO: call this when cart items are removed and when the cart is cleared
	this.$.remove();
};