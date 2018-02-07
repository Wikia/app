require([
	'wikia.articleVideo.featuredVideo.jwplayer.instance',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'ext.wikia.adEngine.video.articleVideoAd',
	'ext.wikia.adEngine.video.player.jwplayer.adsTracking',
	'ext.wikia.adEngine.video.vastDebugger',
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.a9')
], function (jwplayerInstance, adContext, btfBlocker, vastUrlBuilder, megaAdUnitBuilder, srcProvider, articleVideoAd, adsTracking, vastDebugger, log, a9) {
	'use strict';

	if (!adContext.get('opts.isFVBtf') || !jwplayerInstance) {
		return;
	}

	var baseSrc = adContext.get('targeting.skin') === 'oasis' ? 'gpt' : 'mobile',
		beforePlay,
		featuredVideoSlotName = 'FEATURED',
		featuredVideoSource,
		logGroup = 'wikia.articleVideo.featuredVideo.delayed-ads',
		correlator,
		featuredVideoElement = jwplayerInstance && jwplayerInstance.getContainer && jwplayerInstance.getContainer(),
		featuredVideoContainer = featuredVideoElement && featuredVideoElement.parentNode,
		prerollPositionReached = false,
		trackingParams = {
			adProduct: 'featured-video',
			slotName: featuredVideoSlotName
		},
		videoDepth = 0;

	featuredVideoSource = srcProvider.get(baseSrc, {testSrc: 'test'}, 'JWPLAYER');
	trackingParams.src = featuredVideoSource;

	if (adContext.get('opts.showAds')) {

		jwplayerInstance.on('adBlock', function () {
			trackingParams.adProduct = 'featured-video';
		});

		beforePlay = function () {
			if (prerollPositionReached) {
				return;
			}
			log('Preroll position reached', log.levels.info, logGroup);

			correlator = Math.round(Math.random() * 10000000000);
			trackingParams.adProduct = 'featured-video';
			videoDepth += 1;

			if (articleVideoAd.shouldPlayPreroll(videoDepth)) {

				btfBlocker.decorate(function() {
					var bidParams = (a9 && adContext.get('bidders.a9Video') && a9.getSlotParams('FEATURED')) || {};

					trackingParams.adProduct = 'featured-video-preroll';
					jwplayerInstance.playAd(articleVideoAd.buildVastUrl('preroll', videoDepth, correlator, bidParams));
				})({name: featuredVideoSlotName});

			}
			prerollPositionReached = true;
		};

		jwplayerInstance.on('beforePlay', beforePlay);
		if (jwplayerInstance.getState() === 'playing') {
			beforePlay();
		}

		jwplayerInstance.on('videoMidPoint', function () {
			log('Midroll position reached', log.levels.info, logGroup);
			if (articleVideoAd.shouldPlayMidroll(videoDepth)) {
				trackingParams.adProduct = 'featured-video-midroll';
				jwplayerInstance.playAd(articleVideoAd.buildVastUrl('midroll', videoDepth, correlator));
			}

		});

		jwplayerInstance.on('beforeComplete', function () {
			log('Postroll position reached', log.levels.info, logGroup);
			if (articleVideoAd.shouldPlayPostroll(videoDepth)) {
				trackingParams.adProduct = 'featured-video-postroll';
				jwplayerInstance.playAd(articleVideoAd.buildVastUrl('postroll', videoDepth, correlator));
			}
		});

		jwplayerInstance.on('complete', function () {
			prerollPositionReached = false;
		});

		jwplayerInstance.on('adRequest', function (event) {
			vastDebugger.setVastAttributes(featuredVideoContainer, event.tag, 'success', event.ima && event.ima.ad);
		});

		jwplayerInstance.on('adError', function (event) {
			vastDebugger.setVastAttributes(featuredVideoContainer, event.tag, 'error', event.ima && event.ima.ad);
		});
	} else {
		trackingParams.adProduct = 'featured-video-no-ad';
	}

	// TODO check if we track all player events
	adsTracking(jwplayerInstance, trackingParams);
});
