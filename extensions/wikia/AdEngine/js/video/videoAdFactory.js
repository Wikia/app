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

		return {
			adSlot: adSlot,
			width: width,
			height: height,
			videoContainer: googleIma.prepareVideoAdContainer(adSlot),
			play: function (showVideo, hideVideo) {
				var self = this;

				googleIma.setupIma(vastUrl, adSlot, width, height);
				googleIma.playVideo(this.width, this.height, {
					onVideoEnded: function () {
						hideVideo(self.videoContainer);
						self.videoContainer = googleIma.setupIma(vastUrl, adSlot, self.width, self.height);
					},
					onVideoLoaded: function () {
						showVideo(self.videoContainer);
					}
				});
			},
			resize: function (width, height) {
				this.width = width;
				this.height = height;
				googleIma.resize(width, height);
			}
		};
	}

	return {
		create: create,
		init: init
	};
});
