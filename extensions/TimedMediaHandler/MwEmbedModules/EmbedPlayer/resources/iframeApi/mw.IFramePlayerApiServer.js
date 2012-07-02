/**
* iFrame api mapping support 
* 
* enables player api to be accesses cross domain as 
* if the video element was in page dom 
* 
*  native support in: 
*    * Internet Explorer 8.0+
*    * Firefox 3.0+
*    * Safari 4.0+
*    * Google Chrome 1.0+
*    * Opera 9.5+
*    
*  fallback iframe cross domain hack will target IE6/7
*/

( function( mw ) {
	
// Bind apiServer to newEmbedPlayerEvent:
$( mw ).bind( 'newEmbedPlayerEvent', function( event, embedPlayer ) {	
	// Check if the iFrame player api is enabled and we have a parent iframe url: 
	if ( mw.getConfig('EmbedPlayer.EnableIframeApi') 
			&& 
		mw.getConfig( 'EmbedPlayer.IframeParentUrl' ) 
	){
		embedPlayer['iFrameServer'] = new mw.IFramePlayerApiServer( embedPlayer );
	}
});

mw.IFramePlayerApiServer = function( embedPlayer ){
	this.init( embedPlayer );
}

mw.IFramePlayerApiServer.prototype = {	
	// Exported bindings / events. ( all the native html5 events are added in 'init' )		
	'exportedBindings': [
	     'playerReady',
	     'monitorEvent',
	     'onOpenFullScreen',
	     'onCloseFullScreen'
	],
		
	'init': function( embedPlayer ){
		this.embedPlayer = embedPlayer;
		
		// Add the list of native events to the exportedBindings	
		for( var i =0 ; i < mw.EmbedPlayerNative.nativeEvents.length; i++ ){
			var bindName = mw.EmbedPlayerNative.nativeEvents[i];
			// The progress event fires too often for the iframe proxy ( instead use mwEmbed monitorEvent )
			if( bindName != 'progress' ) {				
				this.exportedBindings.push( bindName );
			}
		}
		
		// Allow modules to extend the list of iframeExported bindings
		$( mw ).trigger( 'AddIframePlayerBindings', [ this.exportedBindings ]);
		
		this.addIframeListener();
		this.addIframeSender();
		$( mw ).trigger( 'newIframePlayerServerSide', [embedPlayer]);
	},
	
	/**
	 * Listens to requested methods and triggers their action
	 */
	'addIframeListener': function(){
		var _this = this;		
		mw.log('IFramePlayerApiServer::_addIframeListener');
		$.receiveMessage( function( event ) {			
			_this.handleMsg( event );
		}, this.getParentUrl() );	
	},
	getParentUrl: function(){
		var purl = mw.getConfig( 'EmbedPlayer.IframeParentUrl' );
		if(!purl){
			mw.log("Error: iFramePlayerApiServer:: could not parse parent url. \n" +
				"Player events will be dissabled");
		}
		return purl;
	},
	/**
	 * Add iframe sender bindings:
	 */
	'addIframeSender': function(){		
		var _this = this;		
		// Get the parent page URL as it was passed in, for browsers that don't support
		// window.postMessage (this URL could be hard-coded).
		
		// Set the initial attributes once player is "ready"
		$( this.embedPlayer ).bind( 'playerReady', function(){
			_this.sendPlayerAttributes();
		});		
		// On monitor event package the attributes for cross domain delivery:
		$( this.embedPlayer ).bind( 'monitorEvent', function(){			
			_this.sendPlayerAttributes();
		})

		$.each( this.exportedBindings, function( inx, bindName ){
			$( _this.embedPlayer ).bind( bindName, function( event ){				
				var argSet = $.makeArray( arguments );
				// remove the event from the arg set
				argSet.shift();
				// protect against a jQuery event getting past as an arguments:
				if( argSet[0] && argSet[0].originalEvent ){
					argSet.shift();
				}
				//mw.log("IFramePlayerApiServer::postMessage:: " + bindName + ' arg count:' + argSet.length );
				_this.postMessage({
					'triggerName' : bindName,
					'triggerArgs' : argSet
				})
			});
		});
	},
	
	/**
	 * Send all the player attributes to the host
	 */
	'sendPlayerAttributes': function(){
		var _this = this;
		
		var playerAttributes = mw.getConfig( 'EmbedPlayer.Attributes' );
		var attrSet = { };
		for( var i in playerAttributes ){
			if( i != 'id' ){
				if( typeof this.embedPlayer[ i ] != 'undefined' ){
					attrSet[i] = this.embedPlayer[ i ];
				}
			}
		}
		//mw.log( "IframePlayerApiServer:: sendPlayerAttributes: " + JSON.stringify( attrSet ) );
		_this.postMessage( {
			'attributes' : attrSet 
		} )
	},
	
	'postMessage': function( msgObject ){		
		try {
			var messageString = JSON.stringify( msgObject );
		} catch ( e ){
			mw.log("Error: could not JSON object: " + msgObject + ' ' + e);
			return ;
		}	
		// By default postMessage sends the message to the parent frame:		
		$.postMessage( 
			messageString,
			this.getParentUrl(),
			window.parent
		);
	},
	
	/**
	 * Handle a message event and pass it off to the embedPlayer
	 * 
	 * @param {string} event
	 */
	'handleMsg': function( event ){
		mw.log( 'IFramePlayerApiServer:: handleMsg: ' +  event.data );
		// Check if the server should even be enabled 
		if( !mw.getConfig( 'EmbedPlayer.EnableIframeApi' )){
			mw.log( 'Error: Loading iFrame playerApi but config EmbedPlayer.EnableIframeApi is false');
			return false;
		}
		
		if( !this.eventDomainCheck( event.origin ) ){
			mw.log( 'Error: ' + event.origin + ' domain origin not allowed to send player events');
			return false;
		}		
		// Decode the message 
		var msgObject = JSON.parse( event.data );

		// Call a method:
		if( msgObject.method && this.embedPlayer[ msgObject.method ] ){
			this.embedPlayer[ msgObject.method ].apply( this.embedPlayer, $.makeArray( msgObject.args ) );			
		}
		// Update a attribute
		if( typeof msgObject.attrName != 'undefined' && typeof msgObject.attrValue != 'undefined' ){
			try{
				$( this.embedPlayer ).attr( msgObject.attrName, msgObject.attrValue)
			} catch(e){
				// possible error cant set attribute msgObject.attrName
			}
		}
	},
	
	/**
	 * Check an origin domain against the configuration value: 'EmbedPlayer.IFramePlayer.DomainWhiteList'
	 *  Returns true if the origin domain is allowed to communicate with the embedPlayer
	 *  otherwise returns false. 
	 * 
	 * @parma {string} origin
	 * 		The origin domain to be checked
	 */
	'eventDomainCheck': function( origin ){
		if( mw.getConfig( 'EmbedPlayer.IFramePlayer.DomainWhiteList' ) ){
			// NOTE this is very similar to the apiProxy function: 
			var domainWhiteList =  mw.getConfig('EmbedPlayer.IFramePlayer.DomainWhiteList');
			if( domainWhiteList == '*' ){
				// The default very permissive state
				return true;
			}
			// @@FIXME we should also check protocol to avoid
			// http vs https
			var originDomain = new mw.Uri( origin ).host;
			
			// Check the domains: 
			for ( var i =0; i < domainWhiteList.length; i++ ) {
				whiteDomain = domainWhiteList[i];
				// Check if domain check is a RegEx:
				if( typeof whiteDomain == 'object' ){
					if( originDomain.match( whiteDomain ) ) {
						return true;
					}
				} else {
					if( originDomain == whiteDomain ){
						return true;
					}
				}
			}
		}			
		// If no passing domain was found return false
		return false;
	}
};

} )( window.mw );
