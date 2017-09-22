(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
  if (!OO)
  {
    OO = {};
  }

},{}],2:[function(require,module,exports){
  require("./InitOO.js");

  if (!window._)
  {
    window._ = require('underscore');
  }

  if (!OO._)
  {
    OO._ = window._.noConflict();
  }

},{"./InitOO.js":1,"underscore":5}],3:[function(require,module,exports){
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

},{}],4:[function(require,module,exports){
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

},{}],5:[function(require,module,exports){
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

},{}],6:[function(require,module,exports){
  /*
   * Google IMA Ad Manager
   * owner: PBI
   * originally authored: June 2015
   */

//TODO make amc ignore ad request timeout.
  require("../html5-common/js/utils/InitModules/InitOOUnderscore.js");
  require("../html5-common/js/utils/constants.js");
  require("../html5-common/js/utils/utils.js");



  (function(_, $)
  {
    var registeredGoogleIMAManagers = {};

    OO.Ads.manager(function(_, $)
    {
      /**
       * @class GoogleIMA
       * @classDesc The GoogleIMA Ads Manager class is registered as an ads manager with the Ad Manager Controller.
       * This class communicates between the player's ad manager controller and the GoogleIMA sdk.  This implementation handles both
       * AdRules ads and Non AdRules ads.
       * @property {string} PLUGIN_VERSION This is a variable version number of the player sent to Google for tracking
       *             **This must be updated with big updates to a different number**
       * @property {string} PLAYER_TYPE This is a variable that specifies the name of the player that is relayed to
       *             Google for tracking
       * @property {object} sharedVideoElement The video element to use on iOS where only one video element is allowed
       */
      var GoogleIMA = function()
      {
        this.name = "google-ima-ads-manager";
        this.ready = false;
        this.runningUnitTests = false;
        this.sharedVideoElement = null;

        //private member variables of this GoogleIMA object
        var _amc = null;
        var _adModuleJsReady = false;
        var _playheadTracker;
        var _usingAdRules;
        var _IMAAdsLoader;
        var _IMAAdsManager;
        var _IMAAdsManagerInitialized;
        var _IMAAdDisplayContainer;
        var _linearAdIsPlaying;
        var _timeUpdater = null;
        var _uiContainer = null;
        var _uiContainerPrevStyle = null;

        //Constants
        var DEFAULT_IMA_IFRAME_Z_INDEX = 10004;
        var DEFAULT_ADS_REQUEST_TIME_OUT = 15000;
        var AD_RULES_POSITION_TYPE = 'r';
        var NON_AD_RULES_POSITION_TYPE = 't';
        var NON_AD_RULES_PERCENT_POSITION_TYPE = 'p';
        var PLAYER_TYPE = "Ooyala";
        var PLUGIN_VERSION = "1.0";

        var VISIBLE_CSS = {left: OO.CSS.VISIBLE_POSITION, visibility: "visible"};
        var INVISIBLE_CSS = {left: OO.CSS.INVISIBLE_POSITION, visibility: "hidden"};

        var OVERLAY_WIDTH_PADDING = 50;
        var OVERLAY_HEIGHT_PADDING = 50;

        var TIME_UPDATER_INTERVAL = 500;

        /**
         * Helper function to make functions private to GoogleIMA variable for consistency
         * and ease of reading.
         */
        var privateMember = _.bind(function(functionVar)
        {
          if (!_.isFunction(functionVar))
          {
            _throwError("Error: Trying to make private function but " + functionVar + " is not a function.");
            return;
          }
          return _.bind(functionVar, this);
        }, this);

        /**
         * Initializes the class by registering the ad manager controller.
         * Adds listeners for Ad Manager Controller events.
         * @public
         * @method GoogleIMA#initialize
         * @param {object} amcIn A reference to the ad manager controller instance
         * @param {string} playerId The unique player identifier of the player initializing the class
         */
        this.initialize = function(amcIn, playerId)
        {
          registeredGoogleIMAManagers[playerId] = this;

          _amc = amcIn;

          var ext = OO.DEBUG ? '_debug.js' : '.js';
          var remoteModuleJs = "//imasdk.googleapis.com/js/sdkloader/ima3" + ext;
          _resetVars();
          _createAMCListeners();
          if (!this.runningUnitTests)
          {
            _amc.loadAdModule(this.name, remoteModuleJs, _onSdkLoaded);
          }
          else
          {
            _onSdkLoaded(true);
          }
        };

        /**
         * Reset all the variables needed for multiple ad plays.
         * @private
         * @method GoogleIMA#_createAMCListeners
         */
        var _resetVars = privateMember(function()
        {
          this.ready = false;
          this.preloadAdRulesAds = false;
          _usingAdRules = true;

          this.mainContentDuration = 0;
          this.initialPlayRequested = false;
          this.canSetupAdsRequest = true;
          this.adTagUrl = null;
          this.showInAdControlBar = false;
          this.adsReady = false;
          this.additionalAdTagParameters = null;
          this.adsRequested = false;
          this.adsRequestTimeoutRef = null;
          this.disableFlashAds = false;
          this.contentEnded = false;
          this.pauseAdOnClick = null;
          this.isFullscreen = false;
          this.maxAdsRequestTimeout = DEFAULT_ADS_REQUEST_TIME_OUT;
          this.uiRegistered = false;
          this.metadataReady = false;
          this.allAdInfo = null;
          this.currentAMCAdPod = null;
          this.currentIMAAd = null;
          this.currentNonLinearIMAAd = null;
          this.isReplay = false;
          this.requestAdsOnReplay = true;
          _linearAdIsPlaying = false;
          _resetPlayheadTracker();
          this.hasPreroll = false;

          this.adPlaybackStarted = false;
          this.savedVolume = -1;
          this.showAdControls = false;
          this.useGoogleAdUI = false;
          this.useGoogleCountdown = false;
          this.useInsecureVpaidMode = false;
          this.imaIframeZIndex = DEFAULT_IMA_IFRAME_Z_INDEX;
          // WIKIA CHANGE - START
          this.onAdRequestSuccess = function () {};
          this.onBeforeAdsManagerStart = function () {};
          // WIKIA CHANGE - END

          //flag to track whether ad rules failed to load
          this.adRulesLoadError = false;

          //google sdk variables
          _IMAAdsLoader = null;
          _IMAAdsManager = null;
          _IMAAdsManagerInitialized = false;
          _IMAAdDisplayContainer = null;
        });

        /**
         * Add listeners to the Ad Manager Controller about playback.
         * @private
         * @method GoogleIMA#_createAMCListeners
         */
        var _createAMCListeners = privateMember(function()
        {
          _amc.addPlayerListener(_amc.EVENTS.INITIAL_PLAY_REQUESTED, _onInitialPlayRequested);
          _amc.addPlayerListener(_amc.EVENTS.CONTENT_COMPLETED, _onContentCompleted);
          _amc.addPlayerListener(_amc.EVENTS.PLAYHEAD_TIME_CHANGED, _onPlayheadTimeChanged);
          _amc.addPlayerListener(_amc.EVENTS.SIZE_CHANGED, _onSizeChanged);
          _amc.addPlayerListener(_amc.EVENTS.CONTENT_CHANGED, _onContentChanged);
          _amc.addPlayerListener(_amc.EVENTS.REPLAY_REQUESTED, _onReplayRequested);
          _amc.addPlayerListener(_amc.EVENTS.FULLSCREEN_CHANGED, _onFullscreenChanged);
        });

        /**
         * Remove listeners from the Ad Manager Controller about playback.
         * @private
         * @method GoogleIMA@_removeAMCListeners
         */
        var _removeAMCListeners = privateMember(function()
        {
          if (_amc)
          {
            _amc.removePlayerListener(_amc.EVENTS.INITIAL_PLAY_REQUESTED, _onInitialPlayRequested);
            _amc.removePlayerListener(_amc.EVENTS.CONTENT_COMPLETED, _onContentCompleted);
            _amc.removePlayerListener(_amc.EVENTS.PLAYHEAD_TIME_CHANGED, _onPlayheadTimeChanged);
            _amc.removePlayerListener(_amc.EVENTS.SIZE_CHANGED, _onSizeChanged);
            _amc.removePlayerListener(_amc.EVENTS.CONTENT_CHANGED, _onContentChanged);
            _amc.removePlayerListener(_amc.EVENTS.REPLAY_REQUESTED, _onReplayRequested);
            _amc.removePlayerListener(_amc.EVENTS.FULL_SCREEN_CHANGED, _onFullscreenChanged);
          }
        });

        /**
         * This is called by the ad manager controller when the metadata has been loaded.
         * Ingests metadata, determines if it should use AdRules logic or Non AdRules logic.
         * If preloading ad rules ads is enabled, then it preloads the ads as well.
         * @public
         * @method GoogleIMA#loadMetadata
         * @param {object} metadata Ad manager metadata from Backlot and from the page level
         * @param {object} baseMetadata Base level metadata from Backlot
         * @param {object} movieMetadata Metadata pertaining specifically to the movie being played
         */
        this.loadMetadata = function(metadata, baseMetadata, movieMetadata)
        {
          this.mainContentDuration = movieMetadata.duration/1000;
          this.allAdInfo = metadata.all_ads;

          //Check if any ad is ad rules type.  if one is then we change to only using ad rules.
          var usesAdRulesCheck =
            function(ad)
            {
              return ad.position_type == AD_RULES_POSITION_TYPE;
            };
          var adRulesAd = _.find(metadata.all_ads, usesAdRulesCheck);
          _usingAdRules = !!adRulesAd;

          //only fill in the adTagUrl if it's ad rules. Otherwise wait till AMC gives the correct one.
          this.adTagUrl = null;
          if (_usingAdRules)
          {
            this.adTagUrl = adRulesAd.tag_url;
          }

          //the preload feature works, but has been disabled due to product, so setting to false here
          this.preloadAdRulesAds = false;

          //check if ads should play on replays
          this.requestAdsOnReplay = true;
          if (_amc.adManagerSettings.hasOwnProperty(_amc.AD_SETTINGS.REPLAY_ADS))
          {
            this.requestAdsOnReplay = _amc.adManagerSettings[_amc.AD_SETTINGS.REPLAY_ADS];
          }

          //check for override on ad timeout
          this.maxAdsRequestTimeout = DEFAULT_ADS_REQUEST_TIME_OUT;
          //IMA does not like timeouts of 0, it still attempts to play the ad even though
          //we have timed out
          //This may be a fault of the plugin or SDK. More investigation is required
          if (_.isFinite(_amc.adManagerSettings[_amc.AD_SETTINGS.AD_LOAD_TIMEOUT])
            && _amc.adManagerSettings[_amc.AD_SETTINGS.AD_LOAD_TIMEOUT] > 0)
          {
            this.maxAdsRequestTimeout = _amc.adManagerSettings[_amc.AD_SETTINGS.AD_LOAD_TIMEOUT];
          }

          this.additionalAdTagParameters = null;
          if (metadata.hasOwnProperty("additionalAdTagParameters"))
          {
            this.additionalAdTagParameters = metadata.additionalAdTagParameters;
          }

          this.showAdControls = false;
          if (metadata.hasOwnProperty("showAdControls"))
          {
            this.showAdControls = metadata.showAdControls;
          }

          this.useGoogleAdUI = false;
          if (metadata.hasOwnProperty("useGoogleAdUI"))
          {
            this.useGoogleAdUI = metadata.useGoogleAdUI;
          }

          this.useGoogleCountdown = false;
          if (metadata.hasOwnProperty("useGoogleCountdown"))
          {
            this.useGoogleCountdown = metadata.useGoogleCountdown;
          }

          this.useInsecureVpaidMode = false;
          if (metadata.hasOwnProperty("vpaidMode"))
          {
            this.useInsecureVpaidMode = metadata.vpaidMode === "insecure";
          }

          this.disableFlashAds = false;
          if (metadata.hasOwnProperty("disableFlashAds"))
          {
            this.disableFlashAds = metadata.disableFlashAds;
          }

          this.imaIframeZIndex = DEFAULT_IMA_IFRAME_Z_INDEX;
          if (metadata.hasOwnProperty("iframeZIndex"))
          {
            this.imaIframeZIndex = metadata.iframeZIndex;
          }

          // WIKIA CHANGE - START
          this.onAdRequestSuccess = function () {};
          if (metadata.hasOwnProperty("onAdRequestSuccess"))
          {
            this.onAdRequestSuccess = metadata.onAdRequestSuccess;
          }

          this.onBeforeAdsManagerStart = function () {};
          if (metadata.hasOwnProperty("onBeforeAdsManagerStart"))
          {
            this.onBeforeAdsManagerStart = metadata.onBeforeAdsManagerStart;
          }
          // WIKIA CHANGE - END

          //On second video playthroughs, we will not be initializing the ad manager again.
          //Attempt to create the ad display container here instead of after the sdk has loaded
          if (!_IMAAdDisplayContainer)
          {
            _IMA_SDK_tryInitAdContainer();
          }

          this.metadataReady = true;

          _trySetAdManagerToReady();

          //double check that we have ads to play, and that after building the timeline there are ads (it filters out
          //ill formed ads).
          var validAdTags = _getValidAdTagUrls();
          if (validAdTags && validAdTags.length > 0)
          {
            if (_usingAdRules)
            {
              if (this.preloadAdRulesAds)
              {
                this.canSetupAdsRequest = true;
                _trySetupAdsRequest();
              }
              else
              {
                this.canSetupAdsRequest = false;
              }
            }
          }
        };

        /**
         * Called when the UI has been set up.  Sets up the native element listeners and style for the overlay.
         * Checks if the module is ready to send the request for ads.
         * @public
         * @method GoogleIMA#registerUi
         */
        this.registerUi = function()
        {
          this.uiRegistered = true;
          if (_amc.ui.useSingleVideoElement && !this.sharedVideoElement && _amc.ui.ooyalaVideoElement[0] &&
            (_amc.ui.ooyalaVideoElement[0].className === "video")) {
            this.setupSharedVideoElement(_amc.ui.ooyalaVideoElement[0]);
          }

          _IMA_SDK_tryInitAdContainer();
          _trySetupAdsRequest();
        };

        /**
         * Sets up the shared video element.
         * @public
         * @method GoogleIMA#setupSharedVideoElement
         * @param element Element to be setup as the shared video element
         */
        this.setupSharedVideoElement = function(element)
        {
          //Remove any listeners we added on the previous shared video element
          if (this.sharedVideoElement && OO.isIphone && typeof this.sharedVideoElement.removeEventListener === "function")
          {
            this.sharedVideoElement.removeEventListener('webkitendfullscreen', _raiseFullScreenEndEvent);
          }
          this.sharedVideoElement = element;
          //On iPhone, there is a limitation in the IMA SDK where we do not receive a pause event when
          //we leave the native player
          //This is a workaround to listen for the webkitendfullscreen event ourselves
          if(this.sharedVideoElement && OO.isIphone && typeof this.sharedVideoElement.addEventListener === "function"){
            this.sharedVideoElement.addEventListener('webkitendfullscreen', _raiseFullScreenEndEvent);
          }
        };

        /**
         * Called by the ad manager controller.  Creates OO.AdManagerController#Ad objects, places them in an array,
         * and returns them to the ad manager controller.  If AdRules is used, then the list will be empty. In that
         * case the SDK will handle the timing of ads playing.
         * @public
         * @method GoogleIMA#buildTimeline
         * @returns {OO.AdManagerController#Ad[]} timeline A list of the ads to play for the current video
         */
        this.buildTimeline = function()
        {
          var adsTimeline = [];
          //for the moment we don't support mixing adrules and non-adrules.
          if (!_usingAdRules)
          {
            var validAdTags = _getValidAdTagUrls();
            if(validAdTags)
            {
              for (var i = 0; i < validAdTags.length; i++)
              {
                var ad = validAdTags[i];
                //double check it's not an ad rules ad before trying to add it to the timeline
                if (ad.position_type != AD_RULES_POSITION_TYPE)
                {
                  var streams = {};
                  streams[OO.VIDEO.ENCODING.IMA] = "";
                  var adData = {
                    "position": ad.position / 1000,
                    "adManager": this.name,
                    "ad": ad,
                    "streams": streams,
                    "adType": _amc.ADTYPE.UNKNOWN_AD_REQUEST
                  };

                  //percentage position types require a different calculation.
                  if (ad.position_type == NON_AD_RULES_PERCENT_POSITION_TYPE)
                  {
                    adData.position = ad.position/100 * this.mainContentDuration;
                  }

                  var adToInsert = new _amc.Ad(adData);
                  adsTimeline.push(adToInsert);
                }
              }
            }
          }
          else
          {
            //return a placeholder preroll while we wait for IMA
            var streams = {};
            streams[OO.VIDEO.ENCODING.IMA] = "";
            var placeholder = [ new _amc.Ad({
              position: 0,
              duration: 0,
              adManager: this.name,
              ad: {},
              streams: streams,
              //use linear video so VTC can prepare the video element (does not disturb overlays)
              adType: _amc.ADTYPE.UNKNOWN_AD_REQUEST
            })];

            return placeholder;
          }

          return adsTimeline;
        };

        /**
         * Returns all the valid ad tags stored inside of this.allAdInfo. If using
         * Ad Rules, return only valid Ad Rules ads. If not using Ad Rules then
         * it returns the valid non Ad Rules ads.
         * @private
         * @method GoogleIMA#_getValidAdTagUrls
         * @returns {array} Ads with valid ad tags. Null if this.allAdInfo doesn't exist.
         */
        var _getValidAdTagUrls = privateMember(function()
        {
          if (!this.allAdInfo)
          {
            return null;
          }

          return _.filter(this.allAdInfo, _isValidAdTag);
        });

        /**
         * Returns true if ad (from backlot) has a valid ad tag.
         * @private
         * @method GoogleIMA#isValidAdTag
         * @returns {array} Ads with valid ad tags.
         */
        var _isValidAdTag = privateMember(function(ad)
        {
          if(!ad)
          {
            return false;
          }

          var url = ad.tag_url;
          var isAdRulesAd = (ad.position_type == AD_RULES_POSITION_TYPE);
          var isSameAdType = (_usingAdRules == isAdRulesAd);

          return isSameAdType && url && typeof url === 'string';
        });

        /**
         * Called by the ad manager controller.  Ad Manager Controller lets the module know that an ad should play now.
         * @public
         * @method GoogleIMA#playAd
         * @param {object} ad The ad to play from the timeline.
         */
        this.playAd = function(amcAdPod)
        {
          if(this.currentAMCAdPod)
          {
            _endCurrentAd(true);
          }

          this.currentAMCAdPod = amcAdPod;
          if(!this.currentAMCAdPod)
          {
            _throwError("playAd() called but amcAdPod is null.");
          }
          else if (!this.currentAMCAdPod.ad)
          {
            _throwError("playAd() called but amcAdPod.ad is null.");
          }

          /*
           Set the z-index of IMA's iframe, where IMA ads are displayed, to 10004.
           This puts IMA ads in front of the main content element, but under the control bar.
           This fixes issues where overlays appear behind the video and for iOS it fixes
           video ads not showing.
           */
          var IMAiframe = $("iframe[src^='http://imasdk.googleapis.com/']")[0];
          if (IMAiframe && IMAiframe.style)
          {
            IMAiframe.style.zIndex = this.imaIframeZIndex;
          }

          if(_usingAdRules && this.currentAMCAdPod.adType == _amc.ADTYPE.UNKNOWN_AD_REQUEST)
          {
            //we started our placeholder ad
            _amc.notifyPodStarted(this.currentAMCAdPod.id, 1);
            //if the sdk ad request failed when trying to preload, we should end the placeholder ad
            if(this.preloadAdRulesAds && this.adRulesLoadError)
            {
              _amc.notifyPodEnded(this.currentAMCAdPod.id, 1);
            }
            return;
          }

          //IMA doesn't use the adVideoElement layer so make sure to hide it.
          if (!_amc.ui.useSingleVideoElement && _amc.ui.adVideoElement)
          {
            _amc.ui.adVideoElement.css(INVISIBLE_CSS);
          }

          if(_usingAdRules && this.currentAMCAdPod.ad.forced_ad_type !== _amc.ADTYPE.NONLINEAR_OVERLAY)
          {
            _tryStartAd();
          }
          else
          {
            //if we are trying to play an linear ad then we need to request the ad now.
            if (this.currentAMCAdPod.ad.forced_ad_type != _amc.ADTYPE.NONLINEAR_OVERLAY)
            {
              //reset adRequested and adTagUrl so we can request another ad
              _resetAdsState();
              this.adTagUrl = this.currentAMCAdPod.ad.tag_url;
              _trySetupAdsRequest();
            }
            //Otherwise we are trying to play an overlay, at this point IMA is already
            //displaying it, so just notify AMC that we are showing an overlay.
            else
            {
              //provide width and height values if available. Alice will use these to resize
              //the skin plugins div when a non linear overlay is on screen
              if (this.currentAMCAdPod && this.currentNonLinearIMAAd)
              {
                //IMA requires some padding in order to have the overlay render or else
                //IMA thinks the available real estate is too small.
                this.currentAMCAdPod.width = this.currentNonLinearIMAAd.getWidth();
                this.currentAMCAdPod.height = this.currentNonLinearIMAAd.getHeight();
                this.currentAMCAdPod.paddingWidth = OVERLAY_WIDTH_PADDING;
                this.currentAMCAdPod.paddingHeight = OVERLAY_HEIGHT_PADDING;
                _onSizeChanged();
              }
              // raise WILL_PLAY_NONLINEAR_AD event and alert AMC and player that a nonlinear ad is started.
              // Nonlinear ad is rendered by IMA.
              _amc.sendURLToLoadAndPlayNonLinearAd(this.currentAMCAdPod, this.currentAMCAdPod.id, null);
            }
          }
        };

        /**
         * Called by the ad manager controller.  Hide the overlay. In this case, overlay showing, after a hide, is not supported
         * so it just cancels the overlay.
         * @public
         * @method GoogleIMA#hideOverlay
         * @param {object} ad The ad to hide
         */
        this.cancelOverlay = function(ad)
        {
          //currently IMA doesn't have overlay durations so it will always be canceled.
          //They will never receive a completed message.
          this.cancelAd(ad);
        };

        /**
         * Called by the ad manager controller.  Cancels the current running ad.
         * @public
         * @method GoogleIMA#cancelAd
         * @param {object} ad The ad to cancel
         */
        this.cancelAd = function(ad)
        {
          if(ad && this.currentAMCAdPod && ad.id != this.currentAMCAdPod.id)
          {
            _throwError("AMC canceling ad that is not the current one playing.");
          }
          OO.log("GOOGLE IMA: ad got canceled by AMC");
          _endCurrentAd(true);
          if (!_usingAdRules)
          {
            _IMA_SDK_destroyAdsManager();
          }
        };

        /**
         * Called by the ad manager controller.  Pauses the current ad.
         * @public
         * @method GoogleIMA#pauseAd
         * @param {object} ad The ad to pause
         */
        this.pauseAd = function(ad)
        {
          if (_IMAAdsManager && this.adPlaybackStarted)
          {
            _IMAAdsManager.pause();
          }
        };

        /**
         * Called by the ad manager controller.  Resumes the current ad.
         * @public
         * @method GoogleIMA#resumeAd
         * @param {object} ad The ad to resume
         */
        this.resumeAd = function(ad)
        {
          if (_IMAAdsManager && this.adPlaybackStarted)
          {
            _IMAAdsManager.resume();
          }
        };

        this.getVolume = function()
        {
          var volume = 1;
          if (_IMAAdsManager)
          {
            volume = _IMAAdsManager.getVolume();
          }
          return volume;
        };

        this.setVolume = function(volume)
        {
          if (_IMAAdsManager && _linearAdIsPlaying)
          {
            _IMAAdsManager.setVolume(volume);
          }
          else
          {
            //if ad is not playing, store the volume to set later when we start the video
            this.savedVolume = volume;
          }
        };

        this.getCurrentTime = function()
        {
          var currentTime = 0;
          //IMA provides values for getRemainingTime which can result in negative current times
          //or current times which are greater than duration.
          //We will check these boundaries so we will not report these unexpected current times
          if (_IMAAdsManager &&
            this.currentIMAAd &&
            _IMAAdsManager.getRemainingTime() >= 0 &&
            _IMAAdsManager.getRemainingTime() <= this.currentIMAAd.getDuration())
          {
            currentTime = this.currentIMAAd.getDuration() - _IMAAdsManager.getRemainingTime();
          }
          return currentTime;
        };

        this.getDuration = function()
        {
          var duration = 0;
          if (this.currentIMAAd)
          {
            duration = this.currentIMAAd.getDuration();
          }
          return duration;
        };

        this.adVideoFocused = function()
        {
          //Required for plugin
        };

        /**
         * Callback for Ad Manager Controller EVENTS.REPLAY_REQUESTED.  Resets the IMA SDK to be able to
         * request ads again and then requests the ads if it's AdRules.
         * @private
         * @method GoogleIMA#_onReplayRequested.
         */
        var _onReplayRequested = privateMember(function()
        {
          this.isReplay = true;
          _resetAdsState();
          _resetPlayheadTracker();
          this.contentEnded = false;
          //In the case of ad rules, non of the ads are in the timeline
          //and we won't call initialPlayRequested again. So we manually call
          //to load the ads again. We don't care about preloading at this point.
          if (_usingAdRules)
          {
            _trySetupAdsRequest();
          }
        });

        /**
         * Resets the IMA SDK to allow for requesting more ads.
         * @private
         * @method GoogleIMA#_resetAdsState
         */
        var _resetAdsState = privateMember(function()
        {
          _tryUndoSetupForAdRules();

          //If you want to use the same ad tag twice you have to destroy the admanager and call
          //adsLoader.contentComplete. (This also helps with non-adrules ads)  This resets the
          //internal state in the IMA SDK. You call contentComplete after destroying the adManager
          //so you don't accidently play postrolls.
          //Link to documentation: https://developers.google.com/interactive-media-ads/docs/sdks/android/faq
          _IMA_SDK_destroyAdsManager();
          if (_IMAAdsLoader)
          {
            _IMAAdsLoader.contentComplete();
          }

          this.adsRequested = false;
        });

        /**
         * Callback for Ad Manager Controller EVENTS.INITIAL_PLAY_REQUESTED.  Sets up IMA SDK so it can display ads and
         * trys to request ads if preloading Ad Rules is not enabled.
         * @private
         * @method GoogleIMA#_onInitialPlayRequested
         */
        var _onInitialPlayRequested = privateMember(function()
        {
          OO.log("_onInitialPlayRequested");
          //double check that IMA SDK loaded.
          if(!_IMAAdDisplayContainer)
          {
            _onImaAdError();
            _amc.unregisterAdManager(this.name);
            _throwError("onInitialPlayRequested called but _IMAAdDisplayContainer not created yet.");
          }

          this.initialPlayRequested = true;
          this.isReplay = false;
          _IMAAdDisplayContainer.initialize();
          _IMA_SDK_tryInitAdsManager();

          //if we aren't preloading the ads, then it's safe to make the ad request now.
          //so we don't mess up analytics and request ads that may not be shown.
          if (!this.preloadAdRulesAds)
          {
            this.canSetupAdsRequest = true;
            _trySetupAdsRequest();
          }
        });

        /**
         * Tries to initialize the AdsManager variable, from the IMA SDK, that is received from an ad request.
         * @private
         * @method GoogleIMA#_IMA_SDK_tryInitAdsManager
         */
        var _IMA_SDK_tryInitAdsManager = privateMember(function()
        {
          //block this code from running till we want to play the video
          //if you run it before then ima will take over and immediately try to play
          //ads (if there is a preroll)
          if (_IMAAdsManager && this.initialPlayRequested && !_IMAAdsManagerInitialized && _uiContainer)
          {
            try
            {
              //notify placeholder end if we do not have a preroll to start main content
              if(_usingAdRules &&
                !this.hasPreroll &&
                this.currentAMCAdPod &&
                this.currentAMCAdPod.adType == _amc.ADTYPE.UNKNOWN_AD_REQUEST)
              {
                _endCurrentAd(true);
              }
              _IMAAdsManager.init(_uiContainer.clientWidth, _uiContainer.clientHeight, google.ima.ViewMode.NORMAL);
              // WIKIA CHANGE - START
              this.onBeforeAdsManagerStart(_IMAAdsManager);
              // WIKIA CHANGE - END

              // PBW-6610
              // Traditionally we have relied on the LOADED ad event before calling adsManager.start.
              // This may have worked accidentally.
              // IMA Guides and the video suite inspector both call adsManager.start immediately after
              // adsManager.init
              // Furthermore, some VPAID ads do not fire LOADED event until adsManager.start is called
              _IMAAdsManager.start();
              _IMAAdsManagerInitialized = true;
              OO.log("tryInitadsManager successful: adsManager started")
            }
            catch (adError)
            {
              _onImaAdError(adError);
            }
          }
        });

        /**
         * Callback for Ad Manager Controller EVENTS.CONTENT_COMPLETED.  Marks the main content as having completed and
         * notifies the IMA SDK, so it can play postrolls if neccessary.
         * @private
         * @method GoogleIMA#_onContentCompleted
         */
        var _onContentCompleted = privateMember(function()
        {
          if (this.contentEnded == false)
          {
            this.contentEnded = true;
            if (_IMAAdsLoader)
            {
              _IMAAdsLoader.contentComplete();
            }
          }
        });

        /**
         * Callback for Ad Manager Controller EVENTS.PLAYHEAD_TIME_CHANGED.  Updates the IMA SDK with current playhead time.
         * @private
         * @method GoogleIMA#_onPlayheadTimeChanged
         * @param playhead current playhead time
         * @param duration - duration of the movie.
         */
        var _onPlayheadTimeChanged = privateMember(function(event, playheadTime, duration)
        {
          if (!_playheadTracker)
          {
            _resetPlayheadTracker();
          }

          //in case the amc gives us playhead updates while IMA is playing an ad (AdRules case)
          //then we don't want to update the playhead that IMA reads from to avoid triggering
          //more ads while playing the current one.
          if(!_linearAdIsPlaying)
          {
            _playheadTracker.currentTime = playheadTime;
            _playheadTracker.duration = duration;
          }
        });

        /**
         * Callback for Ad Manager Controller. Handles going into and out of fullscreen mode.
         * @public
         * @method GoogleIMA#onFullScreenChanged
         * @param {boolean} shouldEnterFullscreen True if going into fullscreen
         */
        var _onFullscreenChanged = privateMember(function(event, shouldEnterFullscreen)
        {
          this.isFullscreen = shouldEnterFullscreen;
          _onSizeChanged();
        });

        /**
         * Callback for size change notifications.
         * @private
         * @method GoogleIMA#_onSizeChanged
         */
        var _onSizeChanged = privateMember(function()
        {
          _updateIMASize();
        });

        /**
         * Update the IMA SDK to inform it the size of the video container has changed.
         * @private
         * @method GoogleIMA#_updateIMASize
         */
        var _updateIMASize = privateMember(function()
        {
          if (_IMAAdsManager && _uiContainer)
          {
            var viewMode = this.isFullscreen ? google.ima.ViewMode.FULLSCREEN : google.ima.ViewMode.NORMAL;
            var width = _uiContainer.clientWidth;
            var height = _uiContainer.clientHeight;
            //For nonlinear overlays, we want to provide the size that we sent to the AMC in playAd.
            //We do this because the player skin plugins div (_uiContainer) may not have been redrawn yet
            if (this.currentAMCAdPod && this.currentNonLinearIMAAd)
            {
              if (this.currentAMCAdPod.width)
              {
                width = this.currentAMCAdPod.width;
                if (this.currentAMCAdPod.paddingWidth)
                {
                  width += this.currentAMCAdPod.paddingWidth;
                }
              }

              if (this.currentAMCAdPod.height)
              {
                height = this.currentAMCAdPod.height;
                if (this.currentAMCAdPod.paddingHeight)
                {
                  height += this.currentAMCAdPod.paddingHeight;
                }
              }
            }
            _IMAAdsManager.resize(width, height, viewMode);
          }
        });

        /**
         * Resets _playheadTracker's current time to 0. If _playheadTracker doesn't
         * exist, it creates it.
         * @private
         * @method GoogleIMA#_resetPlayheadTracker
         */
        var _resetPlayheadTracker = privateMember(function()
        {
          if (!_playheadTracker)
          {
            _playheadTracker = {duration: 0, currentTime: 0};
          }
          else
          {
            _playheadTracker.currentTime = 0;
          }
        });

        /**
         * Tries to request an ad, if all requirements are met.  You cannot request
         * an ad again without first calling _resetAdsState().
         * @private
         * @method GoogleIMA#_trySetupAdsRequest
         */
        var _trySetupAdsRequest = privateMember(function()
        {
          //need metadata, ima sdk, and ui to be registered before we can request an ad
          if ( this.adsRequested         ||
            !this.canSetupAdsRequest   ||
            !this.adTagUrl             ||
            !this.uiRegistered         ||
            !_amc.currentEmbedCode     ||
            !_IMAAdsLoader             ||
            !_checkRequestAdsOnReplay())
          {
            return;
          }

          //at this point we are guaranteed that metadata has been received and the sdk is loaded.
          //so now we can set whether to disable flash ads or not.
          if (google && google.ima && google.ima.settings)
          {
            google.ima.settings.setDisableFlashAds(this.disableFlashAds);
          }

          var adsRequest = new google.ima.AdsRequest();
          if (this.additionalAdTagParameters)
          {
            var connector = this.adTagUrl.indexOf("?") > 0 ? "&" : "?";

            // Generate an array of key/value pairings, for faster string concat
            var paramArray = [];
            var param = null;
            for (param in this.additionalAdTagParameters)
            {
              paramArray.push(param + "=" + this.additionalAdTagParameters[param]);
            }
            this.adTagUrl += connector + paramArray.join("&");
          }
          adsRequest.adTagUrl = OO.getNormalizedTagUrl(this.adTagUrl, _amc.currentEmbedCode);
          // Specify the linear and nonlinear slot sizes. This helps the SDK to
          // select the correct creative if multiple are returned.
          var w = _amc.ui.width;
          var h = _amc.ui.height;
          adsRequest.linearAdSlotWidth = w;
          adsRequest.linearAdSlotHeight = h;

          adsRequest.nonLinearAdSlotWidth = w;
          adsRequest.nonLinearAdSlotHeight = h;

          _resetAdsState();
          _trySetupForAdRules();
          _IMAAdsLoader.requestAds(adsRequest);
          this.adsRequestTimeoutRef = _.delay(_adsRequestTimeout, this.maxAdsRequestTimeout);
          OO.log("adsRequestTimeout: " + this.maxAdsRequestTimeout);
          this.adsRequested = true;
        });


        /**
         * Return true if you can ad request depending on if it's a replay or not.
         * If it's not a replay then it will return true. If it is, then it depends
         * on the player setup.
         * @private
         * @method GoogleIMA#_checkRequestAdsOnReplay
         */
        var _checkRequestAdsOnReplay = privateMember(function()
        {
          if (!this.isReplay)
          {
            return true;
          }

          return this.requestAdsOnReplay;
        });

        /**
         * Callback after IMA SDK is successfully loaded. Tries to setup ad request and container for ads.
         * @private
         * @method GoogleIMA#_onSdkLoaded
         * @param success - whether SDK loaded successfully.
         */
        var _onSdkLoaded = privateMember(function(success)
        {
          _adModuleJsReady = success;
          OO.log("onSdkLoaded!");
          // [PBK-639] Corner case where Google's SDK 200s but isn't properly
          // loaded. Better safe than sorry..
          if (!success || !_isGoogleSDKValid())
          {
            _onImaAdError();
            _amc.unregisterAdManager(this.name);
            return;
          }

          //These are required by Google for tracking purposes.
          google.ima.settings.setPlayerVersion(PLUGIN_VERSION);
          google.ima.settings.setPlayerType(PLAYER_TYPE);
          google.ima.settings.setLocale(OO.getLocale());
          if (this.useInsecureVpaidMode)
          {
            google.ima.settings.setVpaidMode(google.ima.ImaSdkSettings.VpaidMode.INSECURE);
          }
          else
          {
            google.ima.settings.setVpaidMode(google.ima.ImaSdkSettings.VpaidMode.ENABLED);
          }

          _IMA_SDK_tryInitAdContainer();
          _trySetupAdsRequest();
        });

        /**
         * Tries to initialize the IMA SDK AdContainer.  This is where the ads will be located.
         * @private
         * @method GoogleIMA#_IMA_SDK_tryInitAdContainer
         */
        var _IMA_SDK_tryInitAdContainer = privateMember(function()
        {
          if (_adModuleJsReady && this.uiRegistered)
          {
            if (!_isGoogleSDKValid())
            {
              _throwError("IMA SDK loaded but does not contain valid data");
            }

            if (_IMAAdDisplayContainer) {
              _IMAAdDisplayContainer.destroy();
            }

            //Prefer to use player skin plugins element to allow for click throughs. Use plugins element if not available
            _uiContainer = _amc.ui.playerSkinPluginsElement ? _amc.ui.playerSkinPluginsElement[0] : _amc.ui.pluginsElement[0];
            //iphone performance is terrible if we don't use the custom playback (i.e. filling in the second param for adDisplayContainer)
            //also doesn't not seem to work nicely with podded ads if you don't use it.

            //for IMA, we always want to use the plugins element to house the IMA UI. This allows it to behave
            //properly with the Alice skin.
            _IMAAdDisplayContainer = new google.ima.AdDisplayContainer(_uiContainer,
              this.sharedVideoElement);

            _trySetAdManagerToReady();

            _IMA_SDK_createAdsLoader();
          }
        });

        /**
         * Tries to create an IMA SDK AdsLoader.  The AdsLoader notifies this ad manager when ad requests are completed.
         * @private
         * @method GoogleIMA#_IMA_SDK_createAdsLoader
         */
        var _IMA_SDK_createAdsLoader = privateMember(function()
        {
          var adsManagerEvents = google.ima.AdsManagerLoadedEvent.Type;
          var adErrorEvent = google.ima.AdErrorEvent.Type;
          _IMA_SDK_destroyAdsLoader();
          _IMAAdsLoader = new google.ima.AdsLoader(_IMAAdDisplayContainer);
          // This will enable notifications whenever ad rules or VMAP ads are scheduled
          // for playback, it has no effect on regular ads
          _IMAAdsLoader.getSettings().setAutoPlayAdBreaks(false);
          _IMAAdsLoader.addEventListener(adsManagerEvents.ADS_MANAGER_LOADED, _onAdRequestSuccess, false);
          _IMAAdsLoader.addEventListener(adErrorEvent.AD_ERROR, _onImaAdError, false);
        });

        /**
         * Clean up function for IMA SDK AdDisplayContainer.
         * @private
         * @method GoogleIMA#_IMA_SDK_destroyAdDisplayContainer
         */
        var _IMA_SDK_destroyAdDisplayContainer = privateMember(function()
        {
          if (_IMAAdDisplayContainer)
          {
            _IMAAdDisplayContainer.destroy();
            _IMAAdDisplayContainer = null;
          }
        });

        /**
         * Clean up function for IMA SDK AdsLoader.
         * @private
         * @method GoogleIMA#_IMA_SDK_destroyAdsLoader
         */
        var _IMA_SDK_destroyAdsLoader = privateMember(function()
        {
          if (_IMAAdsLoader)
          {
            _IMAAdsLoader.destroy();
            _IMAAdsLoader = null;
          }
        });

        /**
         * Clean up function for IMA SDK AdsManager.
         * @private
         * @method GoogleIMA#_IMA_SDK_destroyAdsManager
         */
        var _IMA_SDK_destroyAdsManager = privateMember(function()
        {
          this.currentIMAAd = null;
          this.currentNonLinearIMAAd = null;
          if (_IMAAdsManager)
          {
            _IMAAdsManager.stop();
            _IMAAdsManager.destroy();
            _IMAAdsManager = null;
            _IMAAdsManagerInitialized = false;
          }
        });

        /**
         * Cancel the current ad, and destroy/reset all the GoogleIMA SDK variables.
         * @public
         * @method GoogleIMA#destroy
         */
        this.destroy = function()
        {
          _uiContainer = null;
          _tryUndoSetupForAdRules();
          _IMA_SDK_destroyAdsManager();
          _IMA_SDK_destroyAdsLoader();
          _IMA_SDK_destroyAdDisplayContainer();
          _resetVars();
          _removeAMCListeners();
        };

        /**
         * Sets this ad manager to ready and notifies the Ad Manager Controller that it's ready if
         * the ad display container has been created and the metadata has been received.
         * @private
         * @method GoogleIMA#_trySetAdManagerToReady
         */
        var _trySetAdManagerToReady = privateMember(function()
        {
          if (_IMAAdDisplayContainer && this.metadataReady)
          {
            this.ready = true;
            _amc.onAdManagerReady();
          }
        });

        /**
         * Callback in case of timeout during ad request.
         * @private
         * @method GoogleIMA#_adsRequestTimeout
         */
        var _adsRequestTimeout = privateMember(function()
        {
          if (!this.adsReady)
          {
            _onImaAdError(google.ima.AdEvent.Type.FAILED_TO_REQUEST_ADS);
          }
        });

        /**
         * If an error occurs cause ad manager to fail gracefully.  If it's ad rules, no more ads will play.  Non ad rules
         * just not play the one ad.
         * @private
         * @method GoogleIMA#_onImaAdError
         * @param {object} adErrorEvent - IMA SDK error data
         */
        var _onImaAdError = privateMember(function(adError)
        {
          if(_usingAdRules)
          {
            //if ads are not ready yet, ima failed to load
            if(!this.adsReady)
            {
              this.adRulesLoadError = true;
            }
            //give control back to AMC
            _tryUndoSetupForAdRules();
          }

          _endCurrentAd(true);
          _IMA_SDK_destroyAdsManager();
          //make sure we are showing the video in case it was hidden for whatever reason.
          if (adError)
          {
            var errorString = "ERROR Google IMA";

            if(adError.getError)
            {
              errorString = "ERROR Google SDK: " + adError.getError();
            }
            else
            {
              errorString = "ERROR Google IMA plugin: " + adError;
            }

            if (_amc)
            {
              _amc.raiseAdError(errorString);
            }
            else
            {
              OO.log(errorString);
            }
          }
        });

        /**
         * Callback when ad request is completed. Sets up ad manager to listen to IMA SDK events.
         * @private
         * @method GoogleIMA#_onAdRequestSuccess
         * @param {object} adsManagerLoadedEvent - from the IMA SDK contains the IMA AdManager instance.
         */
        var _onAdRequestSuccess = privateMember(function(adsManagerLoadedEvent)
        {
          if (!_usingAdRules && _IMAAdsManager)
          {
            //destroy the current ad manager is there is one
            _IMA_SDK_destroyAdsManager();
          }
          // https://developers.google.com/interactive-media-ads/docs/sdks/googlehtml5_apis_v3#ima.AdsRenderingSettings
          var adsSettings = new google.ima.AdsRenderingSettings();
          adsSettings.restoreCustomPlaybackStateOnAdBreakComplete = false;
          adsSettings.useStyledNonLinearAds = true;
          // WIKIA CHANGE - START
          adsSettings.uiElements = [];
          // WIKIA CHANGE - END
          if (this.useGoogleCountdown)
          {
            //both COUNTDOWN and AD_ATTRIBUTION are required as per
            //https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.UiElements
            adsSettings.uiElements = [google.ima.UiElements.COUNTDOWN, google.ima.UiElements.AD_ATTRIBUTION];
          }
          adsSettings.useStyledLinearAds = this.useGoogleAdUI;
          _IMAAdsManager = adsManagerLoadedEvent.getAdsManager(_playheadTracker, adsSettings);

          // WIKIA CHANGE - START
          this.onAdRequestSuccess(_IMAAdsManager, _uiContainer);
          // WIKIA CHANGE - END

          // When the ads manager is ready, we are ready to apply css changes to the video element
          // If the sharedVideoElement is not used, mark it as null before applying css
          if (this.videoControllerWrapper)
          {
            this.videoControllerWrapper.readyForCss = true;
          }
          if (!_IMAAdsManager.isCustomPlaybackUsed()) {
            this.setupSharedVideoElement(null);
          }
          if (this.videoControllerWrapper)
          {
            this.videoControllerWrapper.applyStoredCss();
          }

          //a cue point index of 0 references a preroll, so we know we have a preroll if we find it in cuePoints
          var cuePoints = _IMAAdsManager.getCuePoints();
          this.hasPreroll = cuePoints.indexOf(0) >= 0;

          var eventType = google.ima.AdEvent.Type;
          // Add listeners to the required events.
          _IMAAdsManager.addEventListener(eventType.CLICK, _IMA_SDK_onAdClicked, false, this);
          _IMAAdsManager.addEventListener(google.ima.AdErrorEvent.Type.AD_ERROR, _onImaAdError, false, this);
          _IMAAdsManager.addEventListener(google.ima.AdEvent.Type.AD_BREAK_READY, _IMA_SDK_onAdBreakReady);
          _IMAAdsManager.addEventListener(eventType.CONTENT_PAUSE_REQUESTED, _IMA_SDK_pauseMainContent, false, this);
          _IMAAdsManager.addEventListener(eventType.CONTENT_RESUME_REQUESTED, _IMA_SDK_resumeMainContent, false, this);

          // Listen to any additional events, if necessary.
          var imaAdEvents = [
            eventType.ALL_ADS_COMPLETED,
            eventType.COMPLETE,
            eventType.SKIPPED,
            eventType.FIRST_QUARTILE,
            eventType.LOADED,
            eventType.MIDPOINT,
            eventType.PAUSED,
            eventType.RESUMED,
            eventType.STARTED,
            eventType.THIRD_QUARTILE,
            eventType.VOLUME_CHANGED,
            eventType.VOLUME_MUTED,
            eventType.USER_CLOSE,
            eventType.DURATION_CHANGE];

          var addIMAEventListener =
            function(e)
            {
              _IMAAdsManager.addEventListener(e, _IMA_SDK_onAdEvent, false, this);
            };

          OO._.each(imaAdEvents, addIMAEventListener, this);
          _trySetAdManagerToReady();
          this.adsReady = true;
          clearTimeout(this.adsRequestTimeoutRef);
          _IMA_SDK_tryInitAdsManager();
        });

        /**
         * Fired when IMA SDK has a VMAP or Ad Rules ad that is ready for playback.
         * @private
         * @method GoogleIMA#_IMA_SDK_onAdBreakReady
         * @param adEvent - Event data from IMA SDK.
         */
        var _IMA_SDK_onAdBreakReady = privateMember(function(adEvent)
        {
          OO.log("GOOGLE_IMA:: Ad Rules ad break ready!", adEvent);
          // Proceed as usual if we're not using ad rules
          if (!_usingAdRules)
          {
            _IMAAdsManager.start();
            return;
          }
          // Mimic AMC behavior and cancel any existing non-linear ads before playing the next ad.
          // Note that there is a known issue in the IMA SDK that prevents the COMPLETE
          // event from being fired when a non-linear ad is removed. This is also a workaround
          // for that issue.
          if (this.currentAMCAdPod && this.currentNonLinearIMAAd)
          {
            this.cancelAd(this.currentAMCAdPod);
          }
          // [PLAYER-319]
          // IMA will not initialize ad rules overlays unless the ad container is already rendered and
          // has enough room for the overlay by the time the ad is ready to play. As a workaround, we expand
          // the ad container and make sure it's rendered, while at the same time hiding it visually.
          // We store the element's current style in order to restore it afterwards.
          _uiContainerPrevStyle = _uiContainer.getAttribute("style") || "";
          _uiContainer.setAttribute("style", "display: block; width: 100%; height: 100%; visibility: hidden; pointer-events: none;");
          _onSizeChanged();
          // Resume ads manager operation
          _IMAAdsManager.start();
        });

        /**
         * Callback when IMA SDK detect an ad click. This relays it to the Ad Manager Controller.
         * @private
         * @method GoogleIMA#_IMA_SDK_onAdClicked
         * @param adEvent - Event data from IMA SDK.
         */
        var _IMA_SDK_onAdClicked = privateMember(function(adEvent)
        {
          _amc.adsClicked();
          _amc.adsClickthroughOpened();
        });

        /**
         * Callback from IMA SDK to tell this ad manager to pause the main content video. If ad is an Ad Rules ad, the Ad
         * Manager Controller is forced to play an ad.
         * @private
         * @method GoogleIMA#_IMA_SDK_pauseMainContent
         */
        var _IMA_SDK_pauseMainContent = privateMember(function()
        {
          OO.log("GOOGLE_IMA:: Content Pause Requested by Google IMA!");
          _linearAdIsPlaying = true;
          if (_usingAdRules)
          {
            var adData =
              {
                position_type: AD_RULES_POSITION_TYPE,
                forced_ad_type: _amc.ADTYPE.LINEAR_VIDEO
              };
            //we do not want to force an ad play with preroll ads
            if(_playheadTracker.currentTime > 0)
            {
              var streams = {};
              streams[OO.VIDEO.ENCODING.IMA] = "";
              _amc.forceAdToPlay(this.name, adData, _amc.ADTYPE.LINEAR_VIDEO, streams);
            }
          }
        });

        /**
         * Callback from IMA SDK to tell this ad manager to resume the main content video.
         * @private
         * @method GoogleIMA#_IMA_SDK_resumeMainContent
         */
        var _IMA_SDK_resumeMainContent = privateMember(function()
        {
          //make sure when we resume, that we have ended the ad pod and told
          //the AMC that we have done so.
          _endCurrentAd(true);

          OO.log("GOOGLE_IMA:: Content Resume Requested by Google IMA!");
        });

        /**
         * Notifies the video controller wrapper of the fullscreen end event.
         * @private
         * @method GoogleIMA#_raiseFullScreenEndEvent
         */
        var _raiseFullScreenEndEvent = privateMember(function()
        {

          if (this.videoControllerWrapper)
          {
            this.videoControllerWrapper.raiseFullScreenEvent();
            this.videoControllerWrapper.raisePauseEvent();
          }
        });

        /**
         * Notifies the video controller wrapper of the pause event.
         * @private
         * @method GoogleIMA#_raisePauseEvent
         */
        var _raisePauseEvent = privateMember(function()
        {
          if (this.videoControllerWrapper)
          {
            this.videoControllerWrapper.raisePauseEvent();
          }
        });

        /**
         * Checks if there is any companion ads associated with the ad and if one is found, it will call the Ad Manager
         * Controller to show it.
         * @public
         * @method GoogleIMA#checkCompanionAds
         * @param {object} ad The Ad metadata
         */
        var _checkCompanionAds = privateMember(function(ad) {
          // companionAd slots are required
          if (!ad || !_amc.pageSettings.companionAd || !_amc.pageSettings.companionAd.slots) {
            return;
          }
          // Page level setting with format:
          // companionAd: {
          //  slots: [{width: 300, height: 250}, ..]
          // }
          var slots = _amc.pageSettings.companionAd.slots;
          var companionAds = [],
            companionAd = null;

          _.each(slots, function(slot) {
            if (slot.width && slot.height) {
              companionAd = ad.getCompanionAds(slot.width, slot.height);
              if (companionAd.length) {
                _.each(companionAd, function(ad) {
                  companionAds.push({slotSize: slot.width + "x" + slot.height, ad: ad.getContent()});
                });
              }
            }
          });

          if (!companionAds.length) {
            return;
          }
          //companionAds = [{slotSize: "300x250", ad: <Companion Ad as HTML>}, ..]
          _amc.showCompanion(companionAds);
        });

        /**
         * Callback from IMA SDK for ad tracking events.
         * @private
         * @method GoogleIMA#_IMA_SDK_onAdEvent
         */
        var _IMA_SDK_onAdEvent = privateMember(function(adEvent)
        {
          // Retrieve the ad from the event. Some events (e.g. ALL_ADS_COMPLETED)
          // don't have ad object associated.
          var eventType = google.ima.AdEvent.Type;
          var ad = adEvent.getAd();
          OO.log("IMA EVENT: ", adEvent.type, adEvent);
          switch (adEvent.type)
          {
            case eventType.LOADED:
              _resetUIContainerStyle();

              if (ad.isLinear())
              {
                _amc.focusAdVideo();
              }
              break;
            case eventType.STARTED:
              this.adPlaybackStarted = true;
              if(ad.isLinear())
              {
                _linearAdIsPlaying = true;
                if (this.savedVolume >= 0)
                {
                  this.setVolume(this.savedVolume);
                  this.savedVolume = -1;
                }
                //Since IMA handles its own UI, we want the video player to hide its UI elements
                _amc.hidePlayerUi(this.showAdControls, false);
              }
              else
              {
                this.currentNonLinearIMAAd = ad;
              }
              this.currentIMAAd = ad;
              _onSizeChanged();
              _tryStartAd();
              if (this.videoControllerWrapper)
              {
                if (ad.isLinear())
                {
                  this.videoControllerWrapper.raisePlayEvent();
                }
                this.videoControllerWrapper.raiseTimeUpdate(this.getCurrentTime(), this.getDuration());
                _startTimeUpdater();
              }
              // Non-linear ad rules or VMAP ads will not be started by _tryStartAd()
              // because there'll be no AMC ad pod. We start them here after the time update event
              // in order to prevent the progress bar from flashing
              if (_usingAdRules && !ad.isLinear())
              {
                _startNonLinearAdRulesOverlay();
              }
              break;
            case eventType.RESUMED:
              if (this.videoControllerWrapper)
              {
                if (ad.isLinear())
                {
                  this.videoControllerWrapper.raisePlayEvent();
                }
              }
              break;
            case eventType.USER_CLOSE:
            case eventType.SKIPPED:
            case eventType.COMPLETE:
              this.adPlaybackStarted = false;
              if (this.videoControllerWrapper && (ad && ad.isLinear()))
              {
                _stopTimeUpdater();
                //IMA provides values which can result in negative current times or current times which are greater than duration.
                //For good user experience, we will provide the duration as the current time here if the event type is COMPLETE
                var currentTime = adEvent.type === eventType.COMPLETE ? this.getDuration() : this.getCurrentTime();
                this.videoControllerWrapper.raiseTimeUpdate(currentTime, this.getDuration());
                this.videoControllerWrapper.raiseEndedEvent();
              }
              //Save the volume so the volume can persist on future ad playbacks if we don't receive another volume update from VTC
              this.savedVolume = this.getVolume();

              if (!ad || !ad.isLinear())
              {
                this.currentNonLinearIMAAd = null;
              }

              _endCurrentAd(false);
              _linearAdIsPlaying = false;
              _onAdMetrics(adEvent);

              // (agunawan): Google SDK is not publishing CONTENT_RESUME with livestream!!! !@#!@#!@#@!#@
              if (_amc.isLiveStream)
              {
                // iOS8 fix
                _.delay(_.bind(function()
                {
                  _IMA_SDK_resumeMainContent();
                }, this), 100);
              }
              break;
            case eventType.PAUSED:
              _raisePauseEvent();
              break;
            case eventType.ALL_ADS_COMPLETED:
              _linearAdIsPlaying = false;
              OO.log("all google ima ads completed!");
              _tryUndoSetupForAdRules();

              /*
               On iPhone, _IMA_SDK_resumeMainContent() is not being triggered after the last postroll, for
               both adrules and non-adrules. For non-adrules, this event is triggered after every ad,
               so we must check that it is the last postroll before calling _IMA_SDK_resumeMainContent().
               */
              if (OO.isIos && this.contentEnded && _amc.isLastAdPlayed())
              {
                _IMA_SDK_resumeMainContent();
              }

              break;
            case eventType.FIRST_QUARTILE:
            case eventType.MIDPOINT:
            case eventType.THIRD_QUARTILE:
              _onAdMetrics(adEvent);
              break;
            case eventType.VOLUME_CHANGED:
            case eventType.VOLUME_MUTED:
              if (this.videoControllerWrapper)
              {
                this.videoControllerWrapper.raiseVolumeEvent();
              }
              break;
            case eventType.DURATION_CHANGE:
              if (this.videoControllerWrapper)
              {
                this.videoControllerWrapper.raiseDurationChange(this.getCurrentTime(), this.getDuration());
              }
              break;
            default:
              break;
          }
        });

        /**
         * Will restore the original style of the UI container if one exists.
         * This is used in a workaround for PLAYER-319.
         * @private
         * @method GoogleIMA#_resetUIContainerStyle
         */
        var _resetUIContainerStyle = privateMember(function()
        {
          if (_uiContainer && typeof _uiContainerPrevStyle !== 'undefined' && _uiContainerPrevStyle !== null)
          {
            _uiContainer.setAttribute("style", _uiContainerPrevStyle);
          }
          _uiContainerPrevStyle = null;
        });

        /**
         * Starts a timer that will provide an update to the video controller wrapper of the ad's current time.
         * We use a timer because IMA does not provide us with a time update event.
         * @private
         * @method GoogleIMA#_startTimeUpdater
         */
        var _startTimeUpdater = privateMember(function()
        {
          _stopTimeUpdater();
          //starting an interval causes unit tests to throw a max call stack exceeded error
          if (!this.runningUnitTests)
          {
            _timeUpdater = setInterval(_.bind(function()
            {
              if(_linearAdIsPlaying)
              {
                this.videoControllerWrapper.raiseTimeUpdate(this.getCurrentTime(), this.getDuration());
              }
              else
              {
                _stopTimeUpdater();
              }
            }, this), TIME_UPDATER_INTERVAL);
          }
        });

        /**
         * Stops the timer that was started via _startTimeUpdater.
         * @private
         * @method GoogleIMA#_stopTimeUpdater
         */
        var _stopTimeUpdater = privateMember(function()
        {
          clearInterval(_timeUpdater);
          _timeUpdater = null;
        });

        /**
         * Tries to tell the Ad Manager Controller that this ad manager will determine when the video and ads end.
         * @private
         * @method GoogleIMA#_trySetupForAdRules
         */
        var _trySetupForAdRules = privateMember(function()
        {
          if (_usingAdRules)
          {
            _amc.adManagerWillControlAds(this.name);
          }
        });

        /**
         * Give control back to Ad Manager Controller for determining when all ads and video have played.
         * @private
         * @method GoogleIMA#_tryUndoSetupForAdRules
         */
        var _tryUndoSetupForAdRules = privateMember(function()
        {
          if (_usingAdRules && _amc)
          {
            _amc.adManagerDoneControllingAds(this.name);
          }
        });

        /**
         * Logs ad metric events.
         * @private
         * @method GoogleIMA#_onAdMetrics
         * @param {object} adEvent
         */
        var _onAdMetrics = privateMember(function(adEvent)
        {
          OO.log("Google IMA Ad playthrough", adEvent.type);
        });

        /**
         * Callback for EVENTS.CONTENT_CHANGED. Means new video is playing, so all ad data needs to be reset.
         * @private
         * @method GoogleIMA#_onContentChanged
         */
        var _onContentChanged = privateMember(function()
        {
          this.contentEnded = false;
          _tryUndoSetupForAdRules();
          _resetAdsState();
          _resetPlayheadTracker();
        });

        /**
         * Try to notify the AMC that an ad started to play.  Will fail if either the AMC
         * isn't in ad mode or if IMA hasn't started playing the ad.
         * @private
         * @method GoogleIMA#_tryStartAd
         */
        var _tryStartAd = privateMember(function()
        {
          var adTypeStarted = null;
          if (this.currentIMAAd && this.currentAMCAdPod)
          {
            if (this.currentIMAAd.isLinear())
            {
              adTypeStarted = _amc.ADTYPE.LINEAR_VIDEO;
              _startLinearAd();
            }
            else
            {
              adTypeStarted = _amc.ADTYPE.NONLINEAR_OVERLAY;
              _startNonLinearOverlay();
            }
          }
          return adTypeStarted;
        });

        /**
         * Notify the AMC that a linear ad has started to play.
         * @private
         * @method GoogleIMA#_startLinearAd
         */
        var _startLinearAd = privateMember(function()
        {
          if (!this.currentIMAAd)
          {
            _throwError("Trying to start linear ad and this.currentIMAAd is falsy");
          }

          if (!this.currentAMCAdPod)
          {
            _throwError("Trying to start linear ad and this.currentAMCAdPod is falsy");
          }

          var adId = this.currentAMCAdPod.id;

          var adProperties = {};

          //ad properties - actual values to be provided by IMA APIs, default values are set here
          var totalAdsInPod = 1;
          adProperties.indexInPod = 1;
          adProperties.name = null;
          adProperties.duration = 0;
          adProperties.hasClickUrl = false; //default to false because IMA does not provide any clickthrough APIs to us
          adProperties.skippable = false;

          try
          {
            var adPodInfo = this.currentIMAAd.getAdPodInfo();
            totalAdsInPod = adPodInfo.getTotalAds();
            adProperties.indexInPod = adPodInfo.getAdPosition();
          }
          catch(e)
          {
            _throwError("IMA ad returning bad value for this.currentIMAAd.getAdPodInfo().");
          }

          //Google may remove any of these APIs at a future point.
          //Note: getClickThroughUrl has been removed by Google
          if (typeof this.currentIMAAd.getTitle == "function")
          {
            adProperties.name = this.currentIMAAd.getTitle();
          }

          if (typeof this.currentIMAAd.getDuration == "function")
          {
            adProperties.duration = this.currentIMAAd.getDuration();
          }

          if (typeof this.currentIMAAd.isSkippable == "function")
          {
            adProperties.skippable = this.currentIMAAd.isSkippable();
          }

          if (adProperties.indexInPod == 1)
          {
            _amc.notifyPodStarted(adId, totalAdsInPod);
          }

          _checkCompanionAds(this.currentIMAAd);
          _amc.notifyLinearAdStarted(adId, adProperties);
        });

        /**
         * Switches from playing a linear ad to non-linear overlay (Because we don't
         * know what type of ad it is until it plays).
         * @private
         * @method GoogleIMA#_startNonLinearOverlay
         */
        var _startNonLinearOverlay = privateMember(function()
        {
          if (!this.currentAMCAdPod)
          {
            _throwError("Trying to start non linear overlay and this.currentAMCAdPod is falsy");
          }

          //notify that the fake ad has started
          _amc.notifyPodStarted(this.currentAMCAdPod.id);
          //we don't know the type of ad until it starts playing, we assume it's linear
          //but if it isn't then we need to tell the ad manager otherwise and resume playing
          var adData = {
            position_type: NON_AD_RULES_POSITION_TYPE,
            forced_ad_type: _amc.ADTYPE.NONLINEAR_OVERLAY
          };
          _checkCompanionAds(this.currentIMAAd);
          //end the request ad
          _endCurrentAd(true);
          _amc.forceAdToPlay(this.name, adData, _amc.ADTYPE.NONLINEAR_OVERLAY);
        });

        /**
         * Should be called when IMA has shown a non-linear ad rules ad.
         * Forcing this dummy ad through the AMC queue will raise the necessary
         * events for Ad Impression and it will also let the skin know that it
         * needs to show the ads container.
         * @private
         * @method GoogleIMA#_startNonLinearAdRulesOverlay
         */
        var _startNonLinearAdRulesOverlay = privateMember(function()
        {
          var adData = {
            position_type: AD_RULES_POSITION_TYPE,
            forced_ad_type: _amc.ADTYPE.NONLINEAR_OVERLAY
          };
          _checkCompanionAds(this.currentIMAAd);
          _amc.forceAdToPlay(this.name, adData, _amc.ADTYPE.NONLINEAR_OVERLAY);
        });

        /**
         * Stop overlay and prepare the ad manager to be able to request another ad.
         * @private
         * @method GoogleIMA#_stopNonLinearOverlay
         * @param adId the id of the overlay we are stopping
         */
        var _stopNonLinearOverlay = privateMember(function(adId)
        {
          _amc.notifyNonlinearAdEnded(adId);

          if (!_usingAdRules)
          {
            _resetAdsState();
          }
        });

        /**
         * Ends the current ad pod (linear or non linear) and notifies the Ad Manager
         * Controller that the whole ad pod has ended.
         * @private
         * @method GoogleIMA#_endCurrentAdPod
         * @param linear whether or not the ad pod was linear or overlay
         */
        var _endCurrentAdPod = privateMember(function(linear)
        {
          if (this.currentAMCAdPod)
          {
            var currentAMCAdPod = this.currentAMCAdPod;
            var adId = currentAMCAdPod.id;

            this.currentAMCAdPod = null;
            _linearAdIsPlaying = false;

            if (linear)
            {
              _amc.notifyPodEnded(adId);
            }
            else
            {
              _stopNonLinearOverlay(adId);
            }
          }
        });

        /**
         * Ends the current ad in an ad pod the Ad Manager Controller. If it's the
         * last ad in the pod or if forceEndAdPod is true, it also notifies the AMC
         * that the whole ad pod has ended.
         * @private
         * @method GoogleIMA#_endCurrentAd
         * @param forceEndAdPod forces the ad pod to end
         */
        var _endCurrentAd = privateMember(function(forceEndAdPod)
        {
          if (this.currentAMCAdPod)
          {
            if (this.currentIMAAd)
            {
              var currentIMAAd = this.currentIMAAd;
              this.currentIMAAd = null;
              if (currentIMAAd.isLinear())
              {
                var adPodInfo = currentIMAAd.getAdPodInfo();
                if(!adPodInfo)
                {
                  if (forceEndAdPod)
                  {
                    _endCurrentAdPod(true);
                  }
                  _throwError("IMA ad returning bad value for this.currentIMAAd.getAdPodInfo().");
                }

                _amc.notifyLinearAdEnded(this.currentAMCAdPod.id);

                var adPos = adPodInfo.getAdPosition();
                var totalAds = adPodInfo.getTotalAds();
                //IMA's ad position is 1 based not 0 based.  So last ad in a 3 ad pod will be position 3.

                //Wait until we receive content resume event from IMA before we end ad pod for
                //single video element mode. This is to workaround an issue where the video controller
                //and IMA are out of sync if we end ad pod too early for single video element mode
                if ((!_amc.ui.useSingleVideoElement && adPos == totalAds) || forceEndAdPod)
                {
                  _endCurrentAdPod(true);
                }
              }
              else
              {
                _endCurrentAdPod(this.currentAMCAdPod.isRequest);
              }
            }
            else
            {
              _endCurrentAdPod(true);
            }
          }

          _resetUIContainerStyle();
          this.currentIMAAd = null;
          this.adPlaybackStarted = false;
        });

        /**
         * Returns true if the google sdk has loaded correctly and has at least
         * defined AdDisplayContainer.
         * @private
         * @method GoogleIMA#_isGoogleSDKValid
         * @returns {boolean} True if AdDisplayContainer is defined.
         */
        var _isGoogleSDKValid = privateMember(function()
        {
          return (google && google.ima && google.ima.AdDisplayContainer);
        });

        this.registerVideoControllerWrapper = function(videoWrapper)
        {
          this.videoControllerWrapper = videoWrapper;
        }
      };

      var _throwError = function(outputStr)
      {
        //TODO consolidate code to exit gracefully if we have an error.
        throw new Error("GOOGLE IMA: " + outputStr);
      };

      return new GoogleIMA();
    });

    /**
     * @class GoogleIMAVideoFactory
     * @classdesc Factory for creating video player objects that use HTML5 video tags.
     * @property {string} name The name of the plugin
     * @property {boolean} ready The readiness of the plugin for use (true if elements can be created)
     * @property {object} streams An array of supported encoding types (ex. m3u8, mp4)
     */
    var GoogleIMAVideoFactory = function()
    {
      this.name = "GoogleIMAVideoTech";
      this.encodings = [OO.VIDEO.ENCODING.IMA];
      this.features = [OO.VIDEO.FEATURE.VIDEO_OBJECT_SHARING_TAKE];
      this.technology = OO.VIDEO.TECHNOLOGY.HTML5;

      /**
       * Creates a video player instance using GoogleIMAVideoWrapper.
       * @public
       * @method GoogleIMAVideoFactory#create
       * @param {object} parentContainer The jquery div that should act as the parent for the video element
       * @param {string} id The id of the video player instance to create
       * @param {object} ooyalaVideoController A reference to the video controller in the Ooyala player
       * @param {object} css The css to apply to the video element
       * @param {string} playerId The unique player identifier of the player creating this instance
       * @returns {object} A reference to the wrapper for the newly created element
       */
      this.create = function(parentContainer, id, ooyalaVideoController, css, playerId)
      {
        var googleIMA = registeredGoogleIMAManagers[playerId];
        var wrapper = new GoogleIMAVideoWrapper(googleIMA);
        wrapper.controller = ooyalaVideoController;
        wrapper.subscribeAllEvents();
        return wrapper;
      };

      /**
       * Creates a video player instance using GoogleIMAVideoWrapper which wraps and existing video element.
       * @public
       * @method GoogleIMAVideoFactory#createFromExisting
       * @param {string} domId The dom id of the video DOM object to use
       * @param {object} ooyalaVideoController A reference to the video controller in the Ooyala player
       * @param {string} playerId The unique player identifier of the player creating this instance
       * @returns {object} A reference to the wrapper for the video element
       */
      this.createFromExisting = function(domId, ooyalaVideoController, playerId)
      {
        var googleIMA = registeredGoogleIMAManagers[playerId];
        googleIMA.setupSharedVideoElement($("#" + domId)[0]);
        var wrapper = new GoogleIMAVideoWrapper(googleIMA);
        wrapper.controller = ooyalaVideoController;
        wrapper.subscribeAllEvents();
        return wrapper;
      };

      /**
       * Destroys the video technology factory.
       * @public
       * @method GoogleIMAVideoFactory#destroy
       */
      this.destroy = function()
      {
        this.encodings = [];
        this.create = function() {};
        this.createFromExisting = function() {};
      };

      /**
       * Represents the max number of support instances of video elements that can be supported on the
       * current platform. -1 implies no limit.
       * @public
       * @property GoogleIMAVideoFactory#maxSupportedElements
       */
      this.maxSupportedElements = -1;
    };

    /**
     * @class GoogleIMAVideoWrapper
     * @classdesc Player object that wraps the video element.
     * @param {object} ima The GoogleIMA object this will communicate with
     * @property {object} controller A reference to the Ooyala Video Tech Controller
     * @property {boolean} disableNativeSeek When true, the plugin should supress or undo seeks that come from
     *                                       native video controls
     * @property {boolean} readyForCss When true, css may be applied on the video element.  When false, css
     *                                 should be stored for use later when this value is true.
     */
    var GoogleIMAVideoWrapper = function(ima)
    {
      var _ima = ima;

      this.controller = {};
      this.disableNativeSeek = true;
      this.isControllingVideo = true;
      this.readyForCss = false;
      var storedCss = null;

      /************************************************************************************/
      // Required. Methods that Video Controller, Destroy, or Factory call
      /************************************************************************************/

      /**
       * Takes control of the video element from another plugin.
       * @public
       * @method GoogleIMAVideoWrapper#sharedElementGive
       */
      this.sharedElementTake = function() {
        this.isControllingVideo = true;
      };

      /**
       * Hands control of the video element off to another plugin.
       * @public
       * @method GoogleIMAVideoWrapper#sharedElementGive
       */
      this.sharedElementGive = function() {
        this.isControllingVideo = false;
      };

      /**
       * Subscribes to all events raised by the video element.
       * This is called by the Factory during creation.
       * @public
       * @method GoogleIMAVideoWrapper#subscribeAllEvents
       */
      this.subscribeAllEvents = function()
      {
        _ima.registerVideoControllerWrapper(this);
      };

      /**
       * Sets the url of the video.
       * @public
       * @method GoogleIMAVideoWrapper#setVideoUrl
       * @param {string} url The new url to insert into the video element's src attribute
       * @param {string} encoding The encoding of video stream, possible values are found in OO.VIDEO.ENCODING (unused here)
       * @param {boolean} live True if it is a live asset, false otherwise (unused here)
       * @returns {boolean} True or false indicating success
       */
      this.setVideoUrl = function(url)
      {
        return true;
      };

      /**
       * Loads the current stream url in the video element; the element should be left paused.
       * @public
       * @method GoogleIMAVideoWrapper#load
       * @param {boolean} rewind True if the stream should be set to time 0
       */
      this.load = function(rewind)
      {
      };

      /**
       * Sets the initial time of the video playback.
       * @public
       * @method GoogleIMAVideoWrapper#setInitialTime
       * @param {number} initialTime The initial time of the video (seconds)
       */
      this.setInitialTime = function(initialTime)
      {
      };

      /**
       * Triggers playback on the video element.
       * @public
       * @method GoogleIMAVideoWrapper#play
       */
      this.play = function()
      {
        _ima.resumeAd();
      };

      /**
       * Triggers a pause on the video element.
       * @public
       * @method GoogleIMAVideoWrapper#pause
       */
      this.pause = function()
      {
        _ima.pauseAd();
      };

      /**
       * Triggers a seek on the video element.
       * @public
       * @method GoogleIMAVideoWrapper#seek
       * @param {number} time The time to seek the video to (in seconds)
       */
      this.seek = function(time)
      {
      };

      /**
       * Triggers a volume change on the video element.
       * @public
       * @method GoogleIMAVideoWrapper#setVolume
       * @param {number} volume A number between 0 and 1 indicating the desired volume percentage
       */
      this.setVolume = function(volume)
      {
        _ima.setVolume(volume);
      };

      /**
       * Gets the current time position of the video.
       * @public
       * @method GoogleIMAVideoWrapper#getCurrentTime
       * @returns {number} The current time position of the video (seconds)
       */
      this.getCurrentTime = function()
      {
        var time = _ima.getCurrentTime();
        return time;
      };

      /**
       * Applies the given css to the video element.
       * @public
       * @method GoogleIMAVideoWrapper#applyCss
       * @param {object} css The css to apply in key value pairs
       */
      this.applyCss = function(css)
      {
        if (!this.readyForCss)
        {
          storedCss = css;
        }
        else
        {
          applyCssToElement(css);
        }
      };

      /**
       * Triggers application of css changes that have been previously stored.
       * @public
       * @method GoogleIMAVideoWrapper#applyStoredCss
       */
      this.applyStoredCss = function()
      {
        this.applyCss(storedCss);
      };

      /**
       * Callback to handle notifications that ad finished playing
       * @private
       * @method GoogleIMAVideoWrapper#onAdsPlayed
       */
      this.onAdsPlayed = function() {
      };

      /**
       * Does the application of css to the video element if the video element is shared and under ima control.
       * @private
       * @method GoogleIMAVideoWrapper#applyCssToElemenet
       */
      var applyCssToElement = _.bind(function(css)
      {
        if (css && this.isControllingVideo && _ima.sharedVideoElement) {
          $(_ima.sharedVideoElement).css(css);
        }
      }, this);

      /**
       * Destroys the individual video element.
       * @public
       * @method GoogleIMAVideoWrapper#destroy
       */
      this.destroy = function()
      {
        _ima.sharedVideoElement = null;
      };

      /**
       * Calls the controller notify function only if the video wrapper is controlling the video element.
       * @private
       * @method GoogleIMAVideoWrapper#notifyIfInControl
       * @param {string} event The event to raise to the video controller
       * @param {object} params [optional] Event parameters
       */
      var notifyIfInControl = _.bind(function(event, params) {
        if (this.isControllingVideo) {
          this.controller.notify(event, params);
        }
      }, this);

      //Events
      this.raisePlayEvent = function()
      {
        notifyIfInControl(this.controller.EVENTS.PLAY, {});
        notifyIfInControl(this.controller.EVENTS.PLAYING);
      };

      this.raiseEndedEvent = function()
      {
        notifyIfInControl(this.controller.EVENTS.ENDED);
      };

      this.raisePauseEvent = function()
      {
        notifyIfInControl(this.controller.EVENTS.PAUSED);
      };

      this.raiseFullScreenEvent = function()
      {
        notifyIfInControl(this.controller.EVENTS.FULLSCREEN_CHANGED);
      };

      this.raiseVolumeEvent = function()
      {
        var volume = _ima.getVolume();
        notifyIfInControl(this.controller.EVENTS.VOLUME_CHANGE, { "volume" : volume });
      };

      this.raiseTimeUpdate = function(currentTime, duration)
      {
        raisePlayhead(this.controller.EVENTS.TIME_UPDATE, currentTime, duration);
      };

      this.raiseDurationChange = function(currentTime, duration)
      {
        raisePlayhead(this.controller.EVENTS.DURATION_CHANGE, currentTime, duration);
      };

      var raisePlayhead = _.bind(function(eventname, currentTime, duration)
      {
        notifyIfInControl(eventname,
          { "currentTime" : currentTime,
            "duration" : duration,
            "buffer" : 0,
            "seekRange" : { "begin" : 0, "end" : 0 } });
      }, this);
    };

    OO.Video.plugin(new GoogleIMAVideoFactory());
  }(OO._, OO.$));

},{"../html5-common/js/utils/InitModules/InitOOUnderscore.js":2,"../html5-common/js/utils/constants.js":3,"../html5-common/js/utils/utils.js":4}]},{},[6]);