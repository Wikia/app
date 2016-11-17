/*global define, google*/
define('ext.wikia.adEngine.video.googleIma', [
	'ext.wikia.adEngine.utils.scriptLoader'
], function (scriptLoader) {
	'use strict';
	var imaLibraryUrl = '//imasdk.googleapis.com/js/sdkloader/ima3.js',
		videoMock = document.createElement('video');

	function init() {
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

	function createIma() {
		return {
			container: null,
			isAdsManagerLoaded: false,
			adDisplayContainer: null,
			adsLoader: null,
			adsManager: null,
			playVideo: function (width, height, callbacks) {
				var self = this,
					callback = function () {
						self.adsManager.init(width, height, google.ima.ViewMode.NORMAL);
						self.adsManager.start();
						self.adsManager.addEventListener(google.ima.AdEvent.Type.COMPLETE, callbacks.onVideoEnded);
						self.adsManager.addEventListener(google.ima.AdEvent.Type.LOADED, callbacks.onVideoLoaded);
					};

				if (this.isAdsManagerLoaded) {
					callback();
				} else {
					this.adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, callback, false);
				}
			},
			resize: function(width, height){
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
			ima.isAdsManagerLoaded = true;
		}

		ima.adDisplayContainer = new google.ima.AdDisplayContainer(adContainer);
		ima.adsLoader = new google.ima.AdsLoader(ima.adDisplayContainer);
		ima.adsLoader.addEventListener(
			google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, adsManagerLoadedCallback, false);
		ima.adsLoader.requestAds(createRequest(vastUrl, width, height));
		ima.adDisplayContainer.initialize();
		ima.container = prepareVideoAdContainer(adContainer.querySelector('div'));

		return ima;
	}

	return {
		init: init,
		setupIma: setupIma
	};
});
