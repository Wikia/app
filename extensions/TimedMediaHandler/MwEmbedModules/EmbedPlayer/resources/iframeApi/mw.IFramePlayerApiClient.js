/**
* iFrame api mapping support 
* 
* Client side ( binds a given iFrames to expose the player api ) 
*/

( function( mw ) {

mw.IFramePlayerApiClient = function( iframe, playerProxy ){
	return this.init( iframe , playerProxy );
}
mw.IFramePlayerApiClient.prototype = {
	// flag to register if the iframe is in fullscreen mode
	inFullScreenMode: null,
	
	'exportedMethods': [
		'play',
		'pause'
	],
	// Local store of the previous sate of player proxy
	'_prevPlayerProxy': {},
	
	// Stores the current playerProxy ( can be updated by user js )
	'init': function( iframe , playerProxy, options ){
		this.iframe = iframe;
		this.playerProxy = playerProxy;
		// Set the iframe server
		var srcParts = new mw.Uri( mw.absoluteUrl( $(this.iframe).attr('src') ) );
		this.iframeServer = srcParts.protocol + '://' + srcParts.getAuthority();
		
		this.addPlayerSendApi();
		this.addPlayerReciveApi();
		
		this.addIframeFullscreenBinding();
	},
	'addPlayerSendApi': function(){
		var _this = this;		
		
		// Allow modules to extend the list of iframeExported bindings
		$( mw ).trigger( 'AddIframePlayerMethods', [ this.exportedMethods ]);
		
		$.each( this.exportedMethods, function(na, method){
			_this.playerProxy[ method ] = function(){
				_this.postMessage( {
					'method' : method,
					'args' : $.makeArray( arguments )
				} );
			};
		});
	},
	'addPlayerReciveApi': function(){
		var _this = this;
		$.receiveMessage( function( event ){
			_this.handleReciveMsg( event );
		}, this.iframeServer);
	},
	'addIframeFullscreenBinding': function(){
		var _this = this;
		parentsAbsoluteList = [];
		var fullscreenMode = false;
		var orgSize  = {
			'width' : $( _this.iframe ).width(),
			'height' : $( _this.iframe ).height(),
			'position' : null
		};
		
		// Bind orientation change to resize player ( if fullscreen )
		$(window).bind( 'orientationchange', function(e){
			if( _this.inFullScreenMode ){
				doFullscreen();
			}
		});
		
		var doFullscreen = function(){
			 _this.inFullScreenMode = true;
			// Make the iframe fullscreen
			$( _this.iframe ).css({
				'z-index': mw.getConfig( 'EmbedPlayer.FullScreenZIndex' ) + 1,
				'position': 'absolute',
				'top' : 0,
				'left' : 0,
				'width' : $(window).width(),
				'height' : $(window).height()
			});
			
			// Remove absolute css of the interface parents
			$( _this.iframe ).parents().each( function() {
				//mw.log(' parent : ' + $( this ).attr('id' ) + ' class: ' + $( this ).attr('class') + ' pos: ' + $( this ).css( 'position' ) );
				if( $( this ).css( 'position' ) == 'absolute' ) {
					parentsAbsoluteList.push( $( this ) );
					$( this ).css( 'position', null );
				}
			} );
		}
		var restoreWindowMode = function(){
			 _this.inFullScreenMode = false;
			$( _this.iframe ).css( orgSize );
			// restore any parent absolute pos: 
			$(parentsAbsoluteList).each( function() {	
				$( this ).css( 'position', 'absolute' );
			} );
		};
		
		$( this.playerProxy ).bind( 'onOpenFullScreen', doFullscreen);
		$( this.playerProxy ).bind( 'onCloseFullScreen', restoreWindowMode);
		
	},
	/**
	 * Handle received events
	 */
	'handleReciveMsg': function( event ){
		var _this = this;
		
		// Decode the message 
		var msgObject = JSON.parse( event.data );
		var playerAttributes = mw.getConfig( 'EmbedPlayer.Attributes' );

		// Before we update local attributes check that the object has not been updated by user js
		for( var attrName in playerAttributes ){
			if( attrName != 'id' ){
				if( _this._prevPlayerProxy[ attrName ] != _this.playerProxy[ attrName ] ){
					// mw.log( "IFramePlayerApiClient:: User js update:" + attrName + ' set to: ' + this.playerProxy[ attrName ] + ' != old: ' + _this._prevPlayerProxy[ attrName ] );
					// Send the updated attribute back to the iframe: 
					_this.postMessage({
						'attrName' : attrName,
						'attrValue' : _this.playerProxy[ attrName ]
	 				});
				}
			}
		}
		// Update any attributes
		if( msgObject.attributes ){
			for( var i in msgObject.attributes ){
				if( i != 'id' && i != 'class' && i != 'style' ){
					try{
						this.playerProxy[ i ] = msgObject.attributes[i];
						this._prevPlayerProxy[i] = msgObject.attributes[i];
					} catch( e ){
						mw.log("Error could not set:" + i );
					}
				}
			}
		}
		// Trigger any binding events 
		if( typeof msgObject.triggerName != 'undefined' && msgObject.triggerArgs != 'undefined') {
			//mw.log('IFramePlayerApiClient:: trigger: ' + msgObject.triggerName );
			$( _this.playerProxy ).trigger( msgObject.triggerName, msgObject.triggerArgs );
		}
	},
	'postMessage': function( msgObject ){
		/*mw.log( "IFramePlayerApiClient:: postMessage(): " + JSON.stringify( msgObject ) + 
				' iframe: ' +  this.iframe + ' cw:' + this.iframe.contentWindow + 
				' src: ' + mw.absoluteUrl( $( this.iframe ).attr('src')  ) );*/
		$.postMessage(
			JSON.stringify( msgObject ), 
			mw.absoluteUrl( $( this.iframe ).attr('src') ), 
			this.iframe.contentWindow 
		);
	}
};

//Add the jQuery binding
( function( $ ) {
	$.fn.iFramePlayer = function( readyCallback ){
		if( ! this.selector ){
			this.selector = $( this ).get(0);
		}
		// Append '_ifp' ( iframe player ) to id of real iframe so that 'id', and 'src' attributes don't conflict
		var originalIframeId = ( $( this.selector ).attr( 'id' ) )? $( this.selector ).attr( 'id' ) : Math.floor( 9999999 * Math.random() );
		
		var iframePlayerId = originalIframeId + '_ifp' ; 
		
		// Append the div element proxy after the iframe 
		$( this.selector )
			.attr('id', iframePlayerId)
			.after(
				$('<div />')
				.attr( 'id', originalIframeId )
			);
		
		var playerProxy = $( '#' + originalIframeId ).get(0);		
		var iframe = $('#' + iframePlayerId).get(0);
		if(!iframe){
			mw.log("Error invalid iFramePlayer request");
			return false;
		}
		if( !iframe['playerApi'] ){
			iframe['playerApi'] = new mw.IFramePlayerApiClient( iframe, playerProxy );
		}
		
		// Allow modules to extend the 'iframe' based player
		$( mw ).trigger( 'newIframePlayerClientSide', [ playerProxy ]);
		
		// Bind the iFrame player ready callback
		if( readyCallback ){
			$( playerProxy ).bind( 'playerReady', readyCallback )
		};
		
		// Return the player proxy for chaining player events / attributes
		return $( playerProxy );
	};
} )( jQuery );

} )( window.mw );