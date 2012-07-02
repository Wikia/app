/*
 * JavaScript for WikiEditor Table of Contents
 */

$( document ).ready( function() {
	// Add table of contents module
	$( '#wpTextbox1' ).wikiEditor( 'addModule', 'toc' );
} );
