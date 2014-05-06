/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	$( document ).ready( function() {

		$( '.mw-htmlform-submit' ).button();

		$( '.contest-submission' ).contestSubmission();

		$( '#mw-input-wpcontestant-email' ).contestEmail();
		
	} );

})( window.jQuery, window.mediaWiki );
