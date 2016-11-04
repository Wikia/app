// create ext if it does not exist yet
/*global wgWikiEditorEnabledModules*/
if ( window.ext === null || typeof( window.ext ) === "undefined" ) {
	window.ext = {};
}

( function ( $, mw ) {

window.ext.wikieditor = {
	// initialize the wikieditor on the specified element
	init : function init ( input_id, params ) {
		$( function() {
			if ( mw ) {
				var input = $( '#' + input_id );

				// load toolbar
				mw.loader.using( ['jquery.wikiEditor.toolbar', 'jquery.wikiEditor.toolbar.config'] , function() {
					if ( $.wikiEditor.isSupported( $.wikiEditor.modules.toolbar ) ) {
						input.wikiEditor( 'addModule', $.wikiEditor.modules.toolbar.config.getDefaultConfig() );

						// hide sig if required
						if ( wgWikiEditorEnabledModules && wgWikiEditorEnabledModules.hidesig === true ) {
							input.wikiEditor( 'removeFromToolbar', {
								'section': 'main',
								'group': 'insert',
								'tool': 'signature'
							} );
						}

					}
				});

				// load dialogs
				mw.loader.using( ['jquery.wikiEditor.dialogs', 'jquery.wikiEditor.dialogs.config'] , function(){
					if ( $.wikiEditor.isSupported( $.wikiEditor.modules.dialogs ) ) {
						$.wikiEditor.modules.dialogs.config.replaceIcons( input );
						input.wikiEditor( 'addModule', $.wikiEditor.modules.dialogs.config.getDefaultConfig() );

					}
				});
			}
		} );
	}
};
}( jQuery, mediaWiki ) );
