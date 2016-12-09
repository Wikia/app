/*global define*/
define('ext.wikia.adEngine.video.videoAdFactory', [
	'ext.wikia.adEngine.video.googleIma',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.log'
], function (googleIma, vastUrlBuilder, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.videoAdFactory';

	function init() {
		return googleIma.init();
	}

	function create(width, height, adSlot, slotParams, vastUrl) {
		vastUrl = vastUrl || vastUrlBuilder.build(width / height, slotParams);
		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		var ima = googleIma.setupIma(vastUrl, adSlot, width, height);

		return {
			adSlot: adSlot,
			width: width,
			height: height,
			ima: ima,
			container: ima.container,
			addEventListener: function (eventName, callback) {
				this.ima.addEventListener(eventName, callback);
			},
			play: function (width, height) {
				if (width !== undefined && height !== undefined) {
					this.width = width;
					this.height = height;
				}
				this.ima.playVideo(this.width, this.height);
			},
			reload: function () {
				var events = this.ima.events;
				this.ima = googleIma.setupIma(vastUrl, adSlot, this.width, this.height);
				this.ima.events = events;
				this.container = this.ima.container;
			},
			resize: function (width, height) {
				this.width = width;
				this.height = height;
				this.ima.resize(width, height);
			},
			stop: function () {
				this.ima.adsManager.stop();
			}
		};
	}

	return {
		create: create,
		init: init
	};
});
