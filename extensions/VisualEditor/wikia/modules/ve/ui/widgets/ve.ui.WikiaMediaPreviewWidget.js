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

	// todo: should we use something that's already built?
	this.$overlay = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-overlay' );

	this.$videoWrapper = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-videoWrapper' );

	this.$body = this.$$( 'body' );

	if( model.type === 'video' ) {
		this.requestVideoPreview();
	} else {
		// handle images
		console.log( model );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaPreviewWidget, ve.ui.Widget );

/* Methods */

ve.ui.WikiaMediaPreviewWidget.prototype.requestVideoPreview = function() {

	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'mediapreview',
			'provider': this.model.provider,
			'videoId': this.model.videoId,
			'title': this.model.title
		}
	} )
	.done( ve.bind( this.onRequestVideoPreviewDone, this ) )
	.fail( ve.bind( this.onRequestFail, this ) );

};

/**
 * Handle video preview request promise.done
 *
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.onRequestVideoPreviewDone = function( data ) {
	console.log( data );

	this.addOverlay();
	var $wrapper = this.$videoWrapper.appendTo( this.$overlay ),
		videoInstance;

	require( ['wikia.videoBootstrap'], function( VideoBootstrap ) {
		videoInstance = new VideoBootstrap( $wrapper[0], window.JSON.parse( data.mediapreview.embedCode ), 've-preview' );
	} );
};

/**
 * Handle video preview request promise.error
 *
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.onRequestFail = function() {
	alert( 'error' );
};

ve.ui.WikiaMediaPreviewWidget.prototype.addOverlay = function() {
	// TODO: check if there's a different way I should be adding an overlay
	this.$body.append( this.$overlay );
};