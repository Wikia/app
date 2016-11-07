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

	function create(imageContainer, slotSize, adSlot, slotParams) {
		var vastUrl = vastUrlBuilder.build(slotSize.width / slotSize.height, slotParams);
		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		return {
			adSlot: adSlot,
			events: {
				onVideoEnded: null
			},
			imageContainer: imageContainer,
			slotSize: slotSize,
			slotParams: slotParams,
			videoContainer: googleIma.setupIma(vastUrl, adSlot, slotSize.width, slotSize.height),
			play: function () {
				var self = this;
				googleIma.playVideo(self.slotSize.width, self.slotSize.height, function () {
					self.toggle(true);
					self.videoContainer =
						googleIma.setupIma(vastUrl, adSlot, self.slotSize.width, self.slotSize.height);

					if (self.events.onVideoEnded) {
						self.events.onVideoEnded();
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
			},
			updateSize: function (slotSize) {
				this.slotSize = slotSize;
			}
		};
	}

	return {
		create: create,
		init: init
	};
});
