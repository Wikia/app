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
		toggle(params.image, video.container);
	}

	function add(video, params) {

		video.addEventListener('wikiaAdCompleted', function () {
			hideVideo(video, params);
		});
	}

	return {
		add: add
	};
});
