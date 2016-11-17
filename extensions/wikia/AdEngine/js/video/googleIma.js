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

	function setupIma(vastUrl, adContainer, width, height) {
		var ima = {
			container: null,
			isAdsManagerLoaded: false,
			adDisplayContainer: null,
			adsLoader: null,
			adsManager: null
		};

		ima.adDisplayContainer = new google.ima.AdDisplayContainer(adContainer);
		ima.adsLoader = new google.ima.AdsLoader(ima.adDisplayContainer);
		ima.adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, function (adsManagerLoadedEvent) {
			var adsRenderingSettings = new google.ima.AdsRenderingSettings();
			ima.adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, adsRenderingSettings);
			ima.isAdsManagerLoaded = true;
		}, false);
		ima.adsLoader.requestAds(createRequest(vastUrl, width, height));
		ima.adDisplayContainer.initialize();
		ima.container = prepareVideoAdContainer(adContainer.querySelector('div'));

		return ima;
	}

	function playVideo(ima, width, height, callbacks) {
		runWhenAdsManagerLoaded(ima, function () {
			ima.adsManager.init(width, height, google.ima.ViewMode.NORMAL);
			ima.adsManager.start();
			ima.adsManager.addEventListener(google.ima.AdEvent.Type.COMPLETE, callbacks.onVideoEnded);
			ima.adsManager.addEventListener(google.ima.AdEvent.Type.LOADED, callbacks.onVideoLoaded);
		});
	}

	function runWhenAdsManagerLoaded(ima, callback) {
		if (ima.isAdsManagerLoaded) {
			callback();
		} else {
			ima.adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, callback, false);
		}
	}

	function resize(ima, width, height) {
		if (ima.adsManager) {
			ima.adsManager.resize(width, height, google.ima.ViewMode.NORMAL);
		}
	}

	return {
		init: init,
		playVideo: playVideo,
		resize: resize,
		setupIma: setupIma
	};
});
