/* global define */
define('ext.wikia.adEngine.video.uapVideoAnimation', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.domElementTweaker'
], function (adHelper, DOMElementTweaker) {
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

	function hideVideo(video, imageContainer, adSlot, params, getSlotWidth) {
		var videoContainer = video.ima.container;
		updateHeight(adSlot, getVideoHeight(getSlotWidth(adSlot), params));
		setTimeout(function () {
			updateHeight(adSlot, getAdHeight(getSlotWidth(adSlot), params));
		}, 0);

		setTimeout(function () {
			toggle(imageContainer, videoContainer);
		}, animationDuration);

		setTimeout(function () {
			updateHeight(adSlot);
		}, animationDuration);
	}

	function showVideo(video, imageContainer, adSlot, params, getSlotWidth) {
		var videoContainer = video.ima.container;
		updateHeight(adSlot, getAdHeight(getSlotWidth(adSlot), params));
		toggle(videoContainer, imageContainer);
		setTimeout(function () {
			updateHeight(adSlot, getVideoHeight(getSlotWidth(adSlot), params));
		}, 0);

		setTimeout(function () {
			updateHeight(adSlot);
		}, animationDuration);
	}

	return {
		showVideo: showVideo,
		hideVideo: hideVideo
	};
});
