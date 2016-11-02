/* global define */
define('ext.wikia.adEngine.video.videoAd', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.video.googleIma',
	'ext.wikia.adEngine.video.vastUrlBuilder'
], function (DOMElementTweaker, googleIma, vastUrlBuilder) {
	'use strict';

	var libraryStatus;

	function init() {
		libraryStatus = googleIma.initialize();
	}

	function onLibraryReady(callback) {
		libraryStatus.then(callback);
	}

	function setupIma(vastUrl, imageContainer, width, height) {
		return googleIma.setupIma(vastUrl, imageContainer, width, height);
	}

	function setupVideo(imageContainer, slotWidth, slotHeight,
						adSlot, slotParams, onVideoEndedCallback) {
		var vastUrl = vastUrlBuilder.build(slotWidth / slotHeight, slotParams),
			videoAdContainer = setupIma(vastUrl, adSlot, slotWidth, slotHeight);

		return function() {
			googleIma.playVideo(slotWidth, slotHeight, function () {
				toggle(videoAdContainer, imageContainer, true);
				videoAdContainer = setupIma(vastUrl, adSlot, slotWidth, slotHeight);
				if (onVideoEndedCallback) {
					onVideoEndedCallback();
				}
			});

			toggle(videoAdContainer, imageContainer, false);
		};
	}

	function toggle(videoContainer, imageContainer, showAd) {
		if (showAd) {
			DOMElementTweaker.hide(videoContainer, false);
			DOMElementTweaker.removeClass(imageContainer, 'hidden');
		} else {
			DOMElementTweaker.hide(imageContainer, false);
			DOMElementTweaker.removeClass(videoContainer, 'hidden');
		}
	}

	return {
		init: init,
		onLibraryReady: onLibraryReady,
		setupIma: setupIma,
		setupVideo: setupVideo
	};
});
