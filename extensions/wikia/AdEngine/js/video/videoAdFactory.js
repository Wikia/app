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

	function create(width, height, adSlot, slotParams) {
		var vastUrl = vastUrlBuilder.build(width / height, slotParams);
		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		var ima = googleIma.setupIma(vastUrl, adSlot, width, height);
		return {
			adSlot: adSlot,
			width: width,
			height: height,
			videoContainer: ima.container,
			ima: ima,
			play: function (onVideoLoaded, onVideoEnded) {
				var self = this;

				googleIma.playVideo(ima, this.width, this.height, {
					onVideoEnded: function () {
						onVideoEnded(self.videoContainer);
						self.ima = googleIma.setupIma(vastUrl, adSlot, self.width, self.height);
						self.videoContainer = self.ima.container;
					},
					onVideoLoaded: function () {
						onVideoLoaded(self.videoContainer);
					}
				});
			},
			resize: function (width, height) {
				this.width = width;
				this.height = height;
				googleIma.resize(this.ima, width, height);
			}
		};
	}

	return {
		create: create,
		init: init
	};
});
