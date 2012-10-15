/**
 * JavasSript for the Education Program MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Education_Program
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	$( 'input.commons-input' ).imageInput( {
		'apipath': 'http://commons.wikimedia.org/w/api.php?callback=?'
	} );

})( window.jQuery, window.mediaWiki );