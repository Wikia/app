/* global define */
define('ext.wikia.adEngine.video.uapVideoAd', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document'
], function (DOMElementTweaker, doc) {
	'use strict';

	function toggle(video, image, showAd) {
		if (showAd) {
			DOMElementTweaker.hide(video, false);
			DOMElementTweaker.removeClass(image, 'hidden');
		} else {
			DOMElementTweaker.hide(image, false);
			DOMElementTweaker.removeClass(video, 'hidden');
		}
	}

	function init(container, image, url) {
		var videoElement = doc.createElement('video');

		videoElement.src = url;
		DOMElementTweaker.hide(videoElement, false);
		container.appendChild(videoElement);

		onEnded(videoElement, image);

		return videoElement;
	}

	function onEnded(video, image) {
		video.addEventListener('ended', function () {
			toggle(video, image, true);
		});
	}

	function playAndToggle(video, image) {
		video.play();
		toggle(video, image, false);
	}

	return {
		init: init,
		playAndToggle: playAndToggle
	};
});
