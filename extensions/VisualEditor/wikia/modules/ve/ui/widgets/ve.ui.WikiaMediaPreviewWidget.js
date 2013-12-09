/*!
 * VisualEditor UserInterface WikiaMediaPreviewWidget class.
 */

/* global require */


ve.ui.WikiaMediaPreviewWidget = function VeUiWikiaMediaPreviewWidget( config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	console.log( config.title );

	require( ['wikia.nirvana'], function( nirvana ) {
		nirvana.sendRequest( {
			controller: 'VideoHandlerController',
			method: 'getEmbedCode',
			data: {
				fileTitle: config.title,
				width: 700,
				autoplay: 1
			},
			callback: function( data ) {
				console.log( data );
			},
			onErrorCallback: function() {
				// TODO: fill this in
			}
		} );
	} );

	this.$overlay = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaPreviewWidget-overlay' );

	// TODO: check if there's a different way I should be calling $( 'body' )
	$( 'body' ).append( this.$overlay );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaPreviewWidget, ve.ui.Widget );
