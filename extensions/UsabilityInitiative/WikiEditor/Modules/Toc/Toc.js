/* JavaScript for WikiEditor Toc module */

$j(document).ready( function() {
	// Check preferences for toolbar
	if ( !wgWikiEditorPreferences || !( wgWikiEditorPreferences.toc && wgWikiEditorPreferences.toc.enable ) ) {
		return true;
	}
	// Add the toc module
	if ( $j.fn.wikiEditor ) {
		$j( 'textarea#wpTextbox1' ).wikiEditor( 'addModule',
			{ 'toc' : { 'rtl' : ( $j( 'body' ).is( '.rtl' ) ) } } );
	}
});
