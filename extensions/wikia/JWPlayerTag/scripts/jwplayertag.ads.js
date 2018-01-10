define('wikia.articleVideo.jwplayertag.ads', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'ext.wikia.adEngine.video.vastDebugger',
	'ext.wikia.adEngine.video.player.jwplayer.adsTracking',
	'wikia.log'
], function (adContext, vastUrlBuilder, megaAdUnitBuilder, srcProvider, vastDebugger, adsTracking, log) {
	'use strict';

	var aspectRatio = 640 / 480,
		baseSrc = adContext.get('targeting.skin') === 'oasis' ? 'gpt' : 'mobile',
		videoPassback = 'jwplayer',
		videoSlotName = 'VIDEO',
		videoSource,
		logGroup = 'wikia.articleVideo.jwplayertag.ads';

	function buildVastUrl(position, videoDepth, correlator) {
		var options = {
				correlator: correlator,
				vpos: position
			},
			slotParams = {
				passback: videoPassback,
				pos: videoSlotName,
				rv: videoDepth,
				src: videoSource
			};

		options.adUnit = megaAdUnitBuilder.build(slotParams.pos, slotParams.src);

		log(['buildVastUrl', position, videoDepth, slotParams, options], log.levels.debug, logGroup);

		return vastUrlBuilder.build(aspectRatio, slotParams, options);
	}

	return function(player) {
		var correlator,
			videoElement = player && player.getContainer && player.getContainer(),
			videoContainer = videoElement && videoElement.parentNode,
			prerollPositionReached = false,
			trackingParams = {
				adProduct: 'video',
				slotName: videoSlotName
			},
			videoDepth = 0;

		videoSource = srcProvider.get(baseSrc, {testSrc: 'test'}, 'JWPLAYER');
		trackingParams.src = videoSource;

		if (adContext.get('opts.showAds')) {
			player.on('adBlock', function () {
				trackingParams.adProduct = 'video';
			});

			player.on('beforePlay', function () {
				if (prerollPositionReached) {
					return;
				}
				log('Preroll position reached', log.levels.info, logGroup);

				correlator = Math.round(Math.random() * 10000000000);
				videoDepth += 1;

				trackingParams.adProduct = 'video-preroll';
				player.playAd(buildVastUrl('preroll', videoDepth, correlator));
				prerollPositionReached = true;
			});

			player.on('complete', function () {
				prerollPositionReached = false;
			});
			player.on('adRequest', function (event) {
				vastDebugger.setVastAttributes(videoContainer, event.tag, 'success', event.ima && event.ima.ad);
			});
			player.on('adError', function (event) {
				vastDebugger.setVastAttributes(videoContainer, event.tag, 'error', event.ima && event.ima.ad);
			});
		} else {
			trackingParams.adProduct = 'video';
		}

		adsTracking(player, trackingParams);
	};
});
