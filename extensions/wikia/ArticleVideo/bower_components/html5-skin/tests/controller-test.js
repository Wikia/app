jest.dontMock('../js/controller');
jest.dontMock('screenfull');
jest.dontMock('../js/constants/constants');
jest.dontMock('../js/components/utils');

var CONSTANTS = require('../js/constants/constants');

/**
 * Mock OO
 */
OO = {
  playerParams: {
    "core_version" : 4
  },
  publicApi: {
    VERSION: {
      skin: {}
    }
  },
  EVENTS: {
    DISCOVERY_API: {}
  },
  CONSTANTS: {
    CLOSED_CAPTIONS: {}
  },
  VIDEO: {
    ADS: 'ads',
    MAIN: 'main'
  },
  log: function(a) {console.info(a);},
  init: function() {},
  plugin: function(module, callback) {
    _ = require('underscore');
    $ = require('jquery');
    var plugin = callback(OO, _, $);
    var html5Skin = plugin.call(OO, OO.mb, 0);

    // mock controller
    var controllerMock = {
      mb: {
        subscribe: function() {},
        unsubscribe: function() {},
        publish: function() {},
        addDependent: function() {}
      },
      focusedElement: 'video-id-123587dsjhkewu',
      state: {
        persistentSettings: {
          closedCaptionOptions: {}
        },
        config: {
          adScreen: {
            showControlBar: true
          }
        },
        isPlaybackReadySubscribed: false,
        configLoaded: true,
        elementId: 'oo-video',
        isLiveStream: false,
        contentTree: {},
        discoveryData: {},
        fullscreen: false,
        queuedPlayheadUpdate: true,
        currentAdsInfo: {},
        videoQualityOptions: {},
        closedCaptionsInfoCache: {},
        closedCaptionOptions: {
          enabled: null,
          language: null,
          availableLanguages: {
            languages: ['en','es']
          },
          cueText: null,
          showClosedCaptionPopover: false,
          textColor: null,
          windowColor: null,
          backgroundColor: null,
          textOpacity: null,
          backgroundOpacity: null,
          windowOpacity: null,
          fontType: null,
          fontSize: null,
          textEnhancement: null
        },
        upNextInfo: {
          countDownCancelled: false,
          showing: null,
          upNextData: {data: 2},
          delayedSetEmbedCodeEvent:{},
          delayedContentData: {
            clickedVideo: {
              embed_code: true,
              asset: true
            }
          }
        },
        isPlayingAd: false,
        mainVideoAspectRatio: 6,
        mainVideoInnerWrapper: {
          css: function(a,b) {},
          addClass: function(a) {},
          removeClass: function(a) {}
        },
        timer: 8.45,
        controlBarVisible: null,
        volumeState: {
          volumeSliderVisible: null,
          volume: null
        },
        seeking: null,
        pauseAnimationDisabled: null,
        playerState: null,
        screenToShow: null,
        pluginsElement: {
          addClass: function(a) {},
          removeClass: function(a) {},
          css: function(a,b) {},
          children: function() {
            return {length:2}
          }
        },
        pluginsClickElement: {
          addClass: function(a) {},
          removeClass: function(a) {}
        },
        mainVideoElement: {
          addClass: function(a) {},
          removeClass: function(a) {},
          get: function(a) {
            return {
              webkitSupportsFullscreen: true,
              webkitEnterFullscreen: function() {},
              webkitExitFullscreen: function() {},
              addEventListener: function(a,b) {}
            }
          }
        }
      },
      skin: {
        state: {
          duration: 10,
          buffered: 6
        },
        props: {
          skinConfig: {
            responsive: {
              aspectRatio: 45
            },
            controlBar: {
              autoHide: true
            },
            upNext: {
              showUpNext: true,
              timeToShow: '10'
            },
            pauseScreen: {},
            endScreen: {
              screenToShowOnEnd: 'discovery'
            },
            discoveryScreen: {
              showCountDownTimerOnEndScreen: false
            }
          }
        },
        updatePlayhead: function(playhead, duration, buffered) {window.playheadUpdated = true;},
        switchComponent: function(a) {window.isComponentSwitched = a;}
      },
      enableFullScreen: function() {},
      enableIosFullScreen: function() {},
      onFullscreenChanged: function() {},
      toggleFullscreen: function() {},
      webkitBeginFullscreen: function() {},
      webkitEndFullscreen: function() {},
      enterFullWindow: function() {},
      exitFullWindow: function() {},
      exitFullWindowOnEscKey: function() {},
      onBuffered: function() {},
      unsubscribeBasicPlaybackEvents: function() {},
      resetUpNextInfo: function(a) {},
      showUpNextScreenWhenReady: function(a,b) {},
      subscribeBasicPlaybackEvents: function() {},
      externalPluginSubscription: function() {},
      addDependent: function() {},
      endSeeking: function() {},
      sendDiscoveryDisplayEvent: function(a) {},
      togglePlayPause: function() {},
      closeScreen: function(a) {},
      closePopovers: function() {},
      setVolume: function(a) {},
      toggleVideoQualityPopOver: function(a) {},
      setClosedCaptionsInfo: function(a) {},
      setClosedCaptionsLanguage: function() {},
      displayMoreOptionsScreen: function(a) {},
      closeMoreOptionsScreen: function() {},
      pausedCallback: function() {},
      renderSkin: function() {window.isSkinRendered = true;},
      cancelTimer: function() {window.isTimerCanceled = true;},
      startHideControlBarTimer: function() {},
      startHideVolumeSliderTimer: function() {},
      hideControlBar: function() {window.isControlBarHidden = true;},
      hideVolumeSliderBar: function() {window.isVolumeSliderBarHidden = true;},
      updateAspectRatio: function() {},
      calculateAspectRatio: function(a,b) {},
      setAspectRatio: function() {window.isAspectRatioSet = true;},
      createPluginElements: function() {}
    };


    /**
     * The unit tests
     */

    var Html5Skin = exposeStaticApi.prototype; // public object used to expose private object for testing
    var elementId = 'adrfgyi';

    //setup document body for valid DOM elements
    document.body.innerHTML =
      '<div id='+elementId+'>' +
      '  <div class="oo-player-skin" />' +
      '</div>';

    //test mb subscribe
    window._.bind = function() {};
    Html5Skin.init.call(controllerMock);
    controllerMock.state.isPlaybackReadySubscribed = false;
    Html5Skin.subscribeBasicPlaybackEvents.call(controllerMock);
    Html5Skin.externalPluginSubscription.call(controllerMock);

    //test player state
    var tempSkin = $.extend(true, {}, controllerMock.skin);
    Html5Skin.onPlayerCreated.call(controllerMock, 'customerUi', elementId, {skin:{config:{}}}, {});
    Html5Skin.loadConfigData.call(controllerMock, {skin:{config:{}}}, {});
    Html5Skin.createPluginElements.call(controllerMock);
    controllerMock.skin = tempSkin; //reset skin, onPlayerCreated updates skin

    var tempMainVideoElement = $.extend(true, {}, controllerMock.state.mainVideoElement);
    Html5Skin.onVcVideoElementCreated.call(controllerMock, 'customerUi', {videoId: OO.VIDEO.MAIN});
    controllerMock.state.mainVideoElement = tempMainVideoElement;

    Html5Skin.metaDataLoaded.call(controllerMock);
    Html5Skin.onAuthorizationFetched.call(controllerMock, 'customerUi', {streams: [{is_live_stream: true}]});
    Html5Skin.onContentTreeFetched.call(controllerMock, 'customerUi', {someContent: true});
    Html5Skin.onThumbnailsFetched.call(controllerMock, 'customerUi', {thumb: 'nail'});

    Html5Skin.onVolumeChanged.call(controllerMock, 'customerUi', 0.5);
    window.vol = controllerMock.state.volumeState.volume;

    Html5Skin.onPlayheadTimeChanged.call(controllerMock, 'customerUi', 5, 10, 7, null, 'main');
    Html5Skin.onPlayheadTimeChanged.call(controllerMock, 'customerUi', 5, 0, 7, null, OO.VIDEO.ADS);
    controllerMock.state.fullscreen = true; window.navigator.platform = "iPhone"; controllerMock.state.seeking = true;
    Html5Skin.onPlayheadTimeChanged.call(controllerMock, 'customerUi', 5, 0, 7, null, 'child');
    controllerMock.state.fullscreen = false; window.navigator.platform = 'Node'; controllerMock.state.seeking = false;

    Html5Skin.onInitialPlay.call(controllerMock);

    Html5Skin.onPlaying.call(controllerMock, 'customerUi', OO.VIDEO.MAIN);
    Html5Skin.onPlaying.call(controllerMock, 'customerUi', OO.VIDEO.ADS);

    Html5Skin.onPause.call(controllerMock, 'customerUi', OO.VIDEO.ADS, CONSTANTS.PAUSE_REASON.TRANSITION);
    Html5Skin.onPaused.call(controllerMock, 'customerUi', 'video-id-123587dsjhkewu');
    Html5Skin.onPaused.call(controllerMock, 'customerUi', OO.VIDEO.MAIN);
    controllerMock.focusedElement = OO.VIDEO.MAIN;
    controllerMock.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
    Html5Skin.onPaused.call(controllerMock, 'customerUi', OO.VIDEO.MAIN);

    Html5Skin.onPlayed.call(controllerMock);
    controllerMock.state.upNextInfo.delayedContentData = {clickedVideo: {embed_code: false}};
    Html5Skin.onPlayed.call(controllerMock);
    controllerMock.state.upNextInfo.delayedContentData = {clickedVideo: {embed_code: false}};
    controllerMock.state.upNextInfo.delayedSetEmbedCodeEvent = null;
    controllerMock.state.fullscreen = true; window.navigator.platform = "iPhone";
    Html5Skin.onPlayed.call(controllerMock);
    controllerMock.state.upNextInfo.delayedContentData = {clickedVideo: {embed_code: false}};
    controllerMock.state.fullscreen = false; window.navigator.platform = "Node";

    Html5Skin.onVcPlayed.call(controllerMock, 'customerUi', OO.VIDEO.MAIN);

    Html5Skin.onSeeked.call(controllerMock, 'customerUi');
    controllerMock.state.fullscreen = true; window.navigator.platform = "iPhone"; controllerMock.state.screenToShow = CONSTANTS.SCREEN.END_SCREEN;
    Html5Skin.onSeeked.call(controllerMock, 'customerUi');
    controllerMock.state.fullscreen = false; window.navigator.platform = "Node";

    Html5Skin.onPlaybackReady.call(controllerMock, 'customerUi');

    Html5Skin.onBuffering.call(controllerMock, 'customerUi');
    controllerMock.state.isInitialPlay = true;
    Html5Skin.onBuffering.call(controllerMock, 'customerUi');
    controllerMock.state.isInitialPlay = false;

    Html5Skin.onBuffered.call(controllerMock, 'customerUi');
    controllerMock.state.buffering = true;
    Html5Skin.onBuffered.call(controllerMock, 'customerUi');

    Html5Skin.onReplay.call(controllerMock, 'customerUi');

    Html5Skin.onAssetDimensionsReceived.call(controllerMock, 'customerUi', {});
    controllerMock.skin.props.skinConfig.responsive.aspectRatio = 'auto';
    Html5Skin.onAssetDimensionsReceived.call(controllerMock, 'customerUi', {videoId: OO.VIDEO.MAIN});

    // test ad events
    Html5Skin.onAdsPlayed.call(controllerMock, 'customerUi');
    Html5Skin.onWillPlayAds.call(controllerMock, 'customerUi');

    Html5Skin.onAdPodStarted.call(controllerMock, 'customerUi', 2);
    Html5Skin.onWillPlaySingleAd.call(controllerMock, 'customerUi', {isLive:true, duration:10});

    Html5Skin.onSingleAdPlayed.call(controllerMock, 'customerUi');
    Html5Skin.onShowAdSkipButton.call(controllerMock, 'customerUi');

    Html5Skin.onShowAdControls.call(controllerMock, 'customerUi', true);
    Html5Skin.onShowAdControls.call(controllerMock, 'customerUi', false);

    Html5Skin.onShowAdMarquee.call(controllerMock, 'customerUi', true);
    Html5Skin.onSkipAdClicked.call(controllerMock, 'customerUi');
    Html5Skin.onAdsClicked.call(controllerMock, OO.VIDEO.ADS);
    Html5Skin.publishOverlayRenderingEvent.call(controllerMock, 20);
    Html5Skin.onPlayNonlinearAd.call(controllerMock, 'customerUi', {isLive:true, duration:10, url:'www.ooyala.com', ad:{height:12, width:14}});
    Html5Skin.onAdOverlayLoaded.call(controllerMock);
    Html5Skin.onVideoElementFocus.call(controllerMock, 'customerUi', OO.VIDEO.MAIN);
    Html5Skin.closeNonlinearAd.call(controllerMock, 'customerUi');
    Html5Skin.hideNonlinearAd.call(controllerMock, 'customerUi');
    Html5Skin.showNonlinearAd.call(controllerMock, 'customerUi');
    Html5Skin.showNonlinearAdCloseButton.call(controllerMock, 'customerUi');
    Html5Skin.onBitrateInfoAvailable.call(controllerMock, 'customerUi', {bitrates:{}});

    controllerMock.state.closedCaptionOptions.enabled = true;
    Html5Skin.onClosedCaptionsInfoAvailable.call(controllerMock, 'customerUi', {languages: ['en', 'es']});

    Html5Skin.onClosedCaptionCueChanged.call(controllerMock, 'customerUi', ['Hi, this is caption text', 'more captions']);
    Html5Skin.onClosedCaptionCueChanged.call(controllerMock, 'customerUi', []);

    Html5Skin.onRelatedVideosFetched.call(controllerMock, 'customerUi', {videos:['vid1', 'vid2']});
    Html5Skin.enableFullScreen.call(controllerMock);
    Html5Skin.enableIosFullScreen.call(controllerMock);
    Html5Skin.onFullscreenChanged.call(controllerMock);

    controllerMock.state.isFullWindow = true;
    controllerMock.state.isVideoFullScreenSupported = false;
    Html5Skin.toggleFullscreen.call(controllerMock);
    controllerMock.state.isFullWindow = false;
    Html5Skin.toggleFullscreen.call(controllerMock);
    //controllerMock.state.isFullScreenSupported = true;
    //Html5Skin.toggleFullscreen.call(controllerMock);
    controllerMock.state.isFullScreenSupported = false;
    controllerMock.state.isVideoFullScreenSupported = true;
    Html5Skin.toggleFullscreen.call(controllerMock);
    controllerMock.state.fullscreen = true;
    Html5Skin.toggleFullscreen.call(controllerMock);

    Html5Skin.enterFullWindow.call(controllerMock);
    Html5Skin.exitFullWindow.call(controllerMock);
    Html5Skin.webkitBeginFullscreen.call(controllerMock);
    Html5Skin.webkitEndFullscreen.call(controllerMock);
    Html5Skin.exitFullWindowOnEscKey.call(controllerMock, {keyCode: CONSTANTS.KEYCODES.ESCAPE_KEY, preventDefault: function() {}});
    Html5Skin.onErrorEvent.call(controllerMock, {}, '404');

    // test up next
    Html5Skin.showUpNextScreenWhenReady.call(controllerMock, 5, 100);
    controllerMock.skin.props.skinConfig.upNext.timeToShow = '10%';
    controllerMock.state.playerState = CONSTANTS.STATE.PLAYING;
    Html5Skin.showUpNextScreenWhenReady.call(controllerMock, 5, 10);
    Html5Skin.resetUpNextInfo.call(controllerMock, true);

    // test mb unsubscribe events
    Html5Skin.unsubscribeFromMessageBus.call(controllerMock);
    Html5Skin.unsubscribeBasicPlaybackEvents.call(controllerMock);

    // test render skin
    Html5Skin.renderSkin.call(controllerMock, {state: 'state extended'});

    // test UI functions
    controllerMock.state.playerState = CONSTANTS.STATE.PLAYING;
    Html5Skin.toggleDiscoveryScreen.call(controllerMock);
    controllerMock.pausedCallback();
    controllerMock.state.playerState = CONSTANTS.STATE.PAUSE;
    controllerMock.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
    Html5Skin.toggleDiscoveryScreen.call(controllerMock);
    controllerMock.state.screenToShow = null;
    Html5Skin.toggleDiscoveryScreen.call(controllerMock);

    controllerMock.state.playerState = CONSTANTS.STATE.END;
    controllerMock.state.screenToShow = CONSTANTS.SCREEN.DISCOVERY_SCREEN;
    Html5Skin.toggleDiscoveryScreen.call(controllerMock);
    controllerMock.state.screenToShow = null;
    Html5Skin.toggleDiscoveryScreen.call(controllerMock);

    Html5Skin.toggleMute.call(controllerMock, true);
    Html5Skin.toggleMute.call(controllerMock, false);

    controllerMock.state.playerState = CONSTANTS.STATE.START;
    Html5Skin.togglePlayPause.call(controllerMock);
    controllerMock.state.playerState = CONSTANTS.STATE.END;
    window.navigator.appVersion = "Android"; // set appVersion to Android
    controllerMock.state.isSkipAdClicked = true;
    Html5Skin.togglePlayPause.call(controllerMock);
    controllerMock.state.isSkipAdClicked = false;
    Html5Skin.togglePlayPause.call(controllerMock);
    window.navigator.appVersion = "Not Mobile";
    Html5Skin.togglePlayPause.call(controllerMock);
    controllerMock.state.playerState = CONSTANTS.STATE.PAUSE;
    Html5Skin.togglePlayPause.call(controllerMock);
    controllerMock.state.playerState = CONSTANTS.STATE.PLAYING;
    Html5Skin.togglePlayPause.call(controllerMock);

    Html5Skin.seek.call(controllerMock, 5);
    controllerMock.state.playerState = CONSTANTS.STATE.END;
    Html5Skin.seek.call(controllerMock, 5);

    Html5Skin.onLiveClick.call(controllerMock);

    Html5Skin.setVolume.call(controllerMock, 1);
    Html5Skin.setVolume.call(controllerMock, 0);

    controllerMock.state.volumeState.muted = true;
    Html5Skin.handleMuteClick.call(controllerMock);
    controllerMock.state.volumeState.muted = false;
    Html5Skin.handleMuteClick.call(controllerMock);

    controllerMock.state.screenToShow = CONSTANTS.SCREEN.SHARE_SCREEN;
    Html5Skin.toggleShareScreen.call(controllerMock);
    controllerMock.state.screenToShow = CONSTANTS.SCREEN.END_SCREEN;
    controllerMock.state.playerState = CONSTANTS.STATE.PLAYING;
    Html5Skin.toggleShareScreen.call(controllerMock);
    controllerMock.pausedCallback();
    controllerMock.state.screenToShow = CONSTANTS.SCREEN.ERROR_SCREEN;
    controllerMock.state.playerState = CONSTANTS.STATE.END;
    Html5Skin.toggleShareScreen.call(controllerMock);

    controllerMock.state.screenToShow = CONSTANTS.SCREEN.SHARE_SCREEN;
    Html5Skin.toggleScreen.call(controllerMock, CONSTANTS.SCREEN.SHARE_SCREEN);
    controllerMock.state.screenToShow = null;
    controllerMock.state.playerState = CONSTANTS.STATE.PLAYING;
    Html5Skin.toggleScreen.call(controllerMock, CONSTANTS.SCREEN.SHARE_SCREEN);
    controllerMock.pausedCallback();
    controllerMock.state.screenToShow = null;
    controllerMock.state.playerState = CONSTANTS.STATE.END;
    Html5Skin.toggleScreen.call(controllerMock, CONSTANTS.SCREEN.SHARE_SCREEN);

    Html5Skin.sendDiscoveryClickEvent.call(controllerMock, {}, true);
    Html5Skin.sendDiscoveryClickEvent.call(controllerMock, {clickedVideo:{embed_code: true}}, false);
    Html5Skin.sendDiscoveryClickEvent.call(controllerMock, {clickedVideo:{asset: true}}, false);

    Html5Skin.sendDiscoveryDisplayEvent.call(controllerMock, CONSTANTS.SCREEN.DISCOVERY_SCREEN);
    Html5Skin.toggleVideoQualityPopOver.call(controllerMock);
    Html5Skin.toggleClosedCaptionPopOver.call(controllerMock);
    Html5Skin.closePopovers.call(controllerMock);
    Html5Skin.receiveVideoQualityChangeEvent.call(controllerMock, null, 312);
    Html5Skin.sendVideoQualityChangeEvent.call(controllerMock, {id:2});
    Html5Skin.setClosedCaptionsInfo.call(controllerMock, elementId);

    Html5Skin.setClosedCaptionsLanguage.call(controllerMock);
    controllerMock.state.closedCaptionOptions.availableLanguages = null;
    controllerMock.state.closedCaptionOptions.enabled = true;
    Html5Skin.setClosedCaptionsLanguage.call(controllerMock);

    controllerMock.state.playerState = CONSTANTS.STATE.PAUSE;
    Html5Skin.closeScreen.call(controllerMock);
    controllerMock.state.playerState = CONSTANTS.STATE.END;
    Html5Skin.closeScreen.call(controllerMock);

    Html5Skin.onClosedCaptionChange.call(controllerMock, 'language', 'es');
    Html5Skin.toggleClosedCaptionEnabled.call(controllerMock);
    Html5Skin.upNextDismissButtonClicked.call(controllerMock);

    Html5Skin.toggleMoreOptionsScreen.call(controllerMock, {});
    controllerMock.state.screenToShow = CONSTANTS.SCREEN.MORE_OPTIONS_SCREEN;
    Html5Skin.toggleMoreOptionsScreen.call(controllerMock, {});

    Html5Skin.closeMoreOptionsScreen.call(controllerMock);
    controllerMock.state.playerState = CONSTANTS.STATE.PLAYING;

    Html5Skin.displayMoreOptionsScreen.call(controllerMock, {});
    controllerMock.pausedCallback();
    controllerMock.state.playerState = null;
    Html5Skin.displayMoreOptionsScreen.call(controllerMock, {});

    Html5Skin.enablePauseAnimation.call(controllerMock);

    // test scrubber
    Html5Skin.beginSeeking.call(controllerMock);
    Html5Skin.endSeeking.call(controllerMock);
    Html5Skin.updateSeekingPlayhead.call(controllerMock, 2);

    // test volume
    Html5Skin.hideVolumeSliderBar.call(controllerMock);
    Html5Skin.showVolumeSliderBar.call(controllerMock);

    // test control bar
    Html5Skin.startHideControlBarTimer.call(controllerMock);
    Html5Skin.startHideVolumeSliderTimer.call(controllerMock);

    Html5Skin.showControlBar.call(controllerMock);
    window.showControlBarVisible = controllerMock.state.controlBarVisible;

    window.isVolumeSliderBarHidden = false;
    window.navigator.appVersion = "Android"; // set appVersion to Android
    Html5Skin.hideControlBar.call(controllerMock);
    window.hideControlBarVisible = controllerMock.state.controlBarVisible;

    // test timer
    Html5Skin.cancelTimer.call(controllerMock);
    Html5Skin.cancelTimer.call({state: {timer: null}});

    // test aspect ratio
    window.isAspectRatioSet = false;
    controllerMock.skin.props.skinConfig.responsive.aspectRatio = 45;
    Html5Skin.updateAspectRatio.call(controllerMock);
    Html5Skin.updateAspectRatio.call({});

    window.aspectRatio1 = Html5Skin.calculateAspectRatio(16, 9);
    window.aspectRatio2 = Html5Skin.calculateAspectRatio(4, 3);
    window.aspectRatio3 = Html5Skin.calculateAspectRatio(1.85, 1);
    window.aspectRatio4 = Html5Skin.calculateAspectRatio(2.39, 1);

    Html5Skin.setAspectRatio.call(controllerMock);
    Html5Skin.setAspectRatio.call({state: {mainVideoAspectRatio: 0}});

    //test destroy functions last
    Html5Skin.onEmbedCodeChanged.call(controllerMock, 'customerUi', 'RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2', {});
    Html5Skin.onAssetChanged.call(controllerMock, 'customerUi', {content: {streams: [{is_live_stream: true}], title: 'Title', posterImages: [{url:'www.ooyala.com'}]}});
    Html5Skin.onAssetUpdated.call(controllerMock, 'customerUi', {content: {streams: [{is_live_stream: true}], title: 'Title', posterImages: [{url:'www.ooyala.com'}]}});
    controllerMock.state.elementId = 'oo-video';
    Html5Skin.onPlayerDestroy.call(controllerMock, 'customerUi');
  }
};

var controller = require('../js/controller');


/**
 * Validate results from unit tests
 */
describe('Controller', function () {
  it('tests volume', function () {
    expect(window.vol).toBe(0.5);
  });

  it('tests render skin', function () {
    expect(window.isComponentSwitched.state).toBe('state extended');
  });

  it('tests control bar', function () {
    expect(window.showControlBarVisible).toBeTruthy();
    expect(window.hideControlBarVisible).toBeFalsy();
    expect(window.isVolumeSliderBarHidden).toBeTruthy();
  });

  it('tests aspect ratio', function () {
    expect(window.isAspectRatioSet).toBeTruthy();
    expect(window.aspectRatio1).toBe('56.25');
    expect(window.aspectRatio2).toBe('75.00');
    expect(window.aspectRatio3).toBe('54.05');
    expect(window.aspectRatio4).toBe('41.84');
  });
});
