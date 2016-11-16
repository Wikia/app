/* global define, google, Promise */
define('ext.wikia.adEngine.video.googleIma', [
	'ext.wikia.adEngine.utils.scriptLoader'
], function (scriptLoader) {
	'use strict';
	var adDisplayContainer,
		adsLoader,
		adsManager,
		imaLibraryUrl = '//imasdk.googleapis.com/js/sdkloader/ima3.js',
		isAdsManagerLoaded = false,
		videoMock = document.createElement('video');

	function isInitialized() {
		return !!window.google && !!window.google.ima;
	}

	function init() {
		if (isInitialized()) {
			return new Promise(function (resolve, reject) {
				resolve();
			});
		}

		return scriptLoader.loadScript(imaLibraryUrl);
	}

	function onAdsManagerLoaded(adsManagerLoadedEvent) {
		var adsRenderingSettings = new google.ima.AdsRenderingSettings();
		adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, adsRenderingSettings);
		isAdsManagerLoaded = true;
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
		isAdsManagerLoaded = false;
		adDisplayContainer = new google.ima.AdDisplayContainer(adContainer);
		adsLoader = new google.ima.AdsLoader(adDisplayContainer);
		adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, onAdsManagerLoaded, false);
		adsLoader.requestAds(createRequest(vastUrl, width, height));

		adDisplayContainer.initialize();

		return prepareVideoAdContainer(adContainer.querySelector('div'));
	}

	function playVideo(width, height, callbacks) {
		runWhenAdsManagerLoaded(function () {
			adsManager.init(width, height, google.ima.ViewMode.NORMAL);
			adsManager.start();
			adsManager.addEventListener(google.ima.AdEvent.Type.COMPLETE, callbacks.onVideoEnded);
			adsManager.addEventListener(google.ima.AdEvent.Type.LOADED, callbacks.onVideoLoaded);
		});
	}

	function runWhenAdsManagerLoaded(callback) {
		if (isAdsManagerLoaded) {
			callback();
		} else {
			adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, callback, false);
		}
	}

	function resize(width, height) {
		adsManager.resize(width, height, google.ima.ViewMode.NORMAL);
	}

	return {
		init: init,
		playVideo: playVideo,
		resize: resize,
		setupIma: setupIma
	};
});
