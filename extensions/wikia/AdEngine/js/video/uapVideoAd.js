/*global define, setTimeout*/
define('ext.wikia.adEngine.video.uapVideoAd', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document'
], function (DOMElementTweaker, doc) {
	'use strict';
	var animationDuration = 400;

	function getOriginalHeight(element) {
		var height;

		DOMElementTweaker.removeClass(element, 'hidden');
		height = element.offsetHeight + 'px';
		DOMElementTweaker.addClass(element, 'hidden');

		return height;
	}

	function toggle(container, video, imageContainer, showAd) {
		if (showAd) {
			container.style.height = video.offsetHeight + 'px';
			container.style.height = getOriginalHeight(imageContainer);

			setTimeout(function () {
				DOMElementTweaker.hide(video, false);
				DOMElementTweaker.removeClass(imageContainer, 'hidden');
			}, animationDuration);
		} else {
			container.style.height = imageContainer.offsetHeight + 'px';
			DOMElementTweaker.hide(imageContainer, false);
			DOMElementTweaker.removeClass(video, 'hidden');
			container.style.height = video.offsetHeight + 'px';
		}

		setTimeout(function () {
			container.style.height = '';
		}, animationDuration);
	}

	function onEnded(container, video, imageContainer) {
		video.addEventListener('ended', function () {
			toggle(container, video, imageContainer, true);
		});
	}

	function init(container, imageContainer, url) {
		var videoElement = doc.createElement('video');

		videoElement.src = url;
		DOMElementTweaker.hide(videoElement, false);
		container.appendChild(videoElement);

		onEnded(container, videoElement, imageContainer);

		return videoElement;
	}

	function playAndToggle(container, video, imageContainer) {
		video.play();
		toggle(container, video, imageContainer, false);
	}

	return {
		init: init,
		playAndToggle: playAndToggle
	};
});
