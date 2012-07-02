/**
 * mediawiki.client has some convenience functions for user agent checks 
 * 
 * TODO this should be combined with or bootstrap jquery.client.js
 */
( function( mw ) {
	
	mw.isMobileDevice = function(){
		return ( mw.isIphone() || mw.isIpod() || mw.isIpad() || mw.isAndroid2() )
	},
	
	mw.isIphone = function(){
		return ( navigator.userAgent.indexOf('iPhone') != -1 && ! mw.isIpad() );
	};
	mw.isIE9 = function(){
		return (/msie 9/.test(navigator.userAgent.toLowerCase()));
	}
	// Uses hack described at:
	// http://www.bdoran.co.uk/2010/07/19/detecting-the-iphone4-and-resolution-with-javascript-or-php/
	mw.isIphone4 = function(){
		return ( mw.isIphone() && ( window.devicePixelRatio && window.devicePixelRatio >= 2 ) );		
	};
	mw.isIpod = function(){
		return (  navigator.userAgent.indexOf('iPod') != -1 );
	};
	mw.isIpad = function(){
		return ( navigator.userAgent.indexOf('iPad') != -1 );
	};
	
	// Android 2 has some restrictions vs other mobile platforms
	mw.isAndroid2 = function(){		
		return ( navigator.userAgent.indexOf( 'Android 2.') != -1 );
	};
	
	/**
	 * Fallforward system by default prefers flash.
	 * 
	 * This is separate from the EmbedPlayer library detection to provide
	 * package loading control NOTE: should be phased out in favor of browser
	 * feature detection where possible
	 * 
	 */
	mw.isHTML5FallForwardNative = function(){
		if( mw.isMobileHTML5() ){
			return true;
		}
		// Check for url flag to force html5:
		if( document.URL.indexOf('forceMobileHTML5') != -1 ){
			return true;
		}
		// Fall forward native:
		// if the browser supports flash ( don't use html5 )
		if( mw.supportsFlash() ){
			return false;
		}
		// No flash return true if the browser supports html5 video tag with
		// basic support for canPlayType:
		if( mw.supportsHTML5() ){
			return true;
		}
		
		return false;
	};
	
	mw.isMobileHTML5 = function(){
		// Check for a mobile html5 user agent:
		if ( mw.isIphone() || 
			 mw.isIpod() || 
			 mw.isIpad() ||
			 mw.isAndroid2()
		){
			return true;
		}
		return false;
	};
	
	mw.supportsHTML5 = function(){
		// Blackberry is evil in its response to canPlayType calls.
		if( navigator.userAgent.indexOf('BlackBerry') != -1 ){
			return false ;
		}
		var dummyvid = document.createElement( "video" );
		if( dummyvid.canPlayType ) {
			return true;
		}
		return false;	
	};
	
	mw.supportsFlash = function(){
		// Check if the client does not have flash and has the video tag
		if ( navigator.mimeTypes && navigator.mimeTypes.length > 0 ) {
			for ( var i = 0; i < navigator.mimeTypes.length; i++ ) {
				var type = navigator.mimeTypes[i].type;
				var semicolonPos = type.indexOf( ';' );
				if ( semicolonPos > -1 ) {
					type = type.substr( 0, semicolonPos );
				}
				if (type == 'application/x-shockwave-flash' ) {
					// flash is installed
					return true;
				}
			}
		}

		// for IE:
		var hasObj = true;
		if( typeof ActiveXObject != 'undefined' ){
			try {
				var obj = new ActiveXObject( 'ShockwaveFlash.ShockwaveFlash' );
			} catch ( e ) {
				hasObj = false;
			}
			if( hasObj ){
				return true;
			}
		}
		return false;
	};
	
} )( window.mediaWiki );