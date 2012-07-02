/**
* EmbedPlayer loader
*/
( function( mw, $ ) {
	
	/**
	* Add a DOM ready check for player tags
	*
	* We use 'SetupInterface' binding so other code that depend on the video interface can 
	* work after the 'IntefacesReady' event
	*/
	$( mw ).bind( 'SetupInterface', function( event, callback ){
		// Check if we have tags to rewrite: 
		if( $( mw.getConfig( 'EmbedPlayer.RewriteSelector' )  ).length ) {
			// Rewrite the embedPlayer EmbedPlayer.RewriteSelector and run callback once ready:
			$( mw.getConfig( 'EmbedPlayer.RewriteSelector' ) )
				.embedPlayer( callback );
		} else {
			callback();
		}
	});
	
	/**
	* Add the mwEmbed jQuery loader wrapper 
	*/
	$.fn.embedPlayer = function( readyCallback ){
		var _this = this;
		
		if( this.selector ){
			var playerSelect = this.selector;
		} else {
			var playerSelect = this;
		}
		mw.log( 'jQuery.fn.embedPlayer :: ' + playerSelect );
		
		// Hide videonojs class
		$( '.videonojs' ).hide();

		// Set up the embed video player class request: (include the skin js as well)
		var dependencySet = [
			'mw.EmbedPlayer'
		];
		
		// Add PNG fix code needed:
		if ( $.browser.msie && $.browser.version < 7 ) {
			$.merge( dependencySet, ['jquery.pngFix'] );
		}
		
		// Guess at playback system for 90+% of users the browser indicates playback mode: 
		// NOTE: this does not affect a given playback library being loaded on-demand later. 
		if( ( $.browser.msie && $.browser.version < 9 ) || $.browser.safari ) {			
			$.merge( dependencySet, ['mw.EmbedPlayerJava'] );
		}
		// If video tag is supported add native lib:
		if( document.createElement('video').canPlayType && !$.browser.safari) {
			$.merge( dependencySet, ['mw.EmbedPlayerNative'] )
		}
		
		// Check if the iFrame player api is enabled and we have a parent iframe url: 
		// TODO we might want to move the iframe api to a separate module
		if ( mw.getConfig( 'EmbedPlayer.EnableIframeApi' ) 
				&& 
			mw.getConfig( 'EmbedPlayer.IframeParentUrl' ) 
		){
			$.merge( dependencySet, ['mw.EmbedPlayerNative', 'jquery.postMessage','mw.IFramePlayerApiServer'] );
		}
		
		var rewriteElementCount = 0;
		$( playerSelect).each( function(inx, playerElement){
			var skinName ='';

			// Assign an the element an ID ( if its missing one )
			if ( $( playerElement ).attr( "id" ) == '' ) {
				$( playerElement ).attr( "id", 'v' + ( rewriteElementCount++ ) );
			}
			
			// Add an overlay loader ( firefox has its own native loader )
			if( !$.browser.mozilla ){
				$( playerElement )
					.getAbsoluteOverlaySpinner()
					.attr('id', 'loadingSpinner_' + $( playerElement ).attr('id') )
			}
			// Add core "skin/interface" loader			
			var skinString = $( playerElement ).attr( 'class' );
			if( ! skinString 
					||
				$.inArray( skinString.toLowerCase(), mw.getConfig('EmbedPlayer.SkinList') ) == -1 
			){
				skinName = mw.getConfig( 'EmbedPlayer.DefaultSkin' );
			} else {
				skinName = skinString.toLowerCase();
			}
			// Add the skin to the request
			var skinCaseName = skinName.charAt(0).toUpperCase() + skinName.substr(1);
			$.merge( dependencySet, [ 'mw.PlayerSkin' + skinCaseName ] );
			
			// Allow other modules update the dependencies
			$( mw ).trigger( 'EmbedPlayerUpdateDependencies',
					[ playerElement, dependencySet ] );
		});
		// Remove any duplicates in the dependencySet:
		dependencySet = $.unique( dependencySet );
		// Do the request and process the playerElements with updated dependency set
		mediaWiki.loader.using( dependencySet, function(){
			mw.processEmbedPlayers( playerSelect, readyCallback );
		}, function( e ){
			throw new Error( 'Error loading EmbedPlayer dependency set: ' + e.message  );
		});
	};
	
	/**
	 * Utility loader function to grab configuration for passing into an iframe as a hash target
	 */
	mw.getIframeHash = function( playerId ){
		// Append the configuration and request domain to the iframe hash: 
		var iframeMwConfig =  mw.getNonDefaultConfigObject();
		// Add the parentUrl to the iframe config: 
		iframeMwConfig['EmbedPlayer.IframeParentUrl'] = document.URL;

		return '#' + encodeURIComponent(
			JSON.stringify({
				'mwConfig' :iframeMwConfig,
				'playerId' : playerId
			})
		);
	};

} )( mediaWiki, jQuery );
