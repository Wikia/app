define('wikia.articleVideo.featuredVideo.ads', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'wikia.articleVideo.featuredVideo.adsTracking',
	'wikia.log'
], function (adContext, vastUrlBuilder, megaAdUnitBuilder, srcProvider, adsTracking, log) {

	var aspectRatio = 640 / 480,
		featuredVideoPassback = 'jwplayer',
		featuredVideoSlotName = 'FEATURED',
		featuredVideoSource = srcProvider.get('gpt', {testSrc: 'test'}),
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
			trackingParams = {
				adProduct: 'featured-video',
				slotName: featuredVideoSlotName,
				src: featuredVideoSource
			},
			videoDepth = 0;

		if (adContext.get('opts.showAds')) {
			player.on('adBlock', function () {
				trackingParams.adProduct = 'featured-video';
			});

			player.on('videoStart', function () {
				log('Preroll position reached', log.levels.info, logGroup);

				correlator = Math.round(Math.random() * 10000000000);
				trackingParams.adProduct = 'featured-video';
				videoDepth += 1;

				if (shouldPlayPreroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-preroll';
					player.playAd(buildVastUrl('preroll', videoDepth, correlator, bidParams));
				}
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
		} else {
			trackingParams.adProduct = 'featured-video-no-ad';
		}

		adsTracking(player, trackingParams);
	};
});
