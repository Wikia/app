/* global define */
define('ext.wikia.adEngine.video.uapVideoAd', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document'
], function (DOMElementTweaker, doc) {
	'use strict';

	function toggle(video, imageContainer, showAd) {
		if (showAd) {
			DOMElementTweaker.hide(video, false);
			DOMElementTweaker.removeClass(imageContainer, 'hidden');
		} else {
			DOMElementTweaker.hide(imageContainer, false);
			DOMElementTweaker.removeClass(video, 'hidden');
		}
	}

	function init(container, imageContainer, url) {
		var videoElement = doc.createElement('video');

		videoElement.src = url;
		DOMElementTweaker.hide(videoElement, false);
		container.appendChild(videoElement);

		onEnded(videoElement, imageContainer);

		return videoElement;
	}

	function onEnded(video, imageContainer) {
		video.addEventListener('ended', function () {
			toggle(video, imageContainer, true);
		});
	}

	function playAndToggle(video, imageContainer) {
		video.play();
		toggle(video, imageContainer, false);
	}

	return {
		init: init,
		playAndToggle: playAndToggle
	};
});
