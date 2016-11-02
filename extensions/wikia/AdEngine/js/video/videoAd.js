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

	function create(imageContainer, slotWidth, slotHeight, adSlot, slotParams, onVideoEndedCallback) {
		var vastUrl = vastUrlBuilder.build(slotWidth / slotHeight, slotParams),
			videoContainer = googleIma.setupIma(vastUrl, adSlot, slotWidth, slotHeight);

		return {
			imageContainer: imageContainer,
			slotWidth: slotWidth,
			slotHeight: slotHeight,
			adSlot: adSlot,
			slotParams: slotParams,
			onVideoEndedCallback: onVideoEndedCallback,
			videoContainer: videoContainer,
			play: function () {
				var self = this;
				googleIma.playVideo(slotWidth, slotHeight, function () {
					self.toggle(true);
					self.videoContainer = googleIma.setupIma(vastUrl, adSlot, slotWidth, slotHeight);
					if (onVideoEndedCallback) {
						onVideoEndedCallback();
					}
				});

				this.toggle(false);
			},
			toggle: function (showAd) {
				if (showAd) {
					DOMElementTweaker.hide(this.videoContainer, false);
					DOMElementTweaker.removeClass(this.imageContainer, 'hidden');
				} else {
					DOMElementTweaker.hide(this.imageContainer, false);
					DOMElementTweaker.removeClass(this.videoContainer, 'hidden');
				}
			}
		};
	}

	return {
		init: init,
		onLibraryReady: onLibraryReady,
		create: create
	};
});
