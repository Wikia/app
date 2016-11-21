/* global define */
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.video.uapVideoAnimation',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log',
	'wikia.window'
], function (adHelper, uapContext, uapVideoAnimation, videoAdFactory, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.uapVideo';

	function getVideoHeight(width, params) {
		return width / params.videoAspectRatio;
	}

	function defaultGetSlotWidth(slot) {
		return slot.clientWidth;
	}

	function loadVideoAd(params, adSlot, imageContainer, getSlotWidth) {
		getSlotWidth = getSlotWidth || defaultGetSlotWidth;

		try {
			var video = videoAdFactory.create(
				getSlotWidth(adSlot),
				getVideoHeight(getSlotWidth(adSlot), params),
				adSlot,
				{
					src: 'gpt',
					pos: params.slotName,
					uap: params.uap || uapContext.getUapId(),
					passback: 'vuap'
				}
			);

			win.addEventListener('resize', adHelper.throttle(function () {
				var slotWidth = getSlotWidth(adSlot);
				video.resize(slotWidth, getVideoHeight(slotWidth, params));
			}));

			video.addEventListener(win.google.ima.AdEvent.Type.LOADED, function () {
				uapVideoAnimation.showVideo(video, imageContainer, adSlot, params, getSlotWidth);
			});
			video.addEventListener(win.google.ima.AdEvent.Type.COMPLETE, function () {
				uapVideoAnimation.hideVideo(video, imageContainer, adSlot, params, getSlotWidth);
			});

			params.videoTriggerElement.addEventListener('click', function () {
				video.play();
			});

			return video;
		} catch (error) {
			log(['Video can\'t be loaded correctly', error.message], log.levels.warning, logGroup);
		}
	}

	function isVideoAd(params) {
		return params.videoTriggerElement && params.videoAspectRatio;
	}

	return {
		init: videoAdFactory.init,
		isVideoAd: isVideoAd,
		loadVideoAd: loadVideoAd
	};
});
