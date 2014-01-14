/*!
 * VisualEditor UserInterface WikiaMediaPreviewWidget class.
 */

/* global mw, require */

ve.ui.WikiaMediaPreviewWidget = function VeUiWikiaMediaPreviewWidget() {

	// Parent constructor
	OO.ui.Widget.call( this );

	// Properties
	this.model = null;
	this.videoInstance = null;
	this.$videoWrapper = null;

	this.closeButton = new OO.ui.IconButtonWidget( {
		'$': this.$,
		'title': ve.msg( 'visualeditor-dialog-action-close' ),
		'icon': 'close'
	} );

	this.$titlebar = this.$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-titlebar' );

	this.$title = this.$( '<span>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-title' );

	// Events
	this.closeButton.connect( this, { 'click': 'onCloseClick' } );
	this.$element.on( 'click', ve.bind( this.onCloseClick, this ) );

	// Initialization
	this.closeButton.$element
		.addClass( 've-ui-wikiaMediaPreviewWidget-closeButton' )

	this.$titlebar
		.append( this.$title, this.closeButton.$element )
		.appendTo( this.$element );

	this.$element
		.addClass( 've-ui-wikiaMediaPreviewWidget-overlay' )
		.hide();
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaPreviewWidget, OO.ui.Widget );

/* Methods */

/**
 * Get larger image for preview and append it to overlay
 * @method
 */
ve.ui.WikiaMediaPreviewWidget.prototype.handleImage = function() {
	this.$element.show();

	this.maxImgHeight = Math.round( $( window ).height() * 0.95 ) - this.$titlebar.outerHeight();
	this.maxImgWidth = Math.round( $( window ).width() * 0.95 );

	this.$image = $( '<img>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-image' );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'nocrop', this.maxImgWidth ) );
	}, this ) );

	this.$image
		.load( ve.bind( this.onImageLoad, this ) )
		.appendTo( this.$element );
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

	this.verticallyAlign( this.$image );
};

ve.ui.WikiaMediaPreviewWidget.prototype.verticallyAlign = function( $element ) {
	var availableHeight = $( window ).height() - this.$titlebar.outerHeight();

	// Vertically align in available space:
	// * Divide available space by 2 to get the middle of the available space,
	// * Subtract half the image height to vertically center the image,
	// * Add add the titlebar height.
	// Show image.
	$element
		.css( 'top', availableHeight / 2 - $element.height() / 2 + this.$titlebar.outerHeight() )
		.show();
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
	this.$videoWrapper = this.$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-videoWrapper' )
		.appendTo( this.$element.show() );

	require( ['wikia.videoBootstrap'], ve.bind( function( VideoBootstrap ) {
		this.videoInstance = new VideoBootstrap(
			this.$videoWrapper[0],
			window.JSON.parse( data.videopreview.embedCode ),
			've-preview'
		);

		this.verticallyAlign( this.$videoWrapper );

	}, this ) );
};


/**
 * Handle video preview request promise.done
 * @method
 */
ve.ui.WikiaMediaPreviewWidget.prototype.onRequestVideoDone = function( data ) {
	if ( data.videopreview ) {
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
 * Open a media item
 * @method
 * @param {Object} model The media item model to open
 */
ve.ui.WikiaMediaPreviewWidget.prototype.open = function( model ) {
	this.model = model;
	this.$title.text( this.model.title );

	// Init media
	if ( model.type === 'video' ) {
		this.handleVideo();
	} else {
		this.handleImage();
	}
};

/**
 * Close the preview
 * @method
 * @emits close
 */
ve.ui.WikiaMediaPreviewWidget.prototype.onCloseClick = function() {
	this.emit( 'close' );
};
