/*global define*/
define('ext.wikia.adEngine.video.porvata', [
	'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory',
	'ext.wikia.adEngine.video.player.porvata.googleIma',
	'wikia.log'
], function (porvataPlayerFactory, googleIma, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.porvata';

	function inject(params) {
		log(['injecting porvata player', params], log.levels.debug, logGroup);

		params.vastTargeting = params.vastTargeting || {
				src: params.src,
				pos: params.slotName,
				passback: 'porvata'
			};

		return googleIma.load()
			.then(function () {
				log('google ima loaded', log.levels.debug, logGroup);

				return googleIma.getPlayer(params);
			}).then(function (ima) {
				log(['ima player set up', ima], log.levels.debug, logGroup);

				return porvataPlayerFactory.create(params, ima);
			}).then(function (video) {
				log(['porvata video player created', video], log.levels.debug, logGroup);

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
