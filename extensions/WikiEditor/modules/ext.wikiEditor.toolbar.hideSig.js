/*
 * Remove the signature button if the main namespace is edited.
 */
$( document ).ready( function() {
	// This module is designed not to depend on ext.wikiEditor or jquery.wikiEditor.
	// Removing this dependency fixed various bugs, but it does mean that we have to
	// account for the situation where $.wikiEditor is not present
	if ( !$.wikiEditor || !$.wikiEditor.isSupported( $.wikiEditor.modules.toolbar ) ) {
		return;
	}
	if ( $( 'body' ).hasClass( 'ns-0' ) ) {
		$( '#wpTextbox1' ).wikiEditor( 'removeFromToolbar', { 'section': 'main', 'group': 'insert', 'tool': 'signature' } );
	}
});
