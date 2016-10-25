/*global define, setTimeout*/
define('ext.wikia.adEngine.video.uapVideoAd', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document'
], function (DOMElementTweaker, doc) {
	'use strict';
	var animationDuration = 200;

	function getOriginalHeight(element) {
		var height;

		DOMElementTweaker.removeClass(element, 'hidden');
		height = element.offsetHeight + 'px';
		DOMElementTweaker.addClass(element, 'hidden');

		return height;
	}

	function toggle(video, imageContainer, showAd) {
		var leaderboard = doc.getElementById('TOP_LEADERBOARD');

		if (showAd) {
			leaderboard.style.height = video.offsetHeight + 'px';
			leaderboard.style.height = getOriginalHeight(imageContainer);

			setTimeout(function () {
				DOMElementTweaker.hide(video, false);
				DOMElementTweaker.removeClass(imageContainer, 'hidden');
			}, animationDuration);
		} else {
			leaderboard.style.height = imageContainer.offsetHeight + 'px';
			DOMElementTweaker.hide(imageContainer, false);
			DOMElementTweaker.removeClass(video, 'hidden');
			leaderboard.style.height = video.offsetHeight + 'px';
		}

		setTimeout(function () {
			leaderboard.style.height = '';
		}, animationDuration);
	}

	function onEnded(video, imageContainer) {
		video.addEventListener('ended', function () {
			toggle(video, imageContainer, true);
		});
	}

	function init(container, imageContainer, url) {
		var videoElement = doc.createElement('video');

		videoElement.src = url;
		DOMElementTweaker.hide(videoElement, false);
		container.appendChild(videoElement);

		onEnded(videoElement, imageContainer);

		return videoElement;
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
