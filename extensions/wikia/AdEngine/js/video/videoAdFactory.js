/*global define*/
define('ext.wikia.adEngine.video.videoAdFactory', [
	'ext.wikia.adEngine.video.googleIma',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.log',
	'wikia.window'
], function (googleIma, vastUrlBuilder, log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.videoAdFactory';

	function init() {
		return googleIma.init();
	}

	function create(width, height, adSlot, slotParams, vastUrl, preventImaReload) {
		vastUrl = vastUrl || vastUrlBuilder.build(width / height, slotParams);
		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		return {
			adSlot: adSlot,
			width: width,
			height: height,
			ima: googleIma.setupIma(vastUrl, adSlot, width, height),
			play: function () {
				var self = this;

				if (!preventImaReload) {
					this.ima.addEventListener(win.google.ima.AdEvent.Type.COMPLETE, function () {
						var events = self.ima.events;
						self.ima = googleIma.setupIma(vastUrl, adSlot, self.width, self.height);
						self.ima.events = events;
					});
				}
				this.ima.playVideo(this.width, this.height);
			},
			resize: function (width, height) {
				this.width = width;
				this.height = height;
				this.ima.resize(width, height);
			}
		};
	}

	return {
		create: create,
		init: init
	};
});
