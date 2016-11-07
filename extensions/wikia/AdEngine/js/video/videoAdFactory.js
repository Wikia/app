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

	function create(imageContainer, getSlotWidth, getSlotHeight, adSlot, slotParams, onVideoEndedCallback) {
		var vastUrl = vastUrlBuilder.build(getSlotWidth() / getSlotHeight(), slotParams);
		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		return {
			adSlot: adSlot,
			imageContainer: imageContainer,
			onVideoEndedCallback: onVideoEndedCallback,
			slotParams: slotParams,
			videoContainer: googleIma.setupIma(vastUrl, adSlot, getSlotWidth(), getSlotHeight()),
			play: function () {
				var slotHeight = getSlotHeight(),
					slotWidth = getSlotWidth(),
					self = this;

				googleIma.playVideo(slotWidth, slotHeight, function () {
					self.toggle(true);
					self.videoContainer = googleIma.setupIma(vastUrl, adSlot, slotWidth, slotHeight);
					if (onVideoEndedCallback) {
						onVideoEndedCallback();
						log('On video ended callback is executed', log.levels.info, logGroup);
					}
				});

				this.toggle(false);
			},
			toggle: function (showAd) {
				if (showAd) {
					log('Hide vided ad/show image ad', log.levels.info, logGroup);
					DOMElementTweaker.hide(this.videoContainer, false);
					DOMElementTweaker.removeClass(this.imageContainer, 'hidden');
				} else {
					log('Hide image ad/show video ad', log.levels.info, logGroup);
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
