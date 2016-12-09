/*global define, google, Promise*/
define('ext.wikia.adEngine.video.googleIma', [
	'ext.wikia.adEngine.utils.scriptLoader',
	'ext.wikia.adEngine.video.googleImaAdStatus',
	'ext.wikia.adEngine.video.player.ui.closeButtonFactory',
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
		return scriptLoader.loadScript(imaLibraryUrl);
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

	function registerEvents(ima) {
		Object.keys(google.ima.AdEvent.Type).forEach(function (eventKey) {
			var eventName = google.ima.AdEvent.Type[eventKey];
			ima.adsManager.addEventListener(eventName, function (event) {
				ima.events[eventName] = ima.events[eventName] || [];

				ima.events[eventName].map(function (callback) {
					callback(ima, event);
				});
				log([eventName, event.getAdData()], log.levels.debug, logGroup);
			}, false);
		});

		Object.keys(google.ima.AdErrorEvent.Type).forEach(function (eventKey) {
			var eventName = google.ima.AdErrorEvent.Type[eventKey];
			ima.adsLoader.addEventListener(eventName, function (event) {
				ima.events[eventName] = ima.events[eventName] || [];

				ima.events[eventName].map(function (callback) {
					callback(ima, event);
				});
				log([eventName, event.getError()], log.levels.debug, logGroup);
			}, false);
		});
	}

	function addLayerOverVideo(ad) {
		var layer = document.createElement('div');

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
				var self = this,
					callback = function () {
						log('Video play: prepare player UI', log.levels.debug, logGroup);
						self.status = googleImaAdStatus.create(self);
						addLayerOverVideo(self);
						volumeControlHandler.init(self);

						// https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.AdDisplayContainer.initialize
						self.adDisplayContainer.initialize();
						self.adsManager.init(width, height, google.ima.ViewMode.NORMAL);
						self.adsManager.start();
						log('Video play: stared', log.levels.debug, logGroup);
					};

				if (this.isAdsManagerLoaded) {
					callback();
				} else if (!browserDetect.isMobile()) { // ADEN-4275 quick fix
					log(['Video play: waiting for full load of adsManager'], log.levels.debug, logGroup);
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

		function adsManagerLoadedCallback(adsManagerLoadedEvent){
			ima.adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, getRenderingSettings());
			registerEvents(ima);
			ima.isAdsManagerLoaded = true;
		}

		ima.adDisplayContainer = new google.ima.AdDisplayContainer(adContainer);
		ima.adsLoader = new google.ima.AdsLoader(ima.adDisplayContainer);
		ima.adsLoader.addEventListener(
			google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, adsManagerLoadedCallback, false);
		ima.adsLoader.requestAds(createRequest(vastUrl, width, height));
		ima.container = prepareVideoAdContainer(adContainer.querySelector('div'));

		return ima;
	}

	return {
		init: init,
		setupIma: setupIma
	};
});
