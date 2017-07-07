/********************************************************************
 CONTROLLER
 *********************************************************************/
// WIKIA CHANGE - START
require('./components/deepMerge');
var DeepMerge = window.ooyalaDeepMerge;
// WIKIA CHANGE - END

var React = require('react'),
    ReactDOM = require('react-dom'),
    Utils = require('./components/utils'),
    CONSTANTS = require('./constants/constants'),
    AccessibilityControls = require('./components/accessibilityControls'),
    Fullscreen = require('screenfull'),
    Skin = require('./skin'),
    SkinJSON = require('../config/skin'),
    Bulk = require('bulk-require'),
    Localization = Bulk('./config', ['languageFiles/*.json']),
    Cookies = require('js-cookie');

OO.plugin("Html5Skin", function (OO, _, $, W) {
  //Check if the player is at least v4. If not, the skin cannot load.
  if (!OO.playerParams.core_version || OO.playerParams.core_version <= 3) {
    console.error("Html5Skin requires at least player version 4.");
    return null;
  }

  if (OO.publicApi && OO.publicApi.VERSION) {
    // This variable gets filled in by the build script
    OO.publicApi.VERSION.skin = {"releaseVersion": "4.14.8", "rev": "<SKIN_REV>"};
  }

  // WIKIA CHANGE - START
  OO.EVENTS.WIKIA = {
    AUTOPLAY_TOGGLED: 'wikia.autoplayToggled',
    SHOW_AD_TIME_LEFT: 'wikia.showAdTimeLeft',
    SHOW_AD_FULLSCREEN_TOGGLE: 'wikia.showAdFullScreenToggle',
  };
  OO.exposeStaticApi('EVENTS', OO.EVENTS);
  // WIKIA CHANGE - END

  var autoplayCookieName = 'html5-skin.autoplay',
    autoplayCookieExpireDays = 14,
    Html5Skin = function (mb, id) {
      this.mb = mb;
      this.id = id;
      this.state = {
        "playerParam": {},
        "skinMetaData": {},
      "attributes": {},
      "persistentSettings": {
          "closedCaptionOptions": {},
        },
        "assetId": null,
        "contentTree": {},
        "thumbnails": null,
        "isLiveStream": false,
        "screenToShow": null,
        "playerState": null,
        "discoveryData": null,
        "forceCountDownTimerOnEndScreen": false,
      "isPlayingAd": false,
        "adOverlayUrl": null,
        "showAdOverlay": false,
        "showAdOverlayCloseButton": false,
        "showAdControls": true,
        "showAdMarquee": true,
        "isOoyalaAds": false,
      "afterOoyalaAd": false,
      "configLoaded": false,
        "config": {},
        "customSkinJSON": {},
      "fullscreen": false,
        "pauseAnimationDisabled": false,
        "adPauseAnimationDisabled": true,
        "pausedCallback": null,
        "seeking": false,
        "queuedPlayheadUpdate": null,
        "accessibilityControlsEnabled": false,
        "duration": 0,
        "mainVideoDuration": 0,
        "adVideoDuration": 0,
        "adStartTime": 0,
        "elementId": null,
        "mainVideoContainer": null,
        "mainVideoInnerWrapper": null,
        "mainVideoElement": null,
        "mainVideoMediaType": null,
        "mainVideoAspectRatio": 0,
        "pluginsElement": null,
        "pluginsClickElement": null,
        "buffering": false,
        "mainVideoBuffered": null,
        "mainVideoPlayhead": 0,
      "adVideoPlayhead": 0,
        "focusedElement": null,

        "currentAdsInfo": {
          "currentAdItem": null,
          "numberOfAds": 0,
          "skipAdButtonEnabled": false
        },

        "closedCaptionsInfoCache": {},
        "closedCaptionOptions": {
          "enabled": null,
          "language": null,
          "availableLanguages": null,
          "cueText": null,
          "showClosedCaptionPopover": false,
          "textColor": null,
          "windowColor": null,
          "backgroundColor": null,
          "textOpacity": null,
          "backgroundOpacity": null,
          "windowOpacity": null,
          "fontType": null,
          "fontSize": null,
          "textEnhancement": null
        },

        "videoQualityOptions": {
          "availableBitrates": null,
          "selectedBitrate": null,
          "showVideoQualityPopover":false
        },

        // WIKIA CHANGE - START
        "autoPlay": {
          "enabled": false
        },

        "configPanelOptions": {
            "availableBitrates": null,
            "selectedBitrate": null,
            "showVideoQualityPanel":false,
            "showConfigPanelPopover": false
        },
        // WIKIA CHANGE - END

        "volumeState": {
          "volume": 1,
          "muted": false,
          "oldVolume": 1,
          "volumeSliderVisible": false
        },

        "upNextInfo": {
          "upNextData": null,
          "countDownFinished": false,
          "countDownCancelled": false,
          "timeToShow": 0,
          "showing": false,
          "delayedSetEmbedCodeEvent": false,
          "delayedContentData": null
        },

        "moreOptionsItems": null,

        "isMobile": false,
        "controlBarVisible": true,
        "forceControlBarVisible": false,
        "timer": null,
        "errorCode": null,
        "isSubscribed": false,
        "isPlaybackReadySubscribed": false,
        "isSkipAdClicked": false,
        "isInitialPlay": false,
        "isFullScreenSupported": false,
        "isVideoFullScreenSupported": false,
        "isFullWindow": false,
        "autoPauseDisabled": false,
        // WIKIA CHANGE - START
        "showAdTimeLeft": true,
        "showAdFullScreenToggle": true
        // WIKIA CHANGE - END
      };

      this.init();
  };

  Html5Skin.prototype = {
    init: function () {
      // player events
      this.mb.subscribe(OO.EVENTS.PLAYER_CREATED, 'customerUi', _.bind(this.onPlayerCreated, this));
      this.mb.subscribe(OO.EVENTS.VC_VIDEO_ELEMENT_CREATED, 'customerUi', _.bind(this.onVcVideoElementCreated, this));
      this.mb.subscribe(OO.EVENTS.DESTROY, 'customerUi', _.bind(this.onPlayerDestroy, this));
      this.mb.subscribe(OO.EVENTS.EMBED_CODE_CHANGED, 'customerUi', _.bind(this.onEmbedCodeChanged, this));
      this.mb.subscribe(OO.EVENTS.EMBED_CODE_CHANGED_AFTER_OOYALA_AD, 'customerUi', _.bind(this.onEmbedCodeChangedAfterOoyalaAd, this));
      this.mb.subscribe(OO.EVENTS.CONTENT_TREE_FETCHED, 'customerUi', _.bind(this.onContentTreeFetched, this));
      this.mb.subscribe(OO.EVENTS.THUMBNAILS_FETCHED, 'customerUi', _.bind(this.onThumbnailsFetched, this));//xenia: to be replaced by a more appropriate event
      this.mb.subscribe(OO.EVENTS.AUTHORIZATION_FETCHED, 'customerUi', _.bind(this.onAuthorizationFetched, this));
      this.mb.subscribe(OO.EVENTS.SKIN_METADATA_FETCHED, 'customerUi', _.bind(this.onSkinMetaDataFetched, this));
      this.mb.subscribe(OO.EVENTS.ATTRIBUTES_FETCHED, 'customerUi', _.bind(this.onAttributesFetched, this));
      this.mb.subscribe(OO.EVENTS.ASSET_CHANGED, 'customerUi', _.bind(this.onAssetChanged, this));
      this.mb.subscribe(OO.EVENTS.ASSET_UPDATED, 'customerUi', _.bind(this.onAssetUpdated, this));
      this.mb.subscribe(OO.EVENTS.PLAYBACK_READY, 'customerUi', _.bind(this.onPlaybackReady, this));
      this.mb.subscribe(OO.EVENTS.ERROR, "customerUi", _.bind(this.onErrorEvent, this));
      this.mb.addDependent(OO.EVENTS.PLAYBACK_READY, OO.EVENTS.UI_READY);
      this.state.isPlaybackReadySubscribed = true;
    },

    subscribeBasicPlaybackEvents: function () {
      if(!this.state.isSubscribed) {
        this.mb.subscribe(OO.EVENTS.SEND_QUALITY_CHANGE, 'customerUi', _.bind(this.receiveVideoQualityChangeEvent, this));
        this.mb.subscribe(OO.EVENTS.INITIAL_PLAY, 'customerUi', _.bind(this.onInitialPlay, this));
        this.mb.subscribe(OO.EVENTS.VC_PLAYED, 'customerUi', _.bind(this.onVcPlayed, this));
        this.mb.subscribe(OO.EVENTS.VC_PLAYING, 'customerUi', _.bind(this.onPlaying, this));
        this.mb.subscribe(OO.EVENTS.VC_PAUSED, 'customerUi', _.bind(this.onPaused, this));
        this.mb.subscribe(OO.EVENTS.VC_PAUSE, 'customerUi', _.bind(this.onPause, this));
        this.mb.subscribe(OO.EVENTS.PLAYED, 'customerUi', _.bind(this.onPlayed, this));
        this.mb.subscribe(OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'customerUi', _.bind(this.onPlayheadTimeChanged, this));
        this.mb.subscribe(OO.EVENTS.SEEKED, 'customerUi', _.bind(this.onSeeked, this));
        this.mb.subscribe(OO.EVENTS.BUFFERING, 'customerUi', _.bind(this.onBuffering, this));
        this.mb.subscribe(OO.EVENTS.BUFFERED, 'customerUi', _.bind(this.onBuffered, this));
        this.mb.subscribe(OO.EVENTS.CLOSED_CAPTIONS_INFO_AVAILABLE, "customerUi", _.bind(this.onClosedCaptionsInfoAvailable, this));
        this.mb.subscribe(OO.EVENTS.BITRATE_INFO_AVAILABLE, "customerUi", _.bind(this.onBitrateInfoAvailable, this));
        this.mb.subscribe(OO.EVENTS.CLOSED_CAPTION_CUE_CHANGED, "customerUi", _.bind(this.onClosedCaptionCueChanged, this));
        this.mb.subscribe(OO.EVENTS.CHANGE_CLOSED_CAPTION_LANGUAGE, 'customerUi', _.bind(this.onChangeClosedCaptionLanguage, this));
        this.mb.subscribe(OO.EVENTS.VOLUME_CHANGED, "customerUi", _.bind(this.onVolumeChanged, this));
        this.mb.subscribe(OO.EVENTS.VC_VIDEO_ELEMENT_IN_FOCUS, "customerUi", _.bind(this.onVideoElementFocus, this));
        this.mb.subscribe(OO.EVENTS.REPLAY, "customerUi", _.bind(this.onReplay, this));
        this.mb.subscribe(OO.EVENTS.ASSET_DIMENSION, "customerUi", _.bind(this.onAssetDimensionsReceived, this));
        // PLAYBACK_READY is a fundamental event in the init process that can be unsubscribed by errors.
        // If and only if such has occured, it needs a route to being resubscribed.
        if(!this.state.isPlaybackReadySubscribed) {
          this.mb.subscribe(OO.EVENTS.PLAYBACK_READY, 'customerUi', _.bind(this.onPlaybackReady, this));
        }

        // ad events
        if (!Utils.isIPhone()) {
          //since iPhone is always playing in full screen and not showing our skin, don't need to render skin
          this.mb.subscribe(OO.EVENTS.ADS_PLAYED, "customerUi", _.bind(this.onAdsPlayed, this));
          this.mb.subscribe(OO.EVENTS.WILL_PLAY_ADS , "customerUi", _.bind(this.onWillPlayAds, this));
          this.mb.subscribe(OO.EVENTS.AD_POD_STARTED, "customerUi", _.bind(this.onAdPodStarted, this));
          this.mb.subscribe(OO.EVENTS.WILL_PLAY_SINGLE_AD , "customerUi", _.bind(this.onWillPlaySingleAd, this));
          this.mb.subscribe(OO.EVENTS.SINGLE_AD_PLAYED , "customerUi", _.bind(this.onSingleAdPlayed, this));
          this.mb.subscribe(OO.EVENTS.PLAY_NONLINEAR_AD, "customerUi", _.bind(this.onPlayNonlinearAd, this));
          this.mb.subscribe(OO.EVENTS.NONLINEAR_AD_PLAYED, "customerUi", _.bind(this.closeNonlinearAd, this));
          this.mb.subscribe(OO.EVENTS.HIDE_NONLINEAR_AD, "customerUi", _.bind(this.hideNonlinearAd, this));
          this.mb.subscribe(OO.EVENTS.SHOW_NONLINEAR_AD, "customerUi", _.bind(this.showNonlinearAd, this));
          this.mb.subscribe(OO.EVENTS.SHOW_NONLINEAR_AD_CLOSE_BUTTON, "customerUi", _.bind(this.showNonlinearAdCloseButton, this));
          this.mb.subscribe(OO.EVENTS.SHOW_AD_SKIP_BUTTON, "customerUi", _.bind(this.onShowAdSkipButton, this));
          this.mb.subscribe(OO.EVENTS.SHOW_AD_CONTROLS, "customerUi", _.bind(this.onShowAdControls, this));
          this.mb.subscribe(OO.EVENTS.SHOW_AD_MARQUEE, "customerUi", _.bind(this.onShowAdMarquee, this));
          // WIKIA CHANGE - START
          this.mb.subscribe(OO.EVENTS.WIKIA.SHOW_AD_TIME_LEFT, "customerUi", _.bind(this.onShowAdTimeLeft, this));
          this.mb.subscribe(OO.EVENTS.WIKIA.SHOW_AD_FULLSCREEN_TOGGLE, "customerUi", _.bind(this.onShowAdFullScreenToggle, this));
          // WIKIA CHANGE - END
        }
      }
      this.state.isSubscribed = true;
    },

    externalPluginSubscription: function() {
      if (OO.EVENTS.DISCOVERY_API) {
        this.mb.subscribe(OO.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED, "customerUi", _.bind(this.onRelatedVideosFetched, this));
      }
    },

    /*--------------------------------------------------------------------
     event listeners from core player -> regulate skin STATE
     ---------------------------------------------------------------------*/
    onPlayerCreated: function (event, elementId, params, settings) {
      //subscribe to plugin events
      this.externalPluginSubscription();

      //set state variables
      this.state.mainVideoContainer = $("#" + elementId);
      this.state.mainVideoInnerWrapper = $("#" + elementId + " .innerWrapper");
      this.state.playerParam = params;
      this.state.persistentSettings = settings;
      this.state.elementId = elementId;
      this.state.isMobile = Utils.isMobile();
      this.state.browserSupportsTouch = Utils.browserSupportsTouch();

      //initial DOM manipulation
      this.state.mainVideoContainer.addClass('oo-player-container');
      // WIKIA CHANGE - START
      if (params.autoplay && this.state.isMobile) {
        // set autoplay data attribute which is read by main_html5 plugin
        this.state.mainVideoInnerWrapper.attr('data-autoplay', 'autoplay');
        this.state.volumeState.muted = true;
        this.state.volumeState.volume = 0;
        this.state.volumeState.oldVolume = 1;
        this.setVolume(0);
      }
      // WIKIA CHANGE - END
      this.state.mainVideoInnerWrapper.addClass('oo-player');
      this.state.mainVideoInnerWrapper.append("<div class='oo-player-skin'></div>");

      //load player with page level config param if exist
      if (params.skin && params.skin.config) {
        $.getJSON(params.skin.config, function(data) {
          this.state.customSkinJSON = data;
          this.loadConfigData(this.state.playerParam, this.state.persistentSettings, data, this.state.skinMetaData);
        }.bind(this));
      } else {
        this.loadConfigData(this.state.playerParam, this.state.persistentSettings, this.state.customSkinJSON, this.state.skinMetaData);
      }

      this.accessibilityControls = new AccessibilityControls(this); //keyboard support
      this.state.screenToShow = CONSTANTS.SCREEN.LOADING_SCREEN;
    },

    onVcVideoElementCreated: function(event, params) {
      var videoElement = params.videoElement;
      videoElement = this.findMainVideoElement(videoElement);

      //add loadedmetadata event listener to main video element
      if (videoElement) {
        videoElement.addEventListener("loadedmetadata", this.metaDataLoaded.bind(this));
      }

      if (Utils.isIE10()) {
        videoElement.attr("controls", "controls");
      }

      if (params.videoId === OO.VIDEO.MAIN) {
        this.state.mainVideoElement = videoElement;
        this.enableFullScreen();
        this.updateAspectRatio();
      }
    },

    // functions dependent on video metadata
    metaDataLoaded: function () {
      this.enableIosFullScreen();
    },

    onPlayerDestroy: function (event) {
      var elementId = this.state.elementId;
      var mountNode = document.querySelector('#' + elementId + ' .oo-player-skin');
      // remove mounted Skin component
      if (mountNode) {
        ReactDOM.unmountComponentAtNode(mountNode);
      }
      this.cleanUpEventListeners()
      this.mb = null;
    },

    cleanUpEventListeners : function() {
      this.accessibilityControls.cleanUp()
    },

    onEmbedCodeChangedAfterOoyalaAd: function(event, embedCode, options) {
      if (options) {
        this.state.playerParam = DeepMerge(this.state.playerParam, options);
      }
      this.state.isOoyalaAds = false;
      this.state.afterOoyalaAd = true;
    },

    onEmbedCodeChanged: function(event, embedCode, options) {
      this.state.videoQualityOptions.availableBitrates = null;
      this.state.videoQualityOptions.selectedBitrate = null;
      this.state.closedCaptionOptions.availableLanguages = null;
      this.state.closedCaptionOptions.cueText = null;
      this.state.closedCaptionsInfoCache = {};
      this.state.discoveryData = null;
      this.state.thumbnails = null;
      this.state.afterOoyalaAd = false;
      this.resetUpNextInfo(true);

      if (options && options.ooyalaAds === true) {
        this.state.isOoyalaAds = true;
      } else {
        this.state.isOoyalaAds = false;
      }

      this.state.assetId = embedCode;
      if (options) {
        this.state.playerParam = DeepMerge(this.state.playerParam, options);
      }
      this.subscribeBasicPlaybackEvents();
    },

    onAuthorizationFetched: function(event, authorization) {
      this.state.isLiveStream = authorization.streams[0].is_live_stream;
    },

    onContentTreeFetched: function (event, contentTree) {
      this.state.contentTree = contentTree;
      this.state.playerState = CONSTANTS.STATE.START;
      this.renderSkin({"contentTree": contentTree});
    },

    onSkinMetaDataFetched: function (event, skinMetaData) {
      this.state.skinMetaData = skinMetaData;
      this.loadConfigData(this.state.playerParam, this.state.persistentSettings, this.state.customSkinJSON, this.state.skinMetaData);
    },

    onAttributesFetched: function (event, attributes) {
      this.state.attributes = attributes;
      // This is the first point at which we know whether the video is anamorphic or not,
      // apply fix if necessary
      this.trySetAnamorphicFixState(true);
    },

    onThumbnailsFetched: function (event, thumbnails) {
      this.state.thumbnails = thumbnails;
    },

    onAssetChanged: function (event, asset) {
      this.state.videoQualityOptions.availableBitrates = null;
      this.state.closedCaptionOptions.availableLanguages = null;
      this.state.closedCaptionsInfoCache = {};
      this.state.discoveryData = null;
      this.subscribeBasicPlaybackEvents();

      this.resetUpNextInfo(true);
      this.state.isOoyalaAds = false;

      this.state.isLiveStream = asset.content.streams[0].is_live_stream;

      var contentTree  = {};
      contentTree.title = asset.content.title;
      contentTree.description = asset.content.description;
      contentTree.duration = asset.content.duration;
      contentTree.promo_image = asset.content.posterImages[0].url;

      this.state.contentTree = contentTree;
      this.state.playerState = CONSTANTS.STATE.START;
      this.renderSkin({"contentTree": contentTree});
    },

    onAssetUpdated: function (event, asset) {
      this.resetUpNextInfo(true);

      this.state.isLiveStream = asset.content.streams[0].is_live_stream;

      this.state.contentTree.title = asset.content.title;
      this.state.contentTree.description = asset.content.description;
      this.state.contentTree.duration = asset.content.duration;
      this.state.contentTree.promo_image = asset.content.posterImages[0].url;

      this.renderSkin({"contentTree": this.state.contentTree});
    },

    onVolumeChanged: function (event, newVolume) {
      if (newVolume <= 0) {
        this.state.volumeState.muted = true;
        this.state.volumeState.volume = 0;
      } else {
        this.state.volumeState.muted = false;
        this.state.volumeState.volume = newVolume;
      }
      this.renderSkin();
    },

    resetUpNextInfo: function (purge) {
      if (purge) {
        this.state.upNextInfo.upNextData = null;
      }
      this.state.upNextInfo.countDownFinished = false;
      this.state.upNextInfo.countDownCancelled = false;
    },

    onPlayheadTimeChanged: function(event, currentPlayhead, duration, buffered, startEnd, videoId) {
      if (videoId == OO.VIDEO.MAIN) {
        this.state.mainVideoPlayhead = currentPlayhead;
        this.state.mainVideoDuration = duration;
        this.state.mainVideoBuffered = buffered;
      }
      else if (videoId == OO.VIDEO.ADS) {
        //adVideoDuration is only used in adPanel ad marquee
        this.state.adVideoDuration = duration;
        this.state.adVideoPlayhead = currentPlayhead;
      }
      this.state.duration = duration;

      // lower skin z-index if Chrome auto-pauses flash content
      if(!this.state.autoPauseDisabled && Utils.isChrome() && this.state.mainVideoMediaType == CONSTANTS.MEDIA_TYPE.FLASH) {
        var skinElement = $("#"+this.state.elementId+" .oo-player-skin");
        if(currentPlayhead == 0 && this.state.playerState == CONSTANTS.STATE.PLAYING) {
          skinElement.addClass('oo-z-index-auto');
        } else {
          skinElement.removeClass('oo-z-index-auto');
          this.state.autoPauseDisabled = true;
        }
      }

      // The code inside if statement is only for up next, however, up next does not apply to Ad screen.
      // So we only need to update the playhead for ad screen.
      if (this.state.screenToShow !== CONSTANTS.SCREEN.AD_SCREEN ) {
        if (this.skin.props.skinConfig.upNext.showUpNext) {
          if (!(Utils.isIPhone() || (Utils.isIos() && this.state.fullscreen))){//no UpNext for iPhone or fullscreen iPad
            this.showUpNextScreenWhenReady(currentPlayhead, duration);
          }
        } else if (this.state.playerState === CONSTANTS.STATE.PLAYING) {
          this.state.screenToShow = CONSTANTS.SCREEN.PLAYING_SCREEN;
        } else if (this.state.playerState === CONSTANTS.STATE.PAUSE) {
          this.state.screenToShow = CONSTANTS.SCREEN.PAUSE_SCREEN;
        }
      }
      if (!this.state.seeking) {
        this.skin.updatePlayhead(currentPlayhead, duration, buffered, this.state.adVideoPlayhead);
      } else {
        this.state.queuedPlayheadUpdate = [currentPlayhead, duration, buffered];
      }
    },

    showUpNextScreenWhenReady: function(currentPlayhead, duration) {
      var timeToShow = this.skin.props.skinConfig.upNext.timeToShow;

      if (timeToShow < 1){
        // time to show is based on percentage of duration from the beginning
        timeToShow = (1 - timeToShow) * duration;
      }

      this.state.upNextInfo.timeToShow = timeToShow;

      if ((this.state.mainVideoPlayhead != 0 && currentPlayhead != 0) && duration !==0 &&
        duration - currentPlayhead <= timeToShow &&
        !this.state.upNextInfo.countDownCancelled &&
        this.state.isPlayingAd !== true &&
        this.state.upNextInfo.upNextData !== null && (this.state.playerState === CONSTANTS.STATE.PLAYING || this.state.playerState === CONSTANTS.STATE.PAUSE)) {
        // Trigger discovery event only the first time we
        // switch from hidden to showing
        if (!this.state.upNextInfo.showing) {
          var upNextEmbedCode = Utils.getPropertyValue(this.state.upNextInfo, "upNextData.embed_code");
          this.sendDiscoveryDisplayEvent("endScreen", upNextEmbedCode);
        }
        this.state.upNextInfo.showing = true;
      }
      else {
        this.state.upNextInfo.showing = false;
      }
    },

    onInitialPlay: function() {
      this.state.isInitialPlay = true;
      this.startHideControlBarTimer();
    },

    onPlaying: function(event, source) {
      if (source == OO.VIDEO.MAIN) {
        //set mainVideoElement if not set during video plugin initialization
        if (!this.state.mainVideoMediaType) {
          this.state.mainVideoElement = this.findMainVideoElement(this.state.mainVideoElement);
        }
        this.state.pauseAnimationDisabled = false;
        this.state.screenToShow = CONSTANTS.SCREEN.PLAYING_SCREEN;
        this.state.playerState = CONSTANTS.STATE.PLAYING;
        this.setClosedCaptionsLanguage();
        this.state.mainVideoElement.classList.remove('oo-blur');
        this.state.isInitialPlay = false;
        this.renderSkin();
      }
      if (source == OO.VIDEO.ADS) {
        this.state.buffering = false;
        this.state.adPauseAnimationDisabled = true;
        this.state.pluginsElement.addClass("oo-showing");
        this.state.pluginsClickElement.removeClass("oo-showing");
        if (this.state.currentAdsInfo.currentAdItem !== null) {
          this.state.playerState = CONSTANTS.STATE.PLAYING;
          //Set the screen to ad screen in case current screen does not involve video playback, such as discovery
          this.state.screenToShow = CONSTANTS.SCREEN.AD_SCREEN;
          this.renderSkin();
        }
      }
    },

    onPause: function(event, source, pauseReason) {
      if (pauseReason === CONSTANTS.PAUSE_REASON.TRANSITION){
        this.state.pauseAnimationDisabled = true;
        this.endSeeking();
      }
      // If an ad using the custom ad element has issued a pause, activate the click layer
      if (source == OO.VIDEO.ADS && this.state.pluginsElement.children().length > 0) {
        this.state.pluginsClickElement.addClass("oo-showing");
      }
    },

    onPaused: function(event, videoId) {
      if (videoId != this.focusedElement || this.state.screenToShow == CONSTANTS.SCREEN.END_SCREEN) { return; }
      if (videoId == OO.VIDEO.MAIN && this.state.screenToShow != CONSTANTS.SCREEN.AD_SCREEN && this.state.screenToShow != CONSTANTS.SCREEN.LOADING_SCREEN) {
        if (this.state.duration - this.state.mainVideoPlayhead < 0.01) { //when video ends, we get paused event before played event
          this.state.pauseAnimationDisabled = true;
        }
        if (this.state.pauseAnimationDisabled == false && this.state.discoveryData && this.skin.props.skinConfig.pauseScreen.screenToShowOnPause === "discovery"
            && !(Utils.isIPhone() || (Utils.isIos() && this.state.fullscreen))) {
          OO.log("Should display DISCOVERY_SCREEN on pause");
          this.sendDiscoveryDisplayEvent("pauseScreen");
          this.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
        } else if (this.skin.props.skinConfig.pauseScreen.screenToShowOnPause === "social") {
          // Remove this comment once pause screen implemented
        } else {
          // default
          this.state.screenToShow = CONSTANTS.SCREEN.PAUSE_SCREEN;
        }
        if (Utils.isIPhone()){
          //iPhone pause screen is the same as start screen
          this.state.screenToShow = CONSTANTS.SCREEN.PAUSE_SCREEN;
        }
        this.state.playerState = CONSTANTS.STATE.PAUSE;
        this.state.mainVideoElement.classList.add('oo-blur');
        this.renderSkin();
      }
      else if (videoId == OO.VIDEO.ADS){
        this.state.adPauseAnimationDisabled = false;
        this.state.playerState = CONSTANTS.STATE.PAUSE;
        this.renderSkin();
      }
      if (this.pausedCallback) {
        this.pausedCallback();
        this.pausedCallback = null;
      }
    },

    onPlayed: function() {
      var duration = this.state.mainVideoDuration;
      this.state.duration = duration;
      this.skin.updatePlayhead(duration, duration, duration);

      if (this.state.upNextInfo.delayedSetEmbedCodeEvent) {
        var delayedContentData = this.state.upNextInfo.delayedContentData;
        this.state.screenToShow = CONSTANTS.SCREEN.LOADING_SCREEN;

        if (delayedContentData.clickedVideo.embed_code){
          this.mb.publish(OO.EVENTS.SET_EMBED_CODE, delayedContentData.clickedVideo.embed_code, this.state.playerParam);
        }
        else if (delayedContentData.clickedVideo.asset){
          this.mb.publish(OO.EVENTS.SET_ASSET, delayedContentData.clickedVideo.asset, this.state.playerParam);
        }

        this.mb.publish(OO.EVENTS.DISCOVERY_API.SEND_CLICK_EVENT, delayedContentData);
        this.state.upNextInfo.showing = false;
        this.state.upNextInfo.delayedSetEmbedCodeEvent = false;
        this.state.upNextInfo.delayedContentData = null;
      }
      else if (this.state.discoveryData && this.skin.props.skinConfig.endScreen.screenToShowOnEnd === "discovery"
               && !(Utils.isIPhone() || (Utils.isIos() && this.state.fullscreen))) {
        OO.log("Should display DISCOVERY_SCREEN on end");
        this.sendDiscoveryDisplayEvent("endScreen");
        this.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
      } else if (this.skin.props.skinConfig.endScreen.screenToShowOnEnd === "share") {
        this.state.screenToShow = CONSTANTS.SCREEN.SHARE_SCREEN;
      } else {
        this.state.screenToShow = CONSTANTS.SCREEN.END_SCREEN;
        this.mb.publish(OO.EVENTS.END_SCREEN_SHOWN);
      }
      if (Utils.isIPhone()){
        //iPhone end screen is the same as start screen, except for the replay button
        this.state.screenToShow = CONSTANTS.SCREEN.START_SCREEN;
      }
      this.skin.updatePlayhead(this.state.duration, this.state.duration, this.state.duration);
      this.state.playerState = CONSTANTS.STATE.END;
      this.renderSkin();
    },

    onVcPlayed: function(event, source) {
      this.onBuffered();
      if (source == OO.VIDEO.MAIN) {
        var language = "";
        var mode = 'disabled';
        this.mb.publish(OO.EVENTS.SET_CLOSED_CAPTIONS_LANGUAGE, language, {"mode": mode});
        this.state.mainVideoDuration = this.state.duration;
      }
    },

    onSeeked: function(event) {
      this.state.seeking = false;
      if (this.state.queuedPlayheadUpdate) {
        OO.log("popping queued update");
        this.skin.updatePlayhead.apply(this.skin, this.state.queuedPlayheadUpdate);
        this.state.queuedPlayheadUpdate = null;
        this.renderSkin();
      }
      if (Utils.isIos() && this.state.screenToShow == CONSTANTS.SCREEN.END_SCREEN && this.state.fullscreen) {
        this.state.pauseAnimationDisabled = true;
        this.state.screenToShow = CONSTANTS.SCREEN.PAUSE_SCREEN;
        this.state.playerState = CONSTANTS.STATE.PAUSE;
      }
    },

    onPlaybackReady: function(event) {
      if (this.state.afterOoyalaAd) {
        this.state.screenToShow = CONSTANTS.SCREEN.LOADING_SCREEN;
      } else {
        this.state.screenToShow = CONSTANTS.SCREEN.START_SCREEN;
      }

      this.renderSkin({"contentTree": this.state.contentTree});
    },

    onBuffering: function(event) {
      if (this.state.isInitialPlay == false && this.state.screenToShow == CONSTANTS.SCREEN.START_SCREEN) {
        this.state.buffering = false;
      } else {
        this.state.buffering = true;
      }
      this.renderSkin();
    },

    onBuffered: function(event) {
      if (this.state.buffering === true) {
        this.state.buffering = false;
        this.renderSkin();
      }
    },

    onReplay: function(event) {
      this.resetUpNextInfo(false);
    },

    onAssetDimensionsReceived: function(event, params) {
      if (params.videoId == OO.VIDEO.MAIN && (this.skin.props.skinConfig.responsive.aspectRatio == "auto" || !this.skin.props.skinConfig.responsive.aspectRatio)) {
        this.state.mainVideoAspectRatio = this.calculateAspectRatio(params.width, params.height);
        this.setAspectRatio();
      }
    },

    /********************************************************************
      ADS RELATED EVENTS
    *********************************************************************/

    onAdsPlayed: function(event) {
      OO.log("onAdsPlayed is called from event = " + event);
      this.state.screenToShow = CONSTANTS.SCREEN.PLAYING_SCREEN;
      this.skin.updatePlayhead(this.state.mainVideoPlayhead, this.state.mainVideoDuration, this.state.mainVideoBuffered);
      this.state.duration = this.state.contentTree.duration / 1000;
      this.state.isPlayingAd = false;
      this.state.pluginsElement.removeClass("oo-showing");
      this.state.pluginsClickElement.removeClass("oo-showing");
      // Restore anamorphic videos fix after ad playback if necessary
      this.trySetAnamorphicFixState(true);
      this.renderSkin();
    },

    onWillPlayAds: function(event) {
      OO.log("onWillPlayAds is called from event = " + event);
      this.state.isPlayingAd = true;
      // Anamorphic videos fix should not be active during ad playback
      this.trySetAnamorphicFixState(false);
      this.state.pluginsElement.addClass("oo-showing");
      this.state.pluginsElement.css({
        height: "",
        width: ""
      });
      this.state.forceControlBarVisible = (this.state.pluginsElement.children().length > 0);
    },

    onAdPodStarted: function(event, numberOfAds) {
      OO.log("onAdPodStarted is called from event = " + event + " with " + numberOfAds + " ads");
      this.state.currentAdsInfo.numberOfAds = numberOfAds;
      this.renderSkin();
    },

    onWillPlaySingleAd: function(event, adItem) {
      OO.log("onWillPlaySingleAd is called with adItem = " + adItem);
      if (adItem !== null) {
        this.state.adVideoDuration = adItem.duration;
        this.state.screenToShow = CONSTANTS.SCREEN.AD_SCREEN;
        this.state.isPlayingAd = true;
        this.state.currentAdsInfo.currentAdItem = adItem;
        this.state.playerState = CONSTANTS.STATE.PLAYING;
        if (adItem.isLive) {
          this.state.adStartTime = new Date().getTime();
        } else {
          this.state.adStartTime = 0;
        }
        this.skin.state.currentPlayhead = 0;
        this.state.mainVideoElement.classList.remove('oo-blur');
        this.renderSkin();
      }
    },

    onSingleAdPlayed: function(event) {
      OO.log("onSingleAdPlayed is called");
      this.state.isPlayingAd = false;
      this.state.adVideoDuration = 0;
      this.state.currentAdsInfo.skipAdButtonEnabled = false;
    },

    onShowAdSkipButton: function(event) {
      this.state.currentAdsInfo.skipAdButtonEnabled = true;
      this.renderSkin();
    },

    onShowAdControls: function(event, showAdControls) {
      this.state.showAdControls = showAdControls;
      if (showAdControls && this.state.config.adScreen.showControlBar) {
        this.state.pluginsElement.removeClass("oo-full");
        this.state.pluginsClickElement.removeClass("oo-full");
      } else {
        this.state.pluginsElement.addClass("oo-full");
        this.state.pluginsClickElement.addClass("oo-full");
      }
      this.renderSkin();
    },

    onShowAdMarquee: function(event, showAdMarquee) {
      this.state.showAdMarquee = showAdMarquee;
      this.renderSkin();
    },

    // WIKIA CHANGE - START
    onShowAdTimeLeft: function (event, showAdTimeLeft) {
      this.state.showAdTimeLeft = showAdTimeLeft;
      this.renderSkin();
    },

    onShowAdFullScreenToggle: function (event, showAdFullScreenToggle) {
      this.state.showAdFullScreenToggle = showAdFullScreenToggle;
      this.renderSkin();
    },
    // WIKIA CHANGE - END

    onSkipAdClicked: function(event) {
      this.state.isSkipAdClicked = true;
      OO.log("onSkipAdClicked is called");
      this.skin.updatePlayhead(this.state.mainVideoPlayhead, this.state.mainVideoDuration, this.state.mainVideoBuffered);
      this.state.currentAdsInfo.skipAdButtonEnabled = false;
      this.mb.publish(OO.EVENTS.SKIP_AD);
      this.renderSkin();
    },

    onAdsClicked: function(source) {
      OO.log("on ads clicked is called", source);
      this.mb.publish(OO.EVENTS.ADS_CLICKED, {"source": source});
    },

    publishOverlayRenderingEvent: function(marginHeight) {
      this.mb.publish(OO.EVENTS.OVERLAY_RENDERING, {"marginHeight": marginHeight});
    },

    onPlayNonlinearAd: function(event, adInfo) {
      if(adInfo.url) {
        this.state.adOverlayUrl = adInfo.url;
        this.state.showAdOverlay = true;
      }
      this.state.pluginsElement.addClass("oo-overlay-showing");
      var skinElement = $("#"+this.state.elementId+" .oo-player-skin");
      var elementWidth = skinElement.width();
      var elementHeight = skinElement.height();
      var newCSS = {};
      if (adInfo.ad.height && adInfo.ad.height !== -1) {
        var padding = (adInfo.ad.paddingHeight ? adInfo.ad.paddingHeight : 0);
        newCSS.height = (adInfo.ad.height + padding) + "px";
        newCSS.top = "auto";
      } else {
        newCSS.top = 0;
        newCSS.bottom = 0;
      }
      if (adInfo.ad.width && adInfo.ad.width !== -1) {
        var padding = (adInfo.ad.paddingWidth ? adInfo.ad.paddingWidth : 0);
        newCSS.width = (adInfo.ad.width + padding) + "px";
        newCSS.left = "50%";
        newCSS.transform = "translateX(-50%)"
      }
      this.state.pluginsElement.css(newCSS);
      this.renderSkin();
    },

    onAdOverlayLoaded: function() {
      this.mb.publish(OO.EVENTS.NONLINEAR_AD_DISPLAYED);
    },

    onVideoElementFocus: function(event, source) {
      this.focusedElement = source;
      // Make sure that the skin uses the captions that correspond
      // to the newly focused video element
      this.setClosedCaptionsInfo(source);
      if (source == OO.VIDEO.MAIN) {
        this.state.pluginsElement.removeClass("oo-showing");
        this.state.pluginsClickElement.removeClass("oo-showing");
      }
    },

    closeNonlinearAd: function(event) {
      this.state.adOverlayUrl = null;
      this.state.showAdOverlay = false;
      this.state.showAdOverlayCloseButton = false;
      this.state.pluginsElement.removeClass("oo-overlay-showing");
      this.state.pluginsElement.css({
        top: "",
        left: "",
        right: "",
        bottom: "",
        height: "0",
        width: "0",
        transform: ""
      });
      this.renderSkin();
    },

    hideNonlinearAd: function(event) {
      this.state.showAdOverlay = false;
      this.state.pluginsElement.removeClass("oo-overlay-showing");
      this.renderSkin();
    },

    showNonlinearAd: function(event) {
      this.state.showAdOverlay = true;
      this.state.pluginsElement.addClass("oo-overlay-showing");
      this.renderSkin();
    },

    showNonlinearAdCloseButton: function(event) {
      this.state.showAdOverlayCloseButton = true;
      this.renderSkin();
    },

    /********************************************************************
     MAIN VIDEO RELATED EVENTS
     *********************************************************************/

    //merge and load config data
    loadConfigData: function(params, settings, data, skinMetaData) {
      var localSettings = Utils.sanitizeConfigData(settings);
      var inlinePageParams = Utils.sanitizeConfigData(Utils.getPropertyValue(params, 'skin.inline'));
      var customSkinJSON = Utils.sanitizeConfigData(data);
      var metaDataSettings = Utils.sanitizeConfigData(skinMetaData);
      var buttonArrayFusion = params.buttonMerge ? params.buttonMerge : 'replace';

      //override data in skin config with possible local storage settings, inline data input by user, and CMS settings in backlot/themebuilder
      var mergedMetaData = DeepMerge(SkinJSON, metaDataSettings, {arrayMerge: Utils.arrayDeepMerge.bind(Utils), arrayUnionBy:'name'});
      this.state.config = DeepMerge.all([mergedMetaData, customSkinJSON, inlinePageParams, localSettings], {arrayMerge: Utils.arrayDeepMerge.bind(Utils), arrayUnionBy:'name', buttonArrayFusion:buttonArrayFusion});
      this.state.closedCaptionOptions = this.state.config.closedCaptionOptions;

      //remove 'url' from the list until the tab is worked on
      var shareContent = Utils.getPropertyValue(this.state.config, 'shareScreen.shareContent');
      if (shareContent) {
        for (var i = 0; i < shareContent.length; i++) {
          if (shareContent[i] == 'url') {
            shareContent.splice(i, 1);
          }
        }
        this.state.config.shareScreen.shareContent = shareContent;
      }

      //load config language json if exist
      if (this.state.config.localization.availableLanguageFile) {
        this.state.config.localization.availableLanguageFile.forEach(function(languageObj){
          if (languageObj.languageFile) {
            $.getJSON(languageObj.languageFile, function(data) {
              Localization.languageFiles[languageObj.language] = data;
            });
          }
        });
      }

      //backwards compatibility with string parameters in skin.json
      this.state.config.upNext.timeToShow = Utils.convertStringToNumber(this.state.config.upNext.timeToShow);
      this.state.config.discoveryScreen.countDownTime = Utils.convertStringToNumber(this.state.config.discoveryScreen.countDownTime);

      //load player
      this.skin = ReactDOM.render(
        React.createElement(Skin, {skinConfig: this.state.config, localizableStrings: Localization.languageFiles, language: Utils.getLanguageToUse(this.state.config), controller: this, closedCaptionOptions: this.state.closedCaptionOptions, pauseAnimationDisabled: this.state.pauseAnimationDisabled}), document.querySelector("#" + this.state.elementId + " .oo-player-skin")
      );

      if (this.skin.props.skinConfig.controlBar) {
        if(this.skin.props.skinConfig.controlBar.autoplayCookieName) {
          autoplayCookieName = this.skin.props.skinConfig.controlBar.autoplayCookieName;
        }
        if(this.skin.props.skinConfig.controlBar.autoplayCookieExpireDays) {
          autoplayCookieExpireDays = this.skin.props.skinConfig.controlBar.autoplayCookieExpireDays;
        }
      }
      this.state.autoPlay.enabled = Cookies.get(autoplayCookieName) !== '0';
      this.state.configLoaded = true;
      this.renderSkin();
      this.createPluginElements();
    },

    //create plugin container elements
    createPluginElements: function() {
      var fullClass = (this.state.config.adScreen.showControlBar ? "" : " oo-full");
      $("#" + this.state.elementId + " .oo-player-skin").append("<div class='oo-player-skin-plugins"+fullClass+"'></div><div class='oo-player-skin-plugins-click-layer"+fullClass+"'></div>");
      this.state.pluginsElement = $("#" + this.state.elementId + " .oo-player-skin-plugins");
      this.state.pluginsClickElement = $("#" + this.state.elementId + " .oo-player-skin-plugins-click-layer");
      this.state.pluginsElement.mouseover(
        function() {
          this.showControlBar();
          this.renderSkin();
          this.startHideControlBarTimer();
        }.bind(this)
      );
      this.state.pluginsClickElement.click(
        function() {
          this.state.pluginsClickElement.removeClass("oo-showing");
          this.mb.publish(OO.EVENTS.PLAY);
        }.bind(this)
      );
      this.state.pluginsClickElement.mouseover(
        function() {
          this.showControlBar();
          this.renderSkin();
          this.startHideControlBarTimer();
        }.bind(this)
      );
      this.state.pluginsClickElement.mouseout(
        function() {
          this.hideControlBar();
        }.bind(this)
      );
      this.mb.publish(OO.EVENTS.UI_READY, {
        videoWrapperClass: "innerWrapper",
        pluginsClass: "oo-player-skin-plugins"
      });
    },

    onBitrateInfoAvailable: function(event, bitrates) {
      if (bitrates && bitrates.bitrates) {
        // copy array
        var bitratesList = bitrates.bitrates.slice();
				bitratesList.sort(function (a, b) {
					return b.height - a.height;
				});
        this.state.videoQualityOptions.availableBitrates = bitratesList;
        this.renderSkin({
          "videoQualityOptions": {
            "availableBitrates": bitratesList,
            "selectedBitrate": this.state.videoQualityOptions.selectedBitrate
          }
        });
      }
    },

    onClosedCaptionsInfoAvailable: function(event, info) {
      if (!info || !info.videoId || !info.languages) {
        return;
      }
      // Store info in cache in order to be able to restore it
      // if this video element looses and then regains focus (like when an ad plays)
      this.state.closedCaptionsInfoCache[info.videoId] = info;
      this.setClosedCaptionsInfo(info.videoId);
    },

    onClosedCaptionCueChanged: function(event, data) {
      if (data && data.length > 0) {
        this.state.closedCaptionOptions.cueText = data;
      } else {
        this.state.closedCaptionOptions.cueText = null;
      }
      this.renderSkin();
    },

    onRelatedVideosFetched: function(event, relatedVideos) {
      OO.log("onRelatedVideosFetched is called");
      if (relatedVideos.videos) {
        this.state.discoveryData = {relatedVideos: relatedVideos.videos};
        this.state.upNextInfo.upNextData = relatedVideos.videos[0];
        this.renderSkin();
      }
    },

    // check if fullscreen is supported natively, set flag, add event listener for change
    enableFullScreen: function() {
      if (Fullscreen.enabled) {
        this.state.isFullScreenSupported = true;
        document.addEventListener(Fullscreen.raw.fullscreenchange, this.onFullscreenChanged.bind(this));
      }
    },

    // iOS webkitSupportsFullscreen property is not valid until metadata has loaded
    // https://developer.apple.com/library/safari/documentation/AudioVideo/Conceptual/Using_HTML5_Audio_Video/ControllingMediaWithJavaScript/ControllingMediaWithJavaScript.html#//apple_ref/doc/uid/TP40009523-CH3-SW13
    enableIosFullScreen: function() {
      if(!this.state.isFullScreenSupported) {
        if (this.state.mainVideoElement.webkitSupportsFullscreen) {
          this.state.isVideoFullScreenSupported = true;
          this.state.mainVideoElement.addEventListener("webkitbeginfullscreen", this.webkitBeginFullscreen.bind(this));
          this.state.mainVideoElement.addEventListener("webkitendfullscreen", this.webkitEndFullscreen.bind(this));
        }
      }
    },

    //called when event listener triggered
    onFullscreenChanged: function() {
      if (this.state.isFullScreenSupported) {
        this.state.fullscreen = Fullscreen.isFullscreen;
      } else {
        this.toggleFullscreen();
      }

      this.renderSkin();
    },

    //called when user selects fullscreen icon
    toggleFullscreen: function() {
      // full support, any element
      if(this.state.isFullScreenSupported) {
        Fullscreen.toggle(this.state.mainVideoInnerWrapper.get(0));
      }
      // partial support, video element only (iOS)
      else if (this.state.isVideoFullScreenSupported) {
        if(this.state.fullscreen) {
          this.state.mainVideoElement.webkitExitFullscreen();
        } else {
          this.state.mainVideoElement.webkitEnterFullscreen();
        }
      }
      // no support
      else {
        if(this.state.isFullWindow) {
          this.exitFullWindow();
        } else {
          this.enterFullWindow();
        }
      }
      this.state.fullscreen = !this.state.fullscreen;

      // unmute on mobile when switching to fullscreen
      if (this.state.isMobile && this.state.fullscreen && this.state.volumeState.muted) {
        this.handleMuteClick();
      }
      this.renderSkin();
    },

    // if fullscreen is not supported natively, "full window" style
    // is applied to video wrapper to fill browser window
    enterFullWindow: function() {
      this.state.isFullWindow = this.state.fullscreen = true;

      // add listener for esc key
      document.addEventListener("keydown", this.exitFullWindowOnEscKey.bind(this));
      // hide scroll bars
      document.documentElement.style.overflow = 'hidden';
      //apply full window style
      this.state.mainVideoInnerWrapper.addClass('oo-fullscreen');
    },

    // remove "full window" style and event listener
    exitFullWindow: function() {
      this.state.isFullWindow = this.state.fullscreen = false;

      // remove event listener
      document.removeEventListener("keydown", this.exitFullWindowOnEscKey);
      // unhide scroll bars
      document.documentElement.style.overflow = 'visible';
      //remove full window style
      this.state.mainVideoInnerWrapper.removeClass('oo-fullscreen');
    },

    // iOS event fires when a video enters full-screen mode
    webkitBeginFullscreen: function() {
      this.state.fullscreen = true;
    },

    // iOS event fires when a video exits full-screen mode
    webkitEndFullscreen: function() {
      this.state.fullscreen = false;
      var showUpNext = this.skin.props.skinConfig.upNext.showUpNext || this.skin.props.skinConfig.discoveryScreen.showCountDownTimerOnEndScreen;

      // [PLAYER-212]
      // We can't show UI such as the "Up Next" countdown on fullscreen iOS. If a countdown
      // is configured, we wait until the user exits fullscreen and then we display it.
      if (showUpNext && this.state.playerState === CONSTANTS.STATE.END) {
        this.state.forceCountDownTimerOnEndScreen = true;
        this.sendDiscoveryDisplayEvent("endScreen");
        this.state.pluginsElement.addClass("oo-overlay-blur");
        this.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
        this.renderSkin();
        this.state.forceCountDownTimerOnEndScreen = false;
      }
    },

    // exit full window on ESC key
    exitFullWindowOnEscKey: function(event) {
      if (event.keyCode === CONSTANTS.KEYCODES.ESCAPE_KEY) {
        event.preventDefault();
        this.exitFullWindow();
      }
    },

    onErrorEvent: function(event, errorCode){
      this.unsubscribeBasicPlaybackEvents();

      this.state.screenToShow = CONSTANTS.SCREEN.ERROR_SCREEN;
      this.state.playerState = CONSTANTS.STATE.ERROR;
      this.state.errorCode = errorCode;
      this.renderSkin();
    },

    unsubscribeFromMessageBus: function() {
      // basic playback events
      this.unsubscribeBasicPlaybackEvents();

      // player events
      this.mb.unsubscribe(OO.EVENTS.PLAYER_CREATED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.CONTENT_TREE_FETCHED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.SKIN_METADATA_FETCHED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.ATTRIBUTES_FETCHED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.AUTHORIZATION_FETCHED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.ASSET_CHANGED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.ASSET_UPDATED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.PLAYBACK_READY, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.ERROR, "customerUi");
      this.mb.unsubscribe(OO.EVENTS.SET_EMBED_CODE_AFTER_OOYALA_AD, 'customerUi');
    },

    unsubscribeBasicPlaybackEvents: function() {
      this.mb.unsubscribe(OO.EVENTS.INITIAL_PLAY, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.VC_PLAYED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.VC_PLAYING, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.VC_PAUSE, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.VC_PAUSED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.PLAYED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.SEEKED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.BUFFERING, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.BUFFERED, 'customerUi');
      this.mb.unsubscribe(OO.EVENTS.CLOSED_CAPTIONS_INFO_AVAILABLE, "customerUi");
      this.mb.unsubscribe(OO.EVENTS.BITRATE_INFO_AVAILABLE, "customerUi");
      this.mb.unsubscribe(OO.EVENTS.CLOSED_CAPTION_CUE_CHANGED, "customerUi");
      this.mb.unsubscribe(OO.EVENTS.CHANGE_CLOSED_CAPTION_LANGUAGE, "customerUi");
      this.mb.unsubscribe(OO.EVENTS.VOLUME_CHANGED, "customerUi");
      this.mb.unsubscribe(OO.EVENTS.PLAYBACK_READY, 'customerUi');
      this.state.isPlaybackReadySubscribed = false;

      // ad events
      if (!Utils.isIPhone()) {
        //since iPhone is always playing in full screen and not showing our skin, don't need to render skin
        this.mb.unsubscribe(OO.EVENTS.ADS_PLAYED, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.WILL_PLAY_ADS , "customerUi");
        this.mb.unsubscribe(OO.EVENTS.AD_POD_STARTED, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.WILL_PLAY_SINGLE_AD , "customerUi");
        this.mb.unsubscribe(OO.EVENTS.SINGLE_AD_PLAYED , "customerUi");
        this.mb.unsubscribe(OO.EVENTS.PLAY_NONLINEAR_AD, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.NONLINEAR_AD_PLAYED, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.HIDE_NONLINEAR_AD, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.SHOW_NONLINEAR_AD, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.SHOW_AD_SKIP_BUTTON, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.SHOW_AD_CONTROLS, "customerUi");
        this.mb.unsubscribe(OO.EVENTS.SHOW_AD_MARQUEE, "customerUi");

        if (OO.EVENTS.DISCOVERY_API) {
          this.mb.unsubscribe(OO.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED, "customerUi");
        }
      }
      this.state.isSubscribed = false;
    },

    /*--------------------------------------------------------------------
     Skin state -> control skin
     ---------------------------------------------------------------------*/
    renderSkin: function(args) {
      if (this.state.configLoaded) {
        if (args) {
          this.state = DeepMerge(this.state, args);
        }
        this.skin.switchComponent(this.state);
      }
    },

    /*--------------------------------------------------------------------
     skin UI-action -> publish event to core player
     ---------------------------------------------------------------------*/
    toggleDiscoveryScreen: function() {
      switch(this.state.playerState) {
        case CONSTANTS.STATE.PLAYING:
          this.pausedCallback = function() {
            this.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
            this.state.playerState = CONSTANTS.STATE.PAUSE;
            this.state.pluginsElement.addClass("oo-overlay-blur");
            this.renderSkin();
            OO.log("finished toggleDiscoveryScreen");
          }.bind(this);
          this.togglePlayPause();
          this.sendDiscoveryDisplayEvent("pauseScreen");
          break;
        case CONSTANTS.STATE.PAUSE:
          if(this.state.screenToShow === CONSTANTS.SCREEN.DISCOVERY_SCREEN) {
            this.state.pauseAnimationDisabled = true;
            this.state.pluginsElement.removeClass("oo-overlay-blur");
            this.state.screenToShow = CONSTANTS.SCREEN.PAUSE_SCREEN;
          }
          else {
            this.sendDiscoveryDisplayEvent("pauseScreen");
            this.state.pluginsElement.addClass("oo-overlay-blur");
            this.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
          }
          break;
        case CONSTANTS.STATE.END:
          if(this.state.screenToShow === CONSTANTS.SCREEN.DISCOVERY_SCREEN) {
            this.state.pluginsElement.removeClass("oo-overlay-blur");
            this.state.screenToShow = CONSTANTS.SCREEN.END_SCREEN;
          }
          else {
            this.sendDiscoveryDisplayEvent("endScreen");
            this.state.pluginsElement.addClass("oo-overlay-blur");
            this.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
            this.skin.props.skinConfig.discoveryScreen.showCountDownTimerOnEndScreen = false;
          }
          break;
      }
      this.renderSkin();
    },

    toggleMute: function(muted) {
      this.mb.publish(OO.EVENTS.CHANGE_VOLUME, (muted ? 0 : 1));
    },

    togglePlayPause: function() {
      switch (this.state.playerState) {
        case CONSTANTS.STATE.START:
          this.mb.publish(OO.EVENTS.INITIAL_PLAY, Date.now());
          break;
        case CONSTANTS.STATE.END:
          if(Utils.isAndroid() || Utils.isIos()) {
            if(this.state.isSkipAdClicked) {
             this.state.isSkipAdClicked = false;
            }
            else
            {
               this.mb.publish(OO.EVENTS.REPLAY);
            }
          } else {
            this.mb.publish(OO.EVENTS.REPLAY);
          }
          break;
        case CONSTANTS.STATE.PAUSE:
          this.mb.publish(OO.EVENTS.PLAY);
          break;
        case CONSTANTS.STATE.PLAYING:
          this.mb.publish(OO.EVENTS.PAUSE);
          break;
      }
    },

    seek: function(seconds) {
      if (this.state.playerState == CONSTANTS.STATE.END) {
        this.endSeeking();
        this.mb.publish(OO.EVENTS.REPLAY, seconds);
      }
      else {
        this.mb.publish(OO.EVENTS.SEEK, seconds);
      }
    },

    onLiveClick: function() {
      this.mb.publish(OO.EVENTS.LIVE_BUTTON_CLICKED);
    },

    setVolume: function(volume){
      // WIKIA CHANGE - START
      if (this.state.isMobile && !Utils.isIos() && this.state.mainVideoElement) {
        if (volume > 0) {
          this.state.mainVideoElement.muted = false;
        } else {
          this.state.mainVideoElement.muted = true;
        }
      }
      // WIKIA CHANGE - END
      this.mb.publish(OO.EVENTS.CHANGE_VOLUME, volume);
    },

    handleMuteClick: function() {
      var newVolumeSettings = {};
      if (!this.state.volumeState.muted) {
        //if we're muting, save the current volume so we can
        //restore it when we un-mute
        newVolumeSettings = {
          oldVolume: this.state.volumeState.volume,
          muted: !this.state.volumeState.muted
        };
        this.setVolume(0);
      }
      else {
        //restore the volume to the previous setting
        newVolumeSettings = {
          oldVolume: 0,
          muted: !this.state.volumeState.muted
        };
        this.setVolume(this.state.volumeState.oldVolume);
      }

      this.state.volumeState.oldVolume = newVolumeSettings.oldVolume;
      this.state.volumeState.muted = newVolumeSettings.muted;
    },

    toggleShareScreen: function() {
      if (this.state.screenToShow == CONSTANTS.SCREEN.SHARE_SCREEN) {
        this.closeScreen();
      }
      else {
        if (this.state.playerState == CONSTANTS.STATE.PLAYING || this.state.playerState == CONSTANTS.STATE.START) {
          this.pausedCallback = function() {
            this.state.pluginsElement.addClass("oo-overlay-blur");
            this.state.screenToShow = CONSTANTS.SCREEN.SHARE_SCREEN;
            this.renderSkin();
          }.bind(this);
          this.mb.publish(OO.EVENTS.PAUSE);
        }
        else {
          this.state.screenToShow = CONSTANTS.SCREEN.SHARE_SCREEN;
          this.state.pluginsElement.addClass("oo-overlay-blur");
          this.renderSkin();
        }
      }
    },

    toggleScreen: function(screen) {
      if (this.state.screenToShow == screen) {
        this.closeScreen();
      }
      else {
        if (this.state.playerState == CONSTANTS.STATE.PLAYING) {
          this.pausedCallback = function() {
            this.state.pluginsElement.addClass("oo-overlay-blur");
            this.state.screenToShow = screen;
            this.renderSkin();
          }.bind(this);
          this.mb.publish(OO.EVENTS.PAUSE);
        }
        else {
          this.state.screenToShow = screen;
          this.state.pluginsElement.addClass("oo-overlay-blur");
          this.renderSkin();
        }
      }
    },

    sendDiscoveryClickEvent: function(selectedContentData, isAutoUpNext) {
      this.state.pluginsElement.removeClass("oo-overlay-blur");
      if (isAutoUpNext){
        this.state.upNextInfo.delayedContentData = selectedContentData;
        this.state.upNextInfo.delayedSetEmbedCodeEvent = true;
      }
      else {
        this.state.upNextInfo.showing = false;
        this.state.screenToShow = CONSTANTS.SCREEN.LOADING_SCREEN;
        this.renderSkin();
        this.mb.publish(OO.EVENTS.PAUSE);
        if (selectedContentData.clickedVideo.embed_code){
          this.mb.publish(OO.EVENTS.SET_EMBED_CODE, selectedContentData.clickedVideo.embed_code,
                          this.state.playerParam);
        }
        else if (selectedContentData.clickedVideo.asset){
          this.mb.publish(OO.EVENTS.SET_ASSET, selectedContentData.clickedVideo.asset);
        }
        this.mb.publish(OO.EVENTS.DISCOVERY_API.SEND_CLICK_EVENT, selectedContentData);
      }
    },

    sendDiscoveryDisplayEvent: function(screenName, embedCode) {
      var relatedVideosData = Utils.getPropertyValue(this.state.discoveryData, "relatedVideos", []);
      var relatedVideos = relatedVideosData;

      // With "Up Next" panel we only pass the data of the asset
      // that is currently shown
      if (embedCode) {
        var eventAsset = _.find(relatedVideosData, function(relatedVideo) {
          return relatedVideo.embed_code === embedCode;
        });
        relatedVideos = eventAsset ? [eventAsset] : [];
      }

      var eventData = {
        "relatedVideos" : relatedVideos,
        "custom" : { "source" : screenName }
      };
      this.mb.publish(OO.EVENTS.DISCOVERY_API.SEND_DISPLAY_EVENT, eventData);
    },

    toggleConfigPanelPopover: function() {
      this.state.configPanelOptions.showConfigPanelPopover = !this.state.configPanelOptions.showConfigPanelPopover;
      this.state.configPanelOptions.showVideoQualityPanel = false;
      this.renderSkin();
    },

    toggleVideoQualityPopOver: function() {
      this.state.configPanelOptions.showVideoQualityPanel = !this.state.configPanelOptions.showVideoQualityPanel;
      this.renderSkin();
    },

    toggleClosedCaptionPopOver: function() {
      this.state.closedCaptionOptions.showClosedCaptionPopover = !this.state.closedCaptionOptions.showClosedCaptionPopover;
      this.renderSkin();
    },

    closePopovers: function() {
      this.state.closedCaptionOptions.showClosedCaptionPopover = false;
      this.state.videoQualityOptions.showVideoQualityPopover = false;
      this.renderSkin();
    },

    receiveVideoQualityChangeEvent: function(event, targetBitrate) {
        this.state.videoQualityOptions.selectedBitrate = {
        "id": targetBitrate
      };
      this.renderSkin({
          "videoQualityOptions": {
            "availableBitrates": this.state.videoQualityOptions.availableBitrates,
            "selectedBitrate": this.state.videoQualityOptions.selectedBitrate,
            "showVideoQualityPopover":this.state.videoQualityOptions.showVideoQualityPopover
          }
        });
      if(this.state.configPanelOptions.showConfigPanelPopover == true) {

        this.toggleConfigPanelPopover();
      }
      if(this.state.configPanelOptions.showVideoQualityPanel == true) {
          this.toggleVideoQualityPopOver();
      }
    },

    sendVideoQualityChangeEvent: function(selectedContentData) {
      this.state.videoQualityOptions.selectedBitrate = {
        "id": selectedContentData.id
      };
      this.mb.publish(OO.EVENTS.SET_TARGET_BITRATE, selectedContentData.id);
    },

    setClosedCaptionsInfo: function(videoId) {
      var closedCaptionsInfo = this.state.closedCaptionsInfoCache[videoId];
      if (!closedCaptionsInfo) {
        return;
      }
      // Load the CC info for the video with the given id onto the state
      this.state.closedCaptionOptions.availableLanguages = closedCaptionsInfo;
      if (this.state.closedCaptionOptions.enabled) {
        this.setClosedCaptionsLanguage();
      }
    },

    setClosedCaptionsLanguage: function(){
      var availableLanguages = this.state.closedCaptionOptions.availableLanguages;
      //if saved language not in available languages, set to first available language
      if (availableLanguages && (this.state.closedCaptionOptions.language == null || !_.contains(availableLanguages.languages, this.state.closedCaptionOptions.language))) {
        this.state.closedCaptionOptions.language = availableLanguages.languages[0];
      }
      var language = this.state.closedCaptionOptions.enabled ? this.state.closedCaptionOptions.language : "";
      var mode = this.state.closedCaptionOptions.enabled ? OO.CONSTANTS.CLOSED_CAPTIONS.HIDDEN : OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED;
      this.mb.publish(OO.EVENTS.SET_CLOSED_CAPTIONS_LANGUAGE, language, {"mode": mode});
    },

    closeScreen: function() {
      this.state.pluginsElement.removeClass("oo-overlay-blur");
      this.state.pauseAnimationDisabled = true;
      if (this.state.playerState == CONSTANTS.STATE.PAUSE) {
        this.state.screenToShow = CONSTANTS.SCREEN.PAUSE_SCREEN;
      }
      else if (this.state.playerState == CONSTANTS.STATE.END) {
        this.state.screenToShow = CONSTANTS.SCREEN.END_SCREEN;
      }
      this.renderSkin();
    },

    onChangeClosedCaptionLanguage: function(event, language) {
      var availableLanguages = this.state.closedCaptionOptions.availableLanguages;

      //validate language is available before update and save
      if (language && availableLanguages && _.contains(availableLanguages.languages, language)) {
        this.state.closedCaptionOptions.language = this.state.persistentSettings.closedCaptionOptions.language = language;
        var captionLanguage = this.state.closedCaptionOptions.enabled ? language : "";
        var mode = this.state.closedCaptionOptions.enabled ? OO.CONSTANTS.CLOSED_CAPTIONS.HIDDEN : OO.CONSTANTS.CLOSED_CAPTIONS.DISABLED;
        //publish set closed caption event
        this.mb.publish(OO.EVENTS.SET_CLOSED_CAPTIONS_LANGUAGE, captionLanguage, {"mode": mode});
        //update skin, save new closed caption language
        this.renderSkin();
        this.mb.publish(OO.EVENTS.SAVE_PLAYER_SETTINGS, this.state.persistentSettings);
      }
      //if language not in available languages, log error
      else {
        OO.log("Invalid closed caption language.");
      }
    },

    onClosedCaptionChange: function(name, value) {
      this.state.closedCaptionOptions[name] = this.state.persistentSettings.closedCaptionOptions[name] = value;
      if (name === 'language') {
        this.setClosedCaptionsLanguage();
      }
      this.renderSkin();
      this.mb.publish(OO.EVENTS.SAVE_PLAYER_SETTINGS, this.state.persistentSettings);
    },

    /**
     * Used to enable or disable the CSS workaround that prevents anamorphic videos from
     * being distorted on Firefox. The fix will only be enabled if ots_stretch_to_output
     * is set to true in the player attributes.
     * Note that currently the oo-anamorphic class has effect only on Firefox.
     * @param {boolen} enabled A value that determines whether to enable or disable the anamorphic videos CSS fix.
     */
    trySetAnamorphicFixState: function(enabled) {
      if (!this.state || !this.state.mainVideoInnerWrapper) {
        return;
      }

      if (enabled) {
        var isAnamorphic = Utils.getPropertyValue(this.state.attributes, 'provider.ots_stretch_to_output');

        // Only enable anamorphic videos fix if video actually requires it
        if (isAnamorphic === true || isAnamorphic === 'true') {
          this.state.mainVideoInnerWrapper.addClass('oo-anamorphic');
          OO.log('Anamorphic video fix: ON');
        }
      } else {
        this.state.mainVideoInnerWrapper.removeClass('oo-anamorphic');
        OO.log('Anamorphic video fix: OFF');
      }
    },

    toggleClosedCaptionEnabled: function() {
      this.state.closedCaptionOptions.enabled = !this.state.closedCaptionOptions.enabled;
      this.state.persistentSettings.closedCaptionOptions['enabled'] = !!this.state.closedCaptionOptions.enabled;
      this.setClosedCaptionsLanguage();
      this.renderSkin();
      this.mb.publish(OO.EVENTS.SAVE_PLAYER_SETTINGS, this.state.persistentSettings);
    },

    toggleAutoPlayEnabled: function() {
      this.state.autoPlay.enabled = !this.state.autoPlay.enabled;
      this.renderSkin();
      Cookies.set(autoplayCookieName, this.state.autoPlay.enabled ? 1 : 0, { expires: autoplayCookieExpireDays });
      this.mb.publish(OO.EVENTS.WIKIA.AUTOPLAY_TOGGLED, this.state.autoPlay.enabled);
    },

    upNextDismissButtonClicked: function() {
      this.state.upNextInfo.countDownCancelled = true;
      this.state.upNextInfo.showing = false;
      this.renderSkin();
    },

    toggleMoreOptionsScreen: function(moreOptionsItems) {
      if (this.state.screenToShow == CONSTANTS.SCREEN.MORE_OPTIONS_SCREEN) {
        this.closeMoreOptionsScreen();
      } else {
        this.displayMoreOptionsScreen(moreOptionsItems);
      }
    },

    closeMoreOptionsScreen: function() {
      this.state.pauseAnimationDisabled = true;
      this.state.screenToShow = CONSTANTS.SCREEN.PAUSE_SCREEN;
      this.state.playerState = CONSTANTS.STATE.PAUSE;
      this.state.moreOptionsItems = null;
      this.state.pluginsElement.removeClass("oo-overlay-blur");
      this.renderSkin();
    },

    displayMoreOptionsScreen: function(moreOptionsItems) {
      if (this.state.playerState == CONSTANTS.STATE.PLAYING) {
        this.pausedCallback = function() {
          this.state.screenToShow = CONSTANTS.SCREEN.MORE_OPTIONS_SCREEN;
          this.state.pluginsElement.addClass("oo-overlay-blur");
          this.renderSkin();
        }.bind(this);
        this.mb.publish(OO.EVENTS.PAUSE);
      }
      else {
        this.state.screenToShow = CONSTANTS.SCREEN.MORE_OPTIONS_SCREEN;
        this.state.pluginsElement.addClass("oo-overlay-blur");
        this.renderSkin();
      }
      this.state.moreOptionsItems = moreOptionsItems;
    },

    enablePauseAnimation: function(){
      this.state.pauseAnimationDisabled = false;
    },

    beginSeeking: function() {
      this.state.seeking = true;
    },

    endSeeking: function() {
      this.state.seeking = false;
    },

    updateSeekingPlayhead: function(playhead) {
      playhead = Math.min(Math.max(0, playhead), this.skin.state.duration);
      this.skin.updatePlayhead(playhead, this.skin.state.duration, this.skin.state.buffered);
    },

    hideVolumeSliderBar: function() {
      this.state.volumeState.volumeSliderVisible = false;
      this.renderSkin();
    },

    showVolumeSliderBar: function() {
      this.state.volumeState.volumeSliderVisible = true;
      if (Utils.isAndroid()) {
        this.startHideVolumeSliderTimer();
      }
      this.renderSkin();
    },

    startHideVolumeSliderTimer: function() {
        this.cancelTimer();
        var timer = setTimeout(function() {
          if(this.state.volumeState.volumeSliderVisible === true){
            this.hideVolumeSliderBar();
          }
        }.bind(this), 3000);
        this.state.timer = timer;
    },

    startHideControlBarTimer: function() {
      if (this.skin.props.skinConfig.controlBar.autoHide == true) {
        this.cancelTimer();
        var timer = setTimeout(function() {
          if(this.state.controlBarVisible === true){
            this.hideControlBar();
          }
        }.bind(this), 3000);
        this.state.timer = timer;
      }
    },

    showControlBar: function() {
      this.state.controlBarVisible = true;
    },

    hideControlBar: function() {
      this.state.controlBarVisible = false;
      if (Utils.isAndroid()) {
        this.hideVolumeSliderBar();
      }
    },

    cancelTimer: function() {
      if (this.state.timer !== null){
        clearTimeout(this.state.timer);
        this.state.timer = null;
      }
    },

    //use fixed aspect ratio number from skinConfig
    updateAspectRatio: function() {
      if(this.skin && this.skin.props.skinConfig.responsive.aspectRatio && this.skin.props.skinConfig.responsive.aspectRatio != "auto") {
        this.state.mainVideoAspectRatio = this.skin.props.skinConfig.responsive.aspectRatio;
        this.setAspectRatio();
      }
    },

    //returns original video aspect ratio
    calculateAspectRatio: function(width, height) {
      var aspectRatio = ((height / width) * 100).toFixed(2);
      return aspectRatio;
    },

    //set Main Video Element Wrapper padding-top to aspect ratio
    setAspectRatio: function() {
      if(this.state.mainVideoAspectRatio > 0) {
        this.state.mainVideoInnerWrapper.css("padding-top", this.state.mainVideoAspectRatio+"%");
      }
    },

    //find descendant video element
    findMainVideoElement: function(element) {
      var elements = [];
      //use actual element
      if (element[0]) {
        element = element[0];
      }

      //find html5 video
      if (element.tagName && element.tagName.toLowerCase().indexOf(CONSTANTS.MEDIA_TYPE.VIDEO) != -1) {
        this.state.mainVideoMediaType = CONSTANTS.MEDIA_TYPE.HTML5;
      }
      else if (element.getElementsByTagName(CONSTANTS.MEDIA_TYPE.VIDEO).length) {
        elements = element.getElementsByTagName(CONSTANTS.MEDIA_TYPE.VIDEO);
        if (elements.length) {
          element = elements[0];
          this.state.mainVideoMediaType = CONSTANTS.MEDIA_TYPE.HTML5;
        }
      }
      //find flash object
      else if (element.tagName && element.tagName.toLowerCase().indexOf(CONSTANTS.MEDIA_TYPE.OBJECT) != -1) {
        this.state.mainVideoMediaType = CONSTANTS.MEDIA_TYPE.FLASH;
      }
      else if (element.getElementsByTagName(CONSTANTS.MEDIA_TYPE.OBJECT).length) {
        elements = element.getElementsByTagName(CONSTANTS.MEDIA_TYPE.OBJECT);
        if (elements.length) {
          element = elements[0];
          this.state.mainVideoMediaType = CONSTANTS.MEDIA_TYPE.FLASH;
        }
      }
      return element;
    }
  };

  exposeStaticApi = Html5Skin; //for unit test only

  return Html5Skin;
});
