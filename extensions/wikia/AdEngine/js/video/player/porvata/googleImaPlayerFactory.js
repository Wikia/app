/*global define*/
define('ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory', [
	'ext.wikia.adEngine.video.player.porvata.googleImaSetup',
	'ext.wikia.adEngine.video.player.porvata.moatVideoTracker',
	'ext.wikia.adEngine.video.vastDebugger',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (imaSetup, moatVideoTracker, vastDebugger, doc, log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory',
		imaViewMode = {};

	function getVideoElement() {
		var videoElement = doc.createElement('video');

		videoElement.setAttribute('preload', 'none');

		return videoElement;
	}

	function create(adDisplayContainer, adsLoader, videoSettings) {
		var adRequest,
			params = videoSettings.getParams(),
			isAdsManagerLoaded = false,
			status = '',
			videoElement = getVideoElement(),
			adsManager,
			mobileVideoAd = params.container.querySelector('video'),
			isFullscreen = false,
			eventListeners = {};

		imaViewMode = win.google.ima.ViewMode;

		function setVastAttributes(status) {
			var currentAd = adsManager && adsManager.getCurrentAd && adsManager.getCurrentAd(),
				playerElement = params.container.querySelector('.video-player');

			vastDebugger.setVastAttributes(playerElement, adRequest.adTagUrl, status, currentAd);
		}

		function adsManagerLoadedCallback(adsManagerLoadedEvent) {
			adsManager = adsManagerLoadedEvent.getAdsManager(videoElement, imaSetup.getRenderingSettings(params));
			isAdsManagerLoaded = true;

			if (videoSettings.isMoatTrackingEnabled()) {
				moatVideoTracker.init(
					adsManager,
					params.container,
					win.google.ima.ViewMode.NORMAL,
					params.src,
					params.adProduct + '/' + params.slotName
				);
			}

			dispatchEvent('wikiaAdsManagerLoaded');
			log('AdsManager loaded', log.levels.debug, logGroup);

			adsManager.addEventListener(win.google.ima.AdEvent.Type.LOADED, function () {
				setVastAttributes('success');
			});
			adsManager.addEventListener(win.google.ima.AdErrorEvent.Type.AD_ERROR, function () {
				setVastAttributes('error');
			});
		}

		function addEventListener(eventName, callback) {
			log(['addEventListener to AdManager', eventName], log.levels.debug, logGroup);

			if (eventName.indexOf('wikia') !== -1) {
				eventListeners[eventName] = eventListeners[eventName] || [];
				eventListeners[eventName].push(callback);
				return;
			}

			if (isAdsManagerLoaded) {
				adsManager.addEventListener(eventName, callback);
			} else {
				adsLoader.addEventListener(win.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, function () {
					adsManager.addEventListener(eventName, callback);
				});
			}
		}

		function removeEventListener(eventName, callback) {
			log(['removeEventListener to AdManager', eventName], log.levels.debug, logGroup);

			if (eventListeners[eventName]) {
				var listenerId = eventListeners[eventName].indexOf(callback);
				if (listenerId !== -1) {
					eventListeners[eventName].splice(listenerId, 1);
				}
				return;
			}

			if (isAdsManagerLoaded) {
				adsManager.removeEventListener(eventName, callback);
			} else {
				adsLoader.addEventListener(win.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, function () {
					adsManager.removeEventListener(eventName, callback);
				});
			}
		}

		function setAutoPlay(value) {
			// mobileVideoAd DOM element is present on mobile only
			if (mobileVideoAd) {
				mobileVideoAd.muted = value;
				mobileVideoAd.autoplay = value;
			}
		}

		function playVideo(width, height) {
			function callback() {
				var roundedWidth = Math.round(width),
					roundedHeight = Math.round(height);

				log(['Video play: prepare player UI', roundedWidth, roundedHeight], log.levels.debug, logGroup);
				dispatchEvent('wikiaAdPlayTriggered');

				// https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.AdDisplayContainer.initialize
				adDisplayContainer.initialize();
				adsManager.init(roundedWidth, roundedHeight, win.google.ima.ViewMode.NORMAL);
				adsManager.start();
				adsLoader.removeEventListener(win.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, callback);

				log('Video play: started', log.levels.debug, logGroup);
			}

			if (isAdsManagerLoaded) {
				callback();
			} else {
				// When adsManager is not loaded yet video can't start without click on mobile
				// Muted auto play is workaround to run video on adsManagerLoaded event
				setAutoPlay(true);
				adsLoader.addEventListener(win.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, callback, false);
				log(['Video play: waiting for full load of adsManager'], log.levels.debug, logGroup);
			}
		}

		function reload(reloadParams) {
			if (adsManager) {
				adsManager.destroy();
			}
			adsLoader.contentComplete();
			adRequest = imaSetup.createRequest(reloadParams || params);
			adsLoader.requestAds(adRequest);

			log('IMA player reloaded', log.levels.debug, logGroup);
		}

		function resize(width, height) {
			var viewMode;

			if (isFullscreen) {
				viewMode = imaViewMode.FULLSCREEN;
				width = win.innerWidth;
				height = win.innerHeight;
			} else {
				viewMode = imaViewMode.NORMAL;
				width = Math.round(width);
				height = Math.round(height);
			}

			if (adsManager) {
				adsManager.resize(width, height, viewMode);

				log(['IMA player resized', viewMode, width, height], log.levels.debug, logGroup);
			}
		}

		function toggleFullscreen() {
			isFullscreen = !isFullscreen;
			return isFullscreen;
		}

		function dispatchEvent(eventName) {
			if (eventListeners[eventName] && eventListeners[eventName].length > 0) {
				eventListeners[eventName].forEach(function (callback) {
					callback({});
				});
			}
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

		if (mobileVideoAd) {
			params.container.classList.add('mobile-porvata');
		}

		adsLoader.addEventListener(
			win.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
			adsManagerLoadedCallback,
			false
		);

		adsLoader.addEventListener(win.google.ima.AdErrorEvent.Type.AD_ERROR, function (event) {
			var emptyVastErrorCode = win.google.ima.AdError.ErrorCode.VAST_EMPTY_RESPONSE;

			if (typeof event.getError === 'function' && event.getError().getErrorCode() === emptyVastErrorCode) {
				dispatchEvent('wikiaEmptyAd');
			}

			setVastAttributes('error');
		});

		adRequest = imaSetup.createRequest(params);
		adsLoader.requestAds(adRequest);

		if (videoSettings.isAutoPlay()) {
			setAutoPlay(true);
		}

		addEventListener(win.google.ima.AdEvent.Type.RESUMED, setStatus('playing'));
		addEventListener(win.google.ima.AdEvent.Type.STARTED, setStatus('playing'));
		addEventListener(win.google.ima.AdEvent.Type.PAUSED, setStatus('paused'));
		addEventListener(win.google.ima.AdEvent.Type.COMPLETE, setStatus('completed'));

		return {
			addEventListener: addEventListener,
			dispatchEvent: dispatchEvent,
			getAdsManager: getAdsManager,
			getStatus: getStatus,
			playVideo: playVideo,
			reload: reload,
			removeEventListener: removeEventListener,
			resize: resize,
			setAutoPlay: setAutoPlay,
			toggleFullscreen: toggleFullscreen
		};
	}

	return {
		create: create
	};
});
