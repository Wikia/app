( function( mw, $ ) {
/**
* List of domains and hosted location of cortado. Lets clients avoid the security warning 
* for cross domain java applet loading. 
*/	
window.cortadoDomainLocations = {
		'upload.wikimedia.org' : 'http://upload.wikimedia.org/jars/cortado.jar'		
};

mw.EmbedPlayerJava = {

	// Instance name:
	instanceOf: 'Java',
	
	// Set the local applet location for CortadoApplet
	localAppletLocation: mw.getConfig('EmbedPlayer.WebPath' ) + '/binPlayers/cortado/cortado-ovtk-stripped-0.6.0.jar',

	
	// Supported feature set of the cortado applet:
	supports: {
		'playHead' : true,
		'pause' : true,
		'stop' : true,
		'fullscreen' : false,
		'timeDisplay' : true,
		'volumeControl' : false
	},

	/**
	* Output the the embed html
	*/
	embedPlayerHTML: function () {
		var _this = this;
		mw.log( "java play url:" + this.getSrc( this.seek_time_sec ) );

		mw.log('Applet location: ' +  this.getAppletLocation() );
		mw.log('Play media: ' + this.getSrc() );

		// load directly in the page..
		// ( media must be on the same server or applet must be signed )
		var appletCode = '' +
		'<applet id="' + this.pid + '" code="com.fluendo.player.Cortado.class" ' +
		'archive="' + this.getAppletLocation() + '" width="' + parseInt( this.getWidth() ) + '" ' +
		'height="' + parseInt( this.getHeight() ) + '">	' + "\n" +
			'<param name="url" value="' + this.getSrc() + '" /> ' + "\n" +
			'<param name="local" value="false"/>' + "\n" +
			'<param name="keepaspect" value="true" />' + "\n" +
			'<param name="video" value="true" />' + "\n" +
			'<param name="showStatus" value="hide" />' + "\n" +
			'<param name="audio" value="true" />' + "\n" +
			'<param name="seekable" value="true" />' + "\n";

		// Add the duration attribute if set:
		if( this.getDuration() ){
			appletCode += '<param name="duration" value="' + parseFloat( this.getDuration() ) + '" />' + "\n";
		}

			appletCode += '<param name="BufferSize" value="4096" />' +
				'<param name="BufferHigh" value="25">' +
				'<param name="BufferLow" value="5">' +
			'</applet>';

		$( this ).html( appletCode );

		// Start the monitor:
		_this.monitor();
	},

	/**
	* Get the applet location
	*/
	getAppletLocation: function() {
		var mediaSrc = this.getSrc();
		var appletLoc = false;
		if (
			!( mw.isLocalDomain( mediaSrc ) && mw.isLocalDomain( mw.getMwEmbedPath() ) )
		){
			if ( window.cortadoDomainLocations[ new mw.Uri( mediaSrc ).host ] ) {
				appletLoc = window.cortadoDomainLocations[ new mw.Uri( mediaSrc ).host ];
			} else {
				appletLoc = 'http://theora.org/cortado.jar';
			}
		} else {
			// Get the local relative cortado applet location:
			appletLoc = this.localAppletLocation;
		}
		return appletLoc;
	},

	/**
	* Get the embed player time
	*/
	getPlayerElementTime: function() {
		this.getPlayerElement();
		var currentTime = 0;
		if ( this.playerElement ) {
				try {
					// java reads ogg media time.. so no need to add the start or seek offset:
					//mw.log(' ct: ' + this.playerElement.getPlayPosition() + ' ' + this.supportsURLTimeEncoding());
					currentTime = this.playerElement.currentTime;
				} catch ( e ) {
					mw.log( 'could not get time from jPlayer: ' + e );
				}
		}else{
			mw.log(" could not find playerElement " );
		}
		return currentTime;
	},

	/**
	* Seek in the ogg stream
	* NOTE: Cortado seek does not seem to work very well.
	* 
	* @param {Float} percentage Percentage to seek into the stream
	*/
	seek: function( percentage ) {
		mw.log( 'java:seek:p: ' + percentage + ' : ' + this.supportsURLTimeEncoding() + ' dur: ' + this.getDuration() + ' sts:' + this.seek_time_sec );
		this.getPlayerElement();

		if ( this.supportsURLTimeEncoding() ) {
			this.parent_seek( percentage );
		} else if ( this.playerElement ) {
			// do a (generally broken) local seek:
			mw.log( "Cortado seek is not very accurate :: seek::" + ( percentage * parseFloat( this.getDuration() ) ) );
			this.playerElement.currentTime = ( percentage * parseFloat( this.getDuration() ) );
		} else {
			this.doPlayThenSeek( percentage );
		}

		// Run the onSeeking interface update
		this.controlBuilder.onSeek();
	},

	/**
	* Issue a play request then seek to a percentage point in the stream
	* @param {Float} percentage Percentage to seek into the stream
	*/
	doPlayThenSeek: function( percentage ) {
		mw.log( 'doPlayThenSeek' );
		var _this = this;
		this.play();
		var rfsCount = 0;
		var readyForSeek = function() {
			_this.getPlayerElement();
			// if we have .jre ~in theory~ we can seek (but probably not)
			if ( _this.playerElement ) {
				_this.seek( perc );
			} else {
				// try to get player for 10 seconds:
				if ( rfsCount < 200 ) {
					setTimeout( readyForSeek, 50 );
					rfsCount++;
				} else {
					mw.log( 'error:doPlayThenSeek failed' );
				}
			}
		};
		readyForSeek();
	},

	/**
	* Update the playerElement instance with a pointer to the embed object
	*/
	getPlayerElement: function() {
		if( !$( '#' + this.pid ).length ) {
			return false;
		}
		//mw.log( 'getPlayerElement::' + this.pid );
		this.playerElement = $( '#' + this.pid ).get( 0 );
		return this.playerElement;
	},

	/**
	* Issue the doPlay request to the playerElement
	*	calls parent_play to update interface
	*/
	play: function() {
		this.getPlayerElement();
		this.parent_play();
		if ( this.playerElement ) {
			try{
				this.playerElement.play();
			}catch( e ){
				mw.log("EmbedPlayerJava::Could not issue play request");
			}
		}
	},

	/**
	* Pause playback
	* 	calls parent_pause to update interface
	*/
	pause: function() {
		this.getPlayerElement();
		// Update the interface
		this.parent_pause();
		// Call the pause function if it exists:
		if ( this.playerElement ) {
			try{
				this.playerElement.pause();
			}catch( e ){
				mw.log("EmbedPlayerJava::Could not issue pause request");
			}
		}
	}
};

} )( window.mediaWiki, window.jQuery );
