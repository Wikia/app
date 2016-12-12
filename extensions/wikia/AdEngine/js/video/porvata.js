/*global define*/
define('ext.wikia.adEngine.video.porvata', [
	'ext.wikia.adEngine.video.googleIma',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.log'
], function (googleIma, vastUrlBuilder, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.porvata';

	function createPlayer(params, ima) {
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
				return ima.getAdsManager().getRemainingTime();
			},
			isMuted: function () {
				return ima.getAdsManager().getVolume() === 0;
			},
			isPaused: function () {
				return ima.status === 'paused';
			},
			pause: function () {
				ima.getAdsManager().pause();
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
				ima.getAdsManager().resume();
			},
			setVolume: function (volume) {
				return ima.getAdsManager().setVolume(volume);
			},
			stop: function () {
				ima.getAdsManager().stop();
			}
		}
	}

	function inject(params) {
		var vastUrl;

		params.vastTargeting = params.vastTargeting || {
				src: params.src,
				pos: params.slotName,
				passback: 'porvata'
			};

		vastUrl = params.vastUrl || vastUrlBuilder.build(params.width / params.height, params.vastTargeting);

		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		return googleIma.load()
			.then(function () {
				return googleIma.setup(vastUrl, params.container, params.width, params.height);
			}).then(function (ima) {
				return createPlayer(params, ima);
			}).then(function (video) {
				video.addEventListener('adCanPlay', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdStarted');
				});
				video.addEventListener('allAdsCompleted', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdCompleted');
				});
				video.addEventListener('start', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
				});
				video.addEventListener('resume', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
				});
				video.addEventListener('pause', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPause');
				});

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
