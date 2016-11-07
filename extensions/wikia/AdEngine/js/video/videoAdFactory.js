/* global define */
define('ext.wikia.adEngine.video.videoAdFactory', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.video.googleIma',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.log'
], function (DOMElementTweaker, googleIma, vastUrlBuilder, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.videoAdFactory';

	function init() {
		return googleIma.init();
	}

	function itCanBeCreated(slotWidth, slotHeight) {
		return slotWidth > 0 && slotHeight > 0;
	}

	function create(imageContainer, slotWidth, slotHeight, adSlot, slotParams, onVideoEndedCallback) {
		var vastUrl,
			videoContainer;

		if (!itCanBeCreated(slotWidth, slotHeight)) {
			log(['Video can\'t be created', 'size not correct:', slotWidth, slotHeight], log.levels.error, logGroup);
			throw new Error('Size of video slot is not correct');
		}

		vastUrl = vastUrlBuilder.build(slotWidth / slotHeight, slotParams);
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
		create: create,
		init: init
	};
});
