/**
* embedPlayer is the base class for html5 video tag javascript abstraction library
* embedPlayer include a few subclasses:
*
* mediaPlayer Media player embed system ie: java, vlc or native.
* mediaElement Represents source media elements
* mw.PlayerControlBuilder Handles skinning of the player controls
*/

( function( mw, $ ) {

	/**
	 * Merge in the default video attributes supported by embedPlayer:
	 * 
	 * TODO this will be moved to php based config.
	 */
	mw.mergeConfig('EmbedPlayer.Attributes', {
		/**
		 * Base html element attributes:
		 */

		// id: Auto-populated if unset
		"id" : null,

		// Width: alternate to "style" to set player width
		"width" : null,

		// Height: alternative to "style" to set player height
		"height" : null,

		/**
		 * Base html5 video element attributes / states also see:
		 * http://www.whatwg.org/specs/web-apps/current-work/multipage/video.html
		 */

		// Media src URI, can be relative or absolute URI
		"src" : null,

		// Poster attribute for displaying a place holder image before loading
		// or playing the video
		"poster" : null,

		// Autoplay if the media should start playing
		"autoplay" : false,

		// Loop attribute if the media should repeat on complete
		"loop" : false,

		// If the player controls should be displayed
		"controls" : true,

		// Video starts "paused"
		"paused" : true,

		// ReadyState an attribute informs clients of video loading state:
		// see: http://www.whatwg.org/specs/web-apps/current-work/#readystate
		"readyState" : 0,

		// Loading state of the video element
		"networkState" : 0,

		// Current playback position
		"currentTime" : 0,

		// Previous player set time
		// Lets javascript use $('#videoId').get(0).currentTime = newTime;
		"previousTime" : 0,

		// Previous player set volume
		// Lets javascript use $('#videoId').get(0).volume = newVolume;
		"previousVolume" : 1,

		// Initial player volume:
		"volume" : 0.75,

		// Caches the volume before a mute toggle
		"preMuteVolume" : 0.75,

		// Media duration: Value is populated via
		// custom data-durationhint attribute or via the media file once its played
		"duration" : null,

		// A hint to the duration of the media file so that duration
		// can be displayed in the player without loading the media file
		'data-durationhint': null,
		
		// Also support direct durationHint attribute ( backwards compatibly )
		// @deprecated please use data-durationhint instead. 
		'durationHint' : null,
		
		// Mute state
		"muted" : false,

		/**
		 * Custom attributes for embedPlayer player: (not part of the html5
		 * video spec)
		 */

		// Default video aspect ratio
		'videoAspect' : '4:3',

		// Start time of the clip
		"start" : 0,

		// End time of the clip
		"end" : null,

		// If the player controls should be overlaid
		// ( Global default via config EmbedPlayer.OverlayControls in module
		// loader.js)
		"overlaycontrols" : true,

		// Attribute to use 'native' controls
		"usenativecontrols" : false,

		// If the player should include an attribution button:
		'attributionbutton' : true,

		// A player error state ( lets you propagate an error instead of a play button )
		// ( while keeping the full player api available )
		'data-playerError': null,

		// If serving an ogg_chop segment use this to offset the presentation time
		// ( for some plugins that use ogg page time rather than presentation time )
		"startOffset" : 0,

		// If the download link should be shown
		"download_link" : true,

		// Content type of the media
		"type" : null
	} );

/**
 * Base embedPlayer object
 *
 * @param {Element}
 *      element, the element used for initialization.
 * @constructor
 */
mw.EmbedPlayer = function( element ) {
	return this.init( element );
};

mw.EmbedPlayer.prototype = {

	// The mediaElement object containing all mediaSource objects
	'mediaElement' : null,

	// Object that describes the supported feature set of the underling plugin /
	// Support list is described in PlayerControlBuilder components
	'supports': { },

	// If the player is done loading ( does not guarantee playability )
	// for example if there is an error playerReady is still set to true once
	// no more loading is to be done
	'playerReadyFlag' : false,

	// Stores the loading errors
	'loadError' : false,

	// Thumbnail updating flag ( to avoid rewriting an thumbnail thats already
	// being updated)
	'thumbnailUpdatingFlag' : false,

	// Poster display flag
	'posterDisplayed' : true,

	// Local variable to hold CMML meeta data about the current clip
	// for more on CMML see: http://wiki.xiph.org/CMML
	'cmmlData': null,

	// Stores the seek time request, Updated by the seek function
	'serverSeekTime' : 0,

	// If the embedPlayer is current 'seeking'
	'seeking' : false,

	// Percent of the clip buffered:
	'bufferedPercent' : 0,

	// Holds the timer interval function
	'monitorTimerId' : null,

	// Buffer flags
	'bufferStartFlag' : false,
	'bufferEndFlag' : false,

	// For supporting media fragments stores the play end time
	'pauseTime' : null,

	// On done playing
	'donePlayingCount' : 0
	,
	// if player events should be Propagated
	'_propagateEvents': true,

	// If the onDone interface should be displayed
	'onDoneInterfaceFlag': true,
	
	// if we should check for a loading spinner in the moitor function: 
	'_checkHideSpinner' : false,
	
	// If pause play controls click controls should be active: 
	'_playContorls' : true,

	/**
	 * embedPlayer
	 *
	 * @constructor
	 *
	 * @param {Element}
	 *      element DOM element that we are building the player interface for.
	 */
	init: function( element ) {
		var _this = this;
		mw.log('EmbedPlayer: initEmbedPlayer: ' + $(element).width() );

		var playerAttributes = mw.getConfig( 'EmbedPlayer.Attributes' );

		// Store the rewrite element tag type
		this.rewriteElementTagName = element.tagName.toLowerCase();

		// Setup the player Interface from supported attributes:
		for ( var attr in playerAttributes ) {
			// We can't use $(element).attr( attr ) because we have to check for boolean attributes:
			if ( element.getAttribute( attr ) != null ) {
				// boolean attributes
				if( element.getAttribute( attr ) == '' ){
					this[ attr ] = true;
				} else {
					this[ attr ] = element.getAttribute( attr );
				}
			} else {
				this[attr] = playerAttributes[attr];
			}
			// string -> boolean
			if( this[ attr ] == "false" ) this[attr] = false;
			if( this[ attr ] == "true" ) this[attr] = true;
		}
		// Hide "controls" if using native player controls:
		if( this.useNativePlayerControls() ){
			_this.controls = false;
		}
		// Set the skin name from the class
		var	sn = $(element).attr( 'class' );

		if ( sn && sn != '' ) {
			var skinList = mw.getConfig('EmbedPlayer.SkinList');
			for ( var n = 0; n < skinList.length; n++ ) {
				if ( sn.indexOf( skinList[n].toLowerCase() ) !== -1 ) {
					this.skinName = skinList[ n ];
				}
			}
		}
		// Set the default skin if unset:
		if ( !this.skinName ) {
			this.skinName = mw.getConfig( 'EmbedPlayer.DefaultSkin' );
		}
		
		// Support custom monitorRate Attribute ( if not use default )
		if( !this.monitorRate ){
			this.monitorRate = mw.getConfig( 'EmbedPlayer.MonitorRate' );
		}

		// Make sure startOffset is cast as an float:
		if ( this.startOffset && this.startOffset.split( ':' ).length >= 2 ) {
			this.startOffset = parseFloat( mw.npt2seconds( this.startOffset ) );
		}

		// Make sure offset is in float:
		this.startOffset = parseFloat( this.startOffset );

		// Set the source duration
		if ( $( element ).attr( 'duration' ) ) {
			_this.duration = $( element ).attr( 'duration' );
		}
		// Add durationHint property form data-durationhint:
		if( _this['data-durationhint']){
			_this.durationHint = _this['data-durationhint'];
		}
		// Update duration from provided durationHint
		if ( _this.durationHint && ! _this.duration){
			_this.duration = mw.npt2seconds( _this.durationHint );
		}
		
		// Make sure duration is a float:
		this.duration = parseFloat( this.duration );
		mw.log( 'EmbedPlayer::mediaElement:' + this.id + " duration is: " + this.duration );

		// Set the player size attributes based loaded video element:
		this.loadPlayerSize( element );

		// Set the plugin id
		this.pid = 'pid_' + this.id;

		// Grab any innerHTML and set it to missing_plugin_html
		// NOTE: we should strip "source" tags instead of checking and skipping
		if ( element.innerHTML != '' && element.getElementsByTagName( 'source' ).length == 0 ) {
			// mw.log( 'innerHTML: ' + element.innerHTML );
			this.user_missing_plugin_html = element.innerHTML;
		}
		// Add the mediaElement object with the elements sources:
		this.mediaElement = new mw.MediaElement( element );
	},
	/**
	 * Bind helpers to help iOS retain bind context
	 *
	 * Yes, iOS will fail when you run $( embedPlayer ).bind() 
	 * but "work" when you run embedPlayer.bind() if the script urls are from diffrent "resources" 
	 */
	bindHelper: function( name, callback ){
		$( this ).bind( name, callback );
	},
	unbindHelper: function( name ){
		$( this ).unbind( name ); 
	},
	triggerQueueCallback: function( name, callback ){
		$( this ).triggerQueueCallback( name, callback );
	},
	triggerHelper: function( name, obj ){
		$( this ).trigger( name, obj );
	},
	/**
	 * Stop events from Propagation and blocks interface updates and trigger events.
	 * @return
	 */
	stopEventPropagation: function(){
		this.stopMonitor();
		this._propagateEvents = false;
	},
	/**
	 * Restores event propagation
	 * @return
	 */
	restoreEventPropagation: function(){
		this._propagateEvents = true;
		this.startMonitor();
	},

	enablePlayControls: function(){
		if( this.useNativePlayerControls() )
			return ;
		this._playContorls = true;
		// re-enable hover: 
		this.$interface.find( '.play-btn' )
			.buttonHover()
			.css('cursor', 'pointer' );
		
		this.controlBuilder.enableSeekBar();
		$( this ).trigger( 'onEnableSeekBar');
	},
	disablePlayControls: function(){
		if( this.useNativePlayerControls() ){
			return ;
		}
		this._playContorls = false;
		// trun off hover: 
		this.$interface.find( '.play-btn' )
			.unbind('mouseenter mouseleave')
			.css('cursor', 'default' );

		this.controlBuilder.disableSeekBar();
		$( this ).trigger( 'onDisableSeekBar');
	},

	/**
	 * For plugin-players to update supported features
	 */
	updateFeatureSupport: function(){
		$( this ).trigger('updateFeatureSupportEvent', this.supports );
		return ;
	},
	/**
	* Apply Intrinsic Aspect ratio of a given image to a poster image layout 
	*/
	applyIntrinsicAspect: function(){
		// Check if a image thumbnail is present:
		if(  this.$interface && this.$interface.find('.playerPoster').length ){
			var img = this.$interface.find('.playerPoster').get(0);
			var pHeight = $( this ).height();
			// Check for intrinsic width and maintain aspect ratio
			if( img.naturalWidth && img.naturalHeight ){
				var pWidth = parseInt(  img.naturalWidth / img.naturalHeight * pHeight);
				if( pWidth > $( this ).width() ){
					pWidth = $( this ).width();
					pHeight =  parseInt( img.naturalHeight / img.naturalWidth * pWidth );
				}
				$( img ).css({
					'height' : pHeight + 'px',
					'width':  pWidth + 'px',
					'left': ( ( $( this ).width() - pWidth ) * .5 ) + 'px',
					'top': ( ( $( this ).height() - pHeight ) * .5 ) + 'px',
					'position' : 'absolute'
				});
			}
		}
	},
	/**
	 * Set the width & height from css style attribute, element attribute, or by
	 * default value if no css or attribute is provided set a callback to
	 * resize.
	 *
	 * Updates this.width & this.height
	 *
	 * @param {Element}
	 *      element Source element to grab size from
	 */
	loadPlayerSize: function( element ) {
		// check for direct element attribute:
		this.height = element.height ? element.height + '' : $(element).css( 'height' );
		this.width = element.width ? element.width + '' : $(element).css( 'width' );
		
		// Special check for chrome 100% with re-mapping to 32px
		// Video embed at 32x32 will have to wait for intrensic video size later on
		if( this.height == '32px' || this.height =='32px' ){
			this.width = '100%';
			this.height = '100%';
		}
		mw.log('EmbedPlayer::loadPlayerSize: css size:' + this.width + ' h: '  + this.height);

		// Set to parent size ( resize events will cause player size updates)
		if( this.height.indexOf('100%') != -1 || this.width.indexOf('100%') != -1 ){
			$relativeParent = $(element).parents().filter(function() {
				 // reduce to only relative position or "body" elements
				 return $(this).is('body') || $(this).css('position') == 'relative';
			}).slice(0,1); // grab only the "first"
			this.width = $relativeParent.width();
			this.height = $relativeParent.height();
		}
		// Make sure height and width are a number
		this.height = parseInt( this.height );
		this.width = parseInt( this.width );

		// Set via attribute if CSS is zero or NaN and we have an attribute value:
		this.height = ( this.height==0 || isNaN( this.height )
				&& $(element).attr( 'height' ) ) ?
						parseInt( $(element).attr( 'height' ) ): this.height;
		this.width = ( this.width == 0 || isNaN( this.width )
				&& $(element).attr( 'width' ) )?
						parseInt( $(element).attr( 'width' ) ): this.width;


		// Special case for audio

		// Firefox sets audio height to "0px" while webkit uses 32px .. force zero:
		if( this.isAudio() && this.height == '32' ) {
			this.height = 20;
		}

		// Use default aspect ration to get height or width ( if rewriting a
		// non-audio player )
		if( this.isAudio() && this.videoAspect ) {
			var aspect = this.videoAspect.split( ':' );
			if( this.height && !this.width ) {
				this.width = parseInt( this.height * ( aspect[0] / aspect[1] ) );
			}
			if( this.width && !this.height ) {
				var apectRatio = ( aspect[1] / aspect[0] );
				this.height = parseInt( this.width * ( aspect[1] / aspect[0] ) );
			}
		}

		// On load sometimes attr is temporally -1 as we don't have video metadata yet.
		// or in IE we get NaN for width height
		//
		// NOTE: browsers that do support height width should set "waitForMeta" flag in addElement
		if( ( isNaN( this.height )|| isNaN( this.width ) ) ||
			( this.height == -1 || this.width == -1 ) ||
				// Check for firefox defaults
				// Note: ideally firefox would not do random guesses at css
				// values
				( (this.height == 150 || this.height == 64 ) && this.width == 300 )
			) {
			var defaultSize = mw.getConfig( 'EmbedPlayer.DefaultSize' ).split( 'x' );
			if( isNaN( this.width ) ){
				this.width = defaultSize[0];
			}

			// Special height default for audio tag ( if not set )
			if( this.isAudio() ) {
				this.height = 20;
			}else{
				this.height = defaultSize[1];
			}
		}
	},
	/**
	 * Resize the player to a new size preserving aspect ratio Wraps the
	 * controlBuilder.resizePlayer function
	 */
	resizePlayer: function( size , animate, callback){
		mw.log("EmbedPlayer::resizePlayer:" + size.width + ' x ' + size.height );

		// Check if we are native display then resize the playerElement directly
		if( this.useNativePlayerControls() ){
			if( animate ){
				$( this.getPlayerElement() ).animate( size , callback);
			} else {
				$( this.getPlayerElement() ).css( size );
				if( callback ) {
					callback();
				}
			}
		} else {
			this.controlBuilder.resizePlayer( size, animate, callback);
		}
		$( this ).trigger( 'onResizePlayer', [size, animate] );
	},

	/**
	 * Get the player pixel width not including controls
	 *
	 * @return {Number} pixel height of the video
	 */
	getPlayerWidth: function() {
		return $( this ).width();
	},

	/**
	 * Get the player pixel height not including controls
	 *
	 * @return {Number} pixel height of the video
	 */
	getPlayerHeight: function() {
		return $( this ).height();
	},

	/**
	 * Check player for sources. If we need to get media sources form an
	 * external file that request is issued here
	 */
	checkPlayerSources: function() {
		mw.log( 'EmbedPlayer::checkPlayerSources: ' + this.id );
		var _this = this;

		// Allow plugins to block on sources lookup ( cases where we just have an api key for example )
		$( _this ).triggerQueueCallback( 'checkPlayerSourcesEvent', function(){
			_this.setupSourcePlayer();
		});
	},

	/**
	 * Check if the embedPlayer has text tracks
	 * 
	 * @return
	 */
	hasTextTracks: function(){
		if( !this.mediaElement ){
			return false;
		}
		return ( this.mediaElement.getTextTracks().length > 0 );
	},
	/**
	 * Get text tracks from the mediaElement
	 */
	getTextTracks: function(){
		if( !this.mediaElement ){
			return [];
		}
		return this.mediaElement.getTextTracks();
	},
	/**
	 * Empty the player sources
	 */
	emptySources: function(){
		if( this.mediaElement ){
			this.mediaElement.sources = [];
			this.mediaElement.selectedSource = null;
		}
		this.selectedPlayer =null;
	},

	/**
	 * Switch and play a video source ( useful for ads or bumper videos )
	 *
	 * Only works while video is in active play back. Only tested with native
	 * playback atm.
	 */
	switchPlaySrc: function(){
		mw.log("Error: only native playback supports insertAndPlaySource right now");
	},

	/**
	 * Set up the select source player
	 *
	 * issues autoSelectSource call
	 *
	 * Sets load error if no source is playable
	 */
	setupSourcePlayer: function() {
		mw.log("EmbedPlayer::setupSourcePlayer: " + this.id + ' sources: ' + this.mediaElement.sources.length );
		var prevPlayer = this.selectedPlayer;
		// Autoseletct the media source
		this.mediaElement.autoSelectSource();
		
		// Auto select player based on default order
		if ( this.mediaElement.selectedSource ) {
			this.selectedPlayer = mw.EmbedTypes.getMediaPlayers().defaultPlayer( this.mediaElement.selectedSource.mimeType );
		} else {
			mw.log( 'Error: setupSourcePlayer:: No source Auto Selected:' + this.type );
		}
		
		if( !this.selectedPlayer ){
			this.showPluginMissingHTML();
			return ;
		}
		if ( prevPlayer != this.selectedPlayer ) {
			// Inherit the playback system of the selected player:
			this.updatePlaybackInterface();
		} else {
			// Show the interface: 
			this.$interface.find( '.control-bar,.play-btn-large').show();
		}
	},

	/**
	 * Updates the player interface 
	 * 
	 * Loads and inherit methods from the selected player interface.
	 *
	 * @param {Function}
	 *      callback Function to be called once playback-system has been
	 *      inherited
	 */
	updatePlaybackInterface: function( callback ) {
		var _this = this;
		mw.log( "EmbedPlayer::updatePlaybackInterface: duration is: " + this.getDuration() + ' playerId: ' + this.id );
		// Clear out any non-base embedObj methods:
		if ( this.instanceOf ) {
			eval( 'var tmpObj = mw.EmbedPlayer' + this.instanceOf );
			for ( var i in tmpObj ) { // for in loop oky for object
				if ( this[ 'parent_' + i ] ) {
					this[i] = this[ 'parent_' + i];
				} else {
					this[i] = null;
				}
			}
		}

		// Set up the new embedObj
		mw.log( 'EmbedPlayer::updatePlaybackInterface: embedding with ' + this.selectedPlayer.library );
		this.selectedPlayer.load( function() {
			_this.updateLoadedPlayerInterface( callback );
		});
	},
	/**
	 * Update a loaded player interface by setting local methods to the 
	 * updated player prototype methods
	 * 
	 * @parma {function}
	 * 		callback function called once player has been loaded
	 */
	updateLoadedPlayerInterface: function( callback ){
		var _this = this;
		mw.log( 'EmbedPlayer::updateLoadedPlayerInterface ' + _this.selectedPlayer.library + " player loaded for " + _this.id );

		// Get embed library player Interface
		var playerInterface = mw[ 'EmbedPlayer' + _this.selectedPlayer.library ];

		for ( var method in playerInterface ) {
			if ( _this[method] && !_this['parent_' + method] ) {
				_this['parent_' + method] = _this[method];
			}
			_this[ method ] = playerInterface[method];
		}
		// Update feature support
		_this.updateFeatureSupport();
		// Update duration
		_this.getDuration();
		// Run callback in timeout to avoid function stacking
		setTimeout(function(){
			_this.showPlayer();
			// Run the callback if provided
			if ( callback && $.isFunction( callback ) ){
				callback();
			}
		}, 0);
	},

	/**
	 * Select a player playback system
	 *
	 * @param {Object}
	 *      player Player playback system to be selected player playback
	 *      system include vlc, native, java etc.
	 */
	selectPlayer: function( player ) {
		var _this = this;
		if ( this.selectedPlayer.id != player.id ) {
			this.selectedPlayer = player;
			this.updatePlaybackInterface( function(){
				// Hide / remove track container
				_this.$interface.find( '.track' ).remove();
				// We have to re-bind hoverIntent ( has to happen in this scope )
				if( ! _this.useNativePlayerControls() && _this.controls && _this.controlBuilder.isOverlayControls() ){
					_this.controlBuilder.showControlBar();
					_this.$interface.hoverIntent({
						'sensitivity': 4,
						'timeout' : 2000,
						'over' : function(){
							_this.controlBuilder.showControlBar();
						},
						'out' : function(){
							_this.controlBuilder.hideControlBar();
						}
					});
				}
			});
		}
	},

	/**
	 * Get a time range from the media start and end time
	 *
	 * @return startNpt and endNpt time if present
	 */
	getTimeRange: function() {
		var end_time = ( this.controlBuilder.longTimeDisp )? '/' + mw.seconds2npt( this.getDuration() ) : '';
		var defaultTimeRange = '0:00' + end_time;
		if ( !this.mediaElement ){
			return defaultTimeRange;
		}
		if ( !this.mediaElement.selectedSource ){
			return defaultTimeRange;
		}
		if ( !this.mediaElement.selectedSource.endNpt ){
			return defaultTimeRange;
		}
		return this.mediaElement.selectedSource.startNpt + this.mediaElement.selectedSource.endNpt;
	},

	/**
	 * Get the duration of the embed player
	 */
	getDuration: function() {
		if ( isNaN(this.duration)  &&  this.mediaElement && this.mediaElement.selectedSource &&
		     typeof this.mediaElement.selectedSource.durationHint != 'undefined' ){
			this.duration = this.mediaElement.selectedSource.durationHint;
		}
		return this.duration;
	},

	/**
	 * Get the player height
	 */
	getHeight: function() {
		return this.height;
	},

	/**
	 * Get the player width
	 */
	getWidth: function(){
		return this.width;
	},

	/**
	 * Check if the selected source is an audio element:
	 */
	isAudio: function(){
		return 	( this.rewriteElementTagName == 'audio'
				||
				( this.mediaElement && this.mediaElement.selectedSource.mimeType.indexOf('audio/') !== -1 )
		);
	},

	/**
	 * Get the plugin embed html ( should be implemented by embed player interface )
	 */
	embedPlayerHTML: function() {
		return 'Error: function embedPlayerHTML should be implemented by embed player interface ';
	},

	/**
	 * Seek function ( should be implemented by embedPlayer interface
	 * playerNative, playerKplayer etc. ) embedPlayer seek only handles URL
	 * time seeks
	 * @param {Float}
	 * 			percent of the video total length to seek to
	 */
	seek: function( percent ) {
		var _this = this;
		this.seeking = true;
		// Do argument checking:
		if( percent < 0 ){
			percent = 0;
		}
		
		if( percent > 1 ){
			percent = 1;
		}
		// set the playhead to the target position
		this.updatePlayHead( percent );

		// See if we should do a server side seek ( player independent )
		if ( this.supportsURLTimeEncoding() ) {
			mw.log( 'EmbedPlayer::seek:: updated serverSeekTime: ' + mw.seconds2npt ( this.serverSeekTime ) +
					' currentTime: ' + _this.currentTime );
			// make sure we need to seek:
			if( _this.currentTime == _this.serverSeekTime ){
				return ;
			}

			this.stop();
			this.didSeekJump = true;
			// Make sure this.serverSeekTime is up-to-date:
			this.serverSeekTime = mw.npt2seconds( this.startNpt ) + parseFloat( percent * this.getDuration() );
		}
		// Run the onSeeking interface update
		// NOTE controlBuilder should really bind to html5 events rather
		// than explicitly calling it or inheriting stuff.
		this.controlBuilder.onSeek();
	},

	/**
	 * Seeks to the requested time and issues a callback when ready (should be
	 * overwritten by client that supports frame serving)
	 */
	setCurrentTime: function( time, callback ) {
		mw.log( 'Error: setCurrentTime not overriden' );
	},

	/**
	 * On clip done action. Called once a clip is done playing
	 * TODO clean up end sequence flow
	 */
	postSequence: false,
	onClipDone: function() {
		var _this = this;
		// Don't run onclipdone if _propagateEvents is off
		if( !_this._propagateEvents ){
			return ;
		}
		mw.log( 'EmbedPlayer::onClipDone: propagate:' +  _this._propagateEvents + ' id:' + this.id + ' doneCount:' + this.donePlayingCount + ' stop state:' +this.isStopped() );
		
		// Only run stopped once:
		if( !this.isStopped() ){
			this.stop();
			// Show the control bar:
			this.controlBuilder.showControlBar();

			// Update the clip done playing count:
			this.donePlayingCount ++;

			// TOOD we should improve the end event flow
			// First end event for ads or current clip ended bindings
			this.stopEventPropagation();
			mw.log("EmbedPlayer:: trigger: ended");
			$( this ).trigger( 'ended' );
			this.restoreEventPropagation();
			
			mw.log("EmbedPlayer::onClipDone:Trigged ended, continue? " + this.onDoneInterfaceFlag);
			
			// A secondary end event for playlist and clip sequence endings
			if( this.onDoneInterfaceFlag ){
				mw.log("EmbedPlayer:: trigger: postEnded");
				$( this ).trigger( 'postEnded' );
			}
		
			// if the ended event did not trigger more timeline actions run the actual stop:
			if( this.onDoneInterfaceFlag ){
				mw.log("EmbedPlayer::onDoneInterfaceFlag=true do interface done");
				// Prevent the native "onPlay" event from propagating that happens when we rewind:
				this.stopEventPropagation();
				this.stop();
				
				// Check if we have the "loop" property set
				if( this.loop ) {
					this.restoreEventPropagation(); 
					this.play();
					return;
				}
				
				// Stop the clip (load the thumbnail etc)
				this.serverSeekTime = 0;
				this.updatePlayHead( 0 );

				// An event for once the all ended events are done.
				mw.log("EmbedPlayer:: trigger: onEndedDone");
				$( this ).trigger( 'onEndedDone' );
				
				setTimeout(function(){
					_this.restoreEventPropagation(); 
				}, mw.getConfig( 'EmbedPlayer.MonitorRate' ) );
				
			}
		}
	},


	/**
	 * Shows the video Thumbnail, updates pause state
	 */
	showThumbnail: function() {
		var _this = this;
		mw.log( 'EmbedPlayer::showThumbnail' + this.posterDisplayed );

		// Close Menu Overlay:
		this.controlBuilder.closeMenuOverlay();

		// update the thumbnail html:
		this.updatePosterHTML();

		this.paused = true;
		this.posterDisplayed = true;
		// Make sure the controlBuilder bindings are up-to-date
		this.controlBuilder.addControlBindings();

		// Once the thumbnail is shown run the mediaReady trigger (if not using native controls)
		if( !this.useNativePlayerControls() ){
			mw.log("mediaLoaded");
			$( this ).trigger( 'mediaLoaded' );
		}
	},

	/**
	 * Show the player
	 */
	showPlayer: function () {
		mw.log( 'EmbedPlayer:: Show player: ' + this.id + ' interace: w:' + this.width + ' h:' + this.height );
		var _this = this;
		// Remove the player loader spinner if it exists
		this.hidePlayerSpinner();
		// Set-up the local controlBuilder instance:
		this.controlBuilder = new mw.PlayerControlBuilder( this );

		// Set up local jQuery object reference to "mwplayer_interface"
		this.getPlayerInterface();

		// If a isPersistentNativePlayer ( overlay the controls )
		if( !this.useNativePlayerControls() && this.isPersistentNativePlayer() ){
			this.$interface.css({
				'position' : 'absolute',
				'top' : '0px',
				'left' : '0px',
				'background': null
			});
			$( this ).show();
		}
		if(  !this.useNativePlayerControls() && !this.isPersistentNativePlayer() && !_this.controlBuilder.isOverlayControls() ){
			// Update the video size per available control space.
			$(this).css('height', this.height - _this.controlBuilder.height );
		}


		// Add controls if enabled:
		if ( ! this.useNativePlayerControls() && this.controls ) {
			this.controlBuilder.addControls();
		}

		// Update Thumbnail for the "player"
		this.updatePosterHTML();

		// Update temporal url if present
		this.updateTemporalUrl();

		// Check for intrinsic width and maintain aspect ratio
		setTimeout(function(){
			_this.applyIntrinsicAspect();
		}, 0);

		// Update the playerReady flag
		this.playerReadyFlag = true;
		// trigger the player ready event;
		$(this).trigger('playerReady');

		// Right before player autoplay ... check if there are any errors that prevent playback or player:
		if( this['data-playerError'] ){
			this.showErrorMsg( this['data-playerError'] );
			return ;
		}
		// Auto play if not on an iPad with iOS > 3 
		if (this.autoplay && (!mw.isIOS() || mw.isIpad3() ) ) {
			mw.log( 'EmbedPlayer::showPlayer::Do autoPlay' );			
			_this.play();
		}
	},
	getPlayerInterface: function(){
		if( !this.$interface ){
			var posObj = {
					'width' : this.width + 'px',
					'height' : this.height + 'px'
			};
			if( !mw.getConfig( 'EmbedPlayer.IsIframeServer' ) ){
				posObj['position'] = 'relative';
			}
			// Make sure we have mwplayer_interface
			$( this ).wrap(
				$('<div>')
				.addClass( 'mwplayer_interface ' + this.controlBuilder.playerClass )
				.css( posObj )
			)
			// position the "player" absolute inside the relative interface
			// parent:
			.css('position', 'absolute');
		}
		this.$interface = $( this ).parent( '.mwplayer_interface' );
		return this.$interface;
	},
	/**
	 * Media fragments handler based on:
	 * http://www.w3.org/2008/WebVideo/Fragments/WD-media-fragments-spec/#fragment-dimensions
	 *
	 * We support seconds and npt ( normal play time )
	 *
	 * Updates the player per fragment url info if present
	 *
	 */
	updateTemporalUrl: function(){
		var sourceHash = /[^\#]+$/.exec( this.getSrc() ).toString();
		if( sourceHash.indexOf('t=') === 0 ){
			// parse the times
			var times = sourceHash.substr(2).split(',');
			if( times[0] ){
				// update the current time
				this.currentTime = mw.npt2seconds( times[0].toString() );
			}
			if( times[1] ){
				this.pauseTime = mw.npt2seconds( times[1].toString() );
				// ignore invalid ranges:
				if( this.pauseTime < this.currentTime ){
					this.pauseTime = null;
				}
			}
			// Update the play head
			this.updatePlayHead( this.currentTime / this.duration );
			// Update status:
			this.controlBuilder.setStatus( mw.seconds2npt( this.currentTime ) );
		}
	},

	/**
	 * Show an error message on the player
	 * 
	 * @param {string}
	 *            errorMsg
	 */
	showErrorMsg: function( errorMsg ){
		// remove a loading spinner: 
		this.hidePlayerSpinner();
		
		if( this.$interface ){
			$target = this.$interface;
		} else{
			$target = $(this);
		}
		$target.append(
			$('<div />').addClass('error').text(
				errorMsg
			)
		)
		// Hide the interface components
		.find( '.control-bar,.play-btn-large').hide();		
		return ;
	},
	
	/**
	 * Get missing plugin html (check for user included code)
	 * 
	 * @param {String}
	 *            [misssingType] missing type mime
	 */
	showPluginMissingHTML: function( ) {
		mw.log("EmbedPlayer::showPluginMissingHTML");
		// Hide loader
		this.hidePlayerSpinner();
		
		// Error in loading media ( trigger the mediaLoadError )
		$( this ).trigger( 'mediaLoadError' );
		
		// We don't distiguish between mediaError and mediaLoadError right now 
		// TODO fire mediaError only on failed to recive audio/video  data. 
		$( this ).trigger( 'mediaError' );
		
		
		// Check if there is a more specific error: 
		if( this['data-playerError'] ){
			this.showErrorMsg( this['data-playerError'] );
			return ;
		}
		
		// Set the top level container to relative position:
		$( this ).css('position', 'relative');
		
		// Control builder ( for play button )
		this.controlBuilder = new mw.PlayerControlBuilder( this );					
		
		// Make sure interface is available
		this.getPlayerInterface();
		
		// Update the poster and html:
		this.updatePosterHTML();
		// on iOS devices don't try to add warnings
		if( !this.mediaElement.sources.length || mw.isIOS() || !mw.getConfig('EmbedPlayer.NotPlayableDownloadLink') ){
			var noSourceMsg = gM('mwe-embedplayer-missing-source');
			$( this ).trigger( 'NoSourcesCustomError', function( customErrorMsg ){
				if( customErrorMsg){
					noSourceMsg = customErrorMsg;
				}
        	});
			
			// Add the no sources error:
			this.$interface.append( 
				$('<div />')
				.css({
					'position' : 'absolute',
					'top' : ( this.height /2 ) - 10, 
					'left': this.left/2
				})
				.addClass('error')
				.html( noSourceMsg )
			);
			
			$( this ).find('.play-btn-large').remove();
		} else {
			// Add the warning
			this.controlBuilder.addWarningBinding( 'EmbedPlayer.DirectFileLinkWarning',
				gM( 'mwe-embedplayer-download-warn', mw.getConfig('EmbedPlayer.FirefoxLink') )
			);
			$( this ).show();
			// Make sure we have a play btn:
			if( $( this ).find('.play-btn-large').length == 0) {
				this.$interface.append(
						this.controlBuilder.getComponent( 'playButtonLarge' )
				);
			}
			
			// Set the play button to the first available source:
			this.$interface.find('.play-btn-large')
			.show()
			.unbind('click')
			.wrap(
				$('<a />').attr( {
					'target' : '_new',
					'href': this.mediaElement.sources[0].getSrc(),
					'title' : gM('mwe-embedplayer-play_clip')
				} )
			);
		}
		// TODO we should have a smart done Loading system that registers player
		// states
		// http://www.whatwg.org/specs/web-apps/current-work/#media-element
	},

	/**
	 * Update the video time request via a time request string
	 *
	 * @param {String}
	 *      timeRequest video time to be updated
	 */
	updateVideoTimeReq: function( timeRequest ) {
		mw.log( 'EmbedPlayer::updateVideoTimeReq:' + timeRequest );
		var timeParts = timeRequest.split( '/' );
		this.updateVideoTime( timeParts[0], timeParts[1] );
	},

	/**
	 * Update Video time from provided startNpt and endNpt values
	 *
	 * @param {String}
	 *      startNpt the new start time in npt format ( hh:mm:ss.ms )
	 * @pamra {String} 
	 * 		endNpt the new end time in npt format ( hh:mm:ss.ms )
	 */
	updateVideoTime: function( startNpt, endNpt ) {
		// update media
		this.mediaElement.updateSourceTimes( startNpt, endNpt );

		// update mv_time
		this.controlBuilder.setStatus( startNpt + '/' + endNpt );

		// reset slider
		this.updatePlayHead( 0 );

		// Reset the serverSeekTime if urlTimeEncoding is enabled 
		if ( this.supportsURLTimeEncoding() ) {
			this.serverSeekTime = 0;
		} else {
			this.serverSeekTime = mw.npt2seconds( startNpt );
		}
	},


	/**
	 * Update Thumb time with npt formated time
	 *
	 * @param {String}
	 *      time NPT formated time to update thumbnail
	 */
	updateThumbTimeNPT: function( time ) {
		this.updateThumbTime( mw.npt2seconds( time ) - parseInt( this.startOffset ) );
	},

	/**
	 * Update the thumb with a new time
	 *
	 * @param {Float}
	 *      floatSeconds Time to update the thumb to
	 */
	updateThumbTime:function( floatSeconds ) {
		// mw.log('updateThumbTime:'+floatSeconds);
		var _this = this;
		if ( typeof this.orgThumSrc == 'undefined' ) {
			this.orgThumSrc = this.poster;
		}
		if ( this.orgThumSrc.indexOf( 't=' ) !== -1 ) {
			this.lastThumbUrl = mw.replaceUrlParams( this.orgThumSrc,
				{
					't' : mw.seconds2npt( floatSeconds + parseInt( this.startOffset ) )
				}
			);
			if ( !this.thumbnailUpdatingFlag ) {
				this.updatePoster( this.lastThumbUrl , false );
				this.lastThumbUrl = null;
			}
		}
	},

	/**
	 * Updates the displayed thumbnail via percent of the stream
	 *
	 * @param {Float}
	 *      percent Percent of duration to update thumb
	 */
	updateThumbPerc:function( percent ) {
		return this.updateThumbTime( ( this.getDuration() * percent ) );
	},

	/**
	 * Update the poster source
	 * @param {String} 
	 * 		posterSrc Poster src url
	 */	
	updatePosterSrc: function( posterSrc ){
		this.poster = posterSrc;
		this.updatePosterHTML();
		this.applyIntrinsicAspect();
	},
	
	/**
	 * Called after sources are updated, and your ready for the player to change media
	 * @return
	 */
	changeMedia: function( callback ){
		var _this = this;
		// onChangeMedia): triggered at the start of the change media commands
		$( this ).trigger( 'onChangeMedia' );
		// setup flag for change media
		var chnagePlayingMedia = this.isPlaying();
		
		// Reset first play to true, to count that play event
		this.firstPlay = true;
		this.preSequence = false;
		this.postSequence = false;
		
		// Add a loader to the embed player: 
		this.pauseLoading();
		
		// Clear out any player error ( both via attr and object property ):
		this['data-playerError'] = null;
		$( this ).attr( 'data-playerError', '');
		
		// Clear out the player error div:
		this.$interface.find('.error').remove();
		// Restore the control bar:
		this.$interface.find('.control-bar').show();
		// Hide the play btn
		this.$interface.find('.play-btn-large').hide(); 
		
		//If we are change playing media add a ready binding: 
		var bindName = 'playerReady.changeMedia';
		$( this ).unbind( bindName ).bind( bindName, function(){
			// Always show the control bar on switch:
			if( _this.controlBuilder ){
				_this.controlBuilder.showControlBar();
			}
			// Make sure the play button reflects the original play state
			if(  chnagePlayingMedia ){
				_this.$interface.find( '.play-btn-large' ).hide();
			} else {
				_this.$interface.find( '.play-btn-large' ).show();
			}
			
			if( _this.isPersistentNativePlayer() ){
				// If switching a Persistent native player update the source:
				// ( stop and play won't refresh the source  )
				_this.switchPlaySrc( _this.getSrc(), function(){
					$( _this ).trigger( 'onChangeMediaDone' );
					if( chnagePlayingMedia ){
						_this.play();
					}
					if( callback ){
						callback()
					}
				});
				// we are handling trigger and callback asynchronously return here. 
				return ;
			} else {
				//stop should unload the native player
				_this.stop();
				// reload the player
				if( chnagePlayingMedia ){
					_this.play()
				}
			}
			$( _this ).trigger( 'onChangeMediaDone' );
			if( callback ) {
				callback();
			}
		});

		// Load new sources per the entry id via the checkPlayerSourcesEvent hook:
		$( this ).triggerQueueCallback( 'checkPlayerSourcesEvent', function(){
			// Start player events leading to playerReady
			_this.setupSourcePlayer();
		});
	},
	
	/**
	 * Returns the HTML code for the video when it is in thumbnail mode.
	 * playing, configuring the player, inline cmml display, HTML 
	 * download, and embed code.
	 */
	updatePosterHTML: function () {
		mw.log( 'EmbedPlayer:updatePosterHTML::' + this.id );
		var _this = this;
		var thumb_html = '';
		var class_atr = '';
		var style_atr = '';
		
		if( this.useNativePlayerControls() && this.mediaElement.selectedSource ){
			this.showNativePlayer();
			return ;
		}

		// Set by default thumb value if not found
		var posterSrc = ( this.poster ) ? this.poster :
						mw.getConfig( 'imagesPath' ) + 'vid_default_thumb.jpg';

		// Update PersistentNativePlayer poster:
		if( this.isPersistentNativePlayer() ){
			var $vid = $( '#' + this.pid );
			$vid.attr( 'poster', posterSrc );
			// Add a quick timeout hide / show ( firefox 4x bug with native poster updates )
			if( $.browser.mozilla ){
				$vid.hide();
				setTimeout(function(){
					$vid.show();
				},0);
			}
		} else {
			// Poster support is not very consistent in browsers use a jpg poster image:
			$( this ).html(
				$( '<img />' )
				.css({
					'position' : 'relative',
					'width' : '100%',
					'height' : '100%'
				})
				.attr({
					'id' : 'img_thumb_' + this.id,
					'src' : posterSrc
				})
				.addClass( 'playerPoster' )
			);
		}
		if ( !this.useNativePlayerControls()  && this.controlBuilder
			&& this.height > this.controlBuilder.getComponentHeight( 'playButtonLarge' )
			&& $( this ).find('.play-btn-large').length == 0
		) {
			
			$( this ).append(
				this.controlBuilder.getComponent( 'playButtonLarge' )
			);
		}
	},

	/**
	 * Checks if native controls should be used
	 *
	 * @returns boolean true if the mwEmbed player interface should be used
	 *     false if the mwEmbed player interface should not be used
	 */
	useNativePlayerControls: function() {

		if( this.usenativecontrols === true ){
			return true;
		}

		if( mw.getConfig('EmbedPlayer.NativeControls') === true ) {
			return true;
		}

		// Do some device detection devices that don't support overlays
		// and go into full screen once play is clicked:
		if( mw.isAndroid2() || mw.isIpod()  || mw.isIphone() ){
			return true;
		}
		
		// iPad can use html controls if its a persistantPlayer in the dom before loading )
		// else it needs to use native controls:
		if( mw.isIpad() ){
			if( this.isPersistentNativePlayer() && mw.getConfig('EmbedPlayer.EnableIpadHTMLControls') === true){
				return false;
			} else {
				// Set warning that your trying to do iPad controls without
				// persistent native player:
				return true;
			}
		}
		return false;
	},

	isPersistentNativePlayer: function(){
		// Since we check this early on sometimes the player
		// has not yet been updated to the pid location
		if( $('#' + this.pid ).length == 0 ){
			return $('#' + this.id ).hasClass('persistentNativePlayer');
		}
		return $('#' + this.pid ).hasClass('persistentNativePlayer');
	},


	/**
	 * Show the native player embed code
	 *
	 * This is for cases where the main library needs to "get out of the way"
	 * since the device only supports a limited subset of the html5 and won't
	 * work with an html javascirpt interface
	 */
	showNativePlayer: function(){
		var _this = this;
		// Empty the player of any child nodes
		$(this).empty();

		// Remove the player loader spinner if it exists
		this.hidePlayerSpinner();

		// Get the selected source:
		var source = this.mediaElement.selectedSource;
		// Setup videoAttribues
		var videoAttribues = {
			'poster': _this.poster,
			'src' : source.getSrc()
		};
		if( this.controls ){
			videoAttribues.controls = 'true';
		}
		if( this.loop ){
			videoAttribues.loop = 'true';
		}
		var cssStyle = {
			'width' : _this.width,
			'height' : _this.height
		};

		$( '#' + this.pid ).replaceWith(
			_this.getNativePlayerHtml( videoAttribues, cssStyle )
		);

		// Bind native events:
		this.applyMediaElementBindings();

		// Android only can play with a special play button, android 2x has no native controls
		if( mw.isAndroid2() ){
			this.addPlayBtnLarge();
		}
		return ;
	},
	// Add a play button (if not already there ) 
	addPlayBtnLarge:function(){
		if( this.$interface.find( '.play-btn-large').length ){
			this.$interface.find( '.play-btn-large').show();
		} else {
			this.$interface.append( 
				this.controlBuilder.getComponent( 'playButtonLarge' )
			);
		}
	},
	
	/**
	 * Abstract method,
	 * Get native player html ( should be set by mw.EmbedPlayerNative )
	 */
	getNativePlayerHtml: function(){
		return $('<div />' )
			.css( 'width', this.getWidth() )
			.html( 'Error: Trying to get native html5 player without native support for codec' );
	},
	
	/**
	 * Should be set via native embed support
	 */
	applyMediaElementBindings: function(){
		mw.log("Warning applyMediaElementBindings should be implemented by player interface" );
		return ;
	},

	/**
	 * Gets code to embed the player remotely for "share" this player links
	 */
	getSharingEmbedCode: function() {
		switch( mw.getConfig( 'EmbedPlayer.ShareEmbedMode' ) ){
			case 'iframe':
				return this.getShareIframeObject();
			break;
			case 'videojs':
				return this.getShareEmbedVideoJs();
			break;
		}
	},

	/**
	 * Get the iframe share code:
	 */
	getShareIframeObject: function(){
		// TODO move to getShareIframeSrc
        if (typeof(mw.IA) != 'undefined'){
        	return mw.IA.embedCode();
        }
		iframeUrl = this.getIframeSourceUrl();

		// Set up embedFrame src path
		var embedCode = '&lt;iframe src=&quot;' + mw.escapeQuotesHTML( iframeUrl ) + '&quot; ';

		// Set width / height of embed object
		embedCode += 'width=&quot;' + this.getPlayerWidth() +'&quot; ';
		embedCode += 'height=&quot;' + this.getPlayerHeight() + '&quot; ';
		embedCode += 'frameborder=&quot;0&quot; ';

		// Close up the embedCode tag:
		embedCode+='&gt;&lt/iframe&gt;';

		// Return the embed code
		return embedCode;
	},
	getIframeSourceUrl: function(){
		var iframeUrl = false;
		$( this ).trigger( 'getShareIframeSrc', function( localIframeSrc ){
			if( iframeUrl){
				mw.log("Error multiple modules binding getShareIframeSrc" );
			}
			iframeUrl = localIframeSrc;
    	});
		if( iframeUrl ){
			return iframeUrl;
		}
		// old style embed:
		var iframeUrl = mw.getMwEmbedPath() + 'mwEmbedFrame.php?';
		var params = { 'src[]' : [] };

		// TODO move to mediaWiki Support module
		if( this.apiTitleKey ) {
			params.apiTitleKey = this.apiTitleKey;
			if ( this.apiProvider ) {
				// Commons always uses the commons api provider ( special hack
				// should refactor )
				if( mw.parseUri( document.URL ).host == 'commons.wikimedia.org'){
					 this.apiProvider = 'commons';
				}
				params.apiProvider = this.apiProvider;
			}
		} else {
			// Output all the video sources:
			for( var i=0; i < this.mediaElement.sources.length; i++ ){
				var source = this.mediaElement.sources[i];
				if( source.src ) {
                                      params['src[]'].push(mw.absoluteUrl( source.src ));
				}
			}
			// Output the poster attr
			if( this.poster ){
				params.poster = this.poster;
			}
		}

		// Set the skin if set to something other than default
		if( this.skinName ){
			params.skin = this.skinName;
		}

		if( this.duration ) {
			params.durationHint = parseFloat( this.duration );
		}
		iframeUrl += $.param( params );
		return iframeUrl;
	},
	/**
	 * Get the share embed Video tag code
	 */
	getShareEmbedVideoJs: function(){

		// Set the embed tag type:
		var embedtag = ( this.isAudio() )? 'audio': 'video';

		// Set up the mwEmbed js include:
		var embedCode = '&lt;script type=&quot;text/javascript&quot; ' +
					'src=&quot;' +
					mw.html.escape(
						mw.absoluteUrl(
							mw.getMwEmbedSrc()
						)
					) + '&quot;&gt;&lt;/script&gt' +
					'&lt;' + embedtag + ' ';

		if( this.poster ) {
			embedCode += 'poster=&quot;' +
				mw.html.escape( mw.absoluteUrl( this.poster ) ) +
				'&quot; ';
		}

		// Set the skin if set to something other than default
		if( this.skinName ){
			embedCode += 'class=&quot;' +
				mw.html.escape( this.skinName ) +
				'&quot; ';
		}

		if( this.duration ) {
			embedCode +='data-durationhint=&quot;' + parseFloat( this.duration ) + '&quot; ';
		}

		if( this.width || this.height ){
			embedCode +='style=&quot;';
			embedCode += ( this.width )? 'width:' + this.width +'px;': '';
			embedCode += ( this.height )? 'height:' + this.height +'px;': '';
			embedCode += '&quot; ';
		}

		// TODO move to mediaWiki Support module
		if( this.apiTitleKey ) {
			embedCode += 'apiTitleKey=&quot;' + mw.html.escape( this.apiTitleKey ) + '&quot; ';
			if ( this.apiProvider ) {
				embedCode += 'apiProvider=&quot;' + mw.html.escape( this.apiProvider ) + '&quot; ';
			}
			// close the video tag
			embedCode += '&gt;&lt;/video&gt;';

		} else {
			// Close the video attr
			embedCode += '&gt;';

			// Output all the video sources:
			for( var i=0; i < this.mediaElement.sources.length; i++ ){
				var source = this.mediaElement.sources[i];
				if( source.src ) {
					embedCode +='&lt;source src=&quot;' +
						mw.absoluteUrl( source.src ) +
						'&quot; &gt;&lt;/source&gt;';
				}
			}
			// Close the video tag
			embedCode += '&lt;/video&gt;';
		}

		return embedCode;
	},



	/**
	 * Base Embed Controls
	 */

	/**
	 * The Play Action
	 *
	 * Handles play requests, updates relevant states:
	 * seeking =false
	 * paused =false
	 *
	 * Triggers the play event
	 *
	 * Updates pause button Starts the "monitor"
	 */
	firstPlay : true,
	preSequence: false,
	inPreSequence: false,
	replayEventCount : 0,
	play: function() {
		var _this = this;
		mw.log( "EmbedPlayer:: play: " + this._propagateEvents + ' poster: ' +  this.posterDisplayed );

		// Store the absolute play time ( to track native events that should not invoke interface updates )
		this.absoluteStartPlayTime =  new Date().getTime();
		
		// Check if thumbnail is being displayed and embed html
		if ( _this.posterDisplayed &&  !_this.useNativePlayerControls() ) {
			if ( !_this.selectedPlayer ) {
				_this.showPluginMissingHTML();
				return false;
			} else {
				_this.posterDisplayed = false;
				_this.embedPlayerHTML();
			}
		}
		
		if( !this.preSequence ) {
			this.preSequence = true;
			mw.log( "EmbedPlayer:: trigger preSequence " );
			$( this ).trigger( 'preSequence' );
			this.playInterfaceUpdate();
		}
		
		if( this.paused === true ){
			this.paused = false;
			// Check if we should Trigger the play event
			mw.log("EmbedPlayer:: trigger play event::" + !this.paused + ' events:' + this._propagateEvents );
			// We need first play event for analytics purpose
			if( this.firstPlay ) {
				this.firstPlay = false;
				$( this ).trigger( 'firstPlay' );
			}
			// trigger the actual play event: 
			if(  this._propagateEvents  ) {
				$( this ).trigger( 'onplay' );
			}
		}
		
		// If we previously finished playing this clip run the "replay hook"
		if( this.donePlayingCount > 0 && !this.paused && this._propagateEvents ) {			
			this.replayEventCount++;
			if( this.replayEventCount <= this.donePlayingCount){
				$( this ).trigger( 'replayEvent' );
			}
		}

		// if we have start time defined, start playing from that point
		if( this.currentTime < this.startTime ) {
			var percent = parseFloat( this.startTime ) / this.getDuration();
			this.seek( percent );
		}
		
		this.playInterfaceUpdate();
		return true;
	},
	playInterfaceUpdate: function(){
		var _this = this;
		// Hide any overlay:
		if( this.controlBuilder ){
			this.controlBuilder.closeMenuOverlay();
		}
		// Hide any buttons or errors  if present:
		if( this.$interface ){
			this.$interface.find( '.play-btn-large,.error' ).remove();
		}
		
		this.$interface.find('.play-btn span')
		.removeClass( 'ui-icon-play' )
		.addClass( 'ui-icon-pause' );
		
		this.hideSpinnerOncePlaying();

		this.$interface.find( '.play-btn' )
		.unbind('click')
		.click( function( ) {
			if( _this._playContorls ){
				_this.pause();
			}
		 } )
		.attr( 'title', gM( 'mwe-embedplayer-pause_clip' ) );
	},
	/**
	 * Pause player, and display a loading animation
	 * @return
	 */
	pauseLoading: function(){
		this.pause();
		this.addPlayerSpinner();
		this.isPauseLoading = true;
	},
	addPlayerSpinner: function(){
		$( this ).getAbsoluteOverlaySpinner()
			.attr( 'id', 'loadingSpinner_' + this.id );
	},
	hidePlayerSpinner: function(){
		this.isPauseLoading = false;
		$( '#loadingSpinner_' + this.id + ',.loadingSpinner' ).remove();
	},
	hideSpinnerOncePlaying: function(){
		this._checkHideSpinner = true;
		// if using native controls, hide the spinner directly
		if( this.useNativePlayerControls() ){
			this.hidePlayerSpinner();
		}
	},
	/**
	 * Base embed pause Updates the play/pause button state.
	 * 
	 * There is no general way to pause the video must be overwritten by embed
	 * object to support this functionality.
	 */
	pause: function( event ) {
		var _this = this;
		// Trigger the pause event if not already paused and using native controls:
		if( this.paused === false ){
			this.paused = true;
			if(  this._propagateEvents ){
				mw.log('EmbedPlayer:trigger pause:' + this.paused);
				// "pause" will be deprecated in favor of "onpause"
				$( this ).trigger( 'pause' );
				$( this ).trigger( 'onpause' );
			}
		}

		// Update the ctrl "paused state"
		if( this.$interface ){
			this.$interface.find('.play-btn span' )
			.removeClass( 'ui-icon-pause' )
			.addClass( 'ui-icon-play' );
	
			this.$interface.find( '.play-btn' )
			.unbind('click')
			.click( function() {
				if( _this._playContorls ){
					_this.play();
				}
			} )
			.attr( 'title', gM( 'mwe-embedplayer-play_clip' ) );
		}
	},

	/**
	 * Maps the html5 load request. There is no general way to "load" clips so
	 * underling plugin-player libs should override.
	 */
	load: function() {
		// should be done by child (no base way to pre-buffer video)
		mw.log( 'Waring:: the load method should be overided by player interface' );
	},


	/**
	 * Base embed stop
	 *
	 * Updates the player to the stop state.
	 *
	 * Shows Thumbnail
	 * Resets Buffer
	 * Resets Playhead slider
	 * Resets Status
	 * 
	 * Tirgger the "doStop" event
	 */
	stop: function() {
		var _this = this;
		mw.log( 'EmbedPlayer::stop:' + this.id );

		// Trigger the stop event:
		$( this ).trigger( 'doStop' );

		// no longer seeking:
		this.didSeekJump = false;

		// Reset current time and prev time and seek offset
		this.currentTime = this.previousTime = 	this.serverSeekTime = 0;

		this.stopMonitor();

		// pause playback ( if playing ) 
		if( !this.paused ){
			this.pause();
		}
		// Restore the play button: 
		this.addPlayBtnLarge();
		// Native player controls:
		if( !this.isPersistentNativePlayer() ){			
			// Rewrite the html to thumbnail disp
			this.showThumbnail();
			this.bufferedPercent = 0; // reset buffer state
			this.controlBuilder.setStatus( this.getTimeRange() );
		}
		// Reset the playhead
		this.updatePlayHead( 0 );
		// update the status: 
		// update mv_time
		this.controlBuilder.setStatus( this.getTimeRange() );
	},

	/**
	 * Base Embed mute
	 *
	 * Handles interface updates for toggling mute. Plug-in / player interface
	 * must handle the actual media player action
	 */
	toggleMute: function() {
		mw.log( 'f:toggleMute:: (old state:) ' + this.muted );
		if ( this.muted ) {
			this.muted = false;
			var percent = this.preMuteVolume;
		} else {
			this.muted = true;
			this.preMuteVolume = this.volume;
			var percent = 0;
		}
		this.setVolume( percent );
		// Update the interface
		this.setInterfaceVolume( percent );
		// trigger the onToggleMute event
		$(this).trigger('onToggleMute');
	},

	/**
	 * Update volume function ( called from interface updates )
	 *
	 * @param {float}
	 *      percent Percent of full volume
	 * @param {triggerChange}
	 * 		boolean change if the event should be triggered 
	 */
	setVolume: function( percent, triggerChange ) {
		var _this = this;
		// ignore NaN percent:
		if( isNaN( percent ) ){
			return ;
		}
		// Set the local volume attribute
		this.previousVolume = this.volume;
		
		this.volume = percent;

		// Un-mute if setting positive volume
		if( percent != 0 ){
			this.muted = false;
		}

		// Update the playerElement volume
		this.setPlayerElementVolume( percent );

		// mw.log(" setVolume:: " + percent + ' this.volume is: ' +
		// this.volume);
		if( triggerChange ){
			$( _this ).trigger('volumeChanged', percent );
		}
	},

	/**
	 * Updates the interface volume
	 *
	 * TODO should move to controlBuilder
	 *
	 * @param {float}
	 *      percent Percentage volume to update interface
	 */
	setInterfaceVolume: function( percent ) {
		if( this.supports[ 'volumeControl' ] &&
			this.$interface.find( '.volume-slider' ).length
		) {
			this.$interface.find( '.volume-slider' ).slider( 'value', percent * 100 );
		}
	},

	/**
	 * Abstract method Update volume Method must be override by plug-in / player interface
	 *
	 * @param {float}
	 * 		percent Percentage volume to update
	 */
	setPlayerElementVolume: function( percent ) {
		mw.log('Error player does not support volume adjustment' );
	},

	/**
	 * Abstract method get volume Method must be override by plug-in / player interface
	 * (if player does not override we return the abstract player value )
	 */
	getPlayerElementVolume: function(){
		// mw.log(' error player does not support getting volume property' );
		return this.volume;
	},

	/**
	 * Abstract method  get volume muted property must be overwritten by plug-in /
	 * player interface (if player does not override we return the abstract
	 * player value )
	 */
	getPlayerElementMuted: function(){
		// mw.log(' error player does not support getting mute property' );
		return this.muted;
	},

	/**
	 * Passes a fullscreen request to the controlBuilder interface
	 */
	fullscreen: function() {
		this.controlBuilder.toggleFullscreen();
	},

	/**
	 * Abstract method to be run post embedding the player Generally should be
	 * overwritten by the plug-in / player
	 */
	postEmbedActions:function() {
		return ;
	},

	/**
	 * Checks the player state based on thumbnail display & paused state
	 *
	 * @return {Boolean} true if playing false if not playing
	 */
	isPlaying : function() {
		if ( this.posterDisplayed ) {
			// in stopped state
			return false;
		} else if ( this.paused ) {
			// paused state
			return false;
		} else {
			return true;
		}
	},

	/**
	 * Get Stopped state
	 *
	 * @return {Boolean} true if stopped false if playing
	 */
	isStopped: function() {
		return this.posterDisplayed;
	},
	/**
	 * Stop the play state monitor
	 */
	stopMonitor: function(){
		clearInterval( this.monitorInterval );
		this.monitorInterval = 0;
	},
	/**
	 * Start the play state monitor
	 */
	startMonitor: function(){
		this.monitor();
	},

	/**
	 * Monitor playback and update interface components. underling player classes
	 *  are responsible for updating currentTime
	 */
	monitor: function() {
		var _this = this;

		// Check for current time update outside of embed player
		_this.syncCurrentTime();
		
		// Keep volume proprties set outside of the embed player in sync
		_this.syncVolume();

		// Update the playhead status:
		_this.updatePlayheadStatus()

		// Update buffer information
		_this.updateBufferStatus();
		
		// Make sure the monitor continues to run as long as the video is not stoped
		_this.syncMonitor()
		
		if( _this._propagateEvents ){
			// mw.log('trigger:monitor:: ' + this.currentTime );
			$( this ).trigger( 'monitorEvent' );
			
			// Trigger the "progress" event per HTML5 api support
			if( this.progressEventData ) {
				$( this ).trigger( 'progress', this.progressEventData );
			}
		}
	},
	/**
	 * Sync the monitor function  
	 */
	syncMonitor: function(){
		var _this = this;
		// Call monitor at this.monitorRate interval.
		// ( use setInterval to avoid stacking monitor requests )
		if( ! this.isStopped() ) {
			if( !this.monitorInterval ){
				this.monitorInterval = setInterval( function(){
					if( _this.monitor )
						_this.monitor();
				}, this.monitorRate );
			}
		} else {
			// If stopped "stop" monitor:
			this.stopMonitor();
		}
	},
	/**
	 * Sync the video volume
	 */
	syncVolume: function(){
		var _this = this;
		// Check if volume was set outside of embed player function
		// mw.log( ' this.volume: ' + _this.volume + ' prev Volume:: ' + _this.previousVolume );
		if( Math.round( _this.volume * 100 ) != Math.round( _this.previousVolume * 100 ) ) {
			_this.setInterfaceVolume( _this.volume );
			if( _this._propagateEvents ){
				$( this ).trigger('volumeChanged', _this.volume );
			}
		}
		// Update the previous volume
		_this.previousVolume = _this.volume;

		// Update the volume from the player element
		_this.volume = this.getPlayerElementVolume();

		// update the mute state from the player element
		if( _this.muted != _this.getPlayerElementMuted() && ! _this.isStopped() ){
			mw.log( "EmbedPlayer::syncVolume: muted does not mach embed player" );
			_this.toggleMute();
			// Make sure they match:
			_this.muted = _this.getPlayerElementMuted();
		}
	},
	
	/**
	 * Checks if the currentTime was updated outside of the getPlayerElementTime function
	 */
	syncCurrentTime: function(){
		var _this = this;

		// Hide the spinner once we have time update: 
		if( _this._checkHideSpinner && _this.currentTime != _this.getPlayerElementTime() ){
			_this._checkHideSpinner = false;
			// also hide the play button ( in case it was there somehow )
			_this.$interface.find('.play-btn-large').hide()
			_this.hidePlayerSpinner();
		}

		// Check if a javascript currentTime change based seek has occurred
		if( _this.previousTime != _this.currentTime && !this.userSlide && !this.seeking){
			// If the time has been updated and is in range issue a seek
			if( _this.getDuration() && _this.currentTime <= _this.getDuration() ){
				var seekPercent = _this.currentTime / _this.getDuration();
				mw.log("EmbedPlayer::syncCurrentTime::" + _this.previousTime + ' != ' +
						 _this.currentTime + " javascript based currentTime update to " +
						 seekPercent + ' == ' + _this.currentTime );
				_this.previousTime = _this.currentTime;
				this.seek( seekPercent );
			}
		}
		
		// Update currentTime via embedPlayer
		_this.currentTime = _this.getPlayerElementTime();

		// Update any offsets from server seek
		if( _this.serverSeekTime && _this.supportsURLTimeEncoding() ){
			_this.currentTime = parseInt( _this.serverSeekTime ) + parseInt( _this.getPlayerElementTime() );
		}

		// Update the previousTime ( so we can know if the user-javascript changed currentTime )
		_this.previousTime = _this.currentTime;
		
		// Check for a pauseTime to stop playback in temporal media fragments 
		if( _this.pauseTime && _this.currentTime >  _this.pauseTime ){
			_this.pause();
			_this.pauseTime = null;
		}
	},

	updatePlayheadStatus: function(){
		var _this = this;
		if ( this.currentTime >= 0 && this.duration ) {
			if ( !this.userSlide && !this.seeking ) {
				if ( parseInt( this.startOffset ) != 0 ) {
					// If start offset include that calculation
					this.updatePlayHead( ( this.currentTime - this.startOffset ) / this.duration );
					var et = ( this.controlBuilder.longTimeDisp ) ? '/' + mw.seconds2npt( parseFloat( this.startOffset ) + parseFloat( this.duration ) ) : '';
					this.controlBuilder.setStatus( mw.seconds2npt( this.currentTime ) + et );
				} else {
					this.updatePlayHead( this.currentTime / this.duration );
					// Only include the end time if longTimeDisp is enabled:
					var et = ( this.controlBuilder.longTimeDisp ) ? '/' + mw.seconds2npt( this.duration ) : '';
					this.controlBuilder.setStatus( mw.seconds2npt( this.currentTime ) + et );
				}
			}
			// Check if we are "done"
			var endPresentationTime = ( this.startOffset ) ? ( this.startOffset + this.duration ) : this.duration;
			if ( this.currentTime >= endPresentationTime ) {
				//mw.log( "mWEmbedPlayer::should run clip done :: " + this.currentTime + ' > ' + endPresentationTime );
				this.onClipDone();
			}
		} else {
			// Media lacks duration just show end time
			if ( this.isStopped() ) {
				this.controlBuilder.setStatus( this.getTimeRange() );
			} else if ( this.paused ) {
				this.controlBuilder.setStatus( gM( 'mwe-embedplayer-paused' ) );
			} else if ( this.isPlaying() ) {
				if ( this.currentTime && ! this.duration )
					this.controlBuilder.setStatus( mw.seconds2npt( this.currentTime ) + ' /' );
				else
					this.controlBuilder.setStatus( " - - - " );
			} else {
				this.controlBuilder.setStatus( this.getTimeRange() );
			}
		}
	},

	/**
	 * Abstract getPlayerElementTime function
	 */
	getPlayerElementTime: function(){
		mw.log("Error: getPlayerElementTime should be implemented by embed library");
	},

	/**
	 * Abstract getPlayerElementTime function
	 */
	getPlayerElement: function(){
		mw.log("Error: getPlayerElement should be implemented by embed library, or you may be calling this event too soon");
	},
	
	/**
	 * Update the Buffer status based on the local bufferedPercent var
	 */
	updateBufferStatus: function() {
		// Get the buffer target based for playlist vs clip
		$buffer = this.$interface.find( '.mw_buffer' );

		// mw.log(' set bufferd %:' + this.bufferedPercent );
		// Update the buffer progress bar (if available )
		if ( this.bufferedPercent != 0 ) {
			// mw.log('Update buffer css: ' + ( this.bufferedPercent * 100 ) +
			// '% ' + $buffer.length );
			if ( this.bufferedPercent > 1 ){
				this.bufferedPercent = 1;
			}
			$buffer.css({
				"width" : ( this.bufferedPercent * 100 ) + '%'
			});
			$( this ).trigger( 'updateBufferPercent', this.bufferedPercent );
		} else {
			$buffer.css( "width", '0px' );
		}

		// if we have not already run the buffer start hook
		if( this.bufferedPercent > 0 && !this.bufferStartFlag ) {
			this.bufferStartFlag = true;
			mw.log("EmbedPlayer::bufferStart");
			$( this ).trigger( 'bufferStartEvent' );
		}

		// if we have not already run the buffer end hook
		if( this.bufferedPercent == 1 && !this.bufferEndFlag){
			this.bufferEndFlag = true;
			$( this ).trigger( 'bufferEndEvent' );
		}
	},

	/**
	 * Update the player playhead
	 *
	 * @param {Float}
	 *      perc Value between 0 and 1 for position of playhead
	 */
	updatePlayHead: function( perc ) {
		//mw.log( 'EmbedPlayer: updatePlayHead: '+ perc);
		$playHead = this.$interface.find( '.play_head' );
		if ( !this.useNativePlayerControls() && $playHead.length != 0 ) {
			var val = parseInt( perc * 1000 );
			$playHead.slider( 'value', val );
		}
		$( this ).trigger('updatePlayHeadPercent', perc);
	},


	/**
	 * Helper Functions for selected source
	 */

	/**
	 * Get the current selected media source or first source
	 * 
	 * @param {Number}
	 *            Requested time in seconds to be passed to the server if the
	 *            server supports supportsURLTimeEncoding
	 * @return src url
	 */
	getSrc: function( serverSeekTime ) {
		if( serverSeekTime ){
			this.serverSeekTime = serverSeekTime;
		}
		if( this.currentTime && !this.serverSeekTime){
			this.serverSeekTime = this.currentTime;
		}

		// No media element we can't return src
		if( !this.mediaElement ){
			return false;
		}

		// If no source selected auto select the source:
		if( !this.mediaElement.selectedSource ){
			this.mediaElement.autoSelectSource();
		};

		// Return selected source:
		if( this.mediaElement.selectedSource ){
			// See if we should pass the requested time to the source generator:
			if( this.supportsURLTimeEncoding() ){
				// get the first source:
				return this.mediaElement.selectedSource.getSrc( this.serverSeekTime );
			} else {
				return this.mediaElement.selectedSource.getSrc();
			}
		}
		// No selected source return false:
		return false;
	},
	
	/**
	 * Static helper to get media sources from a set of videoFiles
	 * 
	 * Uses mediaElement select logic to chose a
	 * video file among a set of sources
	 * 
	 * @param videoFiles
	 * @return
	 */
	getCompatibleSource: function( videoFiles ){
		// Convert videoFiles json into HTML element:
		// TODO mediaElement should probably accept JSON
		$media = $('<video />');
		$.each(videoFiles, function( inx, source){
			$media.append( $('<source />').attr({
				'src' : source.src,
				'type' : source.type
			}));
			mw.log("EmbedPlayer::getCompatibleSource: add " + source.src + ' of type:' + source.type );
		});
		var myMediaElement =  new mw.MediaElement( $media.get(0) );
		var source = myMediaElement.autoSelectSource();
		if( source ){
			mw.log("EmbedPlayer::getCompatibleSource: " + source.getSrc());
			return source.getSrc();
		}
		mw.log("Error:: could not find compatible source");
		return false;
	},
	/**
	 * If the selected src supports URL time encoding
	 * 
	 * @return {Boolean} true if the src supports url time requests false if the
	 *         src does not support url time requests
	 */
	supportsURLTimeEncoding: function() {
		var timeUrls = mw.getConfig('EmbedPlayer.EnableURLTimeEncoding') ;
		if( timeUrls == 'none' ){
			return false;
		} else if( timeUrls == 'always' ){
			return this.mediaElement.selectedSource.URLTimeEncoding;
		} else if( timeUrls == 'flash' ){
			if( this.mediaElement.selectedSource && this.mediaElement.selectedSource.URLTimeEncoding){
				// see if the current selected player is flash:
				return ( this.instanceOf == 'Kplayer' );
			}
		} else {
			mw.log("Error:: invalid config value for EmbedPlayer.EnableURLTimeEncoding:: " + mw.getConfig('EmbedPlayer.EnableURLTimeEncoding') );
		}
		return false;
	}
};


} )( mediaWiki, jQuery );
