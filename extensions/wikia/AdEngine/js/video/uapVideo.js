/*global define*/
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.template.porvata',
	'ext.wikia.adEngine.video.uapVideoAnimation',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log',
	'wikia.window'
], function (adHelper, uapContext, porvata, uapVideoAnimation, videoAdFactory, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.uapVideo';

	function getVideoHeight(width, params) {
		return width / params.videoAspectRatio;
	}

	function getSlotWidth(slot) {
		return slot.clientWidth;
	}

	function updateProgressBar(ima) {
		var currentTime = ima.container.querySelector('.progress-bar > .current-time'),
			remainingTime = ima.adsManager.getRemainingTime();

		if (remainingTime) {
			currentTime.style.transitionDuration = remainingTime + 's';
			currentTime.style.width = '100%';
		} else {
			currentTime.style.width = '0';
		}
	}

	function addProgressListeners(video) {
		video.addEventListener('start', updateProgressBar);
		video.addEventListener('resume', updateProgressBar);
		video.addEventListener('complete', updateProgressBar);
		video.addEventListener('pause', function (ima) {
			var progressBar = ima.container.querySelector('.progress-bar'),
				currentTime = progressBar.querySelector('.current-time');

			currentTime.style.width = (currentTime.offsetWidth / progressBar.offsetWidth * 100) + '%';
		});
	}

	function loadPorvata(params, adSlot, imageContainer) {
		var videoWidth = getSlotWidth(adSlot);

		params.container = adSlot;
		params.width = videoWidth;
		params.height = getVideoHeight(videoWidth, params);
		params.vastTargeting = {
			src: params.src,
			pos: params.slotName,
			passback: 'vuap',
			uap: params.uap || uapContext.getUapId()
		};

		porvata.show(params)
			.then(function (video) {
				addProgressListeners(video);

				win.addEventListener('resize', adHelper.throttle(function () {
					var slotWidth = getSlotWidth(adSlot);
					video.resize(slotWidth, getVideoHeight(slotWidth, params));
				}));

				video.addEventListener(win.google.ima.AdEvent.Type.LOADED, function () {
					uapVideoAnimation.showVideo(video, imageContainer, adSlot, params);
				});

				video.addEventListener(win.google.ima.AdEvent.Type.ALL_ADS_COMPLETED, function () {
					uapVideoAnimation.hideVideo(video, imageContainer, adSlot, params);
					video.reload();
				});

				params.videoTriggerElement.addEventListener('click', function () {
					var slotWidth = getSlotWidth(adSlot);
					video.play(slotWidth, getVideoHeight(slotWidth, params));
				});

				return video;
			});

		log(['loadVideoAd', 'playwire'], log.levels.debug, logGroup);
	}

	function loadVideoAd(params, adSlot, imageContainer) {
		switch (params.player) {
			case 'playwire':
				log(['loadVideoAd', 'playwire']);
				break;
			default:
				loadPorvata(params, adSlot, imageContainer);
		}
	}

	function isEnabled(params) {
		return params.videoTriggerElement && params.videoAspectRatio;
	}

	return {
		init: videoAdFactory.init,
		isEnabled: isEnabled,
		loadVideoAd: loadVideoAd
	};
});
