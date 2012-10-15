/**
 * JavasSript for the Education Program MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Education_Program
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) { 

	$( document ).ready( function() {
		
		$( '.ep-datepicker-tr' ).find( 'input' ).datepicker( {
			'dateFormat': 'yy-mm-dd'
		} );
		
	} );
	
})( window.jQuery );