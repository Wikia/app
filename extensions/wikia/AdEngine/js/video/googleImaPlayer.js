require('ext.wikia.adEngine.video.googleImaPlayer', [
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log',
], function (browserDetect, doc, log) {

	function create(vastUrl, adContainer, width, height) {
		var adDisplayContainer = new google.ima.AdDisplayContainer(adContainer),
			adsLoader = new google.ima.AdsLoader(adDisplayContainer),
			adsManager = {}, isAdsManagerLoaded, container = prepareVideoAdContainer(adContainer),
			videoMock = doc.createElement('video'),
			status = '';

		adsLoader.requestAds(createRequest(vastUrl, width, height));
		adsLoader.addEventListener('adsManagerLoaded', adsManagerLoadedCallback, false);

		function adsManagerLoadedCallback(adsManagerLoadedEvent) {
			adsManager = adsManagerLoadedEvent.getAdsManager(videoMock, getRenderingSettings());
			isAdsManagerLoaded = true;
		}

		function addEventListener(eventName, callback) {
			if (isAdsManagerLoaded) {
				adsManager.addEventListener(eventName, callback);
			} else {
				adsLoader.addEventListener('adsManagerLoaded', function () {
					adsManager.addEventListener(eventName, callback);
				}.bind(this));
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
			adsLoader.requestAds(createRequest(vastUrl, width, height));
		}

		function resize(width, height) {
			if (adsManager) {
				adsManager.resize(width, height, google.ima.ViewMode.NORMAL);
			}
		}

		function dispatchEvent(eventName) {
			adsManager.dispatchEvent(eventName)
		}

		function setStatus(newStatus) {
			status = newStatus;
		}

		addEventListener(google.ima.AdEvent.Type.RESUMED, setStatus('playing'));
		addEventListener(google.ima.AdEvent.Type.STARTED, setStatus('playing'));
		addEventListener(google.ima.AdEvent.Type.PAUSED, setStatus('paused'));

		return {
			container: container,
			adsManager: adsManager,
			status: status,
			reload: reload,
			resize: resize,
			playVideo: playVideo,
			addEventListener: addEventListener,
			dispatchEvent: dispatchEvent
		}
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
		videoAdContainer.classList.add('video-player');

		return videoAdContainer;
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

	return {
		create: create
	}
}
)
;
