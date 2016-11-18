/* global define */
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.video.uapVideoAnimation',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log'
], function (adHelper, DOMElementTweaker, uapVideoAnimation, videoAdFactory, log) {
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
					uap: params.uap,
					passback: 'vuap'
				}
			);

			window.addEventListener('resize', adHelper.throttle(function () {
				var slotWidth = getSlotWidth(adSlot);
				video.resize(slotWidth, getVideoHeight(slotWidth, params));
			}));

			params.videoTriggerElement.addEventListener('click', function () {
				video.play(
					uapVideoAnimation.showVideo.bind(null, video.ima.container, imageContainer, adSlot, params, getSlotWidth),
					uapVideoAnimation.hideVideo.bind(null, video.ima.container, imageContainer, adSlot, params, getSlotWidth)
				);
			});

		} catch (error) {
			log(['Video can\'t be loaded correctly', error.message], log.levels.warning, logGroup);
		}
	}

	return {
		init: videoAdFactory.init,
		loadVideoAd: loadVideoAd
	};
});
