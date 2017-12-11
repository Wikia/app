define('wikia.articleVideo.featuredVideo.ads', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'ext.wikia.adEngine.video.player.jwplayer.adsTracking',
	'ext.wikia.adEngine.video.vastDebugger',
	'wikia.log'
], function (adContext, vastUrlBuilder, megaAdUnitBuilder, srcProvider, adsTracking, vastDebugger, log) {
	'use strict';

	var aspectRatio = 640 / 480,
		baseSrc = adContext.get('targeting.skin') === 'oasis' ? 'gpt' : 'mobile',
		featuredVideoPassback = 'jwplayer',
		featuredVideoSlotName = 'FEATURED',
		featuredVideoSource,
		logGroup = 'wikia.articleVideo.featuredVideo.ads';

	function calculateRV(depth) {
		var capping = adContext.get('opts.fvAdsFrequency');

		return (depth < 2 || !capping) ? 1 : (Math.floor((depth - 1) / capping) + 1);
	}

	function shouldPlayAdOnNextVideo(depth) {
		var capping = adContext.get('opts.fvAdsFrequency');

		return adContext.get('opts.replayAdsForFV') && capping > 0 && (depth - 1) % capping === 0;
	}

	function canAdBePlayed(depth) {
		var isReplay = depth > 1;

		return !isReplay || (isReplay && shouldPlayAdOnNextVideo(depth));
	}

	function shouldPlayPreroll(videoDepth) {
		return canAdBePlayed(videoDepth);
	}

	function shouldPlayMidroll(videoDepth) {
		return adContext.get('opts.isFVMidrollEnabled') && canAdBePlayed(videoDepth);
	}

	function shouldPlayPostroll(videoDepth) {
		return adContext.get('opts.isFVPostrollEnabled') && canAdBePlayed(videoDepth);
	}

	function buildVastUrl(position, videoDepth, correlator, bidParams) {
		var options = {
				correlator: correlator,
				vpos: position
			},
			slotParams = {
				passback: featuredVideoPassback,
				pos: featuredVideoSlotName,
				rv: calculateRV(videoDepth),
				src: featuredVideoSource
			};

		if (videoDepth === 1 && bidParams) {
			Object.keys(bidParams).forEach(function (key) {
				slotParams[key] = bidParams[key];
			});
		}
		options.adUnit = megaAdUnitBuilder.build(slotParams.pos, slotParams.src);

		log(['buildVastUrl', position, videoDepth, slotParams, options], log.levels.debug, logGroup);

		return vastUrlBuilder.build(aspectRatio, slotParams, options);
	}

	return function(player, bidParams) {
		var correlator,
			featuredVideoElement = player && player.getContainer && player.getContainer(),
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
			player.on('adBlock', function () {
				trackingParams.adProduct = 'featured-video';
			});

			player.on('beforePlay', function () {
				if (prerollPositionReached) {
					return;
				}
				log('Preroll position reached', log.levels.info, logGroup);

				correlator = Math.round(Math.random() * 10000000000);
				trackingParams.adProduct = 'featured-video';
				videoDepth += 1;

				if (shouldPlayPreroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-preroll';
					player.playAd(buildVastUrl('preroll', videoDepth, correlator, bidParams));
				}
				prerollPositionReached = true;
			});

			player.on('videoMidPoint', function () {
				log('Midroll position reached', log.levels.info, logGroup);
				if (shouldPlayMidroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-midroll';
					player.playAd(buildVastUrl('midroll', videoDepth, correlator));
				}

			});

			player.on('beforeComplete', function () {
				log('Postroll position reached', log.levels.info, logGroup);
				if (shouldPlayPostroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-postroll';
					player.playAd(buildVastUrl('postroll', videoDepth, correlator));
				}
			});

			player.on('complete', function () {
				prerollPositionReached = false;
			});
			player.on('adRequest', function (event) {
				vastDebugger.setVastAttributes(featuredVideoContainer, event.tag, 'success', event.ima && event.ima.ad);
			});
			player.on('adError', function (event) {
				vastDebugger.setVastAttributes(featuredVideoContainer, event.tag, 'error', event.ima && event.ima.ad);
			});
		} else {
			trackingParams.adProduct = 'featured-video-no-ad';
		}

		adsTracking(player, trackingParams);
	};
});
