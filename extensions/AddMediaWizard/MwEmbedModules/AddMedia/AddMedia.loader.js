/**
* Loader for libAddMedia module:
*/
( function( mw, $ ) {
	/* Bind an add media wizard to a given target */
	$.fn.addMediaWizard = function( options ){
		options['target_invoke_button'] = this.selector;
		$( this ).click( function(){
			$.addMediaWizard( options );
		})
	}
	
	/* Run the add media wizard with a given configuration */
	$.addMediaWizard = function( options ){		
		var addMediaDependencies = ['AddMedia'];
		
		// Check if user scripts updated enabled providers
		var enabledProviders = mw.getConfig( 'AddMedia.EnabledProviders' );
		if( typeof options['enabled_provider'] == 'object' ){
			$.extend( enabledProviders, options['enabled_provider'] );
		}
		
		// Add any related provider dependencies:
		$.each( enabledProviders, function( inx, provider ){
			// skip "upload" provider ( special case in-line loader of upload wizard ) 
			if( provider = 'upload' ){
				return true;
			}
			var lib = '';
			if( provider == 'this_wiki' || provider == 'commons' ){
				lib = 'mediaWikiSearch'
			} else {
				lib = provider + 'Search';
			}
			// Add the search library dependency 
			addMediaDependencies.push( lib );
		} );
		var loadingTxt = ( mw.messages.exists( 'addmediawizard-loading' ) )? 
							mw.messages.get( 'addmediawizard-loading' ) : null;
		// Add a loader:
		mw.addDialog( {'title' : loadingTxt, 'content' : $('<div />').loadingSpinner().html() });
		
		mw.loader.using( 'AddMedia', function(){
			var amwObj = new mw.RemoteSearchDriver( options );
			amwObj.createUI();
		})		
	}
	
} )( window.mediaWiki, jQuery );
