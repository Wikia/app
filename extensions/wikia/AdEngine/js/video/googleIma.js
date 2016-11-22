/*global define, google, Promise*/
define('ext.wikia.adEngine.video.googleIma', [
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (scriptLoader, doc, log, win) {
	'use strict';
	var imaLibraryUrl = '//imasdk.googleapis.com/js/sdkloader/ima3.js',
		logGroup = 'ext.wikia.adEngine.video.googleIma',
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

	function prepareVideoAdContainer(videoAdContainer) {
		videoAdContainer.style.position = 'relative';
		videoAdContainer.classList.add('hidden');
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

	function createIma() {
		return {
			adDisplayContainer: null,
			adsLoader: null,
			adsManager: null,
			container: null,
			events: {},
			isAdsManagerLoaded: false,
			addEventListener: function (eventName, callback) {
				this.events[eventName] = this.events[eventName] || [];
				this.events[eventName].push(callback);
			},
			playVideo: function (width, height) {
				var self = this,
					callback = function () {
						// https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.AdDisplayContainer.initialize
						self.adDisplayContainer.initialize();
						self.adsManager.init(width, height, google.ima.ViewMode.NORMAL);
						self.adsManager.start();
					};

				if (this.isAdsManagerLoaded) {
					callback();
				} else {
					this.adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, callback, false);
				}
			},
			resize: function (width, height) {
				if (this.adsManager) {
					this.adsManager.resize(width, height, google.ima.ViewMode.NORMAL);
				}
			}
		};
	}

	function setupIma(vastUrl, adContainer, width, height) {
		var ima = createIma();

		function adsManagerLoadedCallback(adsManagerLoadedEvent){
			var adsRenderingSettings = new google.ima.AdsRenderingSettings();
			ima.adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, adsRenderingSettings);
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
