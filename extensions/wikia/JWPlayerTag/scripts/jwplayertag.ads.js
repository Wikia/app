define('wikia.articleVideo.jwplayertag.ads', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'ext.wikia.adEngine.video.articleVideoAd',
	'ext.wikia.adEngine.video.vastDebugger',
	'ext.wikia.adEngine.video.player.jwplayer.adsTracking',
	'wikia.log'
], function (adContext, btfBlocker, vastUrlBuilder, megaAdUnitBuilder, srcProvider, articleVideoAd, vastDebugger, adsTracking, log) {
	'use strict';

	var baseSrc = adContext.get('targeting.skin') === 'oasis' ? 'gpt' : 'mobile',
		videoSlotName = 'VIDEO',
		videoSource,
		logGroup = 'wikia.articleVideo.jwplayertag.ads';

	return function(player, slotTargeting) {
		var correlator,
			videoElement = player && player.getContainer && player.getContainer(),
			videoContainer = videoElement && videoElement.parentNode,
			prerollPositionReached = false,
			trackingParams = {
				adProduct: 'video',
				slotName: videoSlotName
			},
			videoDepth = 0;

		slotTargeting = slotTargeting || {};
		videoSource = srcProvider.get(baseSrc, {testSrc: 'test'}, 'JWPLAYER');
		trackingParams.src = videoSource;

		if (adContext.get('opts.showAds')) {
			player.on('adBlock', function () {
				trackingParams.adProduct = 'video';
			});

			player.on('beforePlay', function () {
				var currentMedia = player.getPlaylistItem() || {};

				slotTargeting.v1 = currentMedia.mediaid;

				if (prerollPositionReached) {
					return;
				}
				log('Preroll position reached', log.levels.info, logGroup);

				correlator = Math.round(Math.random() * 10000000000);
				videoDepth += 1;

				trackingParams.adProduct = 'video-preroll';

				btfBlocker.decorate(function() {
					player.playAd(articleVideoAd.buildVastUrl(
						videoSlotName,
						'preroll',
						videoDepth,
						correlator,
						slotTargeting
					));
				})({name: videoSlotName});

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
