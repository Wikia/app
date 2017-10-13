define('wikia.articleVideo.featuredVideo.ads', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'wikia.log'
], function (adContext, vastUrlBuilder, megaAdUnitBuilder, log) {

	var aspectRatio = 640 / 480,
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

	function buildVastUrl(position, videoDepth, correlator) {
		var options = {
				correlator: correlator,
				vpos: position
			},
			slotParams = {
				passback: 'jwplayer',
				pos: 'FEATURED',
				rv: calculateRV(videoDepth),
				src: 'premium'
			};

		options.adUnit = megaAdUnitBuilder.build(slotParams.pos, slotParams.src);

		return vastUrlBuilder.build(aspectRatio, slotParams, options);
	}

	return function (player) {
		var correlator,
			videoDepth = 0;

		if (!adContext.get('opts.showAds')) {
			log('Ads disabled', log.levels.info, logGroup);
			return;
		}

		player.on('videoStart', function () {
			log('Preroll position reached', log.levels.info, logGroup);

			correlator = Math.round(Math.random() * 10000000000);
			videoDepth += 1;

			if (shouldPlayPreroll(videoDepth)) {
				player.playAd(buildVastUrl('preroll', videoDepth, correlator));
			}
		});

		player.on('videoMidPoint', function () {
			log('Midroll position reached', log.levels.info, logGroup);
			if (shouldPlayMidroll(videoDepth)) {
				player.playAd(buildVastUrl('midroll', videoDepth, correlator));
			}

		});

		player.on('beforeComplete', function () {
			log('Postroll position reached', log.levels.info, logGroup);
			if (shouldPlayPostroll(videoDepth)) {
				player.playAd(buildVastUrl('postroll', videoDepth, correlator));
			}
		});
	};
});
