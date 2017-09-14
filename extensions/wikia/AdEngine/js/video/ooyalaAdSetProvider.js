/*global define*/
define('ext.wikia.adEngine.video.ooyalaAdSetProvider', [
	require.optional('ext.wikia.adEngine.adContext'),
	require.optional('ext.wikia.adEngine.video.vastUrlBuilder')
], function (adContext, vastUrlBuilder) {
	'use strict';

	var FEATURED_VIDEO_RATIO = 640 / 480,
		POSITION_UNIT = {
			PERCENTAGE: 'p',
			TIME: 't'
		},
		AD = {
			PREROLL: {
				vpos: 'preroll',
				position_type: POSITION_UNIT.PERCENTAGE,
				position: 0
			},
			MIDROLL: {
				vpos: 'midroll',
				position_type: POSITION_UNIT.PERCENTAGE,
				position: 50
			},
			POSTROLL: {
				vpos: 'postroll',
				position_type: POSITION_UNIT.PERCENTAGE,
				position: 101 // postroll should has more than 100% to correct working, if it is 100%
			}
		};

	function generateSet(ad, rv, correlator, videoInfo) {
		videoInfo = videoInfo || {};
		return {
			position_type: ad.position_type,
			position: ad.position,
			tag_url: vastUrlBuilder.build(FEATURED_VIDEO_RATIO, {
				pos: 'FEATURED',
				src: 'premium',
				rv: rv
			}, {
				vpos: ad.vpos,
				correlator: correlator,
				contentSourceId: videoInfo.contentSourceId,
				videoId: videoInfo.videoId
			})
		};
	}

	function calculateRV(videoDepth, capping) {
		return videoDepth < 2 || !capping ? 1 : Math.floor((videoDepth - 1) / capping) + 1;
	}

	function cappingAllowsToShowNextVideo(videoDepth, capping) {
		return canShowNextVideoAds() && capping > 0 && (videoDepth - 1) % capping === 0;
	}

	function canShowAds() {
		return adContext && adContext.getContext() && adContext.getContext().opts.showAds && vastUrlBuilder;
	}

	function canShowNextVideoAds() {
		return canShowAds() && adContext.getContext().opts.replayAdsForFV;
	}

	function isVideoDepthValid(videoDepth) {
		return videoDepth === undefined || (typeof videoDepth === 'number' && videoDepth > 0);
	}

	function canAdBePlayed(videoDepth, adsFrequency) {
		var isReplay = videoDepth > 1;

		return !isReplay || (isReplay && cappingAllowsToShowNextVideo(videoDepth, adsFrequency));
	}

	function get(videoDepth, correlator, videoInfo) {
		if (!canShowAds() || !isVideoDepthValid(videoDepth)) {
			return [];
		}

		videoDepth = videoDepth || 1;
		correlator = correlator || Math.round(Math.random() * 10000000000);

		var adSet = [],
			adsFrequency = adContext.getContext().opts.fvAdsFrequency,
			rv = calculateRV(videoDepth, adsFrequency);

		if (canAdBePlayed(videoDepth, adsFrequency)) {
			adSet.push(generateSet(AD.PREROLL, rv, correlator, videoInfo));
		}

		if (adContext.getContext().opts.isFVMidrollEnabled && canAdBePlayed(videoDepth, adsFrequency)) {
			adSet.push(generateSet(AD.MIDROLL, rv, correlator, videoInfo));
		}

		if (adContext.getContext().opts.isFVPostrollEnabled && canAdBePlayed(videoDepth, adsFrequency)) {
			adSet.push(generateSet(AD.POSTROLL, rv, correlator, videoInfo));
		}

		return adSet;
	}

	return {
		adsCanBePlayedOnNextVideoViews: canShowNextVideoAds,
		canShowAds: canShowAds,
		get: get
	};
});
