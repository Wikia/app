/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.toggleAnimation', [
	'ext.wikia.adEngine.domElementTweaker'
], function (DOMElementTweaker) {
	'use strict';

	var animationDuration = 400;

	function getAdHeight(params) {
		return params.container.clientWidth / params.aspectRatio;
	}

	function getVideoHeight(params) {
		return params.container.clientWidth / params.videoAspectRatio;
	}

	function updateHeight(element, value) {
		value = value ? value + 'px' : '';
		element.style.height = value;
	}

	function toggle(elementToShow, elementToHide) {
		DOMElementTweaker.hide(elementToHide);
		DOMElementTweaker.show(elementToShow);
	}

	function clearHeight(element) {
		setTimeout(function () {
			element.style.height = '';
		}, animationDuration);
	}

	function hideVideo(video, params) {
		updateHeight(params.container, getVideoHeight(params));
		updateHeight(params.container, getAdHeight(params));

		setTimeout(function () {
			toggle(params.image, video.container);
		}, animationDuration);

		clearHeight(params.container);
	}

	function showVideo(video, params) {
		updateHeight(params.container, getAdHeight(params));
		updateHeight(params.container, getVideoHeight(params));

		toggle(video.container, params.image);
		clearHeight(params.container);
	}

	function add(video, params) {
		video.addEventListener('wikiaAdStarted', function () {
			showVideo(video, params);
		});

		video.addEventListener('wikiaAdCompleted', function () {
			hideVideo(video, params);
		});
	}

	return {
		add: add
	};
});
