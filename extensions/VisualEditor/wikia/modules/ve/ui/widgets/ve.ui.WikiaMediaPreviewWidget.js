/*!
 * VisualEditor UserInterface WikiaMediaPreviewWidget class.
 */

/* global mw */


ve.ui.WikiaMediaPreviewWidget = function VeUiWikiaMediaPreviewWidget( model, config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	ve.bind( this.onRequestPreviewDone, this );

	this.request = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'mediapreview',
			'provider': model.provider,
			'videoId': model.videoId,
			'title': model.title
		}
	} )
		.done( ve.bind( this.onRequestPreviewDone, this ) )
		.fail( ve.bind( this.onRequestPreviewFail, this ) );


	// figure out if it should be $$ or what
	this.$overlay = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-overlay' );

	// TODO: check if there's a different way I should be calling $( 'body' )
	$( 'body' ).append( this.$overlay );
};

/* Methods */

/**
 * Handle video preview request promise.done
 *
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.onRequestPreviewDone = function() {
	alert( 'done' );
};

/**
 * Handle video preview request promise.error
 *
 * @method
 */

ve.ui.WikiaMediaPreviewWidget.prototype.onRequestPreviewFail = function() {
	alert( 'error' );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaPreviewWidget, ve.ui.Widget );
