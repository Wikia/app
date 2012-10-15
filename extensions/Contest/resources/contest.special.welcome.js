/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	$( document ).ready( function() {

		$( '#contest-challenges' ).contestChallenges(
			mw.config.get( 'ContestChallenges' ),
			mw.config.get( 'ContestConfig' )
		);
	} );

})( window.jQuery, window.mediaWiki );
