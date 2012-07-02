/**
 * Script for the Style guide demo extension.
 */
jQuery( document ).ready( function( $ ) {

	// Set up the help system
	$( '.mw-help-field-data' )
		.hide()
		.closest( '.mw-help-field-container' )
			.find( '.mw-help-field-hint' )
				.css( 'display', 'block' ) // <span>, so show() is not enough
				.click( function() {
					$(this)
					.closest( '.mw-help-field-container' )
						.find( '.mw-help-field-data' )
							.slideToggle( 'fast' );
				} );

	// Set up buttons
	$( '.mw-htmlform-submit' ).each( function( i, button ) {
		var	$realButton = $( button ),
			$styleButton = $( '<div>', {
				'class': 'mw-htmlform-button',
				text: $realButton.val()			
			})
			.insertAfter( $realButton.hide() )
			.wrap(
				$( '<div>' ).addClass( 'mw-htmlform-button-wrap' )
			)
			.click( function( e ) {
				$realButton.click();
			} );	
	});
} );
