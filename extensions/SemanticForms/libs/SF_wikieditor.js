// create ext if it does not exist yet
/*global wgWikiEditorEnabledModules*/
if ( window.ext == null || typeof( window.ext ) === "undefined" ) {
	window.ext = {};
}

window.ext.wikieditor = {
	// initialize the wikieditor on the specified element
	init : function init ( input_id, params ) {
		jQuery( function() {
		if ( window.mediaWiki ) {
				var input = jQuery( '#' + input_id );

				// load toolbar
				mediaWiki.loader.using( ['jquery.wikiEditor.toolbar', 'jquery.wikiEditor.toolbar.config'] , function(){
					if ( jQuery.wikiEditor.isSupported( jQuery.wikiEditor.modules.toolbar ) ) {
						input.wikiEditor( 'addModule', jQuery.wikiEditor.modules.toolbar.config.getDefaultConfig() );

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
				mediaWiki.loader.using( ['jquery.wikiEditor.dialogs', 'jquery.wikiEditor.dialogs.config'] , function(){
					if ( jQuery.wikiEditor.isSupported( jQuery.wikiEditor.modules.dialogs ) ) {
						jQuery.wikiEditor.modules.dialogs.config.replaceIcons( input );
						input.wikiEditor( 'addModule', $.wikiEditor.modules.dialogs.config.getDefaultConfig() );

					}
				});
			}
		});
	}
};
