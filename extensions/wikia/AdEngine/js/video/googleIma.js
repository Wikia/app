/*global define, google, Promise*/
define('ext.wikia.adEngine.video.googleIma', [
    'ext.wikia.adEngine.video.player.ui.closeButton',
	'ext.wikia.adEngine.utils.scriptLoader',
	'ext.wikia.adEngine.video.googleImaAdStatus',
	'ext.wikia.adEngine.video.volumeControlHandler',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (closeButton, scriptLoader, googleImaAdStatus, volumeControlHandler, doc, log, win) {
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
		videoAdContainer.classList.add('hidden', 'video-ima-container');
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

	function nextAction(status) {
		return status === 'paused' ? 'resume' : 'pause';
	}

	function addLayerOverVideo(ad) {
		var layer = document.createElement('div');
		layer.classList.add(videoLayerClassName);
		layer.appendChild(closeButton.create(ad));
		ad.container.appendChild(layer);

		layer.addEventListener('click', function () {
			ad.adsManager[nextAction(ad.status.get())]();
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
						self.status = googleImaAdStatus.create(self);
						addLayerOverVideo(self);

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
			adsRenderingSettings.enablePreloading = true;
			adsRenderingSettings.uiElements = [];
			ima.adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, adsRenderingSettings);
			registerEvents(ima);
			ima.isAdsManagerLoaded = true;
		}

		volumeControlHandler.init(ima, adContainer);

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
