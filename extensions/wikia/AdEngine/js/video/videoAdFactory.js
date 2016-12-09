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
			getRemainingTime: function () {
				return this.ima.adsManager.getRemainingTime();
			},
			isMuted: function () {
				return this.ima.adsManager.getVolume() === 0;
			},
			isPaused: function () {
				return this.ima.status && this.ima.status.get() === 'paused';
			},
			pause: function () {
				this.ima.adsManager.pause();
			},
			play: function (width, height) {
				if (width !== undefined && height !== undefined) {
					this.width = width;
					this.height = height;
				}
				this.ima.playVideo(this.width, this.height);
			},
			reload: function () {
				this.ima.reload();
			},
			resize: function (width, height) {
				this.width = width;
				this.height = height;
				this.ima.resize(width, height);
			},
			resume: function () {
				this.ima.adsManager.resume();
			},
			setVolume: function (volume) {
				return this.ima.adsManager.setVolume(volume);
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
