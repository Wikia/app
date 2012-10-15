/**
 * mw.EmbedTypes object handles setting and getting of supported embed types:
 * closely mirrors OggHandler so that its easier to share efforts in this area:
 * http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/OggHandler/OggPlayer.js
 */
( function( mw, $ ) {

/**
 * Setup local players and supported mime types In an ideal world we would query the plugin
 * to get what mime types it supports in practice not always reliable/available
 *
 * We can't cleanly store these values per library since player library is sometimes
 * loaded post player detection
 */
// Flash based players:
var kplayer = new mw.MediaPlayer('kplayer', ['video/x-flv', 'video/h264'], 'Kplayer');

// Java based player
var cortadoPlayer = new mw.MediaPlayer( 'cortado', ['video/ogg', 'audio/ogg', 'application/ogg'], 'Java' );

// Native html5 players
var oggNativePlayer = new mw.MediaPlayer( 'oggNative', ['video/ogg', 'audio/ogg', 'application/ogg' ], 'Native' );
var h264NativePlayer = new mw.MediaPlayer( 'h264Native', ['video/h264'], 'Native' );
var webmNativePlayer = new mw.MediaPlayer( 'webmNative', ['video/webm'], 'Native' );

// VLC player
var vlcMimeList = ['video/ogg', 'audio/ogg', 'application/ogg', 'video/x-flv', 'video/mp4', 'video/h264', 'video/x-msvideo', 'video/mpeg'];
var vlcPlayer = new mw.MediaPlayer( 'vlc-player', vlcMimeList, 'Vlc' );

// Generic plugin
var oggPluginPlayer = new mw.MediaPlayer( 'oggPlugin', ['video/ogg', 'application/ogg'], 'Generic' );

	
mw.EmbedTypes = {

	 // MediaPlayers object ( supports methods for quering set of browser players ) 
	mediaPlayers: null,

	// Detect flag for completion
	detect_done:false,

	/**
	 * Runs the detect method and update the detect_done flag
	 *
	 * @constructor
	 */
	init: function() {
		// detect supported types
		this.detect();
		this.detect_done = true;
	},
	
	getMediaPlayers: function(){
		if( this.mediaPlayers  ){
			return this.mediaPlayers;
		}
		this.mediaPlayers = new mw.MediaPlayers();
		// detect available players
		this.detectPlayers();
		return this.mediaPlayers;
	},

	/**
	 * If the browsers supports a given mimetype
	 *
	 * @param {String}
	 *      mimeType Mime type for browser plug-in check
	 */
	supportedMimeType: function( mimeType ) {
		for ( var i =0; i < navigator.plugins.length; i++ ) {
			var plugin = navigator.plugins[i];
			if ( typeof plugin[ mimeType ] != "undefined" )
			 return true;
		}
		return false;
	},

	/**
	 * Detects what plug-ins the client supports
	 */
	detectPlayers: function() {
		mw.log( "embedPlayer: running detect" );		
		// In Mozilla, navigator.javaEnabled() only tells us about preferences, we need to
		// search navigator.mimeTypes to see if it's installed
		try　{
			var javaEnabled = navigator.javaEnabled();
		} catch ( e )　{

		}
		// Some browsers filter out duplicate mime types, hiding some plugins
		var uniqueMimesOnly = $.browser.opera || $.browser.safari;

		// Opera will switch off javaEnabled in preferences if java can't be
		// found. And it doesn't register an application/x-java-applet mime type like
		// Mozilla does.
		if ( javaEnabled && ( navigator.appName == 'Opera' ) ) {
			this.mediaPlayers.addPlayer( cortadoPlayer );
		}

		// ActiveX plugins
		if ( $.browser.msie ) {
			// check for flash
			if ( this.testActiveX( 'ShockwaveFlash.ShockwaveFlash' ) ) {
				this.mediaPlayers.addPlayer( kplayer );
				// this.mediaPlayers.addPlayer( flowPlayer );
			}
			 // VLC
			 if ( this.testActiveX( 'VideoLAN.VLCPlugin.2' ) ) {
				 this.mediaPlayers.addPlayer( vlcPlayer );
			 }

			 // Java ActiveX
			 if ( this.testActiveX( 'JavaWebStart.isInstalled' ) ) {
				 this.mediaPlayers.addPlayer( cortadoPlayer );
			 }

			 // quicktime (currently off)
			 // if ( this.testActiveX(
				// 'QuickTimeCheckObject.QuickTimeCheck.1' ) )
			 // this.mediaPlayers.addPlayer(quicktimeActiveXPlayer);
		 }
		// <video> element
		if ( typeof HTMLVideoElement == 'object' // Firefox, Safari
				|| typeof HTMLVideoElement == 'function' ) // Opera
		{
			// Test what codecs the native player supports:
			try {
				var dummyvid = document.createElement( "video" );
				if( dummyvid.canPlayType ) {
					// Add the webm player
					if( dummyvid.canPlayType('video/webm; codecs="vp8, vorbis"') ){
						this.mediaPlayers.addPlayer( webmNativePlayer );
					}

					// Test for h264:
					if ( dummyvid.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"' ) ) {
						this.mediaPlayers.addPlayer( h264NativePlayer );
					}
					// For now if Android assume we support h264Native (FIXME
					// test on real devices )
					if ( mw.isAndroid2() ){
						this.mediaPlayers.addPlayer( h264NativePlayer );
					}

					// Test for ogg
					if ( dummyvid.canPlayType( 'video/ogg; codecs="theora,vorbis"' ) ) {
						this.mediaPlayers.addPlayer( oggNativePlayer );
					}
				}
			} catch ( e ) {
				mw.log( 'could not run canPlayType ' + e );
			}
		}

		 // "navigator" plugins
		if ( navigator.mimeTypes && navigator.mimeTypes.length > 0 ) {
			for ( var i = 0; i < navigator.mimeTypes.length; i++ ) {
				var type = navigator.mimeTypes[i].type;
				var semicolonPos = type.indexOf( ';' );
				if ( semicolonPos > -1 ) {
					type = type.substr( 0, semicolonPos );
				}
				// mw.log( 'on type: ' + type );
				var pluginName = navigator.mimeTypes[i].enabledPlugin ? navigator.mimeTypes[i].enabledPlugin.name : '';
				if ( !pluginName ) {
					// In case it is null or undefined
					pluginName = '';
				}
				if ( pluginName.toLowerCase() == 'vlc multimedia plugin' || pluginName.toLowerCase() == 'vlc multimedia plug-in' ) {
					this.mediaPlayers.addPlayer( vlcPlayer );
					continue;
				}

				if ( type == 'application/x-java-applet' ) {
					this.mediaPlayers.addPlayer( cortadoPlayer );
					continue;
				}

				if ( (type == 'video/mpeg' || type == 'video/x-msvideo') &&
					pluginName.toLowerCase() == 'vlc multimedia plugin' ) {
					this.mediaPlayers.addPlayer( vlcMozillaPlayer );
				}

				if ( type == 'application/ogg' ) {
					if ( pluginName.toLowerCase() == 'vlc multimedia plugin' ) {
						this.mediaPlayers.addPlayer( vlcMozillaPlayer );
					// else if ( pluginName.indexOf( 'QuickTime' ) > -1 )
					// this.mediaPlayers.addPlayer(quicktimeMozillaPlayer);
					} else {
						this.mediaPlayers.addPlayer( oggPluginPlayer );
					}
					continue;
				} else if ( uniqueMimesOnly ) {
					if ( type == 'application/x-vlc-player' ) {
						this.mediaPlayers.addPlayer( vlcMozillaPlayer );
						continue;
					} else if ( type == 'video/quicktime' ) {
						// this.mediaPlayers.addPlayer(quicktimeMozillaPlayer);
						continue;
					}
				}

				if ( type == 'application/x-shockwave-flash' ) {

					this.mediaPlayers.addPlayer( kplayer );
					// this.mediaPlayers.addPlayer( flowPlayer );

					// check version to add omtk:
					if( navigator.plugins["Shockwave Flash"] ){
						var flashDescription = navigator.plugins["Shockwave Flash"].description;
						var descArray = flashDescription.split( " " );
						var tempArrayMajor = descArray[2].split( "." );
						var versionMajor = tempArrayMajor[0];
						// mw.log("version of flash: " + versionMajor);
					}
					continue;
				}
			}
		}

		// Allow extensions to detect and add their own "players"
		mw.log("EmbedPlayer::trigger:embedPlayerUpdateMediaPlayersEvent");
		$( mw ).trigger( 'embedPlayerUpdateMediaPlayersEvent' , this.mediaPlayers );

	},

	/**
	 * Test IE for activeX by name
	 *
	 * @param {String}
	 * 		name Name of ActiveXObject to look for
	 */
	testActiveX : function ( name ) {
		mw.log("EmbedPlayer::detect: test testActiveX: " + name);
		var hasObj = true;
		try {
			// No IE, not a class called "name", it's a variable
			var obj = new ActiveXObject( '' + name );
		} catch ( e ) {
			hasObj = false;
		}
		return hasObj;
	}
};


} )( mediaWiki, jQuery );
