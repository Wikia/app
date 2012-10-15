/*
 * JavaScript for WikiEditor Templates
 */

$( document ).ready( function() {
	// Disable for template namespace
	if ( mw.config.get( 'wgNamespaceNumber' ) == 10 ) {
		return true;
	}
	// Add templates module
	$( '#wpTextbox1' ).wikiEditor( 'addModule', 'templates' );
} );