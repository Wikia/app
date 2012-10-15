/**
 * JavasSript for the Education Program MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Education_Program
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {
	
	$( document ).ready( function() {

		$( '.ep-org-add' ).closest( 'form' ).submit( function() {
			$( this ).attr( 'action', $( this ).attr( 'action' ).replace( 'NAME_PLACEHOLDER', $( '#newname' ).val() ) );
		} );
		
		$( '.ep-org-add' ).removeAttr( 'disabled' );

	} );

})( window.jQuery );