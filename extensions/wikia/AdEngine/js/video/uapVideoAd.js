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

	function toggle(container, video, ad, showAd) {
		if (showAd) {
			container.style.height = video.offsetHeight + 'px';
			container.style.height = getOriginalHeight(ad);

			setTimeout(function () {
				DOMElementTweaker.hide(video, false);
				DOMElementTweaker.removeClass(ad, 'hidden');
			}, animationDuration);
		} else {
			container.style.height = ad.offsetHeight + 'px';
			DOMElementTweaker.hide(ad, false);
			DOMElementTweaker.removeClass(video, 'hidden');
			container.style.height = video.offsetHeight + 'px';
		}

		setTimeout(function () {
			container.style.height = '';
		}, animationDuration);
	}

	function onEnded(container, video, ad) {
		video.addEventListener('ended', function () {
			toggle(container, video, ad, true);
		});
	}

	function init(container, ad, url) {
		var videoElement = doc.createElement('video');

		videoElement.src = url;
		DOMElementTweaker.hide(videoElement, false);
		container.appendChild(videoElement);

		onEnded(container, videoElement, ad);

		return videoElement;
	}

	function playAndToggle(container, video, ad) {
		video.play();
		toggle(container, video, ad, false);
	}

	return {
		init: init,
		playAndToggle: playAndToggle
	};
});
