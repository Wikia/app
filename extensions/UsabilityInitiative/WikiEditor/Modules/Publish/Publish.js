/* JavaScript for WikiEditor Publish module */

$j(document).ready( function() {
	// Check preferences for publish
	if ( !wgWikiEditorEnabledModules.publish ) {
		return true;
	}
	// Add the publish module
	if ( $j.fn.wikiEditor ) {
		$j( 'textarea#wpTextbox1' ).wikiEditor( 'addModule', 'publish' );
	}
});
