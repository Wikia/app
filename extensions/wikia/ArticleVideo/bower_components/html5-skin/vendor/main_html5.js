(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
  if (!OO)
  {
    OO = {};
  }

},{}],2:[function(require,module,exports){
  require("./InitOOUnderscore.js");

  var hazmatConfig = {};

// 'debugHazmat' flag needs to be set before plugins are loaded. If we added
// this flag to the OO namespace, it would be overriden during plugin initalization,
// so we need to use a global var instead
  if (window && !window.debugHazmat) {
    hazmatConfig = {
      warn: function() { return; }
    };
  }

  if ((!OO.HM) && (typeof window === 'undefined' || typeof window._ === 'undefined'))
  {
    OO.HM = require('hazmat').create(hazmatConfig);
  }
  else if (!window.Hazmat)
  {
    require('hazmat');
  }

  if (!OO.HM)
  {
    OO.HM = window.Hazmat.noConflict().create(hazmatConfig);
  }

},{"./InitOOUnderscore.js":3,"hazmat":7}],3:[function(require,module,exports){
  require("./InitOO.js");

  if (!window._)
  {
    window._ = require('underscore');
  }

  if (!OO._)
  {
    OO._ = window._.noConflict();
  }

},{"./InitOO.js":1,"underscore":8}],4:[function(require,module,exports){
  /**
   * @namespace OO
   */
  (function(OO,_){

    // External States
    /**
     * @description The Ooyala Player run-time states apply to an Ooyala player while it is running. These states apply equally to both HTML5 and Flash players.
     * State changes occur either through user interaction (for example, the user clickes the PLAY button), or programmatically via API calls. For more information,
     * see <a href="http://support.ooyala.com/developers/documentation/api/pbv4_api_events.html" target="target">Player Message Bus Events</a>.
     * @summary Represents the Ooyala Player run-time states.
     * @namespace OO.STATE
     */
    OO.STATE = {
      /** The embed code has been set. The movie and its metadata is currently being loaded into the player. */
      LOADING : 'loading',
      /**
       * One of the following applies:
       * <ul>
       *   <li>All of the necessary data is loaded in the player. Playback of the movie can begin.</li>
       *   <li>Playback of the asset has finished and is ready to restart from the beginning.</li>
       * </ul>
       */
      READY : 'ready',
      /** The player is currently playing video content. */
      PLAYING : 'playing',
      /** The player has currently paused after playback had begun. */
      PAUSED : 'paused',

      /** Playback has currently stopped because it doesn't have enough movie data to continue and is downloading more. */
      BUFFERING : 'buffering',
      /** The player has encountered an error that prevents playback of the asset. The error could be due to many reasons,
       * such as video format, syndication rules, or the asset being disabled. Refer to the list of errors for details.
       * The error code for the root cause of the error is available from the [OO.Player.getErrorCode()]{@link OO.Player#getErrorCode} method.
       */
      ERROR : 'error',
      /** The player has been destroyed via its [OO.Player.destroy(<i>callback</i>)]{@link OO.Player#destroy} method. */
      DESTROYED : 'destroyed',

      __end_marker : true
    };

    // All Events Constants
    /**
     * @description The Ooyala Player events are default events that are published by the event bus.Your modules can subscribe to any and all of these events.
     * Use message bus events to subscribe to or publish player events from video to ad playback. For more information,
     * see <a href="http://support.ooyala.com/developers/documentation/api/pbv4_api_events.html" target="target">Player Message Bus Events</a>.
     * @summary Represents the Ooyala Player events.
     * @namespace OO.EVENTS
     */
    OO.EVENTS = {

      /**
       * A player was created. This is the first event that is sent after player creation.
       * This event provides the opportunity for any other modules to perform their own initialization.
       * The handler is called with the query string parameters.
       * The DOM has been created at this point, and plugins may make changes or additions to the DOM.<br/><br/>
       *
       *
       * @event OO.EVENTS#PLAYER_CREATED
       */
      PLAYER_CREATED : 'playerCreated',

      PLAYER_EMBEDDED: 'playerEmbedded',

      /**
       * An attempt has been made to set the embed code.
       * If you are developing a plugin, reset the internal state since the player is switching to a new asset.
       * Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The ID (embed code) of the asset.</li>
       *     <li>The ID (embed code) of the asset, with options.</li>
       *   </ul>
       *
       *
       * @event OO.EVENTS#SET_EMBED_CODE
       */
      SET_EMBED_CODE : 'setEmbedCode',

      /**
       * An attempt has been made to set the embed code by Ooyala Ads.
       * If you are developing a plugin, reset the internal state since the player is switching to a new asset.
       * Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The ID (embed code) of the asset.</li>
       *     <li>The ID (embed code) of the asset, with options.</li>
       *   </ul>
       *
       *
       * @event OO.EVENTS#SET_EMBED_CODE_AFTER_OOYALA_AD
       * @private
       */
      SET_EMBED_CODE_AFTER_OOYALA_AD : 'setEmbedCodeAfterOoyalaAd',

      /**
       * The player's embed code has changed. The handler is called with two parameters:
       * <ul>
       *    <li>The ID (embed code) of the asset.</li>
       *    <li>The options JSON object.</li>
       * </ul>
       *
       *
       * @event OO.EVENTS#EMBED_CODE_CHANGED
       */
      EMBED_CODE_CHANGED : 'embedCodeChanged',

      /**
       * An attempt has been made to set a new asset.
       * If you are developing a plugin, reset the internal state since the player is switching to a new asset.
       * Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The asset Object</li>
       *     <li>The asset Object, with options.</li>
       *   </ul>
       *
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @event OO.EVENTS#SET_ASSET
       */
      SET_ASSET: 'setAsset',

      /**
       * A new asset has been specified to for playback and has basic passed validation.
       * The handler will be called with an object representing the new asset.
       * The object will have the following structure:
       *   <ul>
       *     <li>{
       *           Content:
       *           <ul>
       *                 <li>title: String,</li>
       *                 <li>description: String,</li>
       *                 <li>duration: Number,</li>
       *                 <li>posterImages: Array,</li>
       *                 <li>streams: Array,</li>
       *                 <li>captions: Array</li>
       *           </ul>
       *     }</li>
       *
       *   </ul>
       *
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @event OO.EVENTS#ASSET_CHANGED
       */
      ASSET_CHANGED: 'assetChanged',

      /**
       * An attempt has been made to update current asset for cms-less player.
       * The handler is called with:
       *   <ul>
       *     <li>The asset Object, with optional fields populated</li>
       *   </ul>
       *
       *
       * @event OO.EVENTS#UPDATE_ASSET
       * @public
       */
      UPDATE_ASSET: 'updateAsset',

      /**
       * New asset parameters were specified for playback and have passed basic validation.
       * The handler will be called with an object representing the new parameters.
       * The object will have the following structure:
       *   <ul> {
       *     <li> id: String </li>
       *     <li> content:
       *           <ul>
       *                 <li>title: String,</li>
       *                 <li>description: String,</li>
       *                 <li>duration: Number,</li>
       *                 <li>posterImages: Array,</li>
       *                 <li>streams: Array,</li>
       *                 <li>captions: Array</li>
       *           </ul>
       *     </li>
       *     <li> relatedVideos:
       *           <ul>
       *                 <li>title: String,</li>
       *                 <li>description: String,</li>
       *                 <li>thumbnailUrl: String,</li>
       *                 <li>asset: Object</li>
       *           </ul>
       *     </li>
       *   }</ul>
       *
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @event OO.EVENTS#ASSET_UPDATED
       */
      ASSET_UPDATED: 'assetUpdated',

      /**
       * An <code>AUTH_TOKEN_CHANGED</code> event is triggered when an authorization token is issued by the Player Authorization API.<br/>
       * For example, in device registration, an authorization token is issued, as described in
       * <a href="http://support.ooyala.com/developers/documentation/concepts/device_registration.html" target="target">Device Registration</a>.
       * The handler is called with a new value for the authorization token.<br/><br/>
       *
       *
       * @event OO.EVENTS#AUTH_TOKEN_CHANGED
       */
      AUTH_TOKEN_CHANGED: "authTokenChanged",

      /**
       * The GUID has been set. The handler is called with the GUID.
       * <p>This event notifies plugin or page developers that a unique ID has been either generated or loaded for the current user's browser.
       * This is useful for analytics.</p>
       * <p>In HTML5, Flash, and Chromecast environments, a unique user is identified by local storage or a cookie. </p>
       * <p>To generate the GUID, Flash players use the timestamp indicating when the GUID is generated, and append random data to it.
       * The string is then converted to base64.</p>
       * <p>To generate the GUID, HTML5 players use the current time, browser
       * information, and random data and hash it and convert it to base64.</p>
       * <p>Within the same browser on the desktop, once a GUID is set by one platform
       * it is used for both platforms for the user. If a user clears their browser cache, that user's (device's) ID will be regenerated the next time
       * they watch video. Incognito modes will track a user for a single session, but once the browser is closed the GUID is erased.</p>
       * <p>For more information, see <b>unique user</b> <a href="http://support.ooyala.com/users/users/documentation/reference/glossary.html" target="target">Glossary</a>.</p>
       *
       *
       * @event OO.EVENTS#GUID_SET
       */
      GUID_SET: 'guidSet',

      WILL_FETCH_PLAYER_XML: 'willFetchPlayerXml',
      PLAYER_XML_FETCHED: 'playerXmlFetched',
      WILL_FETCH_CONTENT_TREE: 'willFetchContentTree',

      SAVE_PLAYER_SETTINGS: 'savePlayerSettings',

      /**
       * A content tree was fetched. The handler is called with a JSON object that represents the content data for the current asset.<br/><br/>
       *
       *
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;">Records a <code>display</code> event. For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/analytics_plays-and-displays.html" target="target">Displays, Plays, and Play Starts</a>.</p>
       *
       * @event OO.EVENTS#CONTENT_TREE_FETCHED
       */
      CONTENT_TREE_FETCHED: 'contentTreeFetched',

      WILL_FETCH_METADATA: 'willFetchMetadata',

      /**
       * The metadata, which is typically set in Backlot, has been retrieved.
       * The handler is called with the JSON object containing all metadata associated with the current asset.
       * The metadata includes page-level, asset-level, player-level, and account-level metadata, in addition to
       * metadata specific to 3rd party plugins. This is typically used for ad and anlytics plugins, but can be used
       * wherever you need specific logic based on the asset type.<br/><br/>
       *
       *
       * @event OO.EVENTS#METADATA_FETCHED
       */
      METADATA_FETCHED: 'metadataFetched',

      /**
       * The skin metadata, which is set in Backlot, has been retrieved.
       * The handler is called with the JSON object containing metadata set in Backlot for the current asset.
       * This is used by the skin plug-in to deep merge with the embedded skin config.<br/><br/>
       *
       * @event OO.EVENTS#SKIN_METADATA_FETCHED
       */
      SKIN_METADATA_FETCHED: 'skinMetadataFetched',

      /**
       * The thumbnail metadata needed for thumbnail previews while seeking has been fetched and will be
       * passed through to the event handlers subscribing to this event.
       * Thumbnail metadata will have the following structure:
       * {
          data: {
            available_time_slices: [10],  //times that have thumbnails available
            available_widths: [100],       //widths of thumbnails available
            thumbnails: {
                  10: {100: {url: http://test.com, height: 100, width: 100}}
            }
          }
        }
       * <br/><br/>
       *
       *
       * @event OO.EVENTS#THUMBNAILS_FETCHED
       * @public
       */
      THUMBNAILS_FETCHED: 'thumbnailsFetched',

      WILL_FETCH_AUTHORIZATION: 'willFetchAuthorization',

      /**
       * Playback was authorized. The handler is called with an object containing the entire SAS response, and includes the value of <code>video_bitrate</code>.
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       *
       *
       * @event OO.EVENTS#AUTHORIZATION_FETCHED
       */
      AUTHORIZATION_FETCHED: 'authorizationFetched',

      WILL_FETCH_AD_AUTHORIZATION: 'willFetchAdAuthorization',
      AD_AUTHORIZATION_FETCHED: 'adAuthorizationFetched',

      CAN_SEEK: 'canSeek',
      WILL_RESUME_MAIN_VIDEO: 'willResumeMainVideo',

      /**
       * The player has indicated that it is in a playback-ready state.
       * All preparations are complete, and the player is ready to receive playback commands
       * such as play, seek, and so on. The default UI shows the <b>Play</b> button,
       * displaying the non-clickable spinner before this point. <br/><br/>
       *
       *
       * @event OO.EVENTS#PLAYBACK_READY
       */
      PLAYBACK_READY: 'playbackReady',

      /**
       * Play has been called for the first time. <br/><br/>
       *
       *
       * @event OO.EVENTS#INITIAL_PLAY
       */
      INITIAL_PLAY: "initialPlay", // when play is called for the very first time ( in start screen )

      WILL_PLAY : 'willPlay',


      /** The user has restarted the playback after the playback finished */
      REPLAY : 'replay',

      /**
       * The playhead time changed. The handler is called with the following arguments:
       * <ul>
       *   <li>The current time.</li>
       *   <li>The duration.</li>
       *   <li>The name of the buffer.</li>
       *   <li>The seek range.</li>
       *   <li>The id of the video (as defined by the module that controls it).</li>
       * </ul>
       *
       *
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;">The first event is <code>video start</code>. Other instances of the event feed the <code>% completed data points</code>.</p>
       * <p style="text-indent: 1em;">For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/analytics_plays-and-displays.html">Displays, Plays, and Play Starts</a>.</p>
       *
       * @event OO.EVENTS#PLAYHEAD_TIME_CHANGED
       */
      PLAYHEAD_TIME_CHANGED: 'playheadTimeChanged',

      /**
       * The player is buffering the data stream.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The url of the video that is buffering.</li>
       *   <li>The id of the video that is buffering (as defined by the module that controls it).</li>
       * </ul><br/><br/>
       *
       *
       * @event OO.EVENTS#BUFFERING
       */
      BUFFERING: 'buffering', // playing stops because player is buffering

      /**
       * Play resumes because the player has completed buffering. The handler is called with the URL of the stream.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The url of the video that has buffered.</li>
       *   <li>The id of the video that has buffered (as defined by the module that controls it).</li>
       * </ul><br/><br/>
       *
       *
       * @event OO.EVENTS#BUFFERED
       */
      BUFFERED: 'buffered',

      /**
       * The player is downloading content (it can play while downloading).
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The current time.</li>
       *   <li>The duration.</li>
       *   <li>The name of the buffer.</li>
       *   <li>The seek range.</li>
       *   <li>The id of the video (as defined by the module that controls it).</li>
       * </ul>
       * <br/><br/>
       *
       *
       * @event OO.EVENTS#DOWNLOADING
       */
      DOWNLOADING:  'downloading', // player is downloading content (could be playing while downloading)

      /**
       * Lists the available bitrate information. The handler is called with an array containing the available streams, each object includes:
       *   <ul>
       *     <li>bitrate: The bitrate in bits per second. (number|string)</li>
       *     <li>height: The vertical resolution of the stream. (number)</li>
       *     <li>width: The horizontal resolution of the stream. (number)</li>
       *   </ul>
       * If The video plugin supports automatic ABR, one stream will have a bitrate value of "auto".
       *
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * @event OO.EVENTS#BITRATE_INFO_AVAILABLE
       * @public
       */
      BITRATE_INFO_AVAILABLE: 'bitrateInfoAvailable',

      /**
       * A request to set a specific stream bitrate has occurred.
       * The method is published with an object representing the stream to switch to. This will
       * be one of the stream objects published in BITRATE_INFO_AVAILABLE. Each object includes:
       *   <ul>
       *     <li>bitrate: The bitrate in bits per second. (number|string)</li>
       *     <li>height: The vertical resolution of the stream. (number)</li>
       *     <li>width: The horizontal resolution of the stream. (number)</li>
       *   </ul>
       * <br/><br/>
       *
       * @event OO.EVENTS#SET_TARGET_BITRATE
       */
      SET_TARGET_BITRATE: 'setTargetBitrate',

      /**
       * The current playing bitrate has changed. The handler is called with the stream object which includes:
       *   <ul>
       *     <li>bitrate: The bitrate in bits per second. (number|string)</li>
       *     <li>height: The vertical resolution of the stream. (number)</li>
       *     <li>width: The horizontal resolution of the stream. (number)</li>
       *   </ul>
       * If the player is using automatic ABR, it should publish a stream object with the bitrate set to "auto".
       *
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * @event OO.EVENTS#BITRATE_CHANGED
       * @public
       */
      BITRATE_CHANGED: 'bitrateChanged',

      CLOSED_CAPTIONS_INFO_AVAILABLE: 'closedCaptionsInfoAvailable',
      SET_CLOSED_CAPTIONS_LANGUAGE: 'setClosedCaptionsLanguage',
      CLOSED_CAPTION_CUE_CHANGED: 'closedCaptionCueChanged',

      /**
       * Raised when asset dimensions become available.
       *
       * Provide the following arguments in an object:
       * <ul>
       *   <li>width: the width of the asset (number)
       *   </li>
       *   <li>height: the height of the asset (number)
       *   </li>
       *   <li>videoId: the id of the video (string)
       *   </li>
       * </ul>
       *
       * @event OO.EVENTS#ASSET_DIMENSION
       * @public
       */
      ASSET_DIMENSION: 'assetDimension',

      SCRUBBING: 'scrubbing',
      SCRUBBED: 'scrubbed',

      /**
       * A request to perform a seek has occurred. The playhead is requested to move to
       * a specific location, specified in milliseconds. The handler is called with the position to which to seek.<br/><br/>
       *
       *
       * @event OO.EVENTS#SEEK
       */
      SEEK: 'seek',

      /**
       * The player has finished seeking the main video to the requested position.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The current time of the video after seeking.</li>
       * </ul>
       *
       *
       * @event OO.EVENTS#SEEKED
       */
      SEEKED: 'seeked',

      /**
       * A playback request has been made. <br/><br/>
       *
       *
       * @event OO.EVENTS#PLAY
       */
      PLAY: 'play',

      PLAYING: 'playing',
      PLAY_FAILED: 'playFailed',

      /**
       * A player pause has been requested. <br/><br/>
       *
       *
       * @event OO.EVENTS#PAUSE
       */
      PAUSE: 'pause',

      /**
       * The player was paused. <br/><br/>
       *
       *
       * @event OO.EVENTS#PAUSED
       */
      PAUSED: 'paused',

      /**
       * The video and asset were played. The handler is called with the arguments that were passed.<br/><br/>
       *
       *
       * @event OO.EVENTS#PLAYED
       */
      PLAYED: 'played',

      DISPLAY_CUE_POINTS: 'displayCuePoints',
      INSERT_CUE_POINT: 'insertCuePoint',
      RESET_CUE_POINTS: 'resetCuePoints',

      /**
       * This event is triggered before a change is made to the full screen setting of the player.
       * The handler is called with <code>true</code> if the full screen setting will be enabled,
       * and is called with <code>false</code> if the full screen setting will be disabled.
       *
       *
       * @event OO.EVENTS#WILL_CHANGE_FULLSCREEN
       */
      WILL_CHANGE_FULLSCREEN: 'willChangeFullscreen',

      /**
       * The fullscreen state has changed. Depending on the context, the handler is called with:
       * <ul>
       *   <li><code>isFullscreen</code> and <code>paused</code>:</li>
       *     <ul>
       *       <li><code>isFullscreen</code> is set to <code>true</code> or <code>false</code>.</li>
       *       <li><code>isFullscreen</code> and <code>paused</code> are each set to <code>true</code> or <code>false</code>.</li>
       *     </ul>
       *   </li>
       *   <li>The id of the video that has entered fullscreen (as defined by the module that controls it).
       * </ul>
       *
       *
       * @event OO.EVENTS#FULLSCREEN_CHANGED
       */
      FULLSCREEN_CHANGED: 'fullscreenChanged',

      /**
       * The screen size has changed. This event can also be triggered by a screen orientation change for handheld devices.
       * Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The width of the player.</li>
       *     <li>The height of the player.</li>
       *   </ul>
       *
       *
       * @event OO.EVENTS#SIZE_CHANGED
       */
      SIZE_CHANGED: 'sizeChanged',

      /**
       * A request to change volume has been made.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The desired volume of the video element.</li>
       *   <li>The id of the video on which to change the volume (as defined by the module that controls it).
       *        If null or undefined, all video elements volume will be changed</li>
       * </ul>
       *
       *
       * @event OO.EVENTS#CHANGE_VOLUME
       */
      CHANGE_VOLUME: 'changeVolume',

      /**
       * The volume has changed. The handler is called with the current volume, which has a value between 0 and 1, inclusive.<br/><br/>
       *
       *
       * @event OO.EVENTS#VOLUME_CHANGED
       */
      VOLUME_CHANGED: 'volumeChanged',

      /**
       * Controls are shown.<br/><br/>
       *
       *
       * @event OO.EVENTS#CONTROLS_SHOWN
       */
      CONTROLS_SHOWN: 'controlsShown',

      /**
       * Controls are hidden.<br/><br/>
       *
       *
       * @event OO.EVENTS#CONTROLS_HIDDEN
       */
      CONTROLS_HIDDEN: 'controlsHidden',
      END_SCREEN_SHOWN: 'endScreenShown',

      /**
       * An error has occurred. The handler is called with a JSON object that always includes an error code field,
       * and may also include other error-specific fields.<br/><br/>
       *
       *
       * @event OO.EVENTS#ERROR
       */
      ERROR: 'error',

      /**
       * The player is currently being destroyed, and anything created by your module must also be deleted.
       * After the destruction is complete, there is nothing left to send an event.
       * Any plugin that creates or has initialized any long-living logic should listen to this event and clean up that logic.
       * <br/><br/>
       *
       *
       * @event OO.EVENTS#DESTROY
       */
      DESTROY: 'destroy',

      WILL_PLAY_FROM_BEGINNING: 'willPlayFromBeginning',

      DISABLE_PLAYBACK_CONTROLS: 'disablePlaybackControls',
      ENABLE_PLAYBACK_CONTROLS: 'enablePlaybackControls',


      // Video Controller action events

			/*
			 * Denotes that the video controller is ready for playback to be triggered.
			 * @event OO.EVENTS#VC_READY
			 * @public
			 */
      VC_READY: 'videoControllerReady',

      /**
       * Commands the video controller to create a video element.
       * It should be given the following arguments:
       * <ul>
       *   <li>videoId (string)
       *   </li>
       *   <li>streams (object) containing:
       *     <ul>
       *       <li>Encoding type (string) as key defined in OO.VIDEO.ENCODINGS
       *       </li>
       *       <li>Key-value pair (object) as value containing:
       *         <ul>
       *           <li>url (string): Url of the stream</li>
       *           <li>drm (object): Denoted by type of DRM with data as value object containing:
       *             <ul>
       *               <li>Type of DRM (string) as key (ex. "widevine", "fairplay", "playready")</li>
       *               <li>DRM specific data (object) as value</li>
       *             </ul>
       *           </li>
       *         </ul>
       *       </li>
       *     </ul>
       *   </li>
       *   <li>parentContainer of the element. This is a jquery element. (object)
       *   </li>
       *   <li>optional params object (object) containing:
       *     <ul>
       *       <li>closedCaptions: The possible closed captions available on this video. (object)</li>
       *       <li>crossorigin: The crossorigin attribute value to set on the video. (string)</li>
       *       <li>technology: The core video technology required (string) (ex. OO.VIDEO.TECHNOLOGY.HTML5)</li>
       *       <li>features: The video plugin features required (string) (ex. OO.VIDEO.FEATURE.CLOSED_CAPTIONS)</li>
       *     </ul>
       *   </li>
       * </ul>
       * @event OO.EVENTS#VC_CREATE_VIDEO_ELEMENT
       */
      VC_CREATE_VIDEO_ELEMENT: 'videoControllerCreateVideoElement',

      /**
       * A message to be interpreted by the Video Controller to update the URL of the stream for an element.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The name of the element who's URL is being altered</li>
       *   <li>The new url to be used</li>
       * </ul>
       * @event OO.EVENTS#VC_UPDATE_ELEMENT_STREAM
       * @public
       */
      VC_UPDATE_ELEMENT_STREAM: 'videoControllerUpdateElementStream',

      /**
       * The Video Controller has created the desired video element, as denoted by id (string).
       * The handler is called with the following arguments:
       * <ul>
       *   <li>Object containing:
       *     <ul>
       *       <li>videoId: The id of the video as defined by the module that controls it.</li>
       *       <li>encodings: The encoding types supported by the new video element.</li>
       *       <li>parent: The parent element of the video element.</li>
       *       <li>domId: The DOM id of the video element.</li>
       *       <li>videoElement: The video element or its wrapper as created by the video plugin.</li>
       *     </ul>
       *   </li>
       * </ul>
       * @event OO.EVENTS#VC_VIDEO_ELEMENT_CREATED
       */
      VC_VIDEO_ELEMENT_CREATED: 'videoControllerVideoElementCreated',

      /**
       * Commands the Video Controller to bring a video element into the visible range given the video element id (string).
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video to focus (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_FOCUS_VIDEO_ELEMENT
       */
      VC_FOCUS_VIDEO_ELEMENT: 'videoControllerFocusVideoElement',

      /**
       * The Video Controller has moved a video element (string) into focus.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that is in focus (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_VIDEO_ELEMENT_IN_FOCUS
       */
      VC_VIDEO_ELEMENT_IN_FOCUS: 'videoControllerVideoElementInFocus',

      /**
       * The Video Controller has removed a video element (string) from focus.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that lost focus (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_VIDEO_ELEMENT_LOST_FOCUS
       */
      VC_VIDEO_ELEMENT_LOST_FOCUS: 'videoControllerVideoElementLostFocus',

      /**
       * Commands the Video Controller to dispose a video element given the video element id (string).
       * @event OO.EVENTS#VC_DISPOSE_VIDEO_ELEMENT
       */
      VC_DISPOSE_VIDEO_ELEMENT: 'videoControllerDisposeVideoElement',

      /**
       * The Video Controller has disposed the denoted video element (string).
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that was disposed (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_VIDEO_ELEMENT_DISPOSED
       */
      VC_VIDEO_ELEMENT_DISPOSED: 'videoControllerVideoElementDisposed',

      /**
       * Commands the video controller to set the stream for a video element.
       * It should be given the video element name (string) and an object of streams denoted by encoding type (object).
       * @event OO.EVENTS#VC_SET_VIDEO_STREAMS
       */
      VC_SET_VIDEO_STREAMS: 'videoControllerSetVideoStreams',

      /**
       * The Video Controller has encountered an error attempting to configure video elements.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that encountered the error (as defined by the module that controls it).</li>
       *   <li>The error details (object) containing an error code.</li>
       * @event OO.EVENTS#VC_ERROR
       */
      VC_ERROR: 'videoControllerError',


      // Video Player action events

      /**
       * Sets the video element's initial playback time.
       * @event OO.EVENTS#VC_SET_INITIAL_TIME
       */
      VC_SET_INITIAL_TIME: 'videoSetInitialTime',

      /**
       * Commands the video element to play.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video to play (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_PLAY
       */
      VC_PLAY: 'videoPlay',

      /**
       * The video element has detected a command to play and will begin playback.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video to seek (as defined by the module that controls it).</li>
       *   <li>The url of the video that will play.</li>
       * </ul>
       * @event OO.EVENTS#VC_WILL_PLAY
       */
      VC_WILL_PLAY: 'videoWillPlay',

      /**
       * The video element has detected playback in progress.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that is playing (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_PLAYING
       */
      VC_PLAYING: 'videoPlaying',

      /**
       * The video element has detected playback completion.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that has played (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_PLAYED
       */
      VC_PLAYED: 'videoPlayed',

      /**
       * The video element has detected playback failure.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that has played (as defined by the module that controls it).</li>
       *   <li>The error code of the failure (string).</li>
       * </ul>
       * @event OO.EVENTS#VC_PLAY_FAILED
       */
      VC_PLAY_FAILED: 'videoPlayFailed',

      /**
       * Commands the video element to pause.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video to pause (as defined by the module that controls it).</li>
       *   <li>Optional string indicating the reason for the pause.  Supported values include:
       *     <ul>
       *       <li>"transition" indicates that a pause was triggered because a video is going into or out of focus.</li>
       *       <li>null or undefined for all other cases.</li>
       *     </ul>
       *   </li>
       * </ul>
       * @event OO.EVENTS#VC_PAUSE
       */
      VC_PAUSE: 'videoPause',

      /**
       * The video element has detected video state change to paused.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that has paused (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_PAUSED
       */
      VC_PAUSED: 'videoPaused',

      /**
       * Commands the video element to seek.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video to seek (as defined by the module that controls it).</li>
       *   <li>The time position to seek to (in seconds).</li>
       * </ul>
       * @event OO.EVENTS#VC_SEEK
       */
      VC_SEEK: 'videoSeek',

      /**
       * The video element has detected seeking.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that is seeking (as defined by the module that controls it).</li>
       * </ul>
       * @event OO.EVENTS#VC_SEEKING
       */
      VC_SEEKING: 'videoSeeking',

      /**
       * The video element has detected seeked.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that has seeked (as defined by the module that controls it).</li>
       *   <li>The current time of the video after seeking.</li>
       * </ul>
       * @event OO.EVENTS#VC_SEEKED
       */
      VC_SEEKED: 'videoSeeked',

      /**
       * Commands the video element to preload.
       * @event OO.EVENTS#VC_PRELOAD
       */
      VC_PRELOAD: 'videoPreload',

      /**
       * Commands the video element to reload.
       * @event OO.EVENTS#VC_RELOAD
       */
      VC_RELOAD: 'videoReload',

      /**
       * Commands the video controller to prepare all video elements for playback.  This event should be
       * called on a click event and used to enable api-control on html5-based video elements.
       * @event OO.EVENTS#VC_PRIME_VIDEOS
       * @public
       */
      VC_PRIME_VIDEOS: 'videoPrimeVideos',

      /**
       * Notifies the player of tags (such as ID3) encountered during video playback.
       * The handler is called with the following arguments:
       * <ul>
       *   <li>The id of the video that has paused (as defined by the module that controls it). (string)</li>
       *   <li>The type of metadata tag found, such as ID3. (string)</li>
       *   <li>The metadata. (string|object)</li>
       * </ul>
       * @event OO.EVENTS#VC_TAG_FOUND
       * @public
       */
      VC_TAG_FOUND: 'videoTagFound',

      WILL_FETCH_ADS: 'willFetchAds',
      DISABLE_SEEKING: 'disableSeeking',
      ENABLE_SEEKING: 'enableSeeking',

      /**
       * This event is triggered before an ad is played. Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The duration of the ad.</li>
       *     <li>The ID of the ad.</li>
       *   </ul>
       *
       *
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;"Triggers an <b>Ad Analytics</b> <code>AD_IMPRESSION</code> event.</p>
       *
       * @event OO.EVENTS#WILL_PLAY_ADS
       */
      WILL_PLAY_ADS: 'willPlayAds',
      WILL_PLAY_SINGLE_AD: 'willPlaySingleAd',
      WILL_PAUSE_ADS: 'willPauseAds',
      WILL_RESUME_ADS: 'willResumeAds',

      /**
       * This event is triggered to indicate that a non-linear ad will be played.  The handler is called with:
       *   <ul>
       *     <li>An object representing the ad.  For a definition, see class 'Ad' from the ad manager framework.</li>
       *   </ul>
       *
       * @event OO.EVENTS#WILL_PLAY_NONLINEAR_AD
       */
      WILL_PLAY_NONLINEAR_AD: 'willPlayNonlinearAd',

      /**
       * A non-linear ad will play now.  The handler is called with:
       *   <ul>
       *     <li>An object containing the following fields:</li>
       *     <ul>
       *       <li>ad: An object representing the ad.  For a definition, see class 'Ad' from the ad manager framework.</li>
       *       <li>url: [optional] The url of the nonlinear ad.</li>
       *     </ul>
       *   </ul>
       *
       * @event OO.EVENTS#PLAY_NONLINEAR_AD
       */
      PLAY_NONLINEAR_AD: 'playNonlinearAd',

      /**
       * A nonlinear ad was loaded in the UI.
       *
       *
       * @event OO.EVENTS#NONLINEAR_AD_DISPLAYED
       */
      NONLINEAR_AD_DISPLAYED: 'nonlinearAdDisplayed',

      /**
       * A set of ads have been played. Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The duration of the ad.</li>
       *     <li>The ID of the item to play.</li>
       *   </ul>
       *
       *
       * @event OO.EVENTS#ADS_PLAYED
       */
      ADS_PLAYED: 'adsPlayed',

      SINGLE_AD_PLAYED: 'singleAdPlayed',

      /**
       * This event is triggered when an error has occurred with an ad. <br/><br/>
       *
       *
       * @event OO.EVENTS#ADS_ERROR
       */
      ADS_ERROR: 'adsError',

      /**
       * This event is triggered when an ad has been clicked. <br/><br/>
       *
       *
       * @event OO.EVENTS#ADS_CLICKED
       */
      ADS_CLICKED: 'adsClicked',

      FIRST_AD_FETCHED: "firstAdFetched",
      AD_CONFIG_READY: "adConfigReady",

      /**
       * This event is triggered before the companion ads are shown.
       * Companion ads are displayed on a customer page and are not displayed in the player.
       * This event notifies the page handler to display the specified ad, and is the only means by which companion ads can appear.
       * If the page does not handle this event, companion ads will not appear.
       * Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The ID of all companion ads.</li>
       *     <li>The ID of a single companion ad.</li>
       *   </ul>
       *
       *
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;"Triggers an <b>Ad Analytics</b> <code>AD_IMPRESSION</code> event.</p>
       *
       * @event OO.EVENTS#WILL_SHOW_COMPANION_ADS
       */
      WILL_SHOW_COMPANION_ADS: "willShowCompanionAds",
      AD_FETCH_FAILED: "adFetchFailed",

      MIDROLL_PLAY_FAILED: "midrollPlayFailed",
      SKIP_AD: "skipAd",
      UPDATE_AD_COUNTDOWN: "updateAdCountdown",

      // this player is part of these experimental variations
      REPORT_EXPERIMENT_VARIATIONS: "reportExperimentVariations",

      FETCH_STYLE: "fetchStyle",
      STYLE_FETCHED: "styleFetched",
      SET_STYLE: "setStyle",

      USE_SERVER_SIDE_HLS_ADS: "useServerSideHlsAds",

      LOAD_ALL_VAST_ADS: "loadAllVastAds",
      ADS_FILTERED: "adsFiltered",
      ADS_MANAGER_HANDLING_ADS: "adsManagerHandlingAds",
      ADS_MANAGER_FINISHED_ADS: "adsManagerFinishedAds",

      // This event contains the information AMC need to know to place the overlay in the correct position.
      OVERLAY_RENDERING: "overlayRendering",

      /**
       * Event for signaling Ad Controls (Scrubber bar and Control bar) rendering:
       *   <ul>
       *     <li>Boolean parameter, 'false' to not show ad controls, 'true' to show ad controls based on skin config</li>
       *   </ul>
       *
       *
       * @event OO.EVENTS#SHOW_AD_CONTROLS
       */
      SHOW_AD_CONTROLS: "showAdControls",

      /**
       * Event for signaling Ad Marquee rendering:
       *   <ul>
       *     <li>Boolean parameter, 'false' to not show ad marquee, 'true' to show ad marquee based on skin config</li>
       *   </ul>
       *
       *
       * @event OO.EVENTS#SHOW_AD_MARQUEE
       */
      SHOW_AD_MARQUEE: "showAdMarquee",

      // Window published beforeUnload event. It's still user cancellable.
      /**
       * The window, document, and associated resources are being unloaded.
       * The handler is called with <code>true</code> if a page unload has been requested, <code>false</code> otherwise.
       * This event may be required since some browsers perform asynchronous page loading while the current page is still active,
       * meaning that the end user loads a page with the Ooyala player, plays an asset, then redirects the page to a new URL they have specified.
       * Some browsers will start loading the new data while still displaying the player, which will result in an error since the networking has already been reset.
       * To prevent such false errors, listen to this event and ignore any errors raised after such actions have occurred.
       * <br/><br/>
       *
       *
       * @event OO.EVENTS#PAGE_UNLOAD_REQUESTED
       */
      PAGE_UNLOAD_REQUESTED: "pageUnloadRequested",
      // Either 1) The page is refreshing (almost certain) or 2) The user tried to refresh
      // the page, the embedding page had an "Are you sure?" prompt, the user clicked
      // on "stay", and a real error was produced due to another reason during the
      // following few seconds. The real error, if any, will be received in some seconds.
      // If we are certain it has unloaded, it's too late to be useful.
      PAGE_PROBABLY_UNLOADING: "pageProbablyUnloading",

      // DiscoveryApi publishes these, OoyalaAnalytics listens for them and propagates to reporter.js
      REPORT_DISCOVERY_IMPRESSION: "reportDiscoveryImpression",
      REPORT_DISCOVERY_CLICK: "reportDiscoveryClick",

      /**
       * Denotes that the playlist plugin is ready and has configured the playlist Pod(s).
       * @event OO.EVENTS#PLAYLISTS_READY
       * @public
       */
      PLAYLISTS_READY: 'playlistReady',

      /**
       * The UI layer has finished its initial render. The handler is called with an object
       * of the following structure:
       *
       * <ul>
       *   <li>videoWrapperClass: The class name of the element containing the UI layer</li>
       *   <li>pluginsClass: The class name of the element into which the plugins content should be inserted</li>
       * </ul>
       *
       * If the UI layer doesn't require any special handling, the values for these two keys will be null.
       *
       * @event OO.EVENTS#UI_READY
       */
      UI_READY: "uiReady",

      __end_marker : true
    };

    /**
     * @description Represents the Ooyala V3 Player Errors. Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event.
     * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
     * @summary Represents the Ooyala V3 Player Errors.
     * @namespace OO.ERROR
     */
    OO.ERROR = {
      /**
       * @description Represents the <code>OO.ERROR.API</code> Ooyala V3 Player Errors. Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event.
       * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
       * @summary Represents the <code>OO.ERROR.API</code> Ooyala V3 Player Errors.
       * @namespace OO.ERROR.API
       */
      API: {
        /**
         * @description <code>OO.ERROR.API.NETWORK ('network')</code>: Cannot contact the server.
         * @constant OO.ERROR.API.NETWORK
         * @type {string}
         */
        NETWORK:'network',
        /**
         * @description Represents the <code>OO.ERROR.API.SAS</code> Ooyala V3 Player Errors for the Stream Authorization Server.
         * Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event.
         * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
         * @summary Represents the <code>OO.ERROR.API.SAS</code> Ooyala V3 Player Errors.
         * @namespace OO.ERROR.API.SAS
         */
        SAS: {
          /**
           * @description <code>OO.ERROR.API.SAS.GENERIC ('sas')</code>: Invalid authorization response.
           * @constant OO.ERROR.API.SAS.GENERIC
           * @type {string}
           */
          GENERIC:'sas',
          /**
           * @description <code>OO.ERROR.API.SAS.GEO ('geo')</code>: This video is not authorized for your location.
           * @constant OO.ERROR.API.SAS.GEO
           * @type {string}
           */
          GEO:'geo',
          /**
           * @description <code>OO.ERROR.API.SAS.DOMAIN ('domain')</code>: This video is not authorized for your domain.
           * @constant OO.ERROR.API.SAS.DOMAIN
           * @type {string}
           */
          DOMAIN:'domain',
          /**
           * @description <code>OO.ERROR.API.SAS.FUTURE ('future')</code>: This video will be available soon.
           * @constant OO.ERROR.API.SAS.FUTURE
           * @type {string}
           */
          FUTURE:'future',
          /**
           * @description <code>OO.ERROR.API.SAS.PAST ('past')</code>: This video is no longer available.
           * @constant OO.ERROR.API.SAS.PAST
           * @type {string}
           */
          PAST:'past',
          /**
           * @description <code>OO.ERROR.API.SAS.DEVICE ('device')</code>: This video is not authorized for playback on this device.
           * @constant OO.ERROR.API.SAS.DEVICE
           * @type {string}
           */
          DEVICE:'device',
          /**
           * @description <code>OO.ERROR.API.SAS.PROXY ('proxy')</code>: An anonymous proxy was detected. Please disable the proxy and retry.
           * @constant OO.ERROR.API.SAS.PROXY
           * @type {string}
           */
          PROXY:'proxy',
          /**
           * @description <code>OO.ERROR.API.SAS.CONCURRENT_STREAM ('concurrent_streams')S</code>: You have exceeded the maximum number of concurrent streams.
           * @constant OO.ERROR.API.SAS.CONCURRENT_STREAMS
           * @type {string}
           */
          CONCURRENT_STREAMS:'concurrent_streams',
          /**
           * @description <code>OO.ERROR.API.SAS.INVALID_HEARTBEAT ('invalid_heartbeat')</code>: Invalid heartbeat response.
           * @constant OO.ERROR.API.SAS.INVALID_HEARTBEAT
           * @type {string}
           */
          INVALID_HEARTBEAT:'invalid_heartbeat',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_INVALID_AUTH_TOKEN ('device_invalid_auth_token')</code>: Invalid Ooyala Player token.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_INVALID_AUTH_TOKEN
           * @type {string}
           */
          ERROR_DEVICE_INVALID_AUTH_TOKEN:'device_invalid_auth_token',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_LIMIT_REACHED ('device_limit_reached')</code>: The device limit has been reached.
           * The device limit is the maximum number of devices that can be registered with the viewer.
           * When the number of registered devices exceeds the device limit for the account or provider, this error is displayed.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_LIMIT_REACHED
           * @type {string}
           */
          ERROR_DEVICE_LIMIT_REACHED:'device_limit_reached',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_BINDING_FAILED ('device_binding_failed')</code>: Device binding failed.
           * If the number of devices registered is already equal to the number of devices that may be bound for the account,
           * attempting to register a new device will result in this error.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_BINDING_FAILED
           * @type {string}
           */
          ERROR_DEVICE_BINDING_FAILED:'device_binding_failed',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_ID_TOO_LONG ('device_id_too_long')</code>: The device ID is too long.
           * The length limit for the device ID is 1000 characters.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_ID_TOO_LONG
           * @type {string}
           */
          ERROR_DEVICE_ID_TOO_LONG:'device_id_too_long',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DRM_RIGHTS_SERVER_ERROR ('drm_server_error')</code>: DRM server error.
           * @constant OO.ERROR.API.SAS.ERROR_DRM_RIGHTS_SERVER_ERROR
           * @type {string}
           */
          ERROR_DRM_RIGHTS_SERVER_ERROR:'drm_server_error',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DRM_GENERAL_FAILURE ('drm_general_failure')</code>: General error with acquiring license.
           * @constant OO.ERROR.API.SAS.ERROR_DRM_GENERAL_FAILURE
           * @type {string}
           */
          ERROR_DRM_GENERAL_FAILURE:'drm_general_failure',

          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_INVALID_ENTITLEMENTS ('invalid_entitlements')</code>: User Entitlement Terminated - Stream No Longer Active for the User.
           * @constant OO.ERROR.API.SAS.ERROR_INVALID_ENTITLEMENTS
           * @type {string}
           */
          ERROR_INVALID_ENTITLEMENTS:'invalid_entitlements'
        },
        /**
         * @description <code>OO.ERROR.API.CONTENT_TREE ('content_tree')</code>: Invalid Content.
         * @constant OO.ERROR.API.CONTENT_TREE
         * @type {string}
         */
        CONTENT_TREE:'content_tree',
        /**
         * @description <code>OO.ERROR.API.METADATA ('metadata')</code>: Invalid Metadata.
         * @constant OO.ERROR.API.METADATA
         * @type {string}
         */
        METADATA:'metadata'
      },
      /**
       * @description Represents the <code>OO.ERROR.PLAYBACK</code> Ooyala V3 Player Errors. Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event.
       * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
       * @summary Represents the <code>OO.ERROR.PLAYBACK</code> Ooyala V3 Player Errors.
       * @namespace OO.ERROR.PLAYBACK
       */
      PLAYBACK: {
        /**
         * @description <code>OO.ERROR.PLAYBACK.GENERIC ('playback')</code>: Could not play the content.
         * @constant OO.ERROR.PLAYBACK.GENERIC
         * @type {string}
         */
        GENERIC:'playback',
        /**
         * @description <code>OO.ERROR.PLAYBACK.STREAM ('stream')</code>: This video is not encoded for your device.
         * @constant OO.ERROR.PLAYBACK.STREAM
         * @type {string}
         */
        STREAM:'stream',
        /**
         * @description <code>OO.ERROR.PLAYBACK.LIVESTREAM ('livestream')</code>: Live stream is off air.
         * @constant OO.ERROR.PLAYBACK.LIVESTREAM
         * @type {string}
         */
        LIVESTREAM:'livestream',
        /**
         * @description <code>OO.ERROR.PLAYBACK.NETWORK ('network_error')</code>: The network connection was temporarily lost.
         * @constant OO.ERROR.PLAYBACK.NETWORK
         * @type {string}
         */
        NETWORK: 'network_error'
      },
      CHROMECAST: {
        MANIFEST:'chromecast_manifest',
        MEDIAKEYS:'chromecast_mediakeys',
        NETWORK:'chromecast_network',
        PLAYBACK:'chromecast_playback'
      },
      /**
       * @description <code>OO.ERROR.UNPLAYABLE_CONTENT ('unplayable_content')</code>: This video is not playable on this player.
       * @constant OO.ERROR.UNPLAYABLE_CONTENT
       * @type {string}
       */
      UNPLAYABLE_CONTENT:'unplayable_content',
      /**
       * @description <code>OO.ERROR.INVALID_EXTERNAL_ID ('invalid_external_id')</code>: Invalid External ID.
       * @constant OO.ERROR.INVALID_EXTERNAL_ID
       * @type {string}
       */
      INVALID_EXTERNAL_ID:'invalid_external_id',
      /**
       * @description <code>OO.ERROR.EMPTY_CHANNEL ('empty_channel')</code>: This channel is empty.
       * @constant OO.ERROR.EMPTY_CHANNEL
       * @type {string}
       */
      EMPTY_CHANNEL:'empty_channel',
      /**
       * @description <code>OO.ERROR.EMPTY_CHANNEL_SET ('empty_channel_set')</code>: This channel set is empty.
       * @constant OO.ERROR.EMPTY_CHANNEL_SET
       * @type {string}
       */
      EMPTY_CHANNEL_SET:'empty_channel_set',
      /**
       * @description <code>OO.ERROR.CHANNEL_CONTENT ('channel_content')</code>: This channel is not playable at this time.
       * @constant OO.ERROR.CHANNEL_CONTENT
       * @type {string}
       */
      CHANNEL_CONTENT:'channel_content',
      /**
       * @description Represents the <code>OO.ERROR.VC</code> Ooyala V4 Player Errors for the Video Technology stack.
       * Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event.
       * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
       * @summary Represents the <code>OO.ERROR.VC</code> Ooyala V4 Player Errors.
       * @namespace OO.ERROR.VC
       */
      VC: {
        /**
         * @description <code>OO.ERROR.VC.UNSUPPORTED_ENCODING ('unsupported_encoding')</code>:
         *    This device does not have an available decoder for this stream type.
         * @constant OO.ERROR.VC.UNSUPPORTED_ENCODING
         * @type {string}
         */
        UNSUPPORTED_ENCODING:'unsupported_encoding',

        /**
         * @description <code>OO.ERROR.VC.UNABLE_TO_CREATE_VIDEO_ELEMENT ('unable_to_create_video_element')</code>:
         *    A video element to play the given stream could not be created
         * @constant OO.ERROR.VC.UNABLE_TO_CREATE_VIDEO_ELEMENT
         * @type {string}
         */
        UNABLE_TO_CREATE_VIDEO_ELEMENT:'unable_to_create_video_element',
      }
    };

    // All Server-side URLS
    OO.URLS = {
      VAST_PROXY: _.template('http://player.ooyala.com/nuplayer/mobile_vast_ads_proxy?callback=<%=cb%>&embed_code=<%=embedCode%>&expires=<%=expires%>&tag_url=<%=tagUrl%>'),
      EXTERNAL_ID: _.template('<%=server%>/player_api/v1/content_tree/external_id/<%=pcode%>/<%=externalId%>'),
      CONTENT_TREE: _.template('<%=server%>/player_api/v1/content_tree/embed_code/<%=pcode%>/<%=embedCode%>'),
      METADATA: _.template('<%=server%>/player_api/v1/metadata/embed_code/<%=playerBrandingId%>/<%=embedCode%>?videoPcode=<%=pcode%>'),
      SAS: _.template('<%=server%>/player_api/v1/authorization/embed_code/<%=pcode%>/<%=embedCode%>'),
      ANALYTICS: _.template('<%=server%>/reporter.js'),
      THUMBNAILS: _.template('<%=server%>/api/v1/thumbnail_images/<%=embedCode%>'),
      __end_marker : true
    };

    OO.VIDEO = {
      MAIN: "main",
      ADS: "ads",

      /**
       * @description Represents the <code>OO.VIDEO.ENCODING</code> encoding types. Used to denote video
       *              encoding types associated with a video stream url.
       * @summary Represents the <code>OO.VIDEO.ENCODING</code> encoding types.
       * @namespace OO.VIDEO.ENCODING
       */
      ENCODING: {
        /**
         * @description Represents DRM support for the encoding types.
         * @summary Represents the <code>OO.VIDEO.ENCODING.DRM</code> encoding types.
         * @namespace OO.VIDEO.ENCODING.DRM
         */
        DRM : {
          /**
           * @description <code>OO.VIDEO.ENCODING.DRM.HLS ('hls_drm')</code>:
           *   An encoding type for drm HLS streams.
           * @constant OO.VIDEO.ENCODING.DRM.HLS
           * @type {string}
           */
          HLS: "hls_drm",

          /**
           * @description <code>OO.VIDEO.ENCODING.DRM.DASH ('dash_drm')</code>:
           *   An encoding type for drm dash streams.
           * @constant OO.VIDEO.ENCODING.DRM.DASH
           * @type {string}
           */
          DASH: "dash_drm",
        },
        /**
         * @description <code>OO.VIDEO.ENCODING.AUDIO ('audio')</code>:
         *   An encoding type for non-drm audio streams.
         * @constant OO.VIDEO.ENCODING.AUDIO
         * @type {string}
         */
        AUDIO: "audio",

        /**
         * @description <code>OO.VIDEO.ENCODING.DASH ('dash')</code>:
         *   An encoding type for non-drm dash streams (mpd extension).
         * @constant OO.VIDEO.ENCODING.DASH
         * @type {string}
         */
        DASH: "dash",

        /**
         * @description <code>OO.VIDEO.ENCODING.HDS ('hds')</code>:
         *   An encoding type for non-drm hds streams (hds extension).
         * @constant OO.VIDEO.ENCODING.HDS
         * @type {string}
         */
        HDS: "hds",

        /**
         * @description <code>OO.VIDEO.ENCODING.HLS ('hls')</code>:
         *   An encoding type for non-drm HLS streams (m3u8 extension).
         * @constant OO.VIDEO.ENCODING.HLS
         * @type {string}
         */
        HLS: "hls",

        /**
         * @description <code>OO.VIDEO.ENCODING.IMA ('ima')</code>:
         *   A string that represents a video stream that is controlled and configured directly by IMA.
         * @constant OO.VIDEO.ENCODING.IMA
         * @type {string}
         */
        IMA: "ima",

        /**
         * @description <code>OO.VIDEO.ENCODING.PULSE ('pulse')</code>:
         *   A string that represents a video stream that is controlled and configured directly by Pulse.
         * @constant OO.VIDEO.ENCODING.PULSE
         * @type {string}
         */
        PULSE: "pulse",

        /**
         * @description <code>OO.VIDEO.ENCODING.MP4 ('mp4')</code>:
         *   An encoding type for non-drm mp4 streams (mp4 extension).
         * @constant OO.VIDEO.ENCODING.MP4
         * @type {string}
         */
        MP4: "mp4",

        /**
         * @description <code>OO.VIDEO.ENCODING.YOUTUBE ('youtube')</code>:
         *   An encoding type for non-drm youtube streams.
         * @constant OO.VIDEO.ENCODING.YOUTUBE
         * @type {string}
         */
        YOUTUBE:"youtube",

        /**
         * @description <code>OO.VIDEO.ENCODING.RTMP ('rtmp')</code>:
         *   An encoding type for non-drm rtmp streams.
         * @constant OO.VIDEO.ENCODING.RTMP
         * @type {string}
         */
        RTMP: "rtmp",

        /**
         * @description <code>OO.VIDEO.ENCODING.SMOOTH ('smooth')</code>:
         *   An encoding type for non-drm smooth streams.
         * @constant OO.VIDEO.ENCODING.SMOOTH
         * @type {string}
         */
        SMOOTH: "smooth",

        /**
         * @description <code>OO.VIDEO.ENCODING.WEBM ('webm')</code>:
         *   An encoding type for non-drm webm streams (webm extension).
         * @constant OO.VIDEO.ENCODING.WEBM
         * @type {string}
         */
        WEBM: "webm",

        /**
         * @description <code>OO.VIDEO.ENCODING.AKAMAI_HD_VOD ('akamai_hd_vod')</code>:
         *   An encoding type for akamai hd vod streams.
         * @constant OO.VIDEO.ENCODING.AKAMAI_HD_VOD
         * @type {string}
         */
        AKAMAI_HD_VOD: "akamai_hd_vod",

        /**
         * @description <code>OO.VIDEO.ENCODING.AKAMAI_HD2_VOD_HLS ('akamai_hd2_vod_hls')</code>:
         *   An encoding type for akamai hd2 vod hls streams.
         * @constant OO.VIDEO.ENCODING.AKAMAI_HD2_VOD_HLS
         * @type {string}
         */
        AKAMAI_HD2_VOD_HLS: "akamai_hd2_vod_hls",

        /**
         * @description <code>OO.VIDEO.ENCODING.AKAMAI_HD2_VOD_HDS ('akamai_hd2_vod_hds')</code>:
         *   An encoding type for akamai hd2 vod hds streams.
         * @constant OO.VIDEO.ENCODING.AKAMAI_HD2_VOD_HDS
         * @type {string}
         */
        AKAMAI_HD2_VOD_HDS: "akamai_hd2_vod_hds",

        /**
         * @description <code>OO.VIDEO.ENCODING.AKAMAI_HD2_HDS ('akamai_hd2_hds')</code>:
         *   An encoding type for akamai hd2 live/remote hds streams.
         * @constant OO.VIDEO.ENCODING.AKAMAI_HD2_HDS
         * @type {string}
         */
        AKAMAI_HD2_HDS: "akamai_hd2_hds",

        /**
         * @description <code>OO.VIDEO.ENCODING.AKAMAI_HD2_HLS ('akamai_hd2_hls')</code>:
         *   An encoding type for akamai hd2 live hls streams.
         * @constant OO.VIDEO.ENCODING.AKAMAI_HD2_HLS
         * @type {string}
         */
        AKAMAI_HD2_HLS: "akamai_hd2_hls",

        /**
         * @description <code>OO.VIDEO.ENCODING.FAXS_HLS ('faxs_hls')</code>:
         *   An encoding type for adobe faxs streams.
         * @constant OO.VIDEO.ENCODING.FAXS_HLS
         * @type {string}
         */
        FAXS_HLS: "faxs_hls",

        /**
         * @description <code>OO.VIDEO.ENCODING.WIDEVINE_HLS ('wv_hls')</code>:
         *   An encoding type for widevine hls streams.
         * @constant OO.VIDEO.ENCODING.WIDEVINE_HLS
         * @type {string}
         */
        WIDEVINE_HLS: "wv_hls",

        /**
         * @description <code>OO.VIDEO.ENCODING.WIDEVINE_MP4 ('wv_mp4')</code>:
         *   An encoding type for widevine mp4 streams.
         * @constant OO.VIDEO.ENCODING.WIDEVINE_MP4
         * @type {string}
         */
        WIDEVINE_MP4: "wv_mp4",

        /**
         * @description <code>OO.VIDEO.ENCODING.WIDEVINE_WVM ('wv_wvm')</code>:
         *   An encoding type for widevine wvm streams.
         * @constant OO.VIDEO.ENCODING.WIDEVINE_WVM
         * @type {string}
         */
        WIDEVINE_WVM: "wv_wvm",

        /**
         * @description <code>OO.VIDEO.ENCODING.UNKNOWN ('unknown')</code>:
         *   An encoding type for unknown streams.
         * @constant OO.VIDEO.ENCODING.UNKNOWN
         * @type {string}
         */
        UNKNOWN: "unknown"
      },

      /**
       * @description Represents the <code>OO.VIDEO.FEATURE</code> feature list. Used to denote which
       * features are supported by a video player.
       * @summary Represents the <code>OO.VIDEO.FEATURE</code> feature list.
       * @namespace OO.VIDEO.FEATURE
       */
      FEATURE: {
        /**
         * @description <code>OO.VIDEO.FEATURE.CLOSED_CAPTIONS ('closedCaptions')</code>:
         *   Closed captions parsed by the video element and sent to the player.
         * @constant OO.VIDEO.FEATURE.CLOSED_CAPTIONS
         * @type {string}
         */
        CLOSED_CAPTIONS: "closedCaptions",

        /**
         * @description <code>OO.VIDEO.FEATURE.VIDEO_OBJECT_SHARING_GIVE ('videoObjectSharingGive')</code>:
         *   The video object is accessible and can be found by the player via the DOM element id.  Other
         *   modules can use this video object if required.
         * @constant OO.VIDEO.FEATURE.VIDEO_OBJECT_SHARING_GIVE
         * @type {string}
         */
        VIDEO_OBJECT_SHARING_GIVE: "videoObjectSharingGive",

        /**
         * @description <code>OO.VIDEO.FEATURE.VIDEO_OBJECT_SHARING_TAKE ('videoObjectSharingTake')</code>:
         *   The video object used can be created external from this video plugin.  This plugin will use the
         *   existing video element as its own.
         * @constant OO.VIDEO.FEATURE.VIDEO_OBJECT_SHARING_TAKE
         * @type {string}
         */
        VIDEO_OBJECT_SHARING_TAKE: "videoObjectSharingTake",

        /**
         * @description <code>OO.VIDEO.FEATURE.BITRATE_CONTROL ('bitrateControl')</code>:
         *   The video object allows the playing bitrate to be selected via the SET_TARGET_BITRATE event.
         *   The video controller must publish BITRATE_INFO_AVAILABLE with a list of bitrate objects that can be selected.
         *   The video controller must publish BITRATE_CHANGED events with the bitrate object that was switched to.
         *   A bitrate object should at minimum contain height, width, and bitrate properties. Height and width
         *   should be the vertical and horizontal resoluton of the stream and bitrate should be in bits per second.
         * @constant OO.VIDEO.FEATURE.BITRATE_CONTROL
         * @type {string}
         */
        BITRATE_CONTROL: "bitrateControl"
      },

      /**
       * @description Represents the <code>OO.VIDEO.TECHNOLOGY</code> core video technology.
       * @summary Represents the <code>OO.VIDEO.TECHNOLOGY</code> core technology of the video element.
       * @namespace OO.VIDEO.TECHNOLOGY
       */
      TECHNOLOGY: {
        /**
         * @description <code>OO.VIDEO.TECHNOLOGY.FLASH ('flash')</code>:
         *   The core video technology is based on Adobe Flash.
         * @constant OO.VIDEO.TECHNOLOGY.FLASH
         * @type {string}
         */
        FLASH: "flash",

        /**
         * @description <code>OO.VIDEO.TECHNOLOGY.HTML5 ('html5')</code>:
         *   The core video technology is based on the native html5 'video' tag.
         * @constant OO.VIDEO.TECHNOLOGY.HTML5
         * @type {string}
         */
        HTML5: "html5",

        /**
         * @description <code>OO.VIDEO.TECHNOLOGY.MIXED ('mixed')</code>:
         *   The core video technology used may be based on any one of multiple core technologies.
         * @constant OO.VIDEO.TECHNOLOGY.MIXED
         * @type {string}
         */
        MIXED: "mixed",

        /**
         * @description <code>OO.VIDEO.TECHNOLOGY.OTHER ('other')</code>:
         *   The video is based on a core video technology that doesn't fit into another classification
         *   found in <code>OO.VIDEO.TECHNOLOGY</code>.
         * @constant OO.VIDEO.TECHNOLOGY.OTHER
         * @type {string}
         */
        OTHER: "other"
      }

    };

    OO.CSS = {
      VISIBLE_POSITION : "0px",
      INVISIBLE_POSITION : "-100000px",
      VISIBLE_DISPLAY : "block",
      INVISIBLE_DISPLAY : "none",
      VIDEO_Z_INDEX: 10000,
      SUPER_Z_INDEX: 20000,
      ALICE_SKIN_Z_INDEX: 11000,
      OVERLAY_Z_INDEX: 10500,
      TRANSPARENT_COLOR : "rgba(255, 255, 255, 0)",

      __end_marker : true
    };

    OO.TEMPLATES = {
      RANDOM_PLACE_HOLDER: ['[place_random_number_here]', '<now>', '[timestamp]', '<rand-num>', '[cache_buster]', '[random]'],
      REFERAK_PLACE_HOLDER: ['[referrer_url]', '[LR_URL]'],
      EMBED_CODE_PLACE_HOLDER: ['[oo_embedcode]'],
      MESSAGE : '\
                  <table width="100%" height="100%" bgcolor="black" style="padding-left:55px; padding-right:55px; \
                  background-color:black; color: white;">\
                  <tbody>\
                  <tr valign="middle">\
                  <td align="right"><span style="font-family:Arial; font-size:20px">\
                  <%= message %>\
                  </span></td></tr></tbody></table>\
                  ',
      __end_marker : true
    };

    OO.CONSTANTS = {
      // Ad frequency constants
      AD_PLAY_COUNT_KEY: "oo_ad_play_count",
      AD_ID_TO_PLAY_COUNT_DIVIDER: ":",
      AD_PLAY_COUNT_DIVIDER: "|",
      MAX_AD_PLAY_COUNT_HISTORY_LENGTH: 20,

      CONTROLS_BOTTOM_PADDING: 10,

      SEEK_TO_END_LIMIT: 4,

      /**
       * @description <code>OO.CONSTANTS.CLOSED_CAPTIONS</code>:
       *   An object containing the possible modes for the closed caption text tracks.
       * @constant OO.CONSTANTS.CLOSED_CAPTIONS
       * @type {object}
       */
      CLOSED_CAPTIONS: {
        /**
         * @description <code>OO.CONSTANTS.CLOSED_CAPTIONS.SHOWING ('showing')</code>:
         *   Closed caption text track mode for showing closed captions.
         * @constant OO.CONSTANTS.CLOSED_CAPTIONS.SHOWING
         * @type {string}
         */
        SHOWING: "showing",
        /**
         * @description <code>OO.CONSTANTS.CLOSED_CAPTIONS.HIDDEN ('hidden')</code>:
         *   Closed caption text track mode for hiding closed captions.
         * @constant OO.CONSTANTS.CLOSED_CAPTIONS.HIDDEN
         * @type {string}
         */
        HIDDEN: "hidden",
        /**
         * @description <code>OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED ('disabled')</code>:
         *   Closed caption text track mode for disabling closed captions.
         * @constant OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED
         * @type {string}
         */
        DISABLED: "disabled"
      },

      OOYALA_PLAYER_SETTINGS_KEY: 'ooyala_player_settings',

      __end_marker : true
    };

  }(OO,OO._));

},{}],5:[function(require,module,exports){
  (function(OO,_,HM) {
    // Ensure playerParams exists
    OO.playerParams = HM.safeObject('environment.playerParams', OO.playerParams,{});

    // Init publisher's OO.playerParams via player parameter object
    OO.configurePublisher = function(parameters) {
      OO.playerParams.pcode = parameters.pcode || OO.playerParams.pcode || '';
      OO.playerParams.playerBrandingId = parameters.playerBrandingId || OO.playerParams.playerBrandingId || '';
      OO.playerParams.debug = parameters.debug || OO.playerParams.debug || '';
    };

    OO.isPublisherConfigured = function() {
      return !!(OO.playerParams.pcode && OO.playerParams.playerBrandingId);
    };

    // Set API end point environment
    OO.setServerHost = function(parameters) {
      OO.playerParams.api_ssl_server = parameters.api_ssl_server || OO.playerParams.api_ssl_server || null;
      OO.playerParams.api_server = parameters.api_server || OO.playerParams.api_server || null;
      OO.playerParams.auth_ssl_server = parameters.auth_ssl_server || OO.playerParams.auth_ssl_server || null;
      OO.playerParams.auth_server = parameters.auth_server || OO.playerParams.auth_server || null;
      OO.playerParams.analytics_ssl_server = parameters.analytics_ssl_server || OO.playerParams.analytics_ssl_server || null;
      OO.playerParams.analytics_server = parameters.analytics_server || OO.playerParams.analytics_server || null;

      updateServerHost();
    };

    var updateServerHost = function () {
      OO.SERVER =
        {
          API: OO.isSSL ? OO.playerParams.api_ssl_server || "https://player.ooyala.com" :
            OO.playerParams.api_server || "http://player.ooyala.com",
          AUTH: OO.isSSL ? OO.playerParams.auth_ssl_server || "https://player.ooyala.com/sas" :
            OO.playerParams.auth_server || "http://player.ooyala.com/sas",
          ANALYTICS: OO.isSSL ? OO.playerParams.analytics_ssl_server || "https://player.ooyala.com" :
            OO.playerParams.analytics_server || "http://player.ooyala.com"
        };
    }

    // process tweaks
    // tweaks is optional. Hazmat takes care of this but throws an undesirable warning.
    OO.playerParams.tweaks = OO.playerParams.tweaks || '';
    OO.playerParams.tweaks = HM.safeString('environment.playerParams.tweaks', OO.playerParams.tweaks,'');
    OO.playerParams.tweaks = OO.playerParams.tweaks.split(',');

    // explicit list of supported tweaks
    OO.tweaks = {};
    OO.tweaks["android-enable-hls"] = _.contains(OO.playerParams.tweaks, 'android-enable-hls');
    OO.tweaks["html5-force-mp4"] = _.contains(OO.playerParams.tweaks, 'html5-force-mp4');

    // Max timeout for fetching ads metadata, default to 3 seconds.
    OO.playerParams.maxAdsTimeout = OO.playerParams.maxAdsTimeout || 5;
    // max wrapper ads depth we look, we will only look up to 3 level until we get vast inline ads
    OO.playerParams.maxVastWrapperDepth = OO.playerParams.maxVastWrapperDepth || 3;
    OO.playerParams.minLiveSeekWindow = OO.playerParams.minLiveSeekWindow || 10;

    // Ripped from: http://stackoverflow.com/questions/105034/how-to-create-a-guid-uuid-in-javascript
    OO.guid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
      return v.toString(16);
    });
    OO.playerCount = 0;

    // Check environment to see if this is prod
    OO.isProd = !!(OO.playerParams.environment &&
    OO.playerParams.environment.match(/^prod/i));

    // Environment invariant.
    OO.platform = window.navigator.platform;
    OO.os = window.navigator.appVersion;
    OO.supportsVideo = !!document.createElement('video').canPlayType;

    OO.browserSupportsCors = (function() {
      try {
        return _.has(new XMLHttpRequest(), "withCredentials") ||
          _.has(XMLHttpRequest.prototype, "withCredentials");
      } catch(e) {
        return false;
      }
    }());

    OO.isWindows = (function() {
      return !!OO.platform.match(/Win/);
    }());

    OO.isIos = (function() {
      return !!OO.platform.match(/iPhone|iPad|iPod/);
    }());

    OO.isIphone = (function() {
      return !!OO.platform.match(/iPhone|iPod/);
    }());

    OO.isIpad = (function() {
      return !!OO.platform.match(/iPad/);
    }());

    OO.iosMajorVersion = (function() {
      try {
        if (OO.isIos) {
          return parseInt(window.navigator.userAgent.match(/OS (\d+)/)[1], 10);
        } else {
          return null;
        }
      } catch(err) {
        return null;
      }
    }());

    OO.isAndroid = (function() {
      return !!(OO.os.match(/Android/) && !OO.os.match(/Windows Phone/));
    }());

    OO.isAndroid4Plus = (function() {
      var version = OO.os.match(/Android [\d\.]*;/);
      if (version && version.length > 0) {
        version = parseInt(version[0].substring(version[0].indexOf(' ') + 1,
          version[0].search('[\.\;]')));
      }
      return OO.isAndroid && version >= 4;
    }());

    OO.isRimDevice = (function() {
      return !!(OO.os.match(/BlackBerry/) || OO.os.match(/PlayBook/));
    }());

    OO.isFirefox = (function() {
      return !!window.navigator.userAgent.match(/Firefox/);
    }());

    OO.isChrome = (function () {
      return (!!window.navigator.userAgent.match(/Chrome/) && !window.navigator.userAgent.match(/Edge/));
    }());

    OO.isSafari = (function () {
      return (!!window.navigator.userAgent.match(/AppleWebKit/) &&
      !window.navigator.userAgent.match(/Chrome/) &&
      !window.navigator.userAgent.match(/like iPhone/));
    }());

    OO.chromeMajorVersion = (function () {
      try {
        return parseInt(window.navigator.userAgent.match(/Chrome.([0-9]*)/)[1], 10);
      } catch(err) {
        return null;
      }
    }());

    OO.isIE = (function(){
      return !!window.navigator.userAgent.match(/MSIE/) || !!window.navigator.userAgent.match(/Trident/);
    }());

    OO.isEdge = (function(){
      return !!window.navigator.userAgent.match(/Edge/);
    }());

    OO.isIE11Plus = (function(){
      // check if IE
      if (!window.navigator.userAgent.match(/Trident/)) {
        return false;
      }

      // extract version number
      var ieVersionMatch = window.navigator.userAgent.match(/rv:(\d*)/);
      var ieVersion = ieVersionMatch && ieVersionMatch[1];
      return ieVersion >= 11;
    }());

    OO.isWinPhone = (function(){
      return !!OO.os.match(/Windows Phone/) || !!OO.os.match(/ZuneWP/) || !!OO.os.match(/XBLWP/);
    }());

    OO.isSmartTV = (function(){
      return (!!window.navigator.userAgent.match(/SmartTV/) ||
      !!window.navigator.userAgent.match(/NetCast/));
    }());

    OO.isMacOs = (function() {
      return !OO.isIos && !!OO.os.match(/Mac/) && !window.navigator.userAgent.match(/like iPhone/);
    }());

    OO.isMacOsLionOrLater = (function() {
      // TODO: revisit for Firefox when possible/necessary
      var macOs = OO.os.match(/Mac OS X ([0-9]+)_([0-9]+)/);
      if (macOs == null || macOs.length < 3) { return false; }
      return (parseInt(macOs[1],10) >= 10 && parseInt(macOs[2],10) >= 7);
    }());

    OO.macOsSafariVersion = (function() {
      try {
        if (OO.isMacOs && OO.isSafari) {
          return parseInt(window.navigator.userAgent.match(/Version\/(\d+)/)[1], 10);
        } else {
          return null;
        }
      } catch(err) {
        return null;
      }
    }());

    OO.isKindleHD = (function(){
      return !!OO.os.match(/Silk\/2/);
    }());

    OO.supportMSE = (function() {
      return 'MediaSource' in window || 'WebKitMediaSource' in window || 'mozMediaSource' in window || 'msMediaSource' in window;
    }());

    OO.supportAds = (function() {
      // We are disabling ads for Android 2/3 device, the reason is that main video is not resuming after
      // ads finish. Util we can figure out a work around, we will keep ads disabled.
      return !OO.isWinPhone && !OO.os.match(/Android [23]/);
    }());

    OO.allowGesture = (function() {
      return OO.isIos;
    }());

    OO.allowAutoPlay = (function() {
      return !OO.isIos && !OO.isAndroid;
    }());

    OO.supportTouch = (function() {
      // IE8- doesn't support JS functions on DOM elements
      if (document.documentElement.hasOwnProperty && document.documentElement.hasOwnProperty("ontouchstart")) { return true; }
      return false;
    }());

    OO.docDomain = (function() {
      var domain = null;
      try {
        domain = document.domain;
      } catch(e) {}
      if (!OO._.isEmpty(domain)) { return domain; }
      if (OO.isSmartTV) { return 'SmartTV'; }
      return 'unknown';
    }());

    OO.uiParadigm = (function() {
      var paradigm = 'tablet';

      // The below code attempts to decide whether or not we are running in 'mobile' mode
      // Meaning that no controls are displayed, chrome is minimized and only fullscreen playback is allowed
      // Unfortunately there is no clean way to figure out whether the device is tablet or phone
      // or even to properly detect device screen size http://tripleodeon.com/2011/12/first-understand-your-screen/
      // So there is a bunch of heuristics for doing just that
      // Anything that is not explicitly detected as mobile defaults to desktop
      // so worst case they get ugly chrome instead of unworking player
      if(OO.isAndroid4Plus && OO.tweaks["android-enable-hls"]) {
        // special case for Android 4+ running HLS
        paradigm = 'tablet';
      } else if(OO.isIphone) {
        paradigm = 'mobile-native';
      } else if(OO.os.match(/BlackBerry/)) {
        paradigm = 'mobile-native';
      } else if(OO.os.match(/iPad/)) {
        paradigm = 'tablet';
      } else if(OO.isKindleHD) {
        // Kindle Fire HD
        paradigm = 'mobile-native';
      } else if(OO.os.match(/Silk/)) {
        // Kindle Fire
        paradigm = 'mobile';
      } else if(OO.os.match(/Android 2/)) {
        // On Android 2+ only window.outerWidth is reliable, so we are using that and window.orientation
        if((window.orientation % 180) == 0 &&  (window.outerWidth / window.devicePixelRatio) <= 480 ) {
          // portrait mode
          paradigm = 'mobile';
        } else if((window.outerWidth / window.devicePixelRatio) <= 560 ) {
          // landscape mode
          paradigm = 'mobile';
        }
      } else if(OO.os.match(/Android/)) {
        paradigm = 'tablet';
      } else if (OO.isWinPhone) {
        // Windows Phone is mobile only for now, tablets not yet released
        paradigm = 'mobile';
      } else if(!!OO.platform.match(/Mac/)    // Macs
        || !!OO.platform.match(/Win/)  // Winboxes
        || !!OO.platform.match(/Linux/)) {    // Linux
        paradigm = 'desktop';
      }

      return paradigm;
    }());

    /**
     * Determines if a single video element should be used.<br/>
     * <ul><li>Use single video element on iOS, all versions</li>
     *     <li>Use single video element on Android, all versions</li></ul>
     * 01/11/17 Previous JSDoc for Android - to be removed once fix is confirmed and there is no regression:<br />
     * <ul><li>Use single video element on Android < v4.0</li>
     *     <li>Use single video element on Android with Chrome < v40<br/>
     *       (note, it might work on earlier versions but don't know which ones! Does not work on v18)</li></ul>
     *
     * @private
     * @returns {boolean} True if a single video element is required
     */
    OO.requiresSingleVideoElement = (function() {
      return OO.isIos || OO.isAndroid;
      // 01/11/17 - commenting out, but not removing three lines below pending QA, we may need to restore this logic
      //var iosRequireSingleElement = OO.isIos;
      //var androidRequireSingleElement = OO.isAndroid && (!OO.isAndroid4Plus || OO.chromeMajorVersion < 40);
      // return iosRequireSingleElement || androidRequireSingleElement;
    }());

    // TODO(jj): need to make this more comprehensive
    // Note(jj): only applies to mp4 videos for now
    OO.supportedVideoProfiles = (function() {
      // iOS only supports baseline profile
      if (OO.isIos || OO.isAndroid) {
        return "baseline";
      }
      return null;
    }());

    // TODO(bz): add flash for device when we decide to use stream data from sas
    // TODO(jj): add AppleTV and other devices as necessary
    OO.device = (function() {
      var device = 'html5';
      if (OO.isIphone) { device = 'iphone-html5'; }
      else if (OO.isIpad) { device = 'ipad-html5'; }
      else if (OO.isAndroid) { device = 'android-html5'; }
      else if (OO.isRimDevice) { device = 'rim-html5'; }
      else if (OO.isWinPhone) { device = 'winphone-html5'; }
      else if (OO.isSmartTV) { device = 'smarttv-html5'; }
      return device;
    }());

    // list of environment-specific modules needed by the environment or empty to include all
    // Note: should never be empty because of html5
    OO.environmentRequiredFeatures = (function(){
      var features = [];

      if (OO.os.match(/Android 2/)) {  // safari android
        features.push('html5-playback');
      } else { // normal html5
        features.push('html5-playback');
        if (OO.supportAds) { features.push('ads'); }
      }

      return _.reduce(features, function(memo, feature) {return memo+feature+' ';}, '');
    }());

    OO.supportMidRollAds = (function() {
      return (OO.uiParadigm === "desktop" && !OO.isIos && !OO.isRimDevice);
    }());

    OO.supportCookies = (function() {
      document.cookie = "ooyala_cookie_test=true";
      var cookiesSupported = document.cookie.indexOf("ooyala_cookie_test=true") >= 0;
      document.cookie = "ooyala_cookie_test=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
      return cookiesSupported;
    }());

    OO.isSSL = document.location.protocol == "https:";

    updateServerHost();

    // returns true iff environment-specific feature is required to run in current environment
    OO.requiredInEnvironment = OO.featureEnabled = function(feature) {
      return !!OO.environmentRequiredFeatures.match(new RegExp(feature));
    };

    // Detect Chrome Extension. We will recieve an acknowledgement from the content script, which will prompt us to start sending logs
    OO.chromeExtensionEnabled = document.getElementById('ooyala-extension-installed') ? true : false;

    // Locale Getter and Setter
    OO.locale = "";
    OO.setLocale = function(locale) {
      OO.locale = locale.toUpperCase();
    };
    OO.getLocale = function() {
      return (OO.locale || document.documentElement.lang || navigator.language ||
      navigator.userLanguage || "en").substr(0,2).toUpperCase();
    };
  }(OO, OO._, OO.HM));

},{}],6:[function(require,module,exports){
  (function(OO,_,$) {
    OO.getRandomString = function() { return Math.random().toString(36).substring(7); };

    OO.safeClone = function(source) {
      if (_.isNumber(source) || _.isString(source) || _.isBoolean(source) || _.isFunction(source) ||
        _.isNull(source) || _.isUndefined(source)) {
        return source;
      }
      var result = (source instanceof Array) ? [] : {};
      try {
        $.extend(true, result, source);
      } catch(e) { OO.log("deep clone error", e); }
      return result;
    };

    OO.d = function() {
      if (OO.isDebug) { OO.log.apply(OO, arguments); }
      OO.$("#OOYALA_DEBUG_CONSOLE").append(JSON.stringify(OO.safeClone(arguments))+'<br>');
    };

    // Note: This inherit only for simple inheritance simulation, the Parennt class still has a this binding
    // to the parent class. so any variable initiated in the Parent Constructor, will not be available to the
    // Child Class, you need to copy paste constructor to Child Class to make it work.
    // coffeescript is doing a better job here by binding the this context to child in the constructor.
    // Until we switch to CoffeeScript, we need to be careful using this simplified inherit lib.
    OO.inherit = function(ParentClass, myConstructor) {
      if (typeof(ParentClass) !== "function") {
        OO.log("invalid inherit, ParentClass need to be a class", ParentClass);
        return null;
      }
      var SubClass = function() {
        ParentClass.apply(this, arguments);
        if (typeof(myConstructor) === "function") { myConstructor.apply(this, arguments); }
      };
      var parentClass = new ParentClass();
      OO._.extend(SubClass.prototype, parentClass);
      SubClass.prototype.parentClass = parentClass;
      return SubClass;
    };

    var styles = {}; // keep track of all styles added so we can remove them later if destroy is called

    OO.attachStyle = function(styleContent, playerId) {
      var s = $('<style type="text/css">' + styleContent + '</style>').appendTo("head");
      styles[playerId] = styles[playerId] || [];
      styles[playerId].push(s);
    };

    OO.removeStyles = function(playerId) {
      OO._.each(styles[playerId], function(style) {
        style.remove();
      });
    };

    // object: object to get the inner property for, ex. {"mod":{"fw":{"data":{"key":"val"}}}}
    // keylist: list of keys to find, ex. ["mod", "fw", "data"]
    // example output: {"key":"val"}
    OO.getInnerProperty = function(object, keylist) {
      var innerObject = object;
      var list = keylist;
      while (list.length > 0) {
        var key = list.shift();
        // Note that function and arrays are objects
        if (_.isNull(innerObject) || !_.isObject(innerObject) ||
          _.isFunction(innerObject) || _.isArray(innerObject))
          return null;
        innerObject = innerObject[key];
      }
      return innerObject;
    }

    OO.formatSeconds = function(timeInSeconds) {
      var seconds = parseInt(timeInSeconds,10) % 60;
      var hours = parseInt(timeInSeconds / 3600, 10);
      var minutes = parseInt((timeInSeconds - hours * 3600) / 60, 10);


      if (hours < 10) {
        hours = '0' + hours;
      }

      if (minutes < 10) {
        minutes = '0' + minutes;
      }

      if (seconds < 10) {
        seconds = '0' + seconds;
      }

      return (parseInt(hours,10) > 0) ? (hours + ":" + minutes + ":" + seconds) : (minutes + ":" + seconds);
    };

    OO.timeStringToSeconds = function(timeString) {
      var timeArray = (timeString || '').split(":");
      return _.reduce(timeArray, function(m, s) { return m * 60 + parseInt(s, 10); }, 0);
    };

    OO.leftPadding = function(num, totalChars) {
      var pad = '0';
      var numString = num ? num.toString() : '';
      while (numString.length < totalChars) {
        numString = pad + numString;
      }
      return numString;
    };

    OO.getColorString = function(color) {
      return '#' + (OO.leftPadding(color.toString(16), 6)).toUpperCase();
    };

    OO.hexToRgb = function(hex) {
      var r = (hex & 0xFF0000) >> 16;
      var g = (hex & 0xFF00) >> 8;
      var b = (hex & 0xFF);
      return [r, g, b];
    };

    OO.changeColor = function(color, ratio, darker) {
      var minmax     = darker ? Math.max : Math.min;
      var boundary = darker ? 0 : 255;
      var difference = Math.round(ratio * 255) * (darker ? -1 : 1);
      var rgb = OO.hexToRgb(color);
      return [
        OO.leftPadding(minmax(rgb[0] + difference, boundary).toString(16), 2),
        OO.leftPadding(minmax(rgb[1] + difference, boundary).toString(16), 2),
        OO.leftPadding(minmax(rgb[2] + difference, boundary).toString(16), 2)
      ].join('');
    };

    OO.decode64 = function(s) {
      s = s.replace(/\n/g,"");
      var results = "";
      var j, i = 0;
      var enc = [];
      var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

      //shortcut for browsers with atob
      if (window.atob) {
        return atob(s);
      }

      do {
        for (j = 0; j < 4; j++) {
          enc[j] = b64.indexOf(s.charAt(i++));
        }
        results += String.fromCharCode((enc[0] << 2) | (enc[1] >> 4),
          enc[2] == 64 ? 0 : ((enc[1] & 15) << 4) | (enc[2] >> 2),
          enc[3] == 64 ? 0 : ((enc[2] & 3) << 6) | enc[3]);
      } while (i < s.length);

      //trim tailing null characters
      return results.replace(/\0/g, "");
    };

    OO.pixelPing = function (url) {
      var img = new Image();
      img.onerror = img.onabort = function() { OO.d("onerror:", url); };
      img.src = OO.getNormalizedTagUrl(url);
    };

    // ping array of urls.
    OO.pixelPings = function (urls) {
      if (_.isEmpty(urls)) { return; }
      _.each(urls, function(url) {
        OO.pixelPing(url);
      }, this);
    };

    // helper function to convert types to boolean
    // the (!!) trick only works to verify if a string isn't the empty string
    // therefore, we must use a special case for that
    OO.stringToBoolean = function(value) {
      if (typeof value === 'string')
        return (value.toLowerCase().indexOf("true") > -1 || value.toLowerCase().indexOf("yes") > -1);
      return !!value;
    }

    OO.regexEscape = function(value) {
      var specials = /[<>()\[\]{}]/g;
      return value.replace(specials, "\\$&");
    };

    OO.getNormalizedTagUrl = function (url, embedCode) {
      var ts = new Date().getTime();
      var pageUrl = escape(document.URL);

      var placeHolderReplace = function (template, replaceValue) {
        _.each(template, function (placeHolder) {
          var regexSearchVal = new RegExp("(" +
            OO.regexEscape(placeHolder) + ")", 'gi');
          url = url.replace(regexSearchVal, replaceValue);
        }, this);
      }

      // replace the timestamp and referrer_url placeholders
      placeHolderReplace(OO.TEMPLATES.RANDOM_PLACE_HOLDER, ts);
      placeHolderReplace(OO.TEMPLATES.REFERAK_PLACE_HOLDER, pageUrl);

      // first make sure that the embedCode exists, then replace the
      // oo_embedcode placeholder
      if (embedCode) {
        placeHolderReplace(OO.TEMPLATES.EMBED_CODE_PLACE_HOLDER, embedCode);
      }
      return url;
    };

    OO.safeSeekRange = function(seekRange) {
      return {
        start : seekRange.length > 0 ? seekRange.start(0) : 0,
        end : seekRange.length > 0 ? seekRange.end(0) : 0
      };
    };

    OO.loadedJS = OO.loadedJS || {};

    OO.jsOnSuccessList = OO.jsOnSuccessList || {};

    OO.safeFuncCall = function(fn) {
      if (typeof fn !== "function") { return; }
      try {
        fn.apply();
      } catch (e) {
        OO.log("Can not invoke function!", e);
      }
    };

    OO.loadScriptOnce = function(jsSrc, successCallBack, errorCallBack, timeoutInMillis) {
      OO.jsOnSuccessList[jsSrc] = OO.jsOnSuccessList[jsSrc] || [];
      if (OO.loadedJS[jsSrc]) {
        // invoke call back directly if loaded.
        if (OO.loadedJS[jsSrc] === "loaded") {
          OO.safeFuncCall(successCallBack);
        } else if (OO.loadedJS[jsSrc] === "loading") {
          OO.jsOnSuccessList[jsSrc].unshift(successCallBack);
        }
        return false;
      }
      OO.loadedJS[jsSrc] = "loading";
      $.ajax({
        url: jsSrc,
        type: 'GET',
        cache: true,
        dataType: 'script',
        timeout: timeoutInMillis || 15000,
        success: function() {
          OO.loadedJS[jsSrc] = "loaded";
          OO.jsOnSuccessList[jsSrc].unshift(successCallBack);
          OO._.each(OO.jsOnSuccessList[jsSrc], function(fn) {
            OO.safeFuncCall(fn);
          }, this);
          OO.jsOnSuccessList[jsSrc] = [];
        },
        error: function() {
          OO.safeFuncCall(errorCallBack);
        }
      });
      return true;
    };

    try {
      OO.localStorage = window.localStorage;
    } catch (err) {
      OO.log(err);
    }
    if (!OO.localStorage) {
      OO.localStorage = {
        getItem: function (sKey) {
          if (!sKey || !this.hasOwnProperty(sKey)) { return null; }
          return unescape(document.cookie.replace(new RegExp("(?:^|.*;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*"), "$1"));
        },
        key: function (nKeyId) {
          return unescape(document.cookie.replace(/\s*\=(?:.(?!;))*$/, "").split(/\s*\=(?:[^;](?!;))*[^;]?;\s*/)[nKeyId]);
        },
        setItem: function (sKey, sValue) {
          if(!sKey) { return; }
          document.cookie = escape(sKey) + "=" + escape(sValue) + "; expires=Tue, 19 Jan 2038 03:14:07 GMT; path=/";
          this.length = document.cookie.match(/\=/g).length;
        },
        length: 0,
        removeItem: function (sKey) {
          if (!sKey || !this.hasOwnProperty(sKey)) { return; }
          document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
          this.length--;
        },
        hasOwnProperty: function (sKey) {
          return (new RegExp("(?:^|;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
        }
      };
      OO.localStorage.length = (document.cookie.match(/\=/g) || OO.localStorage).length;
    }

    // A container to properly request OO.localStorage.setItem
    OO.setItem = function (sKey, sValue) {
      try {
        OO.localStorage.setItem(sKey, sValue);
      } catch (err) {
        OO.log(err);
      }
    };

    OO.JSON = window.JSON;

  }(OO, OO._, OO.$));

},{}],7:[function(require,module,exports){
// Actual Hazmat Code
  var HazmatBuilder = function(_,root) {

    // top level module
    var Hazmat  = function(config) {
      this.config = config || {};
      if(!_.isObject(this.config)) {
        throw new Error('Hazmat is not initialized properly');
      }
      this.fail = _.isFunction(this.config.fail) ? this.config.fail : Hazmat.fail;
      this.warn = _.isFunction(this.config.warn) ? this.config.warn : Hazmat.warn;
      this.log = _.isFunction(this.config.log) ? this.config.log : Hazmat.log;
    };

    _.extend(Hazmat, {

      // constants
      ID_REGEX : /^[\_A-Za-z0-9]+$/,

      // factory
      create : function(config) {
        return new Hazmat(config);
      },

      // noConflict
      noConflict : function() {
        root.Hazmat = Hazmat.original;
        return Hazmat;
      },

      // default log function
      log : function() {
        if(console && _.isFunction(console.log)) {
          console.log.apply(console, arguments);
        }
      },

      // default fail function
      fail : function(_reason, _data) {
        var reason = _reason || "", data = _data || {};
        Hazmat.log('Hazmat Failure::', reason, data);
        throw new Error('Hazmat Failure '+reason.toString());
      },

      // default warn function
      warn : function(_reason, _data) {
        var reason = _reason || "", data = _data || {};
        Hazmat.log('Hazmat Warning::', reason, data);
      },

      // global fixers
      fixDomId : function(_value) {
        if(_.isString(_value) && _value.length > 0) {
          return _value.replace(/[^A-Za-z0-9\_]/g,'');
        } else {
          return null;
        }
      },

      // global testers
      isDomId : function(value) {
        return _.isString(value) && value.match(Hazmat.ID_REGEX);
      },


      __placeholder : true
    });

    _.extend(Hazmat.prototype, {
      _safeValue : function(name, value, fallback, type) {
        // make fallback safe and eat exceptions
        var _fallback = fallback;
        if(_.isFunction(fallback)) {
          fallback = _.once(function() {
            try {
              return _fallback.apply(this, arguments);
            } catch(e) {
            }
          });
        }

        if(type.checker(value)) {
          return value;
        } else if(type.evalFallback && _.isFunction(fallback) && type.checker(fallback(value))){
          this.warn('Expected valid '+type.name+' for '+name+' but was able to sanitize it:', [value, fallback(value)]);
          return fallback(value);
        } else if(type.checker(_fallback)){
          this.warn('Expected valid '+type.name+' for '+name+' but was able to fallback to default value:', [value, _fallback]);
          return _fallback;
        } else {
          this.fail('Expected valid '+type.name+' for '+name+' but received:', value);
        }
      },

      safeString : function(name, value, fallback) {
        return this._safeValue(name, value, fallback, {name: 'String', checker: _.isString, evalFallback:true});
      },

      safeStringOrNull : function(name, value, fallback) {
        if(value == null) {
          return value;
        } else {
          return this._safeValue(name, value, fallback, {name: 'String', checker: _.isString, evalFallback:true});
        }
      },

      safeDomId : function(name, value, fallback) {
        return this._safeValue(name, value, fallback, {name: 'DOM ID', checker: Hazmat.isDomId, evalFallback:true});
      },

      safeFunction : function(name, value, fallback) {
        return this._safeValue(name, value, fallback, {name: 'Function', checker: _.isFunction, evalFallback:false});
      },

      safeFunctionOrNull : function(name, value, fallback) {
        if(value == null) {
          return value;
        } else {
          return this._safeValue(name, value, fallback, {name: 'Function', checker: _.isFunction, evalFallback:false});
        }
      },

      safeObject : function(name, value, fallback) {
        return this._safeValue(name, value, fallback, {name: 'Object', checker: _.isObject, evalFallback:false});
      },

      safeObjectOrNull : function(name, value, fallback) {
        if(value == null) {
          return value;
        } else {
          return this._safeValue(name, value, fallback, {name: 'Object', checker: _.isObject, evalFallback:false});
        }
      },

      safeArray : function(name, value, fallback) {
        return this._safeValue(name, value, fallback, {name: 'Array', checker: _.isArray, evalFallback:false});
      },

      safeArrayOfElements : function(name, value, elementValidator, fallback) {
        var safeArray = this._safeValue(name, value, fallback, {name: 'Array', checker: _.isArray, evalFallback:false});
        return _.map(safeArray, elementValidator);
      },

      __placeholder:true
    });

    return Hazmat;
  };

// Integration with Node.js/Browser
  if(typeof window !== 'undefined' && typeof window._ !== 'undefined') {
    var hazmat = HazmatBuilder(window._, window);
    hazmat.original = window.Hazmat;
    window.Hazmat = hazmat;
  } else {
    var _ = require('underscore');
    var hazmat = HazmatBuilder(_);
    _.extend(exports,hazmat);
  }

},{"underscore":8}],8:[function(require,module,exports){
//     Underscore.js 1.3.3
//     (c) 2009-2012 Jeremy Ashkenas, DocumentCloud Inc.
//     Underscore is freely distributable under the MIT license.
//     Portions of Underscore are inspired or borrowed from Prototype,
//     Oliver Steele's Functional, and John Resig's Micro-Templating.
//     For all details and documentation:
//     http://documentcloud.github.com/underscore

  (function() {

    // Baseline setup
    // --------------

    // Establish the root object, `window` in the browser, or `global` on the server.
    var root = this;

    // Save the previous value of the `_` variable.
    var previousUnderscore = root._;

    // Establish the object that gets returned to break out of a loop iteration.
    var breaker = {};

    // Save bytes in the minified (but not gzipped) version:
    var ArrayProto = Array.prototype, ObjProto = Object.prototype, FuncProto = Function.prototype;

    // Create quick reference variables for speed access to core prototypes.
    var slice            = ArrayProto.slice,
      unshift          = ArrayProto.unshift,
      toString         = ObjProto.toString,
      hasOwnProperty   = ObjProto.hasOwnProperty;

    // All **ECMAScript 5** native function implementations that we hope to use
    // are declared here.
    var
      nativeForEach      = ArrayProto.forEach,
      nativeMap          = ArrayProto.map,
      nativeReduce       = ArrayProto.reduce,
      nativeReduceRight  = ArrayProto.reduceRight,
      nativeFilter       = ArrayProto.filter,
      nativeEvery        = ArrayProto.every,
      nativeSome         = ArrayProto.some,
      nativeIndexOf      = ArrayProto.indexOf,
      nativeLastIndexOf  = ArrayProto.lastIndexOf,
      nativeIsArray      = Array.isArray,
      nativeKeys         = Object.keys,
      nativeBind         = FuncProto.bind;

    // Create a safe reference to the Underscore object for use below.
    var _ = function(obj) { return new wrapper(obj); };

    // Export the Underscore object for **Node.js**, with
    // backwards-compatibility for the old `require()` API. If we're in
    // the browser, add `_` as a global object via a string identifier,
    // for Closure Compiler "advanced" mode.
    if (typeof exports !== 'undefined') {
      if (typeof module !== 'undefined' && module.exports) {
        exports = module.exports = _;
      }
      exports._ = _;
    } else {
      root['_'] = _;
    }

    // Current version.
    _.VERSION = '1.3.3';

    // Collection Functions
    // --------------------

    // The cornerstone, an `each` implementation, aka `forEach`.
    // Handles objects with the built-in `forEach`, arrays, and raw objects.
    // Delegates to **ECMAScript 5**'s native `forEach` if available.
    var each = _.each = _.forEach = function(obj, iterator, context) {
      if (obj == null) return;
      if (nativeForEach && obj.forEach === nativeForEach) {
        obj.forEach(iterator, context);
      } else if (obj.length === +obj.length) {
        for (var i = 0, l = obj.length; i < l; i++) {
          if (i in obj && iterator.call(context, obj[i], i, obj) === breaker) return;
        }
      } else {
        for (var key in obj) {
          if (_.has(obj, key)) {
            if (iterator.call(context, obj[key], key, obj) === breaker) return;
          }
        }
      }
    };

    // Return the results of applying the iterator to each element.
    // Delegates to **ECMAScript 5**'s native `map` if available.
    _.map = _.collect = function(obj, iterator, context) {
      var results = [];
      if (obj == null) return results;
      if (nativeMap && obj.map === nativeMap) return obj.map(iterator, context);
      each(obj, function(value, index, list) {
        results[results.length] = iterator.call(context, value, index, list);
      });
      if (obj.length === +obj.length) results.length = obj.length;
      return results;
    };

    // **Reduce** builds up a single result from a list of values, aka `inject`,
    // or `foldl`. Delegates to **ECMAScript 5**'s native `reduce` if available.
    _.reduce = _.foldl = _.inject = function(obj, iterator, memo, context) {
      var initial = arguments.length > 2;
      if (obj == null) obj = [];
      if (nativeReduce && obj.reduce === nativeReduce) {
        if (context) iterator = _.bind(iterator, context);
        return initial ? obj.reduce(iterator, memo) : obj.reduce(iterator);
      }
      each(obj, function(value, index, list) {
        if (!initial) {
          memo = value;
          initial = true;
        } else {
          memo = iterator.call(context, memo, value, index, list);
        }
      });
      if (!initial) throw new TypeError('Reduce of empty array with no initial value');
      return memo;
    };

    // The right-associative version of reduce, also known as `foldr`.
    // Delegates to **ECMAScript 5**'s native `reduceRight` if available.
    _.reduceRight = _.foldr = function(obj, iterator, memo, context) {
      var initial = arguments.length > 2;
      if (obj == null) obj = [];
      if (nativeReduceRight && obj.reduceRight === nativeReduceRight) {
        if (context) iterator = _.bind(iterator, context);
        return initial ? obj.reduceRight(iterator, memo) : obj.reduceRight(iterator);
      }
      var reversed = _.toArray(obj).reverse();
      if (context && !initial) iterator = _.bind(iterator, context);
      return initial ? _.reduce(reversed, iterator, memo, context) : _.reduce(reversed, iterator);
    };

    // Return the first value which passes a truth test. Aliased as `detect`.
    _.find = _.detect = function(obj, iterator, context) {
      var result;
      any(obj, function(value, index, list) {
        if (iterator.call(context, value, index, list)) {
          result = value;
          return true;
        }
      });
      return result;
    };

    // Return all the elements that pass a truth test.
    // Delegates to **ECMAScript 5**'s native `filter` if available.
    // Aliased as `select`.
    _.filter = _.select = function(obj, iterator, context) {
      var results = [];
      if (obj == null) return results;
      if (nativeFilter && obj.filter === nativeFilter) return obj.filter(iterator, context);
      each(obj, function(value, index, list) {
        if (iterator.call(context, value, index, list)) results[results.length] = value;
      });
      return results;
    };

    // Return all the elements for which a truth test fails.
    _.reject = function(obj, iterator, context) {
      var results = [];
      if (obj == null) return results;
      each(obj, function(value, index, list) {
        if (!iterator.call(context, value, index, list)) results[results.length] = value;
      });
      return results;
    };

    // Determine whether all of the elements match a truth test.
    // Delegates to **ECMAScript 5**'s native `every` if available.
    // Aliased as `all`.
    _.every = _.all = function(obj, iterator, context) {
      var result = true;
      if (obj == null) return result;
      if (nativeEvery && obj.every === nativeEvery) return obj.every(iterator, context);
      each(obj, function(value, index, list) {
        if (!(result = result && iterator.call(context, value, index, list))) return breaker;
      });
      return !!result;
    };

    // Determine if at least one element in the object matches a truth test.
    // Delegates to **ECMAScript 5**'s native `some` if available.
    // Aliased as `any`.
    var any = _.some = _.any = function(obj, iterator, context) {
      iterator || (iterator = _.identity);
      var result = false;
      if (obj == null) return result;
      if (nativeSome && obj.some === nativeSome) return obj.some(iterator, context);
      each(obj, function(value, index, list) {
        if (result || (result = iterator.call(context, value, index, list))) return breaker;
      });
      return !!result;
    };

    // Determine if a given value is included in the array or object using `===`.
    // Aliased as `contains`.
    _.include = _.contains = function(obj, target) {
      var found = false;
      if (obj == null) return found;
      if (nativeIndexOf && obj.indexOf === nativeIndexOf) return obj.indexOf(target) != -1;
      found = any(obj, function(value) {
        return value === target;
      });
      return found;
    };

    // Invoke a method (with arguments) on every item in a collection.
    _.invoke = function(obj, method) {
      var args = slice.call(arguments, 2);
      return _.map(obj, function(value) {
        return (_.isFunction(method) ? method || value : value[method]).apply(value, args);
      });
    };

    // Convenience version of a common use case of `map`: fetching a property.
    _.pluck = function(obj, key) {
      return _.map(obj, function(value){ return value[key]; });
    };

    // Return the maximum element or (element-based computation).
    _.max = function(obj, iterator, context) {
      if (!iterator && _.isArray(obj) && obj[0] === +obj[0]) return Math.max.apply(Math, obj);
      if (!iterator && _.isEmpty(obj)) return -Infinity;
      var result = {computed : -Infinity};
      each(obj, function(value, index, list) {
        var computed = iterator ? iterator.call(context, value, index, list) : value;
        computed >= result.computed && (result = {value : value, computed : computed});
      });
      return result.value;
    };

    // Return the minimum element (or element-based computation).
    _.min = function(obj, iterator, context) {
      if (!iterator && _.isArray(obj) && obj[0] === +obj[0]) return Math.min.apply(Math, obj);
      if (!iterator && _.isEmpty(obj)) return Infinity;
      var result = {computed : Infinity};
      each(obj, function(value, index, list) {
        var computed = iterator ? iterator.call(context, value, index, list) : value;
        computed < result.computed && (result = {value : value, computed : computed});
      });
      return result.value;
    };

    // Shuffle an array.
    _.shuffle = function(obj) {
      var shuffled = [], rand;
      each(obj, function(value, index, list) {
        rand = Math.floor(Math.random() * (index + 1));
        shuffled[index] = shuffled[rand];
        shuffled[rand] = value;
      });
      return shuffled;
    };

    // Sort the object's values by a criterion produced by an iterator.
    _.sortBy = function(obj, val, context) {
      var iterator = _.isFunction(val) ? val : function(obj) { return obj[val]; };
      return _.pluck(_.map(obj, function(value, index, list) {
        return {
          value : value,
          criteria : iterator.call(context, value, index, list)
        };
      }).sort(function(left, right) {
        var a = left.criteria, b = right.criteria;
        if (a === void 0) return 1;
        if (b === void 0) return -1;
        return a < b ? -1 : a > b ? 1 : 0;
      }), 'value');
    };

    // Groups the object's values by a criterion. Pass either a string attribute
    // to group by, or a function that returns the criterion.
    _.groupBy = function(obj, val) {
      var result = {};
      var iterator = _.isFunction(val) ? val : function(obj) { return obj[val]; };
      each(obj, function(value, index) {
        var key = iterator(value, index);
        (result[key] || (result[key] = [])).push(value);
      });
      return result;
    };

    // Use a comparator function to figure out at what index an object should
    // be inserted so as to maintain order. Uses binary search.
    _.sortedIndex = function(array, obj, iterator) {
      iterator || (iterator = _.identity);
      var low = 0, high = array.length;
      while (low < high) {
        var mid = (low + high) >> 1;
        iterator(array[mid]) < iterator(obj) ? low = mid + 1 : high = mid;
      }
      return low;
    };

    // Safely convert anything iterable into a real, live array.
    _.toArray = function(obj) {
      if (!obj)                                     return [];
      if (_.isArray(obj))                           return slice.call(obj);
      if (_.isArguments(obj))                       return slice.call(obj);
      if (obj.toArray && _.isFunction(obj.toArray)) return obj.toArray();
      return _.values(obj);
    };

    // Return the number of elements in an object.
    _.size = function(obj) {
      return _.isArray(obj) ? obj.length : _.keys(obj).length;
    };

    // Array Functions
    // ---------------

    // Get the first element of an array. Passing **n** will return the first N
    // values in the array. Aliased as `head` and `take`. The **guard** check
    // allows it to work with `_.map`.
    _.first = _.head = _.take = function(array, n, guard) {
      return (n != null) && !guard ? slice.call(array, 0, n) : array[0];
    };

    // Returns everything but the last entry of the array. Especcialy useful on
    // the arguments object. Passing **n** will return all the values in
    // the array, excluding the last N. The **guard** check allows it to work with
    // `_.map`.
    _.initial = function(array, n, guard) {
      return slice.call(array, 0, array.length - ((n == null) || guard ? 1 : n));
    };

    // Get the last element of an array. Passing **n** will return the last N
    // values in the array. The **guard** check allows it to work with `_.map`.
    _.last = function(array, n, guard) {
      if ((n != null) && !guard) {
        return slice.call(array, Math.max(array.length - n, 0));
      } else {
        return array[array.length - 1];
      }
    };

    // Returns everything but the first entry of the array. Aliased as `tail`.
    // Especially useful on the arguments object. Passing an **index** will return
    // the rest of the values in the array from that index onward. The **guard**
    // check allows it to work with `_.map`.
    _.rest = _.tail = function(array, index, guard) {
      return slice.call(array, (index == null) || guard ? 1 : index);
    };

    // Trim out all falsy values from an array.
    _.compact = function(array) {
      return _.filter(array, function(value){ return !!value; });
    };

    // Return a completely flattened version of an array.
    _.flatten = function(array, shallow) {
      return _.reduce(array, function(memo, value) {
        if (_.isArray(value)) return memo.concat(shallow ? value : _.flatten(value));
        memo[memo.length] = value;
        return memo;
      }, []);
    };

    // Return a version of the array that does not contain the specified value(s).
    _.without = function(array) {
      return _.difference(array, slice.call(arguments, 1));
    };

    // Produce a duplicate-free version of the array. If the array has already
    // been sorted, you have the option of using a faster algorithm.
    // Aliased as `unique`.
    _.uniq = _.unique = function(array, isSorted, iterator) {
      var initial = iterator ? _.map(array, iterator) : array;
      var results = [];
      // The `isSorted` flag is irrelevant if the array only contains two elements.
      if (array.length < 3) isSorted = true;
      _.reduce(initial, function (memo, value, index) {
        if (isSorted ? _.last(memo) !== value || !memo.length : !_.include(memo, value)) {
          memo.push(value);
          results.push(array[index]);
        }
        return memo;
      }, []);
      return results;
    };

    // Produce an array that contains the union: each distinct element from all of
    // the passed-in arrays.
    _.union = function() {
      return _.uniq(_.flatten(arguments, true));
    };

    // Produce an array that contains every item shared between all the
    // passed-in arrays. (Aliased as "intersect" for back-compat.)
    _.intersection = _.intersect = function(array) {
      var rest = slice.call(arguments, 1);
      return _.filter(_.uniq(array), function(item) {
        return _.every(rest, function(other) {
          return _.indexOf(other, item) >= 0;
        });
      });
    };

    // Take the difference between one array and a number of other arrays.
    // Only the elements present in just the first array will remain.
    _.difference = function(array) {
      var rest = _.flatten(slice.call(arguments, 1), true);
      return _.filter(array, function(value){ return !_.include(rest, value); });
    };

    // Zip together multiple lists into a single array -- elements that share
    // an index go together.
    _.zip = function() {
      var args = slice.call(arguments);
      var length = _.max(_.pluck(args, 'length'));
      var results = new Array(length);
      for (var i = 0; i < length; i++) results[i] = _.pluck(args, "" + i);
      return results;
    };

    // If the browser doesn't supply us with indexOf (I'm looking at you, **MSIE**),
    // we need this function. Return the position of the first occurrence of an
    // item in an array, or -1 if the item is not included in the array.
    // Delegates to **ECMAScript 5**'s native `indexOf` if available.
    // If the array is large and already in sort order, pass `true`
    // for **isSorted** to use binary search.
    _.indexOf = function(array, item, isSorted) {
      if (array == null) return -1;
      var i, l;
      if (isSorted) {
        i = _.sortedIndex(array, item);
        return array[i] === item ? i : -1;
      }
      if (nativeIndexOf && array.indexOf === nativeIndexOf) return array.indexOf(item);
      for (i = 0, l = array.length; i < l; i++) if (i in array && array[i] === item) return i;
      return -1;
    };

    // Delegates to **ECMAScript 5**'s native `lastIndexOf` if available.
    _.lastIndexOf = function(array, item) {
      if (array == null) return -1;
      if (nativeLastIndexOf && array.lastIndexOf === nativeLastIndexOf) return array.lastIndexOf(item);
      var i = array.length;
      while (i--) if (i in array && array[i] === item) return i;
      return -1;
    };

    // Generate an integer Array containing an arithmetic progression. A port of
    // the native Python `range()` function. See
    // [the Python documentation](http://docs.python.org/library/functions.html#range).
    _.range = function(start, stop, step) {
      if (arguments.length <= 1) {
        stop = start || 0;
        start = 0;
      }
      step = arguments[2] || 1;

      var len = Math.max(Math.ceil((stop - start) / step), 0);
      var idx = 0;
      var range = new Array(len);

      while(idx < len) {
        range[idx++] = start;
        start += step;
      }

      return range;
    };

    // Function (ahem) Functions
    // ------------------

    // Reusable constructor function for prototype setting.
    var ctor = function(){};

    // Create a function bound to a given object (assigning `this`, and arguments,
    // optionally). Binding with arguments is also known as `curry`.
    // Delegates to **ECMAScript 5**'s native `Function.bind` if available.
    // We check for `func.bind` first, to fail fast when `func` is undefined.
    _.bind = function bind(func, context) {
      var bound, args;
      if (func.bind === nativeBind && nativeBind) return nativeBind.apply(func, slice.call(arguments, 1));
      if (!_.isFunction(func)) throw new TypeError;
      args = slice.call(arguments, 2);
      return bound = function() {
        if (!(this instanceof bound)) return func.apply(context, args.concat(slice.call(arguments)));
        ctor.prototype = func.prototype;
        var self = new ctor;
        var result = func.apply(self, args.concat(slice.call(arguments)));
        if (Object(result) === result) return result;
        return self;
      };
    };

    // Bind all of an object's methods to that object. Useful for ensuring that
    // all callbacks defined on an object belong to it.
    _.bindAll = function(obj) {
      var funcs = slice.call(arguments, 1);
      if (funcs.length == 0) funcs = _.functions(obj);
      each(funcs, function(f) { obj[f] = _.bind(obj[f], obj); });
      return obj;
    };

    // Memoize an expensive function by storing its results.
    _.memoize = function(func, hasher) {
      var memo = {};
      hasher || (hasher = _.identity);
      return function() {
        var key = hasher.apply(this, arguments);
        return _.has(memo, key) ? memo[key] : (memo[key] = func.apply(this, arguments));
      };
    };

    // Delays a function for the given number of milliseconds, and then calls
    // it with the arguments supplied.
    _.delay = function(func, wait) {
      var args = slice.call(arguments, 2);
      return setTimeout(function(){ return func.apply(null, args); }, wait);
    };

    // Defers a function, scheduling it to run after the current call stack has
    // cleared.
    _.defer = function(func) {
      return _.delay.apply(_, [func, 1].concat(slice.call(arguments, 1)));
    };

    // Returns a function, that, when invoked, will only be triggered at most once
    // during a given window of time.
    _.throttle = function(func, wait) {
      var context, args, timeout, throttling, more, result;
      var whenDone = _.debounce(function(){ more = throttling = false; }, wait);
      return function() {
        context = this; args = arguments;
        var later = function() {
          timeout = null;
          if (more) func.apply(context, args);
          whenDone();
        };
        if (!timeout) timeout = setTimeout(later, wait);
        if (throttling) {
          more = true;
        } else {
          result = func.apply(context, args);
        }
        whenDone();
        throttling = true;
        return result;
      };
    };

    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    _.debounce = function(func, wait, immediate) {
      var timeout;
      return function() {
        var context = this, args = arguments;
        var later = function() {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        if (immediate && !timeout) func.apply(context, args);
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    };

    // Returns a function that will be executed at most one time, no matter how
    // often you call it. Useful for lazy initialization.
    _.once = function(func) {
      var ran = false, memo;
      return function() {
        if (ran) return memo;
        ran = true;
        return memo = func.apply(this, arguments);
      };
    };

    // Returns the first function passed as an argument to the second,
    // allowing you to adjust arguments, run code before and after, and
    // conditionally execute the original function.
    _.wrap = function(func, wrapper) {
      return function() {
        var args = [func].concat(slice.call(arguments, 0));
        return wrapper.apply(this, args);
      };
    };

    // Returns a function that is the composition of a list of functions, each
    // consuming the return value of the function that follows.
    _.compose = function() {
      var funcs = arguments;
      return function() {
        var args = arguments;
        for (var i = funcs.length - 1; i >= 0; i--) {
          args = [funcs[i].apply(this, args)];
        }
        return args[0];
      };
    };

    // Returns a function that will only be executed after being called N times.
    _.after = function(times, func) {
      if (times <= 0) return func();
      return function() {
        if (--times < 1) { return func.apply(this, arguments); }
      };
    };

    // Object Functions
    // ----------------

    // Retrieve the names of an object's properties.
    // Delegates to **ECMAScript 5**'s native `Object.keys`
    _.keys = nativeKeys || function(obj) {
        if (obj !== Object(obj)) throw new TypeError('Invalid object');
        var keys = [];
        for (var key in obj) if (_.has(obj, key)) keys[keys.length] = key;
        return keys;
      };

    // Retrieve the values of an object's properties.
    _.values = function(obj) {
      return _.map(obj, _.identity);
    };

    // Return a sorted list of the function names available on the object.
    // Aliased as `methods`
    _.functions = _.methods = function(obj) {
      var names = [];
      for (var key in obj) {
        if (_.isFunction(obj[key])) names.push(key);
      }
      return names.sort();
    };

    // Extend a given object with all the properties in passed-in object(s).
    _.extend = function(obj) {
      each(slice.call(arguments, 1), function(source) {
        for (var prop in source) {
          obj[prop] = source[prop];
        }
      });
      return obj;
    };

    // Return a copy of the object only containing the whitelisted properties.
    _.pick = function(obj) {
      var result = {};
      each(_.flatten(slice.call(arguments, 1)), function(key) {
        if (key in obj) result[key] = obj[key];
      });
      return result;
    };

    // Fill in a given object with default properties.
    _.defaults = function(obj) {
      each(slice.call(arguments, 1), function(source) {
        for (var prop in source) {
          if (obj[prop] == null) obj[prop] = source[prop];
        }
      });
      return obj;
    };

    // Create a (shallow-cloned) duplicate of an object.
    _.clone = function(obj) {
      if (!_.isObject(obj)) return obj;
      return _.isArray(obj) ? obj.slice() : _.extend({}, obj);
    };

    // Invokes interceptor with the obj, and then returns obj.
    // The primary purpose of this method is to "tap into" a method chain, in
    // order to perform operations on intermediate results within the chain.
    _.tap = function(obj, interceptor) {
      interceptor(obj);
      return obj;
    };

    // Internal recursive comparison function.
    function eq(a, b, stack) {
      // Identical objects are equal. `0 === -0`, but they aren't identical.
      // See the Harmony `egal` proposal: http://wiki.ecmascript.org/doku.php?id=harmony:egal.
      if (a === b) return a !== 0 || 1 / a == 1 / b;
      // A strict comparison is necessary because `null == undefined`.
      if (a == null || b == null) return a === b;
      // Unwrap any wrapped objects.
      if (a._chain) a = a._wrapped;
      if (b._chain) b = b._wrapped;
      // Invoke a custom `isEqual` method if one is provided.
      if (a.isEqual && _.isFunction(a.isEqual)) return a.isEqual(b);
      if (b.isEqual && _.isFunction(b.isEqual)) return b.isEqual(a);
      // Compare `[[Class]]` names.
      var className = toString.call(a);
      if (className != toString.call(b)) return false;
      switch (className) {
        // Strings, numbers, dates, and booleans are compared by value.
        case '[object String]':
          // Primitives and their corresponding object wrappers are equivalent; thus, `"5"` is
          // equivalent to `new String("5")`.
          return a == String(b);
        case '[object Number]':
          // `NaN`s are equivalent, but non-reflexive. An `egal` comparison is performed for
          // other numeric values.
          return a != +a ? b != +b : (a == 0 ? 1 / a == 1 / b : a == +b);
        case '[object Date]':
        case '[object Boolean]':
          // Coerce dates and booleans to numeric primitive values. Dates are compared by their
          // millisecond representations. Note that invalid dates with millisecond representations
          // of `NaN` are not equivalent.
          return +a == +b;
        // RegExps are compared by their source patterns and flags.
        case '[object RegExp]':
          return a.source == b.source &&
            a.global == b.global &&
            a.multiline == b.multiline &&
            a.ignoreCase == b.ignoreCase;
      }
      if (typeof a != 'object' || typeof b != 'object') return false;
      // Assume equality for cyclic structures. The algorithm for detecting cyclic
      // structures is adapted from ES 5.1 section 15.12.3, abstract operation `JO`.
      var length = stack.length;
      while (length--) {
        // Linear search. Performance is inversely proportional to the number of
        // unique nested structures.
        if (stack[length] == a) return true;
      }
      // Add the first object to the stack of traversed objects.
      stack.push(a);
      var size = 0, result = true;
      // Recursively compare objects and arrays.
      if (className == '[object Array]') {
        // Compare array lengths to determine if a deep comparison is necessary.
        size = a.length;
        result = size == b.length;
        if (result) {
          // Deep compare the contents, ignoring non-numeric properties.
          while (size--) {
            // Ensure commutative equality for sparse arrays.
            if (!(result = size in a == size in b && eq(a[size], b[size], stack))) break;
          }
        }
      } else {
        // Objects with different constructors are not equivalent.
        if ('constructor' in a != 'constructor' in b || a.constructor != b.constructor) return false;
        // Deep compare objects.
        for (var key in a) {
          if (_.has(a, key)) {
            // Count the expected number of properties.
            size++;
            // Deep compare each member.
            if (!(result = _.has(b, key) && eq(a[key], b[key], stack))) break;
          }
        }
        // Ensure that both objects contain the same number of properties.
        if (result) {
          for (key in b) {
            if (_.has(b, key) && !(size--)) break;
          }
          result = !size;
        }
      }
      // Remove the first object from the stack of traversed objects.
      stack.pop();
      return result;
    }

    // Perform a deep comparison to check if two objects are equal.
    _.isEqual = function(a, b) {
      return eq(a, b, []);
    };

    // Is a given array, string, or object empty?
    // An "empty" object has no enumerable own-properties.
    _.isEmpty = function(obj) {
      if (obj == null) return true;
      if (_.isArray(obj) || _.isString(obj)) return obj.length === 0;
      for (var key in obj) if (_.has(obj, key)) return false;
      return true;
    };

    // Is a given value a DOM element?
    _.isElement = function(obj) {
      return !!(obj && obj.nodeType == 1);
    };

    // Is a given value an array?
    // Delegates to ECMA5's native Array.isArray
    _.isArray = nativeIsArray || function(obj) {
        return toString.call(obj) == '[object Array]';
      };

    // Is a given variable an object?
    _.isObject = function(obj) {
      return obj === Object(obj);
    };

    // Is a given variable an arguments object?
    _.isArguments = function(obj) {
      return toString.call(obj) == '[object Arguments]';
    };
    if (!_.isArguments(arguments)) {
      _.isArguments = function(obj) {
        return !!(obj && _.has(obj, 'callee'));
      };
    }

    // Is a given value a function?
    _.isFunction = function(obj) {
      return toString.call(obj) == '[object Function]';
    };

    // Is a given value a string?
    _.isString = function(obj) {
      return toString.call(obj) == '[object String]';
    };

    // Is a given value a number?
    _.isNumber = function(obj) {
      return toString.call(obj) == '[object Number]';
    };

    // Is a given object a finite number?
    _.isFinite = function(obj) {
      return _.isNumber(obj) && isFinite(obj);
    };

    // Is the given value `NaN`?
    _.isNaN = function(obj) {
      // `NaN` is the only value for which `===` is not reflexive.
      return obj !== obj;
    };

    // Is a given value a boolean?
    _.isBoolean = function(obj) {
      return obj === true || obj === false || toString.call(obj) == '[object Boolean]';
    };

    // Is a given value a date?
    _.isDate = function(obj) {
      return toString.call(obj) == '[object Date]';
    };

    // Is the given value a regular expression?
    _.isRegExp = function(obj) {
      return toString.call(obj) == '[object RegExp]';
    };

    // Is a given value equal to null?
    _.isNull = function(obj) {
      return obj === null;
    };

    // Is a given variable undefined?
    _.isUndefined = function(obj) {
      return obj === void 0;
    };

    // Has own property?
    _.has = function(obj, key) {
      return hasOwnProperty.call(obj, key);
    };

    // Utility Functions
    // -----------------

    // Run Underscore.js in *noConflict* mode, returning the `_` variable to its
    // previous owner. Returns a reference to the Underscore object.
    _.noConflict = function() {
      root._ = previousUnderscore;
      return this;
    };

    // Keep the identity function around for default iterators.
    _.identity = function(value) {
      return value;
    };

    // Run a function **n** times.
    _.times = function (n, iterator, context) {
      for (var i = 0; i < n; i++) iterator.call(context, i);
    };

    // Escape a string for HTML interpolation.
    _.escape = function(string) {
      return (''+string).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#x27;').replace(/\//g,'&#x2F;');
    };

    // If the value of the named property is a function then invoke it;
    // otherwise, return it.
    _.result = function(object, property) {
      if (object == null) return null;
      var value = object[property];
      return _.isFunction(value) ? value.call(object) : value;
    };

    // Add your own custom functions to the Underscore object, ensuring that
    // they're correctly added to the OOP wrapper as well.
    _.mixin = function(obj) {
      each(_.functions(obj), function(name){
        addToWrapper(name, _[name] = obj[name]);
      });
    };

    // Generate a unique integer id (unique within the entire client session).
    // Useful for temporary DOM ids.
    var idCounter = 0;
    _.uniqueId = function(prefix) {
      var id = idCounter++;
      return prefix ? prefix + id : id;
    };

    // By default, Underscore uses ERB-style template delimiters, change the
    // following template settings to use alternative delimiters.
    _.templateSettings = {
      evaluate    : /<%([\s\S]+?)%>/g,
      interpolate : /<%=([\s\S]+?)%>/g,
      escape      : /<%-([\s\S]+?)%>/g
    };

    // When customizing `templateSettings`, if you don't want to define an
    // interpolation, evaluation or escaping regex, we need one that is
    // guaranteed not to match.
    var noMatch = /.^/;

    // Certain characters need to be escaped so that they can be put into a
    // string literal.
    var escapes = {
      '\\': '\\',
      "'": "'",
      'r': '\r',
      'n': '\n',
      't': '\t',
      'u2028': '\u2028',
      'u2029': '\u2029'
    };

    for (var p in escapes) escapes[escapes[p]] = p;
    var escaper = /\\|'|\r|\n|\t|\u2028|\u2029/g;
    var unescaper = /\\(\\|'|r|n|t|u2028|u2029)/g;

    // Within an interpolation, evaluation, or escaping, remove HTML escaping
    // that had been previously added.
    var unescape = function(code) {
      return code.replace(unescaper, function(match, escape) {
        return escapes[escape];
      });
    };

    // JavaScript micro-templating, similar to John Resig's implementation.
    // Underscore templating handles arbitrary delimiters, preserves whitespace,
    // and correctly escapes quotes within interpolated code.
    _.template = function(text, data, settings) {
      settings = _.defaults(settings || {}, _.templateSettings);

      // Compile the template source, taking care to escape characters that
      // cannot be included in a string literal and then unescape them in code
      // blocks.
      var source = "__p+='" + text
        .replace(escaper, function(match) {
          return '\\' + escapes[match];
        })
        .replace(settings.escape || noMatch, function(match, code) {
          return "'+\n_.escape(" + unescape(code) + ")+\n'";
        })
        .replace(settings.interpolate || noMatch, function(match, code) {
          return "'+\n(" + unescape(code) + ")+\n'";
        })
        .replace(settings.evaluate || noMatch, function(match, code) {
          return "';\n" + unescape(code) + "\n;__p+='";
        }) + "';\n";

      // If a variable is not specified, place data values in local scope.
      if (!settings.variable) source = 'with(obj||{}){\n' + source + '}\n';

      source = "var __p='';" +
        "var print=function(){__p+=Array.prototype.join.call(arguments, '')};\n" +
        source + "return __p;\n";

      var render = new Function(settings.variable || 'obj', '_', source);
      if (data) return render(data, _);
      var template = function(data) {
        return render.call(this, data, _);
      };

      // Provide the compiled function source as a convenience for build time
      // precompilation.
      template.source = 'function(' + (settings.variable || 'obj') + '){\n' +
        source + '}';

      return template;
    };

    // Add a "chain" function, which will delegate to the wrapper.
    _.chain = function(obj) {
      return _(obj).chain();
    };

    // The OOP Wrapper
    // ---------------

    // If Underscore is called as a function, it returns a wrapped object that
    // can be used OO-style. This wrapper holds altered versions of all the
    // underscore functions. Wrapped objects may be chained.
    var wrapper = function(obj) { this._wrapped = obj; };

    // Expose `wrapper.prototype` as `_.prototype`
    _.prototype = wrapper.prototype;

    // Helper function to continue chaining intermediate results.
    var result = function(obj, chain) {
      return chain ? _(obj).chain() : obj;
    };

    // A method to easily add functions to the OOP wrapper.
    var addToWrapper = function(name, func) {
      wrapper.prototype[name] = function() {
        var args = slice.call(arguments);
        unshift.call(args, this._wrapped);
        return result(func.apply(_, args), this._chain);
      };
    };

    // Add all of the Underscore functions to the wrapper object.
    _.mixin(_);

    // Add all mutator Array functions to the wrapper.
    each(['pop', 'push', 'reverse', 'shift', 'sort', 'splice', 'unshift'], function(name) {
      var method = ArrayProto[name];
      wrapper.prototype[name] = function() {
        var wrapped = this._wrapped;
        method.apply(wrapped, arguments);
        var length = wrapped.length;
        if ((name == 'shift' || name == 'splice') && length === 0) delete wrapped[0];
        return result(wrapped, this._chain);
      };
    });

    // Add all accessor Array functions to the wrapper.
    each(['concat', 'join', 'slice'], function(name) {
      var method = ArrayProto[name];
      wrapper.prototype[name] = function() {
        return result(method.apply(this._wrapped, arguments), this._chain);
      };
    });

    // Start chaining a wrapped Underscore object.
    wrapper.prototype.chain = function() {
      this._chain = true;
      return this;
    };

    // Extracts the result from a wrapped and chained object.
    wrapper.prototype.value = function() {
      return this._wrapped;
    };

  }).call(this);

},{}],9:[function(require,module,exports){
	/*
	 * Simple HTML5 video tag plugin for mp4 and hls
	 * version: 0.1
	 */

  require("../../../html5-common/js/utils/InitModules/InitOO.js");
  require("../../../html5-common/js/utils/InitModules/InitOOUnderscore.js");
  require("../../../html5-common/js/utils/InitModules/InitOOHazmat.js");
  require("../../../html5-common/js/utils/constants.js");
  require("../../../html5-common/js/utils/utils.js");
  require("../../../html5-common/js/utils/environment.js");

  (function(_, $) {
    var pluginName = "ooyalaHtml5VideoTech";
    var currentInstances = {};

    /**
     * @class OoyalaVideoFactory
     * @classdesc Factory for creating video player objects that use HTML5 video tags
     * @property {string} name The name of the plugin
     * @property {object} encodings An array of supported encoding types (ex. OO.VIDEO.ENCODING.MP4)
     * @property {object} features An array of supported features (ex. OO.VIDEO.FEATURE.CLOSED_CAPTIONS)
     * @property {string} technology The core video technology (ex. OO.VIDEO.TECHNOLOGY.HTML5)
     */
    var OoyalaVideoFactory = function() {
      this.name = pluginName;

      this.features = [ OO.VIDEO.FEATURE.CLOSED_CAPTIONS,
        OO.VIDEO.FEATURE.VIDEO_OBJECT_SHARING_GIVE ];
      this.technology = OO.VIDEO.TECHNOLOGY.HTML5;

      // Determine supported encodings
      var getSupportedEncodings = function() {
        var list = [];
        var videoElement = document.createElement("video");

        if (typeof videoElement.canPlayType === "function") {
          if (!!videoElement.canPlayType("video/mp4")) {
            list.push(OO.VIDEO.ENCODING.MP4);
          }

          if (!!videoElement.canPlayType("video/webm")) {
            list.push(OO.VIDEO.ENCODING.WEBM);
          }

          if ((!!videoElement.canPlayType("application/vnd.apple.mpegurl") ||
            !!videoElement.canPlayType("application/x-mpegURL")) &&
            !OO.isSmartTV && !OO.isRimDevice &&
            (!OO.isMacOs || OO.isMacOsLionOrLater)) {
            // 2012 models of Samsung and LG smart TV's do not support HLS even if reported
            // Mac OS must be lion or later
            list.push(OO.VIDEO.ENCODING.HLS);
            list.push(OO.VIDEO.ENCODING.AKAMAI_HD2_VOD_HLS);
            list.push(OO.VIDEO.ENCODING.AKAMAI_HD2_HLS);
          }

          // Sony OperaTV supports HLS but doesn't properly report it so we are forcing it here
          if (window.navigator.userAgent.match(/SonyCEBrowser/)) {
            list.push(OO.VIDEO.ENCODING.HLS);
            list.push(OO.VIDEO.ENCODING.AKAMAI_HD2_VOD_HLS);
            list.push(OO.VIDEO.ENCODING.AKAMAI_HD2_HLS);
          }
        }

        return list;
      };
      this.encodings = getSupportedEncodings();

      /**
       * Creates a video player instance using OoyalaVideoWrapper
       * @public
       * @method OoyalaVideoFactory#create
       * @param {object} parentContainer The jquery div that should act as the parent for the video element
       * @param {string} domId The dom id of the video player instance to create
       * @param {object} controller A reference to the video controller in the Ooyala player
       * @param {object} css The css to apply to the video element
       * @param {string} playerId An id that represents the player instance
       * @returns {object} A reference to the wrapper for the newly created element
       */
      this.create = function(parentContainer, domId, controller, css, playerId) {
        // If the current player has reached max supported elements, do not create a new one
        if (this.maxSupportedElements > 0 && playerId &&
          currentInstances[playerId] >= this.maxSupportedElements) {
          return;
        }

        var video = $("<video>");
        video.attr("class", "video");
        video.attr("id", domId);
        video.attr("playsinline", true);
        if (parentContainer.attr('data-autoplay')) {
          video[0].autoplay = true;
          video[0].muted = true;
        }

        // [PBW-5470] On Safari, when preload is set to 'none' and the user switches to a
        // different tab while the video is about to auto play, the browser stops playback but
        // doesn't fire a 'pause' event, which causes the player to get stuck in 'buffering' state.
        // Setting preload to 'metadata' (or 'auto') allows Safari to auto resume when the tab is refocused.
        if (OO.isSafari && !OO.isIos) {
          video.attr("preload", "metadata");
        } else {
          video.attr("preload", "none");
        }

        video.css(css);

        // enable airplay for iOS
        // http://developer.apple.com/library/safari/#documentation/AudioVideo/Conceptual/AirPlayGuide/OptingInorOutofAirPlay/OptingInorOutofAirPlay.html
        if (OO.isIos) {
          video.attr("x-webkit-airplay", "allow");
        }

        // Set initial container dimension
        var dimension = {
          width: parentContainer.width(),
          height: parentContainer.height()
        };

        if (!playerId) {
          playerId = getRandomString();
        }

        var element = new OoyalaVideoWrapper(domId, video[0], dimension, playerId);
        if (currentInstances[playerId] && currentInstances[playerId] >= 0) {
          currentInstances[playerId]++;
        } else {
          currentInstances[playerId] = 1;
        }
        element.controller = controller;
        controller.notify(controller.EVENTS.CAN_PLAY);

        // TODO: Wait for loadstart before calling this?
        element.subscribeAllEvents();

        parentContainer.append(video);

        return element;
      };

      /**
       * Destroys the video technology factory
       * @public
       * @method OoyalaVideoFactory#destroy
       */
      this.destroy = function() {
        this.encodings = [];
        this.create = function() {};
      };

      /**
       * Represents the max number of support instances of video elements that can be supported on the
       * current platform. -1 implies no limit.
       * @public
       * @property OoyalaVideoFactory#maxSupportedElements
       */
      this.maxSupportedElements = (function() {
        var iosRequireSingleElement = OO.isIos;
        var androidRequireSingleElement = OO.isAndroid &&
          (!OO.isAndroid4Plus || OO.chromeMajorVersion < 40);
        return (iosRequireSingleElement || androidRequireSingleElement) ? 1 : -1;
      })();
    };

    /**
     * @class OoyalaVideoWrapper
     * @classdesc Player object that wraps HTML5 video tags
     * @param {string} domId The dom id of the video player element
     * @param {object} video The core video object to wrap
     * @param {object} dimension JSON object specifying player container's initial width and height
     * @property {object} controller A reference to the Ooyala Video Tech Controller
     * @property {boolean} disableNativeSeek When true, the plugin should supress or undo seeks that come from
     *                                       native video controls
     * @property {string} playerId An id representing the unique player instance
     */
    var OoyalaVideoWrapper = function(domId, video, dimension, playerId) {
      this.controller = {};
      this.disableNativeSeek = false;

      var _video = video;
      var _playerId = playerId;
      var _currentUrl = '';
      var videoEnded = false;
      var listeners = {};
      var loaded = false;
      var canPlay = false;
      var hasPlayed = false;
      var queuedSeekTime = null;
      var playQueued = false;
      var isSeeking = false;
      var currentTime = 0;
      var isM3u8 = false;
      var TRACK_CLASS = "track_cc";
      var firstPlay = true;
      var playerDimension = dimension;
      var videoDimension = {height: 0, width: 0};
      var initialTime = { value: 0, reached: true };
      var canSeek = true;
      var isPriming = false;
      var isLive = false;
      var lastCueText = null;
      var availableClosedCaptions = {};
      var textTrackModes = {};

      // Watch for underflow on Chrome
      var underflowWatcherTimer = null;
      var waitingEventRaised = false;
      var watcherTime = -1;

      // iPad CSS constants
      var IPAD_CSS_DEFAULT = {
        "width":"",
        "height":"",
        "left":"50%",
        "top":"50%",
        "-webkit-transform":"translate(-50%,-50%)",
        "visibility":"visible"
      };

      // [PBW-4000] On Android, if the chrome browser loses focus, then the stream cannot be seeked before it
      // is played again.  Detect visibility changes and delay seeks when focus is lost.
      if (OO.isAndroid && OO.isChrome) {
        var watchHidden = _.bind(function(evt) {
          if (document.hidden) {
            canSeek = false;
          }
        }, this)
        document.addEventListener("visibilitychange", watchHidden);
      }

			/************************************************************************************/
      // External Methods that Video Controller or Factory call
			/************************************************************************************/
      /**
       * Hands control of the video element off to another plugin by unsubscribing from all events.
       * @public
       * @method OoyalaVideoWrapper#sharedElementGive
       */
      this.sharedElementGive = function() {
        unsubscribeAllEvents();
        _currentUrl = "";
      };

      /**
       * Takes control of the video element from another plugin by subscribing to all events.
       * @public
       * @method OoyalaVideoWrapper#sharedElementTake
       */
      this.sharedElementTake = function() {
        this.subscribeAllEvents();
      };

      /**
       * Subscribes to all events raised by the video element.
       * This is called by the Factory during creation.
       * @public
       * @method OoyalaVideoWrapper#subscribeAllEvents
       */
      this.subscribeAllEvents = function() {
        listeners = { "loadstart": onLoadStart,
          "loadedmetadata": onLoadedMetadata,
          "progress": raiseProgress,
          "error": raiseErrorEvent,
          "stalled": raiseStalledEvent,
          "canplay": raiseCanPlay,
          "canplaythrough": raiseCanPlayThrough,
          "playing": raisePlayingEvent,
          "waiting": raiseWaitingEvent,
          "seeking": raiseSeekingEvent,
          "seeked": raiseSeekedEvent,
          "ended": raiseEndedEvent,
          "durationchange": raiseDurationChange,
          "timeupdate": raiseTimeUpdate,
          "play": raisePlayEvent,
          "pause": raisePauseEvent,
          "ratechange": raiseRatechangeEvent,
          "volumechange": raiseVolumeEvent,
          "volumechangeNew": raiseVolumeEvent,
          // ios webkit browser fullscreen events
          "webkitbeginfullscreen": raiseFullScreenBegin,
          "webkitendfullscreen": raiseFullScreenEnd
        };
        // events not used:
        // suspend, abort, emptied, loadeddata, resize, change, addtrack, removetrack
        _.each(listeners, function(v, i) { $(_video).on(i, v); }, this);
      };

      /**
       * Unsubscribes all events from the video element.
       * This is called by the destroy function.
       * @private
       * @method OoyalaVideoWrapper#unsubscribeAllEvents
       */
      var unsubscribeAllEvents = function() {
        _.each(listeners, function(v, i) { $(_video).off(i, v); }, this);
      };

      /**
       * Sets the url of the video.
       * @public
       * @method OoyalaVideoWrapper#setVideoUrl
       * @param {string} url The new url to insert into the video element's src attribute
       * @param {string} encoding The encoding of video stream, possible values are found in OO.VIDEO.ENCODING
       * @param {boolean} live True if it is a live asset, false otherwise
       * @returns {boolean} True or false indicating success
       */
      // Allow for the video src to be changed without loading the video
      this.setVideoUrl = function(url, encoding, live) {
        // check if we actually need to change the URL on video tag
        // compare URLs but make sure to strip out the trailing cache buster
        var urlChanged = false;
        if (_currentUrl.replace(/[\?&]_=[^&]+$/,'') != url) {
          _currentUrl = url || "";

          // bust the chrome caching bug
          if (_currentUrl.length > 0 && OO.isChrome) {
            _currentUrl = _currentUrl + (/\?/.test(_currentUrl) ? "&" : "?") + "_=" + getRandomString();
          }

          isM3u8 = (encoding == OO.VIDEO.ENCODING.HLS ||
            encoding == OO.VIDEO.ENCODING.AKAMAI_HD2_VOD_HLS ||
            encoding == OO.VIDEO.ENCODING.AKAMAI_HD2_HLS
          );
          isLive = live;
          urlChanged = true;
          resetStreamData();
          if (_currentUrl === "") {
            _video.src = null;
          } else {
            _video.src = _currentUrl;
          }
        }

        return urlChanged;
      };

      var resetStreamData = _.bind(function() {
        playQueued = false;
        canPlay = false;
        hasPlayed = false;
        queuedSeekTime = null;
        loaded = false;
        isSeeking = false;
        firstPlay = true;
        currentTime = 0;
        videoEnded = false;
        videoDimension = {height: 0, width: 0};
        initialTime = { value: 0, reached: true };
        canSeek = true;
        isPriming = false;
        stopUnderflowWatcher();
        lastCueText = null;
        textTrackModes = {};
        // [PLAYER-212]
        // Closed captions persist across discovery videos unless they are cleared
        // when a new video is set
        $(_video).find('.' + TRACK_CLASS).remove();
        availableClosedCaptions = {};
      }, this);

      /**
       * Callback to handle notifications that ad finished playing
       * @private
       * @method OoyalaVideoWrapper#onAdsPlayed
       */
      this.onAdsPlayed = function() {
      };

      /**
       * Loads the current stream url in the video element; the element should be left paused.
       * @public
       * @method OoyalaVideoWrapper#load
       * @param {boolean} rewind True if the stream should be set to time 0
       */
      this.load = function(rewind) {
        if (loaded && !rewind) return;
        if (!!rewind) {
          if (OO.isEdge) {
            // PBW-4555: Edge browser will always go back to time 0 on load.  Setting time to 0 here would
            // cause the raw video element to enter seeking state.  Additionally, if we call load while seeking
            // on Edge, then seeking no longer works until the video stream url is changed.  Protect against
            // seeking issues using loaded.  Lastly edge always preloads.
            currentTime = 0;
          } else {
            try {
              if (OO.isIos && OO.iosMajorVersion == 8) {
                // On iOS, wait for durationChange before setting currenttime
                $(_video).on("durationchange", _.bind(function() {
                  _video.currentTime = 0;
                  currentTime = 0;
                }, this));
              } else {
                _video.currentTime = 0;
                currentTime = 0;
              }
              _video.pause();
            } catch (ex) {
              // error because currentTime does not exist because stream hasn't been retrieved yet
              OO.log('VTC_OO: Failed to rewind video, probably ok; continuing');
            }
          }
        }
        canPlay = false;
        _video.load();
        loaded = true;
      };

      /**
       * Sets the initial time of the video playback.  For this plugin that is simply a seek which will be
       * triggered upon 'loadedmetadata' event.
       * @public
       * @method OoyalaVideoWrapper#setInitialTime
       * @param {number} time The initial time of the video (seconds)
       */
      this.setInitialTime = function(time) {
        var canSetInitialTime = (!hasPlayed || videoEnded) && (time !== 0);
        // [PBW-5539] On Safari (iOS and Desktop), when triggering replay after the current browser tab looses focus, the
        // current time seems to fall a few milliseconds behind the video duration, which
        // makes the video play for a fraction of a second and then stop again at the end.
        // In this case we allow setting the initial time back to 0 as a workaround for this
        var initialTimeRequired = OO.isSafari && videoEnded && time === 0;

        if (canSetInitialTime || initialTimeRequired) {
          initialTime.value = time;
          initialTime.reached = false;

          // [PBW-3866] Some Android devices (mostly Nexus) cannot be seeked too early or the seeked event is
          // never raised, even if the seekable property returns an endtime greater than the seek time.
          // To avoid this, save seeking information for use later.
          // [PBW-5539] Same issue with desktop Safari when setting initialTime after video ends
          if (OO.isAndroid || (initialTimeRequired && !OO.isIos)) {
            queueSeek(initialTime.value);
          }
          else {
            this.seek(initialTime.value);
          }
        }
      };

      /**
       * Triggers playback on the video element.
       * @public
       * @method OoyalaVideoWrapper#play
       */
      this.play = function() {
        // enqueue play command if in the process of seeking
        if (_video.seeking) {
          playQueued = true;
        } else {
          executePlay(false);
        }
      };

      /**
       * Triggers a pause on the video element.
       * @public
       * @method OoyalaVideoWrapper#pause
       */
      this.pause = function() {
        playQueued = false;
        _video.pause();
      };

      /**
       * Triggers a seek on the video element.
       * @public
       * @method OoyalaVideoWrapper#seek
       * @param {number} time The time to seek the video to (in seconds)
       */
      this.seek = function(time) {
        if (isLive) {
          return false;
        }
        var safeTime = getSafeSeekTimeIfPossible(_video, time);
        if (safeTime !== null) {
          _video.currentTime = safeTime;
          isSeeking = true;
          return true;
        }
        queueSeek(time);
        return false;
      };

      /**
       * Triggers a volume change on the video element.
       * @public
       * @method OoyalaVideoWrapper#setVolume
       * @param {number} volume A number between 0 and 1 indicating the desired volume percentage
       */
      this.setVolume = function(volume) {
        var resolvedVolume = volume;
        if (resolvedVolume < 0) {
          resolvedVolume = 0;
        } else if (resolvedVolume > 1) {
          resolvedVolume = 1;
        }

        //  TODO check if we need to capture any exception here. ios device will not allow volume set.
        _video.volume = resolvedVolume;

        // If no video is assigned yet, the volumeChange event is not raised although it takes effect
        if (_video.currentSrc === "" || _video.currentSrc === null) {
          raiseVolumeEvent({ target: { volume: resolvedVolume }});
        }
      };

      /**
       * Gets the current time position of the video.
       * @public
       * @method OoyalaVideoWrapper#getCurrentTime
       * @returns {number} The current time position of the video (seconds)
       */
      this.getCurrentTime = function() {
        return _video.currentTime;
      };

      /**
       * Prepares a video element to be played via API.  This is called on a user click event, and is used in
       * preparing HTML5-based video elements on devices.  To prepare the element for playback, call play and
       * pause.  Do not raise playback events during this time.
       * @public
       * @method OoyalaVideoWrapper#primeVideoElement
       */
      this.primeVideoElement = function() {
        // We need to "activate" the video on a click so we can control it with JS later on mobile
        executePlay(true);
        _video.pause();
      };

      /**
       * Applies the given css to the video element.
       * @public
       * @method OoyalaVideoWrapper#applyCss
       * @param {object} css The css to apply in key value pairs
       */
      this.applyCss = function(css) {
        $(_video).css(css);
        setVideoCentering();
      };

      /**
       * Destroys the individual video element.
       * @public
       * @method OoyalaVideoWrapper#destroy
       */
      this.destroy = function() {
        _video.pause();
        stopUnderflowWatcher();
        //On IE and Edge, setting the video source to an empty string has the unwanted effect
        //of a network request to the base url
        if (!OO.isIE && !OO.isEdge) {
          _video.src = '';
        }
        unsubscribeAllEvents();
        $(_video).remove();
        if (_playerId && currentInstances[_playerId] && currentInstances[_playerId] > 0) {
          currentInstances[_playerId]--;
        }
        if (watchHidden) {
          document.removeEventListener("visibilitychange", watchHidden);
        }
      };

      /**
       * Sets the closed captions on the video element.
       * @public
       * @method OoyalaVideoWrapper#setClosedCaptions
       * @param {string} language The language of the closed captions. If null, the current closed captions will be removed.
       * @param {object} closedCaptions The closedCaptions object
       * @param {object} params The params to set with closed captions
       */
      this.setClosedCaptions = _.bind(function(language, closedCaptions, params) {
        var iosVersion = OO.iosMajorVersion;
        var macOsSafariVersion = OO.macOsSafariVersion;
        var useOldLogic = (iosVersion && iosVersion < 10) || (macOsSafariVersion && macOsSafariVersion < 10);
        if (useOldLogic) { // XXX HACK! PLAYER-54 iOS and OSX Safari versions < 10 require re-creation of textTracks every time this function is called
          $(_video).find('.' + TRACK_CLASS).remove();
          textTrackModes = {};
          if (language == null) {
            return;
          }
        } else {
          if (language == null) {
            $(_video).find('.' + TRACK_CLASS).remove();
            textTrackModes = {};
            return;
          }
          // Remove captions before setting new ones if they are different, otherwise we may see native closed captions
          if (closedCaptions) {
            $(_video).children('.' + TRACK_CLASS).each(function() {
              if ($(this).label != closedCaptions.locale[language] ||
                $(this).srclang != language ||
                $(this).kind != "subtitles") {
                $(this).remove();
              }
            });
          }
        }

        //Add the new closed captions if they are valid.
        var captionsFormat = "closed_captions_vtt";
        if (closedCaptions && closedCaptions[captionsFormat]) {
          _.each(closedCaptions[captionsFormat], function(captions, languageKey) {
            var captionInfo = {
              label: captions.name,
              src: captions.url,
              language: languageKey,
              inStream: false
            }
            addClosedCaptions(captionInfo);
          });
        }

        var trackId = OO.getRandomString();
        var captionMode = (params && params.mode) || OO.CONSTANTS.CLOSED_CAPTIONS.SHOWING;
        //Set the closed captions based on the language and our available closed captions
        if (availableClosedCaptions[language]) {
          var captions = availableClosedCaptions[language];
          //If the captions are in-stream, we just need to enable them; Otherwise we must add them to the video ourselves.
          if (captions.inStream == true && _video.textTracks) {
            for (var i = 0; i < _video.textTracks.length; i++) {
              if (((OO.isSafari || OO.isEdge) && isLive) || _video.textTracks[i].kind === "captions") {
                _video.textTracks[i].mode = captionMode;
                _video.textTracks[i].oncuechange = onClosedCaptionCueChange;
              } else {
                _video.textTracks[i].mode = OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED;
              }
              // [PLAYER-327], [PLAYER-73]
              // We keep track of all text track modes in order to prevent Safari from randomly
              // changing them. We can't set the id of inStream tracks, so we use a custom
              // trackId property instead
              trackId = _video.textTracks[i].id || _video.textTracks[i].trackId || OO.getRandomString();
              _video.textTracks[i].trackId = trackId;
              textTrackModes[trackId] = _video.textTracks[i].mode;
            }
          } else if (!captions.inStream) {
            this.setClosedCaptionsMode(OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED);
            if (useOldLogic) { // XXX HACK! PLAYER-54 create video element unconditionally as it was removed
              $(_video).append("<track id='" + trackId + "' class='" + TRACK_CLASS + "' kind='subtitles' label='" + captions.label + "' src='" + captions.src + "' srclang='" + captions.language + "' default>");
              if (_video.textTracks && _video.textTracks[0]) {
                _video.textTracks[0].mode = captionMode;
                //We only want to let the controller know of cue change if we aren't rendering cc from the plugin.
                if (captionMode == OO.CONSTANTS.CLOSED_CAPTIONS.HIDDEN) {
                  _video.textTracks[0].oncuechange = onClosedCaptionCueChange;
                }
              }
            } else {
              if ($(_video).children('.' + TRACK_CLASS).length == 0) {
                $(_video).append("<track id='" + trackId + "' class='" + TRACK_CLASS + "' kind='subtitles' label='" + captions.label + "' src='" + captions.src + "' srclang='" + captions.language + "' default>");
              }
              if (_video.textTracks && _video.textTracks.length > 0) {
                for (var i = 0; i < _video.textTracks.length; i++) {
                  _video.textTracks[i].mode = captionMode;
                  //We only want to let the controller know of cue change if we aren't rendering cc from the plugin.
                  if (captionMode == OO.CONSTANTS.CLOSED_CAPTIONS.HIDDEN) {
                    _video.textTracks[i].oncuechange = onClosedCaptionCueChange;
                  }
                }
              }
            }
            // [PLAYER-327], [PLAYER-73]
            // Store mode of newly added tracks for future use in workaround
            textTrackModes[trackId] = captionMode;
            //Sometimes there is a delay before the textTracks are accessible. This is a workaround.
            _.delay(function(captionMode) {
              if (_video.textTracks && _video.textTracks[0]) {
                _video.textTracks[0].mode = captionMode;
                if (OO.isFirefox) {
                  for (var i=0; i < _video.textTracks[0].cues.length; i++) {
                    _video.textTracks[0].cues[i].line = 15;
                  }
                }
              }
            }, 100, captionMode);
          }
        }
      }, this);

      /**
       * Sets the closed captions mode on the video element.
       * @public
       * @method OoyalaVideoWrapper#setClosedCaptionsMode
       * @param {string} mode The mode to set the text tracks element.
       * One of (OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED, OO.CONSTANTS.CLOSED_CAPTIONS.HIDDEN, OO.CONSTANTS.CLOSED_CAPTIONS.SHOWING).
       */
      this.setClosedCaptionsMode = _.bind(function(mode) {
        if (_video.textTracks) {
          for (var i = 0; i < _video.textTracks.length; i++) {
            _video.textTracks[i].mode = mode;
            // [PLAYER-327], [PLAYER-73]
            // Store newly set track mode for future use in workaround
            var trackId = _video.textTracks[i].id || _video.textTracks[i].trackId;
            textTrackModes[trackId] = mode;
          }
        }
        if (mode == OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED) {
          raiseClosedCaptionCueChanged("");
        }
      }, this);

      /**
       * Sets the crossorigin attribute on the video element.
       * @public
       * @method OoyalaVideoWrapper#setCrossorigin
       * @param {string} crossorigin The value to set the crossorigin attribute. Will remove crossorigin attribute if null.
       */
      this.setCrossorigin = function(crossorigin) {
        if (crossorigin) {
          $(_video).attr("crossorigin", crossorigin);
        } else {
          $(_video).removeAttr("crossorigin");
        }
      };

      // **********************************************************************************/
      // Event callback methods
      // **********************************************************************************/

      /**
       * Stores the url of the video when load is started.
       * @private
       * @method OoyalaVideoWrapper#onLoadStart
       */
      var onLoadStart = _.bind(function() {
        stopUnderflowWatcher();
        _currentUrl = _video.src;
        firstPlay = true;
        videoEnded = false;
        isSeeking = false;
      }, this);

      /**
       * When metadata is done loading, trigger any seeks that were queued up.
       * @private
       * @method OoyalaVideoWrapper#onLoadedMetadata
       */
      var onLoadedMetadata = _.bind(function() {
        // [PLAYER-327], [PLAYER-73]
        // We need to monitor track change in Safari in order to prevent
        // it from overriding our settings
        if (OO.isSafari && _video && _video.textTracks) {
          _video.textTracks.onchange = onTextTracksChange;
        }
        dequeueSeek();
        loaded = true;
      }, this);

      /**
       * Fired when there is a change on a text track.
       * @private
       * @method OoyalaVideoWrapper#onTextTracksChange
       * @param {object} event The event from the track change
       */
      var onTextTracksChange = _.bind(function(event) {
        for (var i = 0; i < _video.textTracks.length; i++) {
          var trackId = _video.textTracks[i].id || _video.textTracks[i].trackId;

          if (typeof textTrackModes[trackId] === 'undefined') {
            continue;
          }
          // [PLAYER-327], [PLAYER-73]
          // Safari (desktop and iOS) sometimes randomly switches a track's mode. As a
          // workaround, we force our own value if we detect that we have switched
          // to a mode that we didn't set ourselves
          if (_video.textTracks[i].mode !== textTrackModes[trackId]) {
            OO.log("main_html5: Forcing text track mode for track " + trackId + ". Expected: '"
              + textTrackModes[trackId] + "', received: '" + _video.textTracks[i].mode + "'");

            _video.textTracks[i].mode = textTrackModes[trackId];
          }
        }
      }, this);

      /**
       * Callback for when a closed caption track cue has changed.
       * @private
       * @method OoyalaVideoWrapper#onClosedCaptionCueChange
       * @param {object} event The event from the cue change
       */
      var onClosedCaptionCueChange = _.bind(function(event) {
        var cueText = "";
        if (event && event.currentTarget && event.currentTarget.activeCues) {
          for (var i = 0; i < event.currentTarget.activeCues.length; i++) {
            if (event.currentTarget.activeCues[i].text) {
              cueText += event.currentTarget.activeCues[i].text + "\n";
            }
          }
        }
        raiseClosedCaptionCueChanged(cueText);
      }, this);

      /**
       * Workaround for Firefox only.
       * Check for active closed caption cues and relay them to the controller.
       * @private
       * @method OoyalaVideoWrapper#checkForClosedCaptionsCueChange
       */
      var checkForClosedCaptionsCueChange = _.bind(function() {
        var cueText = "";
        if (_video.textTracks) {
          for (var i = 0; i < _video.textTracks.length; i++) {
            if (_video.textTracks[i].activeCues) {
              for (var j = 0; j < _video.textTracks[i].activeCues.length; j++) {
                if (_video.textTracks[i].activeCues[j].text) {
                  cueText += _video.textTracks[i].activeCues[j].text + "\n";
                }
              }
              break;
            }
          }
        }
        raiseClosedCaptionCueChanged(cueText);
      }, this);

      /**
       * Check for in-stream and in manifest closed captions.
       * @private
       * @method OoyalaVideoWrapper#checkForClosedCaptions
       */
      var checkForClosedCaptions = _.bind(function() {
        if (_video.textTracks && _video.textTracks.length > 0) {
          var languages = [];
          for (var i = 0; i < _video.textTracks.length; i++) {
            if (((OO.isSafari || OO.isEdge) && isLive) || _video.textTracks[i].kind === "captions") {
              var captionInfo = {
                language: "CC",
                inStream: true,
                label: "In-Stream"
              };
              //Don't overwrite other closed captions of this language. They have priority.
              if (availableClosedCaptions[captionInfo.language] == null) {
                addClosedCaptions(captionInfo);
              }
            }
          }
        }
      }, this);

      /**
       * Add new closed captions and relay them to the controller.
       * @private
       * @method OoyalaVideoWrapper#addClosedCaptions
       */
      var addClosedCaptions = _.bind(function(captionInfo) {
        //Don't add captions if argument is null or we already have added these captions.
        if (captionInfo == null || captionInfo.language == null || (availableClosedCaptions[captionInfo.language] &&
          availableClosedCaptions[captionInfo.language].src == captionInfo.src)) return;
        availableClosedCaptions[captionInfo.language] = captionInfo;
        raiseCaptionsFoundOnPlaying();
      }, this);

      /**
       * Notify the controller with new available closed captions.
       * @private
       * @method OoyalaVideoWrapper#raiseCaptionsFoundOnPlaying
       */
      var raiseCaptionsFoundOnPlaying = _.bind(function() {
        var closedCaptionInfo = {
          languages: [],
          locale: {}
        }
        _.each(availableClosedCaptions, function(value, key) {
          closedCaptionInfo.languages.push(key);
          closedCaptionInfo.locale[key] = value.label;
        });
        this.controller.notify(this.controller.EVENTS.CAPTIONS_FOUND_ON_PLAYING, closedCaptionInfo);
      }, this);

      /**
       * Notify the controller with new closed caption cue text.
       * @private
       * @method OoyalaVideoWrapper#raiseClosedCaptionCueChanged
       * @param {string} cueText The text of the new closed caption cue. Empty string signifies no active cue.
       */
      var raiseClosedCaptionCueChanged = _.bind(function(cueText) {
        cueText = cueText.trim();
        if (cueText != lastCueText) {
          lastCueText = cueText;
          this.controller.notify(this.controller.EVENTS.CLOSED_CAPTION_CUE_CHANGED, cueText);
        }
      }, this);

      /**
       * Notifies the controller that a progress event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseProgress
       * @param {object} event The event from the video
       */
      var raiseProgress = _.bind(function(event) {
        var buffer = 0;
        if (event.target.buffered && event.target.buffered.length > 0) {
          buffer = event.target.buffered.end(0); // in sec;
        }
        this.controller.notify(this.controller.EVENTS.PROGRESS,
          { "currentTime": event.target.currentTime,
            "duration": resolveDuration(event.target.duration),
            "buffer": buffer,
            "seekRange": getSafeSeekRange(event.target.seekable)
          });
      }, this);

      /**
       * Notifies the controller that an error event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseErrorEvent
       * @param {object} event The event from the video
       */
      var raiseErrorEvent = _.bind(function(event) {
        stopUnderflowWatcher();

        var code = event.target.error ? event.target.error.code : -1;
        // Suppress error code 4 when raised by a video element with a null or empty src
        if (!(code === 4 && ($(event.target).attr("src") === "null" || $(event.target).attr("src") === ""))) {
          this.controller.notify(this.controller.EVENTS.ERROR, { errorcode: code });
        }
      }, this);

      /**
       * Notifies the controller that a stalled event was raised.  Pauses the video on iPad if the currentTime is 0.
       * @private
       * @method OoyalaVideoWrapper#raiseStalledEvent
       * @param {object} event The event from the video
       */
      var raiseStalledEvent = _.bind(function(event) {
        // Fix multiple video tag error in iPad
        if (OO.isIpad && event.target.currentTime === 0) {
          _video.pause();
        }

        this.controller.notify(this.controller.EVENTS.STALLED, {"url":_video.currentSrc});
      }, this);

      /**
       * HTML5 video browser can start playing the media. Sets canPlay flag to TRUE
       * @private
       * @method OoyalaVideoWrapper#raiseCanPlay
       */
      var raiseCanPlay = _.bind(function() {
        // On firefox and iOS, at the end of an underflow the video raises 'canplay' instead of
        // 'canplaythrough'.  If that happens, raise canPlayThrough.
        if ((OO.isFirefox || OO.isIos) && waitingEventRaised) {
          raiseCanPlayThrough();
        }
        canPlay = true;

        //Notify controller of video width and height.
        if (firstPlay) {
          this.controller.notify(this.controller.EVENTS.ASSET_DIMENSION, {width: _video.videoWidth, height: _video.videoHeight});
        }
      }, this);

      /**
       * Notifies the controller that a buffered event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseCanPlayThrough
       */
      var raiseCanPlayThrough = _.bind(function() {
        waitingEventRaised = false;
        this.controller.notify(this.controller.EVENTS.BUFFERED, {"url":_video.currentSrc});
      }, this);

      /**
       * Notifies the controller that a playing event was raised.
       * @private
       * @method OoyalaVideoWrapper#raisePlayingEvent
       */
      var raisePlayingEvent = _.bind(function() {
        // Do not raise playback events if the video is priming
        if (isPriming) {
          return;
        }

        this.controller.notify(this.controller.EVENTS.PLAYING);
        startUnderflowWatcher();
        checkForClosedCaptions();

        firstPlay = false;
        canSeek = true;
        isSeeking = false;
        setVideoCentering();
      }, this);

      /**
       * Notifies the controller that a waiting event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseWaitingEvent
       */
      var raiseWaitingEvent = _.bind(function() {
        // WAITING event is not raised if no video is assigned yet
        if (_.isEmpty(_video.currentSrc)) {
          return;
        }
        waitingEventRaised = true;
        this.controller.notify(this.controller.EVENTS.WAITING, {"url":_video.currentSrc});
      }, this);

      /**
       * Notifies the controller that a seeking event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseSeekingEvent
       */
      var raiseSeekingEvent = _.bind(function() {
        isSeeking = true;

        // Do not raise playback events if the video is priming
        // If the stream is seekable, supress seeks that come before or at the time initialTime is been reached
        // or that come while seeking.
        if (!isPriming && initialTime.reached) {
          this.controller.notify(this.controller.EVENTS.SEEKING);
        }
      }, this);

      /**
       * Notifies the controller that a seeked event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseSeekedEvent
       */
      var raiseSeekedEvent = _.bind(function(event) { // Firefox known issue: lack of global event.
        isSeeking = false;

        // After done seeking, see if any play events were received and execute them now
        // This fixes an issue on iPad where playing while seeking causes issues with end of stream eventing.
        dequeuePlay();

        // PBI-718 - If seeking is disabled and a native seek was received, seek back to the previous position.
        // This is required for platforms with native controls that cannot be disabled, such as iOS
        if (this.disableNativeSeek) {
          var fixedSeekedTime = Math.floor(_video.currentTime);
          var fixedCurrentTime = Math.floor(currentTime);
          if (fixedSeekedTime !== fixedCurrentTime) {
            _video.currentTime = currentTime;
          }
        }

        // If the stream is seekable, supress seeks that come before or at the time initialTime is been reached
        // or that come while seeking.
        if (!initialTime.reached) {
          initialTime.reached = true;
        } else {
          this.controller.notify(this.controller.EVENTS.SEEKED);
          raisePlayhead(this.controller.EVENTS.TIME_UPDATE, event); // Firefox and Safari seek from paused state.
        }
      }, this);

      /**
       * Notifies the controller that a ended event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseEndedEvent
       */
      var raiseEndedEvent = _.bind(function(event) {
        stopUnderflowWatcher();
        if (!_video.ended && OO.isSafari) {
          // iOS raises ended events sometimes when a new stream is played in the same video element
          // Prevent this faulty event from making it to the player message bus
          return;
        }
        if (videoEnded) { return; } // no double firing ended event.
        videoEnded = true;
        initialTime.value = 0;

        this.controller.notify(this.controller.EVENTS.ENDED);
      }, this);

      /**
       * Notifies the controller that the duration has changed.
       * @private
       * @method OoyalaVideoWrapper#raiseDurationChange
       * @param {object} event The event from the video
       */
      var raiseDurationChange = _.bind(function(event) {
        raisePlayhead(this.controller.EVENTS.DURATION_CHANGE, event);
      }, this);

      /**
       * Notifies the controller that the time position has changed.  Handles seeks if seeks were enqueued and
       * the stream has become seekable.  Triggers end of stream for m3u8 if the stream won't raise it itself.
       * @private
       * @method OoyalaVideoWrapper#raiseTimeUpdate
       * @param {object} event The event from the video
       */
      var raiseTimeUpdate = _.bind(function(event) {
        if (!isSeeking) {
          currentTime = _video.currentTime;
        }

        if (initialTime.value > 0 && (event.target.currentTime >= initialTime.value)) {
          initialTime.value = 0;
        }

        raisePlayhead(this.controller.EVENTS.TIME_UPDATE, event);

        // iOS has issues seeking so if we queue a seek handle it here
        dequeueSeek();

        // iPad safari has video centering issue. Unfortunately, HTML5 does not have bitrate change event.
        setVideoCentering();

        //Workaround for Firefox because it doesn't support the oncuechange event on a text track
        if (OO.isFirefox) {
          checkForClosedCaptionsCueChange();
        }

        forceEndOnTimeupdateIfRequired(event);
      }, this);

      /**
       * Notifies the controller that the play event was raised.
       * @private
       * @method OoyalaVideoWrapper#raisePlayEvent
       * @param {object} event The event from the video
       */
      var raisePlayEvent = _.bind(function(event) {
        // Do not raise playback events if the video is priming
        if (isPriming) {
          return;
        }

        this.controller.notify(this.controller.EVENTS.PLAY, { url: event.target.src });
      }, this);

      /**
       * Notifies the controller that the pause event was raised.
       * @private
       * @method OoyalaVideoWrapper#raisePauseEvent
       */
      var raisePauseEvent = _.bind(function() {
        // Do not raise playback events if the video is priming
        if (isPriming) {
          return;
        }
        if (!(OO.isIpad && _video.currentTime === 0)) {
          this.controller.notify(this.controller.EVENTS.PAUSED);
        }
        forceEndOnPausedIfRequired();
      }, this);

      /**
       * Notifies the controller that the ratechange event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseRatechangeEvent
       */
      var raiseRatechangeEvent = _.bind(function() {
        this.controller.notify(this.controller.EVENTS.RATE_CHANGE);
      }, this);

      /**
       * Notifies the controller that the volume event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseVolumeEvent
       * @param {object} event The event raised by the video.
       */
      var raiseVolumeEvent = _.bind(function(event) {
        var volume = event.target.volume;
        if (event.target.muted) {
          volume = 0;
        }
        this.controller.notify(this.controller.EVENTS.VOLUME_CHANGE, { volume: volume });
      }, this);

      /**
       * Notifies the controller that the fullscreenBegin event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseFullScreenBegin
       * @param {object} event The event raised by the video.
       */
      var raiseFullScreenBegin = _.bind(function(event) {
        this.controller.notify(this.controller.EVENTS.FULLSCREEN_CHANGED,
          { isFullScreen: true, paused: event.target.paused });
      }, this);

      /**
       * Notifies the controller that the fullscreenEnd event was raised.
       * @private
       * @method OoyalaVideoWrapper#raiseFullScreenEnd
       * @param {object} event The event raised by the video.
       */
      var raiseFullScreenEnd = _.bind(function(event) {
        this.controller.notify(this.controller.EVENTS.FULLSCREEN_CHANGED,
          { "isFullScreen": false, "paused": event.target.paused });
      }, this);


			/************************************************************************************/
      // Helper methods
			/************************************************************************************/

      /**
       * Fix issue with iPad safari browser not properly centering the video
       * @private
       * @method OoyalaVideoWrapper#setVideoCentering
       */
      var setVideoCentering = function() {
        if (OO.isIpad) {
          var videoWidth = _video.videoWidth;
          var videoHeight = _video.videoHeight;
          var playerWidth = playerDimension.width;
          var playerHeight = playerDimension.height;

          // check if video stream dimension was changed, then re-apply video css
          if (videoWidth != videoDimension.width || videoHeight != videoDimension.height) {
            var css = IPAD_CSS_DEFAULT;
            if (videoHeight/videoWidth > playerHeight/playerWidth) {
              css.width = "";
              css.height = "100%";
            } else {
              css.width = "100%";
              css.height = "";
            }
            $(_video).css(css);

            videoDimension.width = videoWidth;
            videoDimension.height = videoHeight;
          }
        }
      };

      /**
       * If any plays are queued up, execute them.
       * @private
       * @method OoyalaVideoWrapper#dequeuePlay
       */
      var dequeuePlay = _.bind(function() {
        if (playQueued) {
          playQueued = false;
          executePlay(false);
        }
      }, this);

      /**
       * Loads (if required) and plays the current stream.
       * @private
       * @method OoyalaVideoWrapper#executePlay
       * @param {boolean} priming True if the element is preparing for device playback
       */
      var executePlay = _.bind(function(priming) {
        isPriming = priming;

        // TODO: Check if no src url is configured?
        if (!loaded) {
          this.load(true);
        }

        _video.play();

        if (!isPriming) {
          hasPlayed = true;
          videoEnded = false;
        }
      }, this);


      /**
       * Gets the range of video that can be safely seeked to.
       * @private
       * @method OoyalaVideoWrapper#getSafeSeekRange
       * @param {object} seekRange The seek range object from the video element.  It contains a length, a start
       *                           function, and an end function.
       * @returns {object} The safe seek range object containing { "start": number, "end": number}
       */
      var getSafeSeekRange = function(seekRange) {
        if (!seekRange || !seekRange.length || !(typeof seekRange.start == "function") ||
          !(typeof seekRange.end == "function" )) {
          return { "start" : 0, "end" : 0 };
        }

        return { "start" : seekRange.length > 0 ? seekRange.start(0) : 0,
          "end" : seekRange.length > 0 ? seekRange.end(0) : 0 };
      };

      /**
       * Gets the seekable object in a way that is safe for all browsers.  This fixes an issue where Safari
       * HLS videos become unseekable if 'seekable' is queried before the stream has raised 'canPlay'.
       * @private
       * @method OoyalaVideoWrapper#getSafeSeekableObject
       * @returns {object?} Either the video seekable object or null
       */
      var getSafeSeekableObject = function() {
        if (OO.isSafari && !canPlay) {
          // Safety against accessing seekable before SAFARI browser canPlay media
          return null;
        } else {
          return _video.seekable;
        }
      };

      /**
       * Converts the desired seek time to a safe seek time based on the duration and platform.  If seeking
       * within OO.CONSTANTS.SEEK_TO_END_LIMIT of the end of the stream, seeks to the end of the stream.
       * @private
       * @method OoyalaVideoWrapper#convertToSafeSeekTime
       * @param {number} time The desired seek-to position
       * @param {number} duration The video's duration
       * @returns {number} The safe seek-to position
       */
      var convertToSafeSeekTime = function(time, duration) {
        // If seeking within some threshold of the end of the stream, seek to end of stream directly
        if (duration - time < OO.CONSTANTS.SEEK_TO_END_LIMIT) {
          time = duration;
        }

        var safeTime = time >= duration ? duration - 0.01 : (time < 0 ? 0 : time);

        // iPad with 6.1 has an interesting bug that causes the video to break if seeking exactly to zero
        if (OO.isIpad && safeTime < 0.1) {
          safeTime = 0.1;
        }
        return safeTime;
      };

      /**
       * Returns the safe seek time if seeking is possible.  Null if seeking is not possible.
       * @private
       * @method OoyalaVideoWrapper#getSafeSeekTimeIfPossible
       * @param {object} _video The video element
       * @param {number} time The desired seek-to position
       * @returns {?number} The seek-to position, or null if seeking is not possible
       */
      var getSafeSeekTimeIfPossible = function(_video, time) {
        if ((typeof time !== "number") || !canSeek) {
          return null;
        }

        var range = getSafeSeekRange(getSafeSeekableObject());
        if (range.start === 0 && range.end === 0) {
          return null;
        }

        var safeTime = convertToSafeSeekTime(time, _video.duration);
        if (range.start <= safeTime && range.end >= safeTime) {
          return safeTime;
        }

        return null;
      };

      /**
       * Adds the desired seek time to a queue so as to be used later.
       * @private
       * @method OoyalaVideoWrapper#queueSeek
       * @param {number} time The desired seek-to position
       */
      var queueSeek = function(time) {
        queuedSeekTime = time;
      };

      /**
       * If a seek was previously queued, triggers a seek to the queued seek time.
       * @private
       * @method OoyalaVideoWrapper#dequeueSeek
       */
      var dequeueSeek = _.bind(function() {
        if (queuedSeekTime === null) { return; }
        if (this.seek(queuedSeekTime)) { queuedSeekTime = null; }
      }, this);

      /**
       * Notifies the controller of events that provide playhead information.
       * @private
       * @method OoyalaVideoWrapper#raisePlayhead
       */
      var raisePlayhead = _.bind(function(eventname, event) {
        // Do not raise playback events if the video is priming
        if (isPriming) {
          return;
        }

        // If the stream is seekable, supress playheads that come before the initialTime has been reached
        // or that come while seeking.
        // TODO: Check _video.seeking?
        if (isSeeking || initialTime.value > 0) {
          return;
        }

        var buffer = 0;
        if (event.target.buffered && event.target.buffered.length > 0) {
          buffer = event.target.buffered.end(0); // in sec;
        }

        // durationchange event raises the currentTime as a string
        var resolvedTime = (event && event.target) ? event.target.currentTime : null;
        if (resolvedTime && (typeof resolvedTime !== "number")) {
          resolvedTime = Number(resolvedTime);
        }

        var seekable = getSafeSeekRange(getSafeSeekableObject());
        this.controller.notify(eventname,
          { "currentTime": resolvedTime,
            "duration": resolveDuration(event.target.duration),
            "buffer": buffer,
            "seekRange": seekable });
      }, this);

      /**
       * Resolves the duration of the video to a valid value.
       * @private
       * @method OoyalaVideoWrapper#resolveDuration
       * @param {number} duration The reported duration of the video in seconds
       * @returns {number} The resolved duration of the video in seconds
       */
      var resolveDuration = function(duration) {
        if (duration === Infinity || isNaN(duration)) {
          return 0;
        }
        return duration;
      };

      /**
       * Safari desktop sometimes doesn't raise the ended event until the next time the video is played.
       * Force the event to come through by calling play if _video.ended to prevent it for coming up on the
       * next stream.
       * @private
       * @method OoyalaVideoWrapper#forceEndOnPausedIfRequired
       */
      var forceEndOnPausedIfRequired = _.bind(function() {
        if (OO.isSafari && !OO.isIos) {
          if (_video.ended) {
            console.log("VTC_OO: Force through the end of stream for Safari", _video.currentSrc,
              _video.duration, _video.currentTime);
            raiseEndedEvent();
          }
        }
      }, this);

      /**
       * Currently, iOS has a bug that if the m3u8 EXTINF indicates a different duration, the ended event never
       * gets dispatched.  Manually trigger an ended event on all m3u8 streams where duration is a non-whole
       * number.
       * @private
       * @method OoyalaVideoWrapper#forceEndOnTimeupdateIfRequired
       */
      var forceEndOnTimeupdateIfRequired = _.bind(function(event) {
        if (isM3u8) {
          var durationResolved = resolveDuration(event.target.duration);
          var durationInt = Math.floor(durationResolved);
          if ((_video.currentTime == durationResolved) && (durationResolved > durationInt)) {
            console.log("VTC_OO: manually triggering end of stream for m3u8", _currentUrl, durationResolved,
              _video.currentTime);
            _.defer(raiseEndedEvent);
          }
          else if (OO.isSafari && !OO.isIos && isSeeking === true && !_video.ended && Math.round(_video.currentTime) === Math.round(_video.duration))
          {
            this.controller.notify(this.controller.EVENTS.SEEKED);
            videoEnded = true;
            initialTime.value = 0;
            this.controller.notify(this.controller.EVENTS.ENDED);
          }
        }
      }, this);

      /**
       * Chrome does not raise a waiting event when the buffer experiences an underflow and the stream stops
       * playing.  To compensate, start a watcher that periodically checks the currentTime.  If the stream is
       * not advancing but is not paused, raise the waiting event once.
       * If the watcher has already been started, do nothing.
       * @private
       * @method OoyalaVideoWrapper#startUnderflowWatcher
       */
      var startUnderflowWatcher = _.bind(function() {
        if ((OO.isChrome || OO.isIos || OO.isIE11Plus || OO.isEdge) && !underflowWatcherTimer) {
          var watchInterval = 300;
          underflowWatcherTimer = setInterval(underflowWatcher, watchInterval)
        }
      }, this);

      /**
       * Periodically checks the currentTime.  If the stream is not advancing but is not paused, raise the
       * waiting event once.
       * @private
       * @method OoyalaVideoWrapper#underflowWatcher
       */
      var underflowWatcher = _.bind(function() {
        if (!hasPlayed) {
          return;
        }

        if (_video.ended) {
          return stopUnderflowWatcher();
        }

        if (!_video.paused && _video.currentTime == watcherTime) {
          if (!waitingEventRaised) {
            raiseWaitingEvent();
          }
        } else { // should be able to do this even when paused
          watcherTime = _video.currentTime;
          if (waitingEventRaised) {
            raiseCanPlayThrough();
          }
        }
      }, this);

      /**
       * Stops the interval the watches for underflow.
       * @private
       * @method OoyalaVideoWrapper#stopUnderflowWatcher
       */
      var stopUnderflowWatcher = _.bind(function() {
        clearInterval(underflowWatcherTimer);
        underflowWatcherTimer = null;
        waitingEventRaised = false;
        watcherTime = -1;
      }, this);
    };

    /**
     * Generates a random string.
     * @private
     * @method getRandomString
     * @returns {string} A random string
     */
    var getRandomString = function() {
      return Math.random().toString(36).substring(7);
    };

    OO.Video.plugin(new OoyalaVideoFactory());
  }(OO._, OO.$));

},{"../../../html5-common/js/utils/InitModules/InitOO.js":1,"../../../html5-common/js/utils/InitModules/InitOOHazmat.js":2,"../../../html5-common/js/utils/InitModules/InitOOUnderscore.js":3,"../../../html5-common/js/utils/constants.js":4,"../../../html5-common/js/utils/environment.js":5,"../../../html5-common/js/utils/utils.js":6}]},{},[9]);