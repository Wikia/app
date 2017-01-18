/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.toggle', [
	'ext.wikia.adEngine.domElementTweaker'
], function (DOMElementTweaker) {
	'use strict';

	function toggle(elementToShow, elementToHide) {
		DOMElementTweaker.hide(elementToHide);
		DOMElementTweaker.show(elementToShow);
	}

	function hideVideo(video, params) {
		toggle(params.videoPlaceholderElement || params.image, video.container);
	}

	function showVideo(video, params) {
		toggle(video.container, params.videoPlaceholderElement || params.image);
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
