/*global define*/
define('ext.wikia.adEngine.video.googleIma', [
	'ext.wikia.adEngine.video.vastBuilder',
	'wikia.lazyqueue',
	'wikia.loader',
	'wikia.log'
], function (vastBuilder, lazyQueue, loader, log) {
	'use strict';
	var adDisplayContainer,
		adsLoader,
		adsManager,
		googleIma,
		logGroup = 'ext.wikia.adEngine.video.googleIma',
		imaLibraryUrl = 'http://imasdk.googleapis.com/js/sdkloader/ima3.js',
		isAdsManagerLoaded = false,
		videoMock = {currentTime: 0};

	function initialize() {
		return loader({
			type: loader.JS,
			resources: imaLibraryUrl
		}).done(function () {
			googleIma = google.ima;
			log('ima library loaded correctly', log.levels.error, logGroup);
		}).fail(function () {
			log('ima library loading failed', log.levels.info, logGroup);
		});
	}

	function onAdsManagerLoaded(adsManagerLoadedEvent) {
		var adsRenderingSettings = new googleIma.AdsRenderingSettings();
		adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, adsRenderingSettings);
		isAdsManagerLoaded = true;
	}

	function createRequest(vastUrl, width, height) {
		var adsRequest = new googleIma.AdsRequest();

		adsRequest.adTagUrl = vastUrl;
		adsRequest.linearAdSlotWidth = width;
		adsRequest.linearAdSlotHeight = height;
		adsRequest.nonLinearAdSlotWidth = width;
		adsRequest.nonLinearAdSlotHeight = height;

		return adsRequest;
	}

	function prepareVideoAdContainer(videoAdContainer) {
		videoAdContainer.style.position = 'relative';
		videoAdContainer.classList.add('hidden');
		return videoAdContainer;
	}

	function setupIma(vastUrl, adContainer, width, height) {
		isAdsManagerLoaded = false;
		adDisplayContainer = new googleIma.AdDisplayContainer(adContainer);
		adsLoader = new googleIma.AdsLoader(adDisplayContainer);
		adsLoader.addEventListener(googleIma.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, onAdsManagerLoaded, false);
		adsLoader.requestAds(createRequest(vastUrl, width, height));

		adDisplayContainer.initialize();

		return prepareVideoAdContainer(adContainer.querySelector('div'));
	}

	function playVideo(width, height, onVideoFinishedCallback) {
		runWhenAdsManagerLoaded(function () {
			adsManager.init(width, height, googleIma.ViewMode.FULLSCREEN);
			adsManager.start();
			adsManager.addEventListener(googleIma.AdEvent.Type.COMPLETE, onVideoFinishedCallback);
		});
	}

	function runWhenAdsManagerLoaded(cb) {
		if (isAdsManagerLoaded) {
			cb();
		} else {
			adsLoader.addEventListener(googleIma.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, cb, false);
		}
	}

	return {
		initialize: initialize,
		playVideo: playVideo,
		setupIma: setupIma
	};
});
