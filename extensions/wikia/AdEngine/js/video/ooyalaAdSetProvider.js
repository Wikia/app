/*global define*/
define('ext.wikia.adEngine.video.ooyalaAdSetProvider', [
	require.optional('ext.wikia.adEngine.adContext'),
	require.optional('ext.wikia.adEngine.video.vastUrlBuilder')
], function (adContext, vastUrlBuilder) {
	'use strict';

	var FEATURED_VIDEO_RATIO = 640 / 480,
		PREROLL = {
			vpos: 'preroll',
			position_type: 'p',
			position: 0
		}, MIDROLL = {
			vpos: 'midroll',
			position_type: 'p',
			position: 50
		},
		POSTROLL = {
			vpos: 'postroll',
			position_type: 'p',
			position: 101 // postroll should has more than 100% to correct working, if it is 100%
		};

	function generateSet(ad, rv, correlator) {
		return {
			position_type: ad.position_type,
			position: ad.position,
			tag_url: vastUrlBuilder.build(FEATURED_VIDEO_RATIO, {
				pos: 'FEATURED',
				src: 'premium',
				rv: rv
			}, {
				vpos: ad.vpos,
				correlator: correlator
			})
		};
	}

	function calculateRV(videoDepth, capping) {
		return videoDepth < 2 || !capping ? 1 : Math.floor((videoDepth - 1) / capping) + 1;
	}

	function shouldPlayNextVideoAd(videoDepth, capping) {
		return capping > 0 && (videoDepth - 1) % capping === 0;
	}

	function isAbleToDisplayAds() {
		return adContext && adContext.getContext() && adContext.getContext().opts.showAds && vastUrlBuilder;
	}

	function adsCanBePlayedOnNextVideoViews() {
		return adContext && adContext.getContext() && adContext.getContext().opts.replayAdsForFV;
	}

	function isVideoDepthCorrect(videoDepth) {
		return videoDepth === undefined || (typeof videoDepth === 'number' && videoDepth > 0);
	}

	function isAbleToReplayAnyAd(videoDepth) {
		var isReplay = videoDepth > 1,
			isReplayAdSupported = adContext.getContext().opts.replayAdsForFV;
		return isReplay && isReplayAdSupported;
	}

	function canAdBePlayed(videoDepth, adsFrequency, isEnabled) {
		var isReplay = videoDepth > 1,
			allowForFirstPlay = !isReplay && isEnabled;

		return allowForFirstPlay ||
			(isAbleToReplayAnyAd(videoDepth) && isEnabled && shouldPlayNextVideoAd(videoDepth, adsFrequency));
	}

	function get(videoDepth, correlator) {
		if (!isVideoDepthCorrect(videoDepth)) {
			throw 'Not correct input variables';
		}

		if (!isAbleToDisplayAds()) {
			return [];
		}

		videoDepth = videoDepth || 1;
		correlator = correlator || Math.round(Math.random() * 10000000000);

		var adSet = [],
			adsFrequency = adContext.getContext().opts.fvAdsFrequency,
			rv = calculateRV(videoDepth, adsFrequency);

		if (canAdBePlayed(videoDepth, adsFrequency, true)) {
			adSet.push(generateSet(PREROLL, rv, correlator));
		}

		if (canAdBePlayed(videoDepth, adsFrequency, adContext.getContext().opts.isFVMidrollEnabled)) {
			adSet.push(generateSet(MIDROLL, rv, correlator));
		}

		if (canAdBePlayed(videoDepth, adsFrequency, adContext.getContext().opts.isFVPostrollEnabled)) {
			adSet.push(generateSet(POSTROLL, rv, correlator));
		}

		return adSet;
	}

	return {
		adsCanBePlayedOnNextVideoViews: adsCanBePlayedOnNextVideoViews,
		isAbleToDisplayAds: isAbleToDisplayAds,
		get: get
	};
});
