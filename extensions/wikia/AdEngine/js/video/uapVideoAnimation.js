/* global define */
define('ext.wikia.adEngine.video.uapVideoAnimation', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.window'
], function (adHelper, DOMElementTweaker, win) {
	'use strict';

	var animationDuration = 400;

	function getAdHeight(width, params) {
		return width / params.aspectRatio;
	}

	function getVideoHeight(width, params) {
		return width / params.videoAspectRatio;
	}

	function updateHeight(element, value) {
		value = value ? value + 'px' : '';
		element.style.height = value;
	}

	function toggle(elementToShow, elementToHide) {
		DOMElementTweaker.hide(elementToHide, false);
		DOMElementTweaker.removeClass(elementToShow, 'hidden');
	}

	function clearHeight(element) {
		setTimeout(function () {
			element.style.height = '';
		}, animationDuration);
	}

	function hideVideo(video, imageContainer, adSlot, params, getSlotWidth) {
		var videoContainer = video.ima.container,
		recoveredImageContainer = document.getElementById(win._sp_.getElementId('wikia_gpt/5441/wka.life/_project43//article/gpt/TOP_LEADERBOARD')).parentNode;
		updateHeight(adSlot, getVideoHeight(getSlotWidth(adSlot), params));
		updateHeight(adSlot, getAdHeight(getSlotWidth(adSlot), params));

		setTimeout(function () {
			toggle(recoveredImageContainer, videoContainer);
		}, animationDuration);

		clearHeight(adSlot);
	}

	function showVideo(video, imageContainer, adSlot, params, getSlotWidth) {
		var videoContainer = video.ima.container,
			recoveredImageContainer = document.getElementById(win._sp_.getElementId('wikia_gpt/5441/wka.life/_project43//article/gpt/TOP_LEADERBOARD')).parentNode;
		updateHeight(adSlot, getAdHeight(getSlotWidth(adSlot), params));
		updateHeight(adSlot, getVideoHeight(getSlotWidth(adSlot), params));

		toggle(videoContainer, recoveredImageContainer);
		clearHeight(adSlot);
	}

	return {
		showVideo: showVideo,
		hideVideo: hideVideo
	};
});
