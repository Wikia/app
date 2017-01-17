/*global define*/
define('ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.log'
], function(DOMElementTweaker, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory',
		autoPlayClassName = 'autoplay';

	function prepareVideoAdContainer(videoAdContainer, params) {

		if (params.autoPlay) {
			videoAdContainer.style.width = params.videoWidth + '%';
			videoAdContainer.classList.add(autoPlayClassName);
		} else {
			videoAdContainer.style.position = 'relative';
			DOMElementTweaker.hide(videoAdContainer);
		}

		videoAdContainer.classList.add('video-player');

		return videoAdContainer;
	}

	function create(params, ima) {
		var width = params.width,
			height = params.height,
			mobileVideoAd = params.container.querySelector('video'),
			videoAdContainer = params.container.querySelector('div');

		log(['create porvata player'], log.levels.debug, logGroup);

		return {
			container: prepareVideoAdContainer(videoAdContainer, params),
			ima: ima,
			addEventListener: function (eventName, callback) {
				ima.addEventListener(eventName, callback);
			},
			getRemainingTime: function () {
				return ima.getAdsManager().getRemainingTime();
			},
			isMuted: function () {
				return ima.getAdsManager().getVolume() === 0;
			},
			isPaused: function () {
				return ima.getStatus() === 'paused';
			},
			pause: function () {
				ima.getAdsManager().pause();
			},
			play: function (newWidth, newHeight) {
				if (newWidth !== undefined && newHeight !== undefined) {
					width = newWidth;
					height = newHeight;
				}
				if (!width || !height) {
					width = params.container.offsetWidth;
					height = params.container.offsetHeight;
				}

				ima.playVideo(width, height);
			},
			reload: function () {
				ima.reload();
			},
			resize: function (newWidth, newHeight) {
				width = newWidth;
				height = newHeight;

				ima.resize(width, height);
			},
			resume: function () {
				ima.getAdsManager().resume();
			},
			setVolume: function (volume) {
				if (mobileVideoAd) {
					mobileVideoAd.muted = volume === 0;
				}
				return ima.getAdsManager().setVolume(volume);
			},
			stop: function () {
				ima.getAdsManager().stop();
			}
		};
	}

	return {
		create: create
	};
});
