/*global define, setTimeout*/
define('ext.wikia.adEngine.video.uapVideoAnimation', [
	'ext.wikia.adEngine.domElementTweaker'
], function (DOMElementTweaker) {
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

	function hideVideo(video, imageContainer, adSlot, params) {
		var videoContainer = video.ima.container;

		updateHeight(adSlot, getVideoHeight(adSlot.clientWidth, params));
		updateHeight(adSlot, getAdHeight(adSlot.clientWidth, params));

		setTimeout(function () {
			toggle(imageContainer, videoContainer);
		}, animationDuration);

		clearHeight(adSlot);
	}

	function showVideo(video, imageContainer, adSlot, params) {
		var videoContainer = video.ima.container;

		updateHeight(adSlot, getAdHeight(adSlot.clientWidth, params));
		updateHeight(adSlot, getVideoHeight(adSlot.clientWidth, params));

		toggle(videoContainer, imageContainer);
		clearHeight(adSlot);
	}

	return {
		showVideo: showVideo,
		hideVideo: hideVideo
	};
});
