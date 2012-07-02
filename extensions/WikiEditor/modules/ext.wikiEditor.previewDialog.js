/*
 * JavaScript for WikiEditor Preview Dialog
 */

$( document ).ready( function() {
	// Add preview module
	$( 'textarea#wpTextbox1' ).wikiEditor( 'addModule', 'previewDialog' );
} );
