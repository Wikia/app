/*
 * JavaScript for WikiEditor Toolbar
 */

$( document ).ready( function() {
	if ( !$.wikiEditor.isSupported( $.wikiEditor.modules.toolbar ) ) {
		$( '.wikiEditor-oldToolbar' ).show();
		return;
	}
	// The old toolbar is still in place and needs to be removed so there aren't two toolbars
	$( '#toolbar' ).remove();
	// Add toolbar module
	// TODO: Implement .wikiEditor( 'remove' )
	$( '#wpTextbox1' ).wikiEditor(
		'addModule', $.wikiEditor.modules.toolbar.config.getDefaultConfig()
	);
} );
