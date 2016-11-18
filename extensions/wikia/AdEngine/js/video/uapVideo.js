/* global define */
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log'
], function (adHelper, DOMElementTweaker, videoAdFactory, log) {
	'use strict';

	var animationDuration = 400,
		logGroup = 'ext.wikia.adEngine.video.uapVideo';

	function showVideo(videoContainer, imageContainer, adSlot, params, getSlotWidth) {
		adSlot.style.height = getAdHeight(getSlotWidth(adSlot), params) + 'px';
		DOMElementTweaker.hide(imageContainer, false);
		DOMElementTweaker.removeClass(videoContainer, 'hidden');
		setTimeout(function () {
			adSlot.style.height = getVideoHeight(getSlotWidth(adSlot), params) + 'px';
		}, 0);

		setTimeout(function () {
			adSlot.style.height = '';
		}, animationDuration);
	}

	function hideVideo(videoContainer, imageContainer, adSlot, params, getSlotWidth) {
		adSlot.style.height = getVideoHeight(getSlotWidth(adSlot), params) + 'px';
		setTimeout(function () {
			adSlot.style.height = getAdHeight(getSlotWidth(adSlot), params) + 'px';
		}, 0);

		setTimeout(function () {
			DOMElementTweaker.hide(videoContainer, false);
			DOMElementTweaker.removeClass(imageContainer, 'hidden');
		}, animationDuration);

		setTimeout(function () {
			adSlot.style.height = '';
		}, animationDuration);
	}

	function getAdHeight(width, params) {
		return width / params.aspectRatio;
	}

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
					showVideo.bind(null, video.ima.container, imageContainer, adSlot, params, getSlotWidth),
					hideVideo.bind(null, video.ima.container, imageContainer, adSlot, params, getSlotWidth)
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
