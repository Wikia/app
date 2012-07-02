/**
 * JavaScript for the Nuke MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Nuke
 *
 * @licence GNU GPL v2 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) { $( document ).ready( function() {
	
	function selectPages( check ) {
		$( 'input[type=checkbox]' ).prop( 'checked', check )
	}
	
	$( '#toggleall' ).click( function(){ selectPages( true ); } );
	$( '#togglenone' ).click( function(){ selectPages( false ); } );
	
} ); })( window.jQuery, window.mediaWiki );