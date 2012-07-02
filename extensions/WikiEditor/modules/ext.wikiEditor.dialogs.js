/*
 * JavaScript for WikiEditor Dialogs
 */

$( document ).ready( function() {
	if ( !$.wikiEditor.isSupported( $.wikiEditor.modules.dialogs ) ) {
		return;
	}
	
	// Replace icons
	$.wikiEditor.modules.dialogs.config.replaceIcons( $( '#wpTextbox1' ) );
	
	// Add dialogs module
	$( '#wpTextbox1' ).wikiEditor( 'addModule', $.wikiEditor.modules.dialogs.config.getDefaultConfig() );
} );