/*global define*/
define('ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory', ['wikia.log'], function(log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory';

	function prepareVideoAdContainer(videoAdContainer) {
		videoAdContainer.style.position = 'relative';
		videoAdContainer.classList.add('hidden');
		videoAdContainer.classList.add('video-player');

		return videoAdContainer;
	}

	function create(params, ima) {
		var width = params.width,
			height = params.height;

		log(['create porvata player'], log.levels.debug, logGroup);

		return {
			container: prepareVideoAdContainer(params.container.querySelector('div')),
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

				console.log('********** PLAY', newWidth, newHeight);
				ima.playVideo(width, height);
			},
			reload: function () {
				ima.reload();
			},
			resize: function (newWidth, newHeight) {
				width = newWidth;
				height = newHeight;

				console.log('****** RESIZE' ,newHeight, newWidth);
				ima.resize(width, height);
			},
			resume: function () {
				ima.getAdsManager().resume();
			},
			setVolume: function (volume) {
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
