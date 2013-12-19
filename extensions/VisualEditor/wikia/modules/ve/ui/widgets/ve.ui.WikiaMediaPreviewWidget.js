/*!
 * VisualEditor UserInterface WikiaMediaPreviewWidget class.
 *
 * @todo: fill in rest of docs
 */

/* global mw, require */

ve.ui.WikiaMediaPreviewWidget = function VeUiWikiaMediaPreviewWidget( model ) {
	// Parent constructor
	ve.ui.Widget.call( this );

	this.model = model;
	this.videoInstance = null;

	// Properties
	// todo: should we use something that's already built?
	this.$.addClass( 've-ui-wikiaMediaPreviewWidget-overlay' );

	this.closeButton = new ve.ui.IconButtonWidget( {
		'$$': this.$$, 'title': ve.msg( 'visualeditor-dialog-action-close' ), 'icon': 'close'
	} );

	// Events
	this.closeButton.connect( this, { 'click': 'onCloseButtonClick' } );

	this.closeButton.$
		.addClass( 've-ui-wikiaMediaPreviewWidget-closeButton' )
		.prependTo( this.$ );

	this.$mediaWrapper = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-mediaWrapper' )
		.appendTo( this.$ );

	if( model.type === 'video' ) {

		$.when( this.getVideoEmbedCode() )
			.done( ve.bind( this.embedVideo, this ) )
			.fail( ve.bind( this.onRequestFail, this ) );

	} else {
		// handle images
		this.handleImage();

		console.log( model );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaPreviewWidget, ve.ui.Widget );

/* Methods */

ve.ui.WikiaMediaPreviewWidget.prototype.handleImage = function() {
	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.maxImgHeight = Math.round( $( window ).height() * 0.95 );
		this.maxImgWidth = Math.round( $( window ).width() * 0.95 );

		this.image = new Image();
		this.$item = $( this.image );

		// TODO: (nice to have) be able to calculate the bounding box without hardcoded
		// values but we would need to know bounding box size up front for that.
		this.image.src = thumbnailer.getThumbURL( this.model.url, 'nocrop', this.maxImgWidth, this.maxImgHeight );

		this.$item.load( ve.bind( this.onImageLoad, this ) );
		this.$mediaWrapper
			.addClass( 've-ui-texture-pending' )
			.append( this.$item );
	}, this ) );
};

ve.ui.WikiaMediaPreviewWidget.prototype.onImageLoad = function () {

	// TODO: Add image aspect ratio to model (same comment from WikiaMediaPageWidget)
	// thumbnailer.js only let's you restrict by width, not by height, so we'll do that here.
	if ( this.image.height > this.maxImgHeight ) {
		this.image.height = this.maxImgHeight;
	}

	this.$mediaWrapper
		.width( this.$item.width() )
		.height( this.$item.height() )
		.removeClass( 've-ui-texture-pending' );
};


ve.ui.WikiaMediaPreviewWidget.prototype.getVideoEmbedCode = function() {
	var ret;

	if( this.model.embedCode ) {
		ret = this.model.embedCode;
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
				this.model.embedCode = window.JSON.parse( data.mediapreview.embedCode );
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
		this.videoInstance = new VideoBootstrap( this.$videoWrapper[0], this.model.embedCode, 've-preview' );
	}, this ) );
};

/**
 * Handle video preview request promise.error
 *
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.onRequestFail = function() {
	alert( 'error' );
};

ve.ui.WikiaMediaPreviewWidget.prototype.open = function() {
	// handle subsequent opens
};

ve.ui.WikiaMediaPreviewWidget.prototype.onCloseButtonClick = function() {
	this.$.hide();
	if( this.videoInstance ) {
		this.videoInstance.destroy();
	}
};