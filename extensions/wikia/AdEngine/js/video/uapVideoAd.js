/* global define */
define('ext.wikia.adEngine.video.uapVideoAd', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document'
], function (DOMElementTweaker, doc) {
	'use strict';

	function create(container, url) {
		var videoElement = doc.createElement('video');

		videoElement.src = url;
		DOMElementTweaker.hide(videoElement, false);

		container.appendChild(videoElement);

		return videoElement;
	}

	function onEnded(video, cb) {
		video.addEventListener('ended', cb);
	}

	return {
		create: create,
		onEnded: onEnded
	};
});
