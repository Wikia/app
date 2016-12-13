/*global define, google, Promise*/
define('ext.wikia.adEngine.video.googleIma', [
	'ext.wikia.adEngine.utils.scriptLoader',
	'ext.wikia.adEngine.video.googleImaAdStatus',
	'ext.wikia.adEngine.video.player.ui.closeButton',
	'ext.wikia.adEngine.video.volumeControlHandler',
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (scriptLoader, googleImaAdStatus, closeButton, volumeControlHandler, browserDetect, doc, log, win) {
	'use strict';
	var imaLibraryUrl = '//imasdk.googleapis.com/js/sdkloader/ima3.js',
		logGroup = 'ext.wikia.adEngine.video.googleIma',
		videoLayerClassName = 'overVideoLayer',
		videoMock = doc.createElement('video');

	function init() {
		if (win.google && win.google.ima) {
			return new Promise(function (resolve) {
				log('Google IMA library already loaded', log.levels.info, logGroup);
				resolve();
			});
		}

		var imaLib = _sp_.getSafeUri(imaLibraryUrl);

		return scriptLoader.loadScript(imaLib);
	}

	function createRequest(vastUrl, width, height) {
		var adsRequest = new google.ima.AdsRequest();

		adsRequest.adTagUrl = vastUrl;
		adsRequest.linearAdSlotWidth = width;
		adsRequest.linearAdSlotHeight = height;

		return adsRequest;
	}

	function createProgressBar() {
		var progressBar = doc.createElement('div'),
			currentTime = doc.createElement('div');

		progressBar.classList.add('progress-bar');
		currentTime.classList.add('current-time');

		progressBar.appendChild(currentTime);

		return progressBar;
	}

	function prepareVideoAdContainer(videoAdContainer) {
		var progressBar = createProgressBar();

		videoAdContainer.style.position = 'relative';
		videoAdContainer.classList.add('hidden');
		videoAdContainer.classList.add('video-ima-container');
		videoAdContainer.appendChild(progressBar);

		return videoAdContainer;
	}

	function registerEvents(ima, types) {
		Object.keys(types).forEach(function (eventKey) {
			var eventName = types[eventKey];
			ima.adsManager.addEventListener(eventName, function (event) {
				ima.events[eventName] = ima.events[eventName] || [];

				ima.events[eventName].map(function (callback) {
					callback(ima, event);
				});
				log([eventName, event], log.levels.debug, logGroup);
			}, false);
		});
	}

	function addLayerOverVideo(ad) {
		var layer = doc.createElement('div');

		layer.classList.add(videoLayerClassName);
		layer.appendChild(closeButton.create(ad));
		ad.container.appendChild(layer);

		layer.addEventListener('click', function () {
			if (ad && ad.adsManager && ad.status) {
				if (ad.status.get() === 'paused') {
					ad.adsManager.resume();
				} else {
					ad.adsManager.pause();
				}
			}
		});
	}

	function createIma() {
		return {
			status: null,
			adDisplayContainer: null,
			adMuted: false,
			adsLoader: null,
			adsManager: null,
			container: null,
			events: {},
			isAdsManagerLoaded: false,
			layerOverVideo: null,
			addEventListener: function (eventName, callback) {
				this.events[eventName] = this.events[eventName] || [];
				this.events[eventName].push(callback);
			},
			playVideo: function (width, height) {
				console.log('***** IMA PLAY VIDEO');
				var self = this,
					callback = function () {
						console.log('***** IMA CALLBACK PLAY VIDEO');
						log('Video play: prepare player UI', log.levels.debug, logGroup);
						self.status = googleImaAdStatus.create(self);
						addLayerOverVideo(self);
						volumeControlHandler.init(self);

						// https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.AdDisplayContainer.initialize
						self.adDisplayContainer.initialize();
						self.adsManager.init(width, height, google.ima.ViewMode.NORMAL);
						self.adsManager.start();
						console.log('***** VIDEO PLAY STARTED');
						log('Video play: stared', log.levels.debug, logGroup);
					};

				if (this.isAdsManagerLoaded) {
					console.log('***** ADS MANAGER LOADED');
					callback();
				} else if (!browserDetect.isMobile()) { // ADEN-4275 quick fix
					log(['Video play: waiting for full load of adsManager'], log.levels.debug, logGroup);
					console.log('***** WAITING FOR ADS MANAGER');
					console.log('*** ADS LOADER', this.adsLoader);
					console.log('***** ADS MANAGER', this.adsManager);
					this.adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, callback, false);
				} else {
					log(['Video play: trigger video play action is ignored'], log.levels.warning, logGroup);
				}
			},
			resize: function (width, height) {
				if (this.adsManager) {
					this.adsManager.resize(width, height, google.ima.ViewMode.NORMAL);
				}
			}
		};
	}

	function getRenderingSettings() {
		var adsRenderingSettings = new google.ima.AdsRenderingSettings(),
			maximumRecommendedBitrate = 68000; // 2160p High Frame Rate

		if (!browserDetect.isMobile()) {
			adsRenderingSettings.bitrate = maximumRecommendedBitrate;
		}

		adsRenderingSettings.enablePreloading = true;
		adsRenderingSettings.uiElements = [];
		return adsRenderingSettings;
	}

	function setupIma(vastUrl, adContainer, width, height) {
		var ima = createIma();

		console.log('**** SETUP IMA');

		function adsManagerLoadedCallback(adsManagerLoadedEvent){
			console.log('*******ADS MANAGER LOADED CALLBACK');
			ima.adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, getRenderingSettings());
			registerEvents(ima, google.ima.AdEvent.Type);
			registerEvents(ima, google.ima.AdErrorEvent.Type);
			ima.isAdsManagerLoaded = true;
		}

		ima.adDisplayContainer = new google.ima.AdDisplayContainer(adContainer);
		console.log('**** DISPLAY CONTAINER', ima.adDisplayContainer);
		ima.adsLoader = new google.ima.AdsLoader(ima.adDisplayContainer);
		console.log('**** ADS LOADER', ima.adsLoader);
		ima.adsLoader.addEventListener(
			google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, adsManagerLoadedCallback, false);
		ima.adsLoader.requestAds(createRequest(vastUrl, width, height));
		console.log('**** REQUSEST ADS, VAST', vastUrl);
		console.log('***** ADS REQUEST', createRequest(vastUrl, width, height));
		ima.container = prepareVideoAdContainer(adContainer.querySelector('div'));

		return ima;
	}

	return {
		init: init,
		setupIma: setupIma
	};
});
