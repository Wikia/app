/**
 * This module enables double-click-to-edit functionality
 */
jQuery( document ).ready( function( $ ) {
	var url = $( '#ca-edit a' ).attr( 'href' );

	// Wikia change - begin - @author: wladek
	// Support Oasis edit-menu dropdown
	if (!url) {
		url = $( 'a#ca-edit' ).attr( 'href' );
	}
	// Wikia change - end

	if ( url ) {
		mw.util.$content.dblclick( function( e ) {
			e.preventDefault();
			window.location = url;
		} );
	}
} );
