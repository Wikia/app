/*global define, google*/
define('ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory', [
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log'
], function(browserDetect, doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory';

	function create(adsRequestUrl, adDisplayContainer, adsLoader, adsRenderingSettings) {
			var isAdsManagerLoaded = false,
			status = '',
			videoMock = doc.createElement('video'),
			adsManager;

		function adsManagerLoadedCallback(adsManagerLoadedEvent) {
			adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, adsRenderingSettings);
			isAdsManagerLoaded = true;

			log('AdsManager loaded', log.levels.debug, logGroup);
		}

		function addEventListener(eventName, callback) {
			log(['addEventListener to AdManager', eventName], log.levels.debug, logGroup);

			if (isAdsManagerLoaded) {
				adsManager.addEventListener(eventName, callback);
			} else {
				adsLoader.addEventListener('adsManagerLoaded', function () {
					adsManager.addEventListener(eventName, callback);
				});
			}
		}

		function playVideo(width, height) {
			function callback() {
				log('Video play: prepare player UI', log.levels.debug, logGroup);

				// https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.AdDisplayContainer.initialize
				adDisplayContainer.initialize();
				adsManager.init(width, height, google.ima.ViewMode.NORMAL);
				adsManager.start();
				adsLoader.removeEventListener('adsManagerLoaded', callback);

				log('Video play: started', log.levels.debug, logGroup);
			}

			if (isAdsManagerLoaded) {
				callback();
			} else if (!browserDetect.isMobile()) { // ADEN-4275 quick fix
				log(['Video play: waiting for full load of adsManager'], log.levels.debug, logGroup);
				adsLoader.addEventListener('adsManagerLoaded', callback, false);
			} else {
				log(['Video play: trigger video play action is ignored'], log.levels.warning, logGroup);
			}
		}

		function reload() {
			adsManager.destroy();
			adsLoader.contentComplete();
			adsLoader.requestAds(adsRequestUrl);

			log('IMA player reloaded', log.levels.debug, logGroup);
		}

		function resize(width, height) {
			if (adsManager) {
				adsManager.resize(width, height, google.ima.ViewMode.NORMAL);

				log(['IMA player resized', width, height], log.levels.debug, logGroup);
			}
		}

		function dispatchEvent(eventName) {
			adsManager.dispatchEvent(eventName);
		}

		function setStatus(newStatus) {
			return function () {
				status = newStatus;
			};
		}

		function getStatus() {
			return status;
		}

		function getAdsManager() {
			return adsManager;
		}

		adsLoader.addEventListener('adsManagerLoaded', adsManagerLoadedCallback, false);
		adsLoader.requestAds(adsRequestUrl);

		addEventListener('resume', setStatus('playing'));
		addEventListener('start', setStatus('playing'));
		addEventListener('pause', setStatus('paused'));

		return {
			addEventListener: addEventListener,
			dispatchEvent: dispatchEvent,
			getAdsManager: getAdsManager,
			getStatus: getStatus,
			playVideo: playVideo,
			reload: reload,
			resize: resize
		};
	}

	return {
		create: create
	};
});
