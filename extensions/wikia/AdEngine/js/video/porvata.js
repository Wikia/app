/*global define*/
define('ext.wikia.adEngine.video.porvata', [
	'ext.wikia.adEngine.video.googleIma',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.log'
], function (googleIma, vastUrlBuilder, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.porvata';

	function inject(params) {
		params.vastTargeting = params.vastTargeting || {
				src: params.src,
				pos: params.slotName,
				passback: 'porvata'
			};

		var vastUrl = params.vastUrl || vastUrlBuilder.build(params.width / params.height, params.vastTargeting);

		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		return googleIma.load()
			.then(function () {
				log(['ima library loaded'], log.levels.debug, logGroup);

				return googleIma.setupIma(vastUrl, params.container, params.width, params.height);
			}).then(function (ima) {
				log(['ima set up'], log.levels.debug, logGroup);
				return {
					adSlot: params.container,
					width: params.width,
					height: params.height,
					ima: ima,
					container: ima.container,
					addEventListener: function (eventName, callback) {
						ima.addEventListener(eventName, callback);
					},
					getRemainingTime: function () {
						return ima.adsManager.getRemainingTime();
					},
					isMuted: function () {
						return ima.adsManager.getVolume() === 0;
					},
					isPaused: function () {
						return ima.status && this.ima.status.get() === 'paused';
					},
					pause: function () {
						ima.adsManager.pause();
					},
					play: function (width, height) {
						if (width !== undefined && height !== undefined) {
							this.width = width;
							this.height = height;
						}
						ima.playVideo(this.width, this.height);
					},
					reload: function () {
						ima.reload();
					},
					resize: function (width, height) {
						this.width = width;
						this.height = height;
						ima.resize(width, height);
					},
					resume: function () {
						ima.adsManager.resume();
					},
					setVolume: function (volume) {
						return ima.adsManager.setVolume(volume);
					},
					stop: function () {
						ima.adsManager.stop();
					}
				}
			}).then(function (video) {

				if (params.onReady) {
					params.onReady(video);
				}

				if (params.autoPlay) {
					video.play();
				}

				return video;
			});
	}

	return {
		inject: inject
	};
});
