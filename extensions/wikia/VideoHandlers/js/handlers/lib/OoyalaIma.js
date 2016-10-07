OO.plugin("GoogleIma", function(OO, _, $, W){
	/*
	 * Google IMA SDK v3
	 * https://developers.google.com/interactive-media-ads/docs/sdks/googlehtml5_ads_v3
	 * https://developers.google.com/interactive-media-ads/docs/sdks/googlehtml5_apis_v3
	 */
	var IMA_MODULE_TYPE = "google-ima-ads-manager";
	var MAX_AD_MANAGER_LOAD_TIME_OUT = 10000;
	var DEFAULT_ADS_REQUEST_TIME_OUT = 3000;
	var PLAYHEAD_UPDATE_INTERVAL = 200;
	var ext = OO.DEV ? '_debug.js' : '.js';
	var IMA_JS = "//imasdk.googleapis.com/js/sdkloader/ima3.js";
	var protocol = OO.isSSL ? "https:" : "http:";
	var bootJsSrc = protocol + IMA_JS;

	bootJsSrc = _sp_.getSafeUri(bootJsSrc);

	W.googleImaSdkLoadedCbList = W.googleImaSdkLoadedCbList  || [];
	W.googleImaSdkFailedCbList = W.googleImaSdkFailedCbList || [];
	W.googleImaSdkLoaded = false;

	var onBootStrapReady = function() {
		OO.log("Bootstrap Ready!!!", W.googleImaSdkLoaded);
		if (W.googleImaSdkLoaded) { return; }
		OO._.each(W.googleImaSdkLoadedCbList, function(fn) { fn(); }, OO);
	};

	var onBootStrapFailed = function() {
		OO.log("Bootstrap failed to load!");
		W.googleImaSdkLoaded = false;
		OO._.each(W.googleImaSdkFailedCbList, function(fn) { fn(); }, OO);
	};

	OO._.defer(function() {
		OO.loadScriptOnce(bootJsSrc, onBootStrapReady, onBootStrapFailed, 15000);
	});

	// helper function to convert types to boolean
	// the (!!) trick only works to verify if a string isn't the empty string
	// therefore, we must use a special case for that
	var convertToBoolean = function(value) {
		if (typeof value === 'string') {
			return value.indexOf("true") > -1 || value.indexOf("yes") > -1;
		}
		return !!value;
	};

	var GoogleIma = function(messageBus, id) {
		this.preparePlatformExtensions();
		this.canSetupAdsRequest = false;

		if (this.platformExtensions.preConstructor) { this.platformExtensions.preConstructor(); }
		if (!OO.requiredInEnvironment('html5-playback') && !OO.requiredInEnvironment('cast-playback')) { return; }
		if (OO.isIE) { return; }
		// disable check for ads environment for now.
		//if (!OO.requiredInEnvironment('ads')) {return; }

		OO.EVENTS.GOOGLE_IMA_READY = "googleImaReady";
		OO.EVENTS.GOOGLE_RESUME_CONTENT = "googleResumeContent";
		OO.EVENTS.GOOGLE_IMA_CAN_SEEK = "googleImaCanSeek";
		OO.EVENTS.GOOGLE_IMA_CAN_PLAY = "googleImaCanPlay";
		OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE = "googleImaAllAdsDone";
		OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING = "googleImaRemoveBuffering";

		this.Id = id;
		this.mb = messageBus;
		this.rootElement = null;

		this.currentEmbedCode = null;
		this.adsLoader = null;
		this.adTagUrl = null;
		this.adDisplayContainer = null;
		this.hasError = false;
		this.playheadUpdateTimer = null;
		this.linearAdStarted = false;
		this.adControls = null;
		this.showInAdControlBar = false;
		this.adPauseCalled = false;
		this.adsReady = false;
		this.imaAdsManagerActive = false;
		this.isLinearAd = false;
		this.adTagUrlFromEmbedHash = null;
		this.switchingAdsManager = false;
		this.additionalAdTagParameters = null;
		this.marqueePageOverride = false;
		this.adsRequested = false;
		this.contentEndedHandler = _.bind(this.onContentEnded, this);
		this.contentEnded = false;
		this.customPlayheadTracker = null;
		this.customPlayheadIntervalFunction = _.bind(this._customPlayheadUpdate, this);
		this.playWhenAdClick = null;
		this.isFullscreen = false;
		this.maxAdsRequestTimeout = DEFAULT_ADS_REQUEST_TIME_OUT;
		this.maxAdsRequestTimeoutPageOverride = false;
		this.isLivePlaying = false;
		this.googleResumeContentDispatched = false;
		this.contentResumeAlreadyCalled = false;
		this.adStarted = false;

		W.googleImaSdkLoadedCbList.unshift(OO._.bind(this.onSdkLoaded, this));
		W.googleImaSdkFailedCbList.unshift(OO._.bind(this.onImaAdError, this));

		OO.StateMachine.create({
			initial:'Init',
			messageBus:this.mb,
			moduleName:'googleIma',
			target:this,
			events:[
				{name:OO.EVENTS.PLAYER_CREATED,                     from:'Init',                                       to:'PlayerCreated'},
				{name:OO.EVENTS.SET_EMBED_CODE,                     from:'*',                                          to:'EmbedCodeChanged'},
				{name:OO.EVENTS.AUTHORIZATION_FETCHED,              from:'*'},
				{name:OO.EVENTS.METADATA_FETCHED,                   from:'EmbedCodeChanged',                           to:'*'},
				{name:OO.EVENTS.PLAYER_CLICKED,                     from:'*',                                          to:'*'},
				{name:OO.EVENTS.INITIAL_PLAY,                       from:'*',                                          to:'*'},
				{name:OO.EVENTS.WILL_PLAY_ADS,                      from:'*',                                          to:'*'},
				{name:OO.EVENTS.PAUSE,                              from:'*',                                          to:'*'},
				{name:OO.EVENTS.FULLSCREEN_CHANGED,                 from:'*',                                          to:'*'},
				{name:OO.EVENTS.WILL_PLAY_FROM_BEGINNING,           from:'*',                                          to:'*'},
				{name:OO.EVENTS.SCRUBBING,                          from:'*',                                          to:'*'},
				{name:OO.EVENTS.SCRUBBED,                           from:'*',                                          to:'*'},
				{name:OO.EVENTS.SIZE_CHANGED,                       from:'*',                                          to:'*'},
				{name:OO.EVENTS.STREAM_PAUSED,                      from:'*',                                          to:'*'}
			]
		});
	};

	_.extend(GoogleIma.prototype, {
		onPlayerCreated: function(event, elementId, params) {
			// Setup timeout for IMA SDK load. Cleared by imaError and onSdkLoaded
			this.unblockPlaybackTimeout = _.delay(_.bind(this.onImaAdError, this), MAX_AD_MANAGER_LOAD_TIME_OUT);

			this.rootElement = $("#" + elementId + " .innerWrapper");
			this.mainVideo = this.rootElement.find("video.video");
			this.mainVideo.on("loadedmetadata", _.bind(this._onVideoMetaLoaded, this));
			this.mainVideo.on("ended", this.contentEndedHandler);

			if (this.platformExtensions.postOnPlayerCreated) { this.platformExtensions.postOnPlayerCreated(); }
			this.mb.intercept(OO.EVENTS.PLAY, 'googleIma', _.bind(this.onPlay, this));
		},

		_processParameters: function(params) {
			if (params && params[IMA_MODULE_TYPE]) {
				if (typeof params[IMA_MODULE_TYPE].adTagUrl !== 'undefined') {
					this.adTagUrl = this.adTagUrlFromEmbedHash = params[IMA_MODULE_TYPE].adTagUrl;
				}

				if (typeof params[IMA_MODULE_TYPE].additionalAdTagParameters !== 'undefined') {
					this.additionalAdTagParameters = params[IMA_MODULE_TYPE].additionalAdTagParameters;
				}

				if (typeof params.showInAdControlBar !== 'undefined') {
					this.showInAdControlBar = params.showInAdControlBar;
				} else {
					this.showInAdControlBar = !!params[IMA_MODULE_TYPE].showInAdControlBar;
				}

				if (typeof params[IMA_MODULE_TYPE].showAdMarquee !== 'undefined') {
					//this takes care of whether or not it's a boolean or a string true, false
					var showAdCountdownText = convertToBoolean(params[IMA_MODULE_TYPE].showAdMarquee);
					this.marqueePageOverride = true;
					this.mb.publish(OO.EVENTS.SHOW_AD_MARQUEE, showAdCountdownText);
				}

				if (typeof params[IMA_MODULE_TYPE].playWhenAdClick !== 'undefined') {
					var playAdClick = convertToBoolean(params[IMA_MODULE_TYPE].playWhenAdClick);
					this.playWhenAdClick = playAdClick;
				}

				if (typeof params[IMA_MODULE_TYPE].adRequestTimeout !== 'undefined') {
					var timeOut = parseInt(params[IMA_MODULE_TYPE].adRequestTimeout, 10);
					if (!_.isNaN(timeOut)) {
						this.maxAdsRequestTimeoutPageOverride = true;
						this.maxAdsRequestTimeout = timeOut;
					}
				}
			}
		},

		_addDependentEvent: function() {
			//[gfrank] setting flag here based on CR [Aldi] in cause this function is reused later at a different place.
			this.googleResumeContentDispatched = false;
			this.mb.addDependent(OO.EVENTS.PLAYBACK_READY, OO.EVENTS.GOOGLE_IMA_READY, "googleIma", function(){});
			this.mb.addDependent(OO.EVENTS.PLAY, OO.EVENTS.GOOGLE_RESUME_CONTENT, "googleIma", function(){});
			this.mb.addDependent(OO.EVENTS.INITIAL_PLAY, OO.EVENTS.GOOGLE_IMA_CAN_PLAY, "googleIma", function(){});
			this.mb.addDependent(OO.EVENTS.CAN_SEEK, OO.EVENTS.GOOGLE_IMA_CAN_SEEK, "googleIma", function(){});
		},

		onSetEmbedCode: function(event, embedCode, params) {
			this.contentResumeAlreadyCalled = false;
			this.canSetupAdsRequest = false;
			this.customPlayheadTracker = {duration: 0, currentTime: 0};
			if (this.platformExtensions.preOnSetEmbedCode) { this.platformExtensions.preOnSetEmbedCode(); }
			this.currentEmbedCode = embedCode;
			this.isLinearAd = false;
			this.adTagUrl = null;
			if (this.adsManager) {
				this.switchingAdsManager = true;
				this.adsManager.destroy();
				// Remove PLAYED addDependency that is set on onAdsManagerLoaded, in case setEmbedCode is called prior ALL_ADS_COMPLETED
				this.mb.publish(OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE);
			}

			// https://developers.google.com/interactive-media-ads/faq#8
			// let the ad server know that these are legitimate ads requests, and not accidental duplicates
			if (this.adsLoader) { this.adsLoader.contentComplete(); }
			this.adsManager = null;
			this.linearAdStarted = false;
			this.adsRequested = false;
			this.adsReady = false;
			this.contentEnded = false;
			if (this.imaAdsManagerActive) {
				// Safety when setEmbedCode is called while IMA ads is still playing.
				this.mb.publish(OO.EVENTS.ADS_MANAGER_FINISHED_ADS);
				this.disptachContentResume();
				this.imaAdsManagerActive = false;
			}
			clearInterval(this.playheadUpdateTimer);
			this.playheadUpdateTimer = null;
			this.adPauseCalled = false;
			this.isLivePlaying = false;

			// If adTagUrl is set via page level override, enable dependentEvents. Else defer to onMetadataFetched
			this._processParameters(params);
			if (this.adTagUrlFromEmbedHash) { this._addDependentEvent(); }
		},

		onAuthorizationFetched:function(event, response) {
			this.authorization = response;
			this.isLivePlaying = (this.isLivePlaying || this.authorization.streams[0].is_live_stream);
		},

		onMetadataFetched: function(event, response) {
			if (this.platformExtensions.overrideOnMetadataFetched){
				this.platformExtensions.overrideOnMetadataFetched(event, response);
				return;
			}

			OO.log("Metadata Ready:", response, this.adTagUrl, this.adTagUrlFromEmbedHash);
			this.adTagUrl = this.adTagUrlFromEmbedHash;

			var responseChecker =
				(response &&
				response['modules'] &&
				response['modules'][IMA_MODULE_TYPE] &&
				response['modules'][IMA_MODULE_TYPE]['metadata']);

			if (!this.adTagUrl) {
				// set adTagUrl if it is not set yet.
				if (responseChecker) {
					var meta1 = response['modules'][IMA_MODULE_TYPE]['metadata'];
					this.adTagUrl = meta1.adTagUrl || meta1.tagUrl;
					if (this.rootElement && this.adTagUrl) { this._addDependentEvent(); }
				}
				this._unBlockPlaybackReady();
			}

			// checks whether the page level has already overridden
			// if not, it will publish the metadata's showAdMarquee parameter
			if (!this.marqueePageOverride) {
				if (responseChecker) {
					var meta2 = response['modules'][IMA_MODULE_TYPE]['metadata'];
					if (meta2.showAdMarquee) {
						this.mb.publish(OO.EVENTS.SHOW_AD_MARQUEE, convertToBoolean(meta2.showAdMarquee));
					}
				}
			}

			// playWhenAdClick will be null if not set on page-level
			if (this.playWhenAdClick === null) {
				if (responseChecker) {
					var meta3 = response['modules'][IMA_MODULE_TYPE]['metadata'];
					this.playWhenAdClick = meta3.playWhenAdClick;
				}
			}

			if (!this.maxAdsRequestTimeoutPageOverride && responseChecker) {
				if (typeof response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout !== 'undefined') {
					var timeOut = parseInt(response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout, 10);
					if (!_.isNaN(timeOut)) {
						this.maxAdsRequestTimeout = timeOut;
					}
				}
			}

			if (this.platformExtensions.postOnMetadataFetched) { this.platformExtensions.postOnMetadataFetched(); }

			this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
			this._unBlockPlaybackReady();
		},

		onSdkLoaded: function() {
			if (this.unblockPlaybackTimeout) {
				clearTimeout(this.unblockPlaybackTimeout);
			}

			if (this.platformExtensions.overrideOnSdkLoaded) {
				this.platformExtensions.overrideOnSdkLoaded();
				return;
			}
			OO.log("onSdkLoaded!");

			// [PBK-639] Corner case where Google's SDK 200s but isn't properly
			// loaded. Better safe than sorry..
			if (!(W.google && W.google.ima && W.google.ima.AdDisplayContainer)) {
				this.onImaAdError();
				return;
			}

			W.googleImaSdkLoaded = true;
			this.adDisplayContainer = new W.google.ima.AdDisplayContainer(this.rootElement.find("div.plugins")[0],
				this.rootElement.find("video.video")[0]);
			this.adsLoader = new W.google.ima.AdsLoader(this.adDisplayContainer);

			this.adsLoader.addEventListener(
				W.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
				_.bind(this.onAdsManagerLoaded, this),
				false);
			this.adsLoader.addEventListener(
				W.google.ima.AdErrorEvent.Type.AD_ERROR,
				_.bind(this.onImaAdError, this),
				false);
		},

		_onVideoMetaLoaded: function(event) {
			if (this.platformExtensions.overrideOnVideoMetaLoaded) {
				this.platformExtensions.overrideOnVideoMetaLoaded();
				return;
			}
			this.customPlayheadTracker.duration = this.mainVideo[0].duration;
			this._setCustomPlayheadTracker();
			if (this.imaAdsManagerActive) { return; }
		},

		_setupAdsRequest: function() {
			if (this.adsRequested || !this.canSetupAdsRequest) { return; }
			if (!W.googleImaSdkLoaded) {
				W.googleImaSdkLoadedCbList.push(OO._.bind(this._setupAdsRequest, this));
				return;
			}
			if (!this.adTagUrl || !this.rootElement) { return; }

			var adsRequest = new W.google.ima.AdsRequest();
			if (this.additionalAdTagParameters) {
				var connector = this.adTagUrl.indexOf("?") > 0 ? "&" : "?";

				// Generate an array of key/value pairings, for faster string concat
				var paramArray = [], param = null;
				for (param in this.additionalAdTagParameters) {
					paramArray.push(param + "=" +  this.additionalAdTagParameters[param]);
				}
				this.adTagUrl += connector + paramArray.join("&");
			}

			adsRequest.adTagUrl = OO.getNormalizedTagUrl(this.adTagUrl, this.currentEmbedCode);
			// Specify the linear and nonlinear slot sizes. This helps the SDK to
			// select the correct creative if multiple are returned.
			var w = this.rootElement.width();
			adsRequest.linearAdSlotWidth = w;
			adsRequest.linearAdSlotHeight = this.rootElement.height();

			adsRequest.nonLinearAdSlotWidth = w;
			adsRequest.nonLinearAdSlotHeight = Math.min(150, w / 4);

			OO.log("setup Ads request", this.adTagUrl, this.rootElement);
			this.adsLoader.requestAds(adsRequest);
			_.delay(_.bind(this._adsRequestTimeout, this), this.maxAdsRequestTimeout);
			this.adsRequested = true;
		},

		onAdsManagerLoaded: function (adsManagerLoadedEvent) {
			// AdsManager was getting instantiated multiple times, prevent this.
			if (this.adsManager) {
				return;
			}

			// https://developers.google.com/interactive-media-ads/docs/sdks/googlehtml5_apis_v3#ima.AdsRenderingSettings
			var adsSettings = new W.google.ima.AdsRenderingSettings();
			adsSettings.restoreCustomPlaybackStateOnAdBreakComplete = true;
			this.adsManager = adsManagerLoadedEvent.getAdsManager(this.customPlayheadTracker, adsSettings);

			// Add listeners to the required events.
			this.adsManager.addEventListener(
				W.google.ima.AdEvent.Type.CLICK,
				_.bind(this.onAdClick, this), false, this);
			this.adsManager.addEventListener(
				W.google.ima.AdErrorEvent.Type.AD_ERROR,
				_.bind(this.onImaAdError, this), false, this);
			this.adsManager.addEventListener(
				W.google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED,
				_.bind(this.onContentPauseRequested, this), false, this);
			this.adsManager.addEventListener(
				W.google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED,
				_.bind(this.onContentResumeRequested, this), false, this);

			// Listen to any additional events, if necessary.
			var imaAdEvents = [
				W.google.ima.AdEvent.Type.ALL_ADS_COMPLETED,
				W.google.ima.AdEvent.Type.COMPLETE,
				W.google.ima.AdEvent.Type.SKIPPED,
				W.google.ima.AdEvent.Type.FIRST_QUARTILE,
				W.google.ima.AdEvent.Type.LOADED,
				W.google.ima.AdEvent.Type.MIDPOINT,
				W.google.ima.AdEvent.Type.PAUSED,
				W.google.ima.AdEvent.Type.RESUMED,
				W.google.ima.AdEvent.Type.STARTED,
				W.google.ima.AdEvent.Type.THIRD_QUARTILE];

			OO._.each(imaAdEvents, function(e) {
				this.adsManager.addEventListener(e, OO._.bind(this.onAdEvent, this), false, this);
			}, this);
			this.adsReady = true;
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING);
			if (this.unblockPlaybackTimeout) {
				clearTimeout(this.unblockPlaybackTimeout);
			}

			this.mb.addDependent(OO.EVENTS.PLAYED, OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE, "googleIma", function(){});
			if (this.platformExtensions.postOnAdsManagerLoaded) {
				this.platformExtensions.postOnAdsManagerLoaded();
				return;
			}
			this._desktopPostOnAdsManagerLoaded();

		},

		_desktopPostOnAdsManagerLoaded: function() {
			if (OO.supportMultiVideo) { this.rootElement.find('div.oo_tap_panel').css('display', ''); }
			this.adDisplayContainer.initialize();
			if (!OO.supportMultiVideo) {
				this.mainVideo[0].load();
			}
			if (this.adsManager) {
				try {
					this.mb.publish(OO.EVENTS.BUFFERING);
					//ad rules will start from this call
					var width = this.rootElement.width();
					var height = this.rootElement.height();
					this.adsManager.init(width, height, W.google.ima.ViewMode.NORMAL);

					//single ads will start here
					this.adsManager.start();
				} catch(adError) {
					this.onImaAdError(adError);
				}
			}
		},

		_unBlockPlaybackReady: function() {
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_READY);
		},

		_unblockMainContentPlay: function(forcePlay) {
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_SEEK);
			this.disptachContentResume();
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
			if (this.linearAdStarted) {
				OO.log("Linear ads started.");
			} else if (forcePlay) {
				_.defer(_.bind(function(){ this.mb.publish(OO.EVENTS.PLAY); }, this));
			}
		},

		_adsRequestTimeout: function() {
			if (!this.adsReady) {
				this.onImaAdError(W.google.ima.AdEvent.Type.FAILED_TO_REQUEST_ADS);
			}
		},

		onImaAdError: function(adErrorEvent) {
			if (this.unblockPlaybackTimeout) {
				clearTimeout(this.unblockPlaybackTimeout);
			}
			OO.log("Can not load Google IMA ADs!!",
				adErrorEvent && adErrorEvent.getError());
			this._unBlockPlaybackReady();

			this.linearAdStarted = false;
			this.mb.publish(OO.EVENTS.ADS_PLAYED);
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE);
			this.mb.publish(OO.EVENTS.GOOGLE_RESUME_CONTENT);
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);

			//only resume playing if we were already playing content.
			if (this.adStarted)
			{
				this.onContentResumeRequested();
				if (!this.showInAdControlBar) {
					_.delay(_.bind(function(){ this.mb.publish(OO.EVENTS.ENABLE_PLAYBACK_CONTROLS); }, this), 100);
				}
			}

			if (this.adsManager) {  this.adsManager.destroy(); }
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING);
			this.mb.publish(OO.EVENTS.ADS_ERROR);
		},

		onPlay: function() {
			if (this.switchingAdsManager && OO.supportMultiVideo) {
				this.switchingAdsManager = false;
			} else {
				this.resume();
				if (this.linearAdStarted && this.adsManager) { return false; }
			}
		},

		onPause: function() {
			if (this.platformExtensions.overrideOnPause) {
				this.platformExtensions.overrideOnPause();
				return;
			}
			if (this.adsManager && this.imaAdsManagerActive) {
				this.adPauseCalled = true;
				this.adsManager.pause();
				this.rootElement.find('div.oo_tap_panel').css('display', '');
				// (agunawan): a hack for iPad iOS8. Safari immediately register any elem click event right away.
				// Unlike any other version or even android and desktop browser.
				_.delay(_.bind(function() { this._createTapPanelClickListener(); }, this), 100);
			}
		},

		onStreamPaused: function() {
			if (this.platformExtensions.preOnStreamPaused) {
				this.platformExtensions.preOnStreamPaused();
			}
		},

		_createTapPanelClickListener: function() {
			// (TODO): May interfere with PBI ads_manager clickthrough. Consider to revise or remove.
			this.rootElement.find('div.oo_tap_panel').on("click", _.bind(
				function() {
					this.rootElement.find('div.oo_tap_panel').css('display', 'none');
					this.rootElement.find('div.oo_tap_panel').off("click");
					this.resume();
				}, this));
		},

		onContentPauseRequested: function() {
			this.adStarted = true;
			if (!this.contentEnded) {
				this.mb.addDependent(OO.EVENTS.PLAY, OO.EVENTS.GOOGLE_RESUME_CONTENT, "googleIma", function(){});
				this.googleResumeContentDispatched = false;
			}
			this._dispatchWillPlayAdEvent();
			this.mb.publish(OO.EVENTS.ADS_MANAGER_HANDLING_ADS);
			OO.log("Content Pause Requested by Google IMA!");
			if (this.platformExtensions.preOnContentPauseRequested) { this.platformExtensions.preOnContentPauseRequested(); }
			// video div is used
			if (this.adsManager.isCustomPlaybackUsed()) {
				this.mainVideo.css("left", OO.CSS.VISIBLE_POSITION);
			} else {
				this.mainVideo.css("left", OO.CSS.INVISIBLE_POSITION);
			}
			this.mb.publish(OO.EVENTS.PAUSE);
			if (!this.showInAdControlBar) {
				_.delay(_.bind(function(){ this.mb.publish(OO.EVENTS.DISABLE_PLAYBACK_CONTROLS); }, this), 100);
			}
			this.imaAdsManagerActive = true;
			this.mainVideo.off("ended", this.contentEndedHandler);
			this._deleteCustomPlayheadTracker();
			this.mb.publish(OO.EVENTS.BUFFERING);
		},

		disptachContentResume: function() {
			if (!this.googleResumeContentDispatched) {
				this.googleResumeContentDispatched = true;
				this.mb.publish(OO.EVENTS.GOOGLE_RESUME_CONTENT);
			}
		},

		onContentResumeRequested: function() {
			this.adStarted = false;
			if (this.contentResumeAlreadyCalled) {
				OO.log("Content Already resuming");
				return;
			}
			OO.log("Content Resume Requested by Google IMA!");
			if (this.platformExtensions.preOnContentResumeRequested) { this.platformExtensions.preOnContentResumeRequested(); }
			// plugins div was used
			if (this.adsManager && !this.adsManager.isCustomPlaybackUsed()) {
				this.mainVideo.css("left", OO.CSS.VISIBLE_POSITION);
				this.mainVideo.css("visibility", "visible");
			}
			this._unblockMainContentPlay(!this.contentEnded);
			if (!this.showInAdControlBar) {
				_.delay(_.bind(function(){ this.mb.publish(OO.EVENTS.ENABLE_PLAYBACK_CONTROLS); }, this), 100);
			}
			this.imaAdsManagerActive = false;

			this.mb.publish(OO.EVENTS.ADS_MANAGER_FINISHED_ADS);
			this.mainVideo.on("ended", this.contentEndedHandler);
			this.mb.publish(OO.EVENTS.ADS_PLAYED);
			this._setCustomPlayheadTracker();
			this.mb.publish(OO.EVENTS.BUFFERED);
		},

		resume: function(e) {
			if (this.linearAdStarted && this.adsManager) {
				this.adsManager.resume();
				// adPauseCalled assignment should not needed if google SDK publishes RESUMED event
				this.adPauseCalled = false;
				this.mb.publish(OO.EVENTS.PLAYING);
			}
		},

		onAdClick: function(adEvent) {
			if (!this.linearAdStarted) {
				return;
			} else if (this.adPauseCalled) {
				this.resume();
			} else if (this.platformExtensions.onMobileAdClick) {
				// Mobile should always PAUSE ads upon clickthrough, when ads is playing
				this.platformExtensions.onMobileAdClick();
			} else if (!this.playWhenAdClick) {
				// Desktop depends on playWhenAdClick param
				this.onPause();
			}
			this.mb.publish(OO.EVENTS.ADS_CLICKED);
		},

		_dispatchWillPlayAdEvent: function() {
			// TODO: fill in other metadata useful for ooyala reporter.js
			var adItem = { type: "GOOGLE_IMA" };
			this.mb.publish(OO.EVENTS.WILL_PLAY_ADS, adItem);
			this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_SEEK);
		},

		onAdEvent: function(adEvent) {
			// Retrieve the ad from the event. Some events (e.g. ALL_ADS_COMPLETED)
			// don't have ad object associated.
			var ad = adEvent.getAd();
			switch (adEvent.type) {
				case W.google.ima.AdEvent.Type.LOADED:
					// This is the first event sent for an ad - it is possible to
					// determine whether the ad is a video ad or an overlay.
					if (this.platformExtensions.preOnAdEventLoaded) { this.platformExtensions.preOnAdEventLoaded(); }
					this.isLinearAd = ad.isLinear();
					this._updateAdsManagerSize();
					break;
				case W.google.ima.AdEvent.Type.STARTED:
					// This event signalizes the ad has started - the video player
					// can adjust the UI, for example display a pause button and
					// remaining time.
					if (ad.isLinear()) {
						this.linearAdStarted = true;
						// For a linear ad, a timer can be started to poll for the remaining time.
						// Only publishes PlayheadTime event if it is NOT using <video> element, i.e. desktop
						// <video> element playhead is controlled by playback.js
						if (!this.adsManager.isCustomPlaybackUsed()) {
							clearInterval(this.playheadUpdateTimer);
							this.playheadUpdateTimer = setInterval(
								_.bind(function() {
									var remainingTime = (this.adsManager && this.adsManager.getRemainingTime() > 0) ?
										this.adsManager.getRemainingTime() : 0;
									var adsDuration = (ad && ad.getDuration() > 0) ? ad.getDuration() : 0;
									this.mb.publish(OO.EVENTS.PLAYHEAD_TIME_CHANGED,
										Math.max(adsDuration - remainingTime, 0), adsDuration, 0);
								}, this),
								PLAYHEAD_UPDATE_INTERVAL); // every 200ms
						}
						this.mb.publish(OO.EVENTS.BUFFERED);
					}
					break;
				case W.google.ima.AdEvent.Type.PAUSED:
					this.adPauseCalled = true;
					this.mb.publish(OO.EVENTS.WILL_PAUSE_ADS);
					break;
				case W.google.ima.AdEvent.Type.RESUMED:
					this.adPauseCalled = false;
					break;
				case W.google.ima.AdEvent.Type.SKIPPED:
				case W.google.ima.AdEvent.Type.COMPLETE:
					// This event signalizes the ad has finished - the video player
					// can do appropriate UI actions, like removing the timer for
					// remaining time detection.
					if (ad.isLinear()) {
						this.linearAdStarted = false;
						clearInterval(this.playheadUpdateTimer);
						this.playheadUpdateTimer = null;
						this.adPauseCalled = false;
					}
					this.onAdMetrics(adEvent);

					// (agunawan): Google SDK is not publishing CONTENT_RESUME with livestream!!! !@#!@#!@#@!#@
					if (this.isLivePlaying) {
						// You should know by know why I did this. Yep iOS8.
						_.delay(_.bind(function() { this.onContentResumeRequested(); }, this), 100);
					}
					if (this.platformExtensions.onAdEventComplete) { this.platformExtensions.onAdEventComplete(adEvent); }
					break;
				case W.google.ima.AdEvent.Type.ALL_ADS_COMPLETED:
					OO.log("all google ima ads completed!");
					if (this.platformExtensions.preOnAdEventAllAdsCompleted) { this.platformExtensions.preOnAdEventAllAdsCompleted(); }
					// ADS_PLAYED must be published first before GOOGLE_IMA_ALL_ADS_DONE (PLAYED)
					// for discovery toaster to show after postroll
					this.mb.publish(OO.EVENTS.ADS_PLAYED);
					this.mb.publish(OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE);
					break;
				case W.google.ima.AdEvent.Type.FIRST_QUARTILE:
				case W.google.ima.AdEvent.Type.MIDPOINT:
				case W.google.ima.AdEvent.Type.THIRD_QUARTILE:
					this.onAdMetrics(adEvent);
					break;
				default:
					OO.log("other ima event:", adEvent);
					break;
			}
		},

		onAdMetrics: function(adEvent) {
			OO.log("Google IMA Ad playthrough", adEvent.type);
		},

		onInitialPlay: function() {
			if (this.platformExtensions.overrideOnInitialPlay) {
				this.platformExtensions.overrideOnInitialPlay();
				return;
			}

			this.canSetupAdsRequest = true;
			this._setupAdsRequest();
		},

		onFullscreenChanged: function(event, shouldEnterFullscreen) {
			if (!OO.supportMultiVideo) { return; }
			this.isFullscreen = shouldEnterFullscreen;
			this._updateAdsManagerSize();
		},

		_updateAdsManagerSize: function() {
			if (this.adsManager) {
				if (this.isLinearAd) {
					// For linear ad, set the size to the full video player size.
					this.adsManager.resize(this.rootElement.width(), this.rootElement.height(),
						this.isFullscreen ? W.google.ima.ViewMode.FULLSCREEN : W.google.ima.ViewMode.NORMAL);
				} else {
					// For nonlinear ads, the ad slot can be adjusted at this time.
					// In this example, we make the ad to be shown at the bottom
					// of the slot. We also make the slot a bit shorter, so there is
					// a padding at the bottom.
					this.adsManager.resize(this.rootElement.width(), this.rootElement.height() - 40,
						W.google.ima.ViewMode.NORMAL);
					this.adsManager.align(
						W.google.ima.AdSlotAlignment.HorizontalAlignment.CENTER,
						W.google.ima.AdSlotAlignment.VerticalAlignment.BOTTOM);
				}
			}
		},

		// This method handles post roll
		onContentEnded: function() {
			this.contentEnded = true;
			if (this.adsLoader) { this.adsLoader.contentComplete(); }
		},

		onWillPlayFromBeginning: function() {
			this.contentEnded = false;
		},

		// (agunawan): This is a container to be called on constructor. Do not call this unless you know what you are doing.
		_customPlayheadUpdate: function() { this.customPlayheadTracker.currentTime = this.mainVideo[0].currentTime; },

		// Please use this and only this method to instantialize the playheadTracker interval
		_setCustomPlayheadTracker: function() {
			// (agunawan) absolutely only a single customTracker must be instantialized
			if (!this.customPlayheadTracker.updateInterval) {
				this.customPlayheadTracker.updateInterval = setInterval(this.customPlayheadIntervalFunction, 1000);
			}
		},

		// Please use this and only this method to delete the playheadTracker interval
		_deleteCustomPlayheadTracker: function() {
			clearInterval(this.customPlayheadTracker.updateInterval);
			delete this.customPlayheadTracker.updateInterval;
		},

		onScrubbing: function() {
			this._deleteCustomPlayheadTracker();
		},

		onScrubbed: function() {
			this._setCustomPlayheadTracker();
		},

		onSizeChanged: function() {
			this._updateAdsManagerSize();
		},

		preparePlatformExtensions: function() {
			if (OO.isAndroid && OO.isChrome) {
				this.platformExtensions = new (function(imaModule) {
					this.imaModule = imaModule;
				})(this);
				_.extend(this.platformExtensions, {
					preConstructor: function(messageBus, id) {
						this.imaModule.loadedMetadataFired = false;
						this.imaModule.adsLoaderReady = false;
						this.imaModule.firstClick = true;
						this.imaModule.initialPlayCalled = false;
						this.imaModule.initCalled = false;
						this.imaModule.unBlockAndroidPlayback = null;
					},
					overrideOnSdkLoaded: function() {
						clearInterval(this.imaModule.unblockPlaybackTimeout);
						W.googleImaSdkLoaded = true;
					},
					preOnSetEmbedCode: function(event, embedCode) {
						this.imaModule.loadedMetadataFired = false;
						this.imaModule.unBlockAndroidPlayback = null;
						this.imaModule.initCalled = false;
						this.imaModule.adsLoaderReady = false;
						this.imaModule.initialPlayCalled = false;
					},
					overrideOnVideoMetaLoaded: function(event) {
						if (this.imaModule.imaAdsManagerActive) { return; }
						this.imaModule.loadedMetadataFired = true;
						this.imaModule.customPlayheadTracker.duration = this.imaModule.mainVideo[0].duration;
						this.imaModule._setCustomPlayheadTracker();
						this.imaModule.platformExtensions.androidImaInit();
					},
					overrideOnMetadataFetched: function(event, response){
						OO.log("Metadata Ready:", response, this.imaModuleadTagUrl, this.imaModule.adTagUrlFromEmbedHash);
						this.imaModule.adTagUrl = this.imaModule.adTagUrlFromEmbedHash;

						var responseChecker =
							(response &&
							response['modules'] &&
							response['modules'][IMA_MODULE_TYPE] &&
							response['modules'][IMA_MODULE_TYPE]['metadata']);

						if (!this.imaModule.adTagUrl) {
							// set adTagUrl if it is not set yet.
							if (responseChecker) {
								var meta4 = response['modules'][IMA_MODULE_TYPE]['metadata'];
								this.imaModule.adTagUrl = meta4.adTagUrl || meta4.tagUrl;
								if (this.imaModule.rootElement && this.imaModule.adTagUrl) { this.imaModule._addDependentEvent(); }
							}
							this.imaModule._unBlockPlaybackReady();
						}

						// checks whether the page level has already overridden
						// if not, it will publish the metadata's showAdMarquee parameter
						if (!this.imaModule.marqueePageOverride) {
							if (responseChecker) {
								var meta5 = response['modules'][IMA_MODULE_TYPE]['metadata'];
								if (meta5.showAdMarquee) {
									this.imaModule.mb.publish(OO.EVENTS.SHOW_AD_MARQUEE, convertToBoolean(meta5.showAdMarquee));
								}
							}
						}

						//playWhenAdClick will be null if not set on page-level
						if (this.imaModule.playWhenAdClick === null) {
							if (responseChecker) {
								var meta6 = response['modules'][IMA_MODULE_TYPE]['metadata'];
								this.imaModule.playWhenAdClick = meta6.playWhenAdClick;
							}
						}

						if (!this.imaModule.maxAdsRequestTimeoutPageOverride && responseChecker) {
							if (typeof response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout !== 'undefined') {
								var timeOut = parseInt(response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout, 10);
								if (!_.isNaN(timeOut)) {
									this.imaModule.maxAdsRequestTimeout = timeOut;
								}
							}
						}
						this.imaModule._unBlockPlaybackReady();
						this.imaModule.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_SEEK);
						this.imaModule.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
					},
					postOnAdsManagerLoaded: function(event) {
						this.imaModule.adsLoaderReady = true;
						this.imaModule.platformExtensions.androidImaInit();
					},
					preOnContentResumeRequested: function() {
						//Protecting on Android from Resume Content getting called twice.
						this.imaModule.contentResumeAlreadyCalled = true;
					},
					preOnContentPauseRequested: function() {
						//reset flag to false if content paused.
						this.imaModule.contentResumeAlreadyCalled = false;
					},
					onMobileAdClick: function(event) {
						this.imaModule.onPause();
					},
					preOnAdEventLoaded: function() {
						if (this.imaModule.unBlockAndroidPlayback) { clearTimeout(this.imaModule.unBlockAndroidPlayback); }
					},
					overrideOnInitialPlay: function() {
						this.imaModule.initialPlayCalled = true;

						this.imaModule.adDisplayContainer = new W.google.ima.AdDisplayContainer(this.imaModule.rootElement.find("div.plugins")[0],
							this.imaModule.rootElement.find("video.video")[0]);
						this.imaModule.adsLoader = new W.google.ima.AdsLoader(this.imaModule.adDisplayContainer);

						this.imaModule.adsLoader.addEventListener(
							W.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
							_.bind(this.imaModule.onAdsManagerLoaded, this.imaModule),
							false);
						this.imaModule.adsLoader.addEventListener(
							W.google.ima.AdErrorEvent.Type.AD_ERROR,
							_.bind(this.imaModule.onImaAdError, this.imaModule),
							false);

						this.imaModule.canSetupAdsRequest = true;
						this.imaModule._setupAdsRequest();
						if(OO.isAndroid && OO.isChrome) {
							this.imaModule.mb.publish(OO.EVENTS.RELOAD_STREAM);
						}
						if (OO.supportMultiVideo) { this.imaModule.rootElement.find('div.oo_tap_panel').css('display', ''); }
						this.imaModule.adDisplayContainer.initialize();
						if (!OO.supportMultiVideo) {
							this.imaModule.mainVideo[0].load();
						}
						if (this.imaModule.adsManager) {
							try {
								this.imaModule.platformExtensions.androidImaInit();
							} catch(adError) {
								this.imaModule.onImaAdError(adError);
							}
						}
						if (this.imaModule.adTagUrl != null) {
							// Gate BUFFERED event when there is a valid adTagURL. Unlocked by imaError or successful ad request
							this.imaModule.mb.addDependent(OO.EVENTS.BUFFERED, OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING, "googleIma", function(){});
						}
						this.imaModule.mb.publish(OO.EVENTS.BUFFERING);
					},
					onAdEventComplete: function(adEvent) {
						//PBW-1691: IMA SDK isn't calling content resume after post-roll so we
						//don't get the chance to re-enable controls. So detect if we just completed
						//the final ad in a post-roll pod and fire content resume.
						var adPodInfo = adEvent.getAd().getAdPodInfo();
						if ( adPodInfo.getAdPosition() == adPodInfo.getTotalAds()) {
							this.imaModule.contentResumeRequest = _.delay(_.bind(function() {
								this.imaModule.onContentResumeRequested();
							}, this), 500);
						}
					},
					androidImaInit: function() {
						if (this.imaModule.adsLoaderReady && this.imaModule.loadedMetadataFired &&
							this.imaModule.initialPlayCalled && !this.imaModule.initCalled) {
							this.imaModule.initCalled = true;
							//ad rules will start from this call
							var w = this.imaModule.rootElement.width();
							var h = this.imaModule.rootElement.height();
							this.imaModule.adsManager.init(w, h, W.google.ima.ViewMode.NORMAL);
							//single ads will start here
							this.imaModule.adsManager.start();

							// IMA SDK is not correctly publishing contentResumeRequested.
							// (dustin) stealing agunawan's hack for iOS.
							var _this = this;
							this.imaModule.unBlockAndroidPlayback = _.delay(function() {
								_this.imaModule.disptachContentResume();
								_this.imaModule.mb.publish(OO.EVENTS.BUFFERED);
							}, DEFAULT_ADS_REQUEST_TIME_OUT);
						}
					}
				});
			}
			// Android 2.3.X tweaks
			else if (OO.isAndroid && !OO.isChrome) {
				this.platformExtensions = new (function(imaModule) {
					this.imaModule = imaModule;
				})(this);
				_.extend(this.platformExtensions, {
					postOnPlayerCreated: function() {
						// 2.3.X seems to need more than 3 seconds to finish a request,
						// so give it double the time
						this.imaModule.maxAdsRequestTimeout = 6000;
					},
					preOnAdEventAllAdsCompleted: function(adEvent) {
						// force the player to play after the preroll finishes,
						// IMA SDK isn't firing content resume events.
						_.delay(_.bind(function() {
							this.imaModule.onContentResumeRequested();
						}, this), 500);
					}
				});
			}
			else if (OO.isIos) {
				this.platformExtensions = new (function(imaModule) {
					this.imaModule = imaModule;
				})(this);
				_.extend(this.platformExtensions, {
					preConstructor: function(messageBus, id) {
						this.imaModule.loadedMetadataFired = false;
						this.imaModule.adsLoaderReady = false;
						this.imaModule.initialPlayCalled = false;
						this.imaModule.initCalled = false;
						this.imaModule.canSetupAdsRequest = false;
						this.imaModule.unBlockIOSPlayback = null;
					},
					overrideOnSdkLoaded: function() {
						// As per google guideline: prevent adDisplayContainer and adsRequest without user action (tap)
						if (this.imaModule.unblockPlaybackTimeout) {
							clearTimeout(this.imaModule.unblockPlaybackTimeout);
						}
					},
					preOnSetEmbedCode: function(event, embedCode) {
						this.imaModule.loadedMetadataFired = false;
						this.imaModule.adsLoaderReady = false;
						this.imaModule.initialPlayCalled = false;
						this.imaModule.initCalled = false;
						this.imaModule.canSetupAdsRequest = false;
						this.imaModule.unBlockIOSPlayback = null;
						// IMA SDK is not correctly publishing contentResumeRequested after postroll.
						// Manually set ended listener for the next setEmbedCode
						this.imaModule.mainVideo.on("ended", this.imaModule.contentEndedHandler);
					},
					postOnMetadataFetched: function() {
						// Unblock PLAYBACK_READY and INITIAL_PLAY onMetadataFetched, otherwise player will not be able to play
						this.imaModule._unBlockPlaybackReady();
						this.imaModule.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
					},
					overrideOnVideoMetaLoaded: function(event) {
						if (this.imaModule.imaAdsManagerActive) { return; }
						this.imaModule.loadedMetadataFired = true;
						this.imaModule.customPlayheadTracker.duration = this.imaModule.mainVideo[0].duration;
						this.imaModule._setCustomPlayheadTracker();
						this.imaModule.platformExtensions.iosImaInit();
					},
					postOnAdsManagerLoaded: function(event) {
						this.imaModule.adsLoaderReady = true;
						this.imaModule.platformExtensions.iosImaInit();
					},
					onMobileAdClick: function(event) {
						this.imaModule.onPause();
					},
					// IMA SDK is not correctly publishing contentResumeRequested. Clear out iOS hack set on iosImaInit.
					preOnAdEventLoaded: function() {
						if (this.imaModule.unBlockIOSPlayback) { clearTimeout(this.imaModule.unBlockIOSPlayback); }
					},
					// IMA SDK is not correctly publishing contentResumeRequested. Prevent playback_control to still think ads is still playing
					preOnAdEventAllAdsCompleted: function() {
						if (OO.isIpad) {
							this.imaModule.rootElement.find('div.plugins').css('display', 'none');
						}
						this.imaModule.mb.publish(OO.EVENTS.ENABLE_PLAYBACK_CONTROLS);
						this.imaModule.mb.publish(OO.EVENTS.ADS_MANAGER_FINISHED_ADS);
					},
					preOnContentPauseRequested: function() {
						// PBW-1910: Google IMA recommended to enable plugins div to show skippable button on iPad
						if (OO.isIpad) {
							this.imaModule.rootElement.find('div.plugins').css('display', 'block');
						}
					},
					preOnContentResumeRequested: function() {
						if (OO.isIpad) {
							this.imaModule.rootElement.find('div.plugins').css('display', 'none');
						}
					},
					// User Click will always get registered as INITIAL_PLAY on iOS. IMA module (or ads manager in future) have to PUBLISH
					// PLAY event if it is already playedOnce. Reset playedOnce on complete / setEmbedCode
					overrideOnInitialPlay: function() {
						if (this.imaModule.initialPlayCalled) {
							this.imaModule.mb.publish(OO.EVENTS.PLAY);
							return;
						}

						this.imaModule.initialPlayCalled = true;
						W.googleImaSdkLoaded = true;

						// PBW-1910: Google IMA recommended to remove custom click through out of iOS.
						this.imaModule.adDisplayContainer = new W.google.ima.AdDisplayContainer(
							this.imaModule.rootElement.find("div.plugins")[0],
							this.imaModule.rootElement.find("video.video")[0]
						);
						this.imaModule.adsLoader = new W.google.ima.AdsLoader(this.imaModule.adDisplayContainer);

						this.imaModule.adsLoader.addEventListener(
							W.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
							_.bind(this.imaModule.onAdsManagerLoaded, this.imaModule),
							false);
						this.imaModule.adsLoader.addEventListener(
							W.google.ima.AdErrorEvent.Type.AD_ERROR,
							_.bind(this.imaModule.onImaAdError, this.imaModule),
							false);

						this.imaModule.canSetupAdsRequest = true;
						this.imaModule._setupAdsRequest();

						if (OO.supportMultiVideo) { this.imaModule.rootElement.find('div.oo_tap_panel').css('display', ''); }
						this.imaModule.adDisplayContainer.initialize();
						if (!OO.supportMultiVideo) {
							this.imaModule.mainVideo[0].load();
						}

						this.imaModule.mb.publish(OO.EVENTS.BUFFERING);
						if (this.imaModule.adTagUrl != null) {
							// Gate BUFFERED event when there is a valid adTagURL. Unlocked by imaError or successful ad request
							this.imaModule.mb.addDependent(OO.EVENTS.BUFFERED, OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING, "googleIma", function(){});
						}
						this.imaModule.platformExtensions.iosImaInit();
					},
					iosImaInit: function() {
						if (this.imaModule.adsLoaderReady && this.imaModule.loadedMetadataFired && this.imaModule.adsManager &&
							this.imaModule.initialPlayCalled && !this.imaModule.initCalled) {
							this.imaModule.initCalled = true;
							//ad rules will start from this call
							var w = this.imaModule.rootElement.width();
							var h = this.imaModule.rootElement.height();
							this.imaModule.adsManager.init(w, h, W.google.ima.ViewMode.NORMAL);
							//single ads will start here
							this.imaModule.adsManager.start();

							// IMA SDK is not correctly publishing contentResumeRequested.
							// (agunawan) This is a hack. Google claims SDK always triggers contentResume event.
							// However I dont see it on iOS on these: solo midroll adSlot and skippable ads on iphone
							var _this = this;
							this.imaModule.unBlockIOSPlayback = _.delay(function() {
								_this.imaModule.disptachContentResume();
								_this.imaModule.mb.publish(OO.EVENTS.BUFFERED);
							}, DEFAULT_ADS_REQUEST_TIME_OUT);
						}
					},
					overrideOnPause: function() {
						//no-op
					},
					preOnStreamPaused: function() {
						// [PBW-1832] Fire pause logic on STREAM_PAUSED for iOS. This is for when the
						// user exits fullscreen by hitting the "Done" button which doesn't activate our pause logic.
						if (this.imaModule.adsManager && this.imaModule.imaAdsManagerActive) {
							this.imaModule.adPauseCalled = true;
							this.imaModule.adsManager.pause();
							this.imaModule.rootElement.find('div.oo_tap_panel').css('display', '');
							// (agunawan): a hack for iPad iOS8. Safari immediately register any elem click event right away.
							// Unlike any other version or even android and desktop browser.
							_.delay(_.bind(function() { this._createTapPanelClickListener(); }, this.imaModule), 100);
						}
					}
				});
			}
			else {
				this.platformExtensions = {};
			}
		},

		__placeholder: true
	});

	// Return class definition.
	return GoogleIma;
});