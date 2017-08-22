/*global define*/
define('ext.wikia.adEngine.video.ooyalaAdSetProvider', [
	require.optional('ext.wikia.adEngine.adContext'),
	require.optional('ext.wikia.adEngine.video.vastUrlBuilder')
], function (adContext, vastUrlBuilder) {
	'use strict';

	var FEATURED_VIDEO_RATIO = 640 / 480;

	function generateSet(vpos, type, position, rv, correlator) {
		return {
			position_type: type,
			position: position,
			tag_url: vastUrlBuilder.build(FEATURED_VIDEO_RATIO, {
				pos: 'FEATURED',
				src: 'premium',
				rv: rv
			}, {
				vpos: vpos,
				correlator: correlator
			})
		};
	}

	function calculateRV(videoDepth, capping) {
		return videoDepth === 1 ? 1 : Math.floor((videoDepth - 1) / capping) + 1;
	}

	function shouldPlayNextVideoAd(videoDepth, capping) {
		return (videoDepth - 1) % capping === 0;
	}

	function isAbleToDisplayAds() {
		return adContext && adContext.getContext() && adContext.getContext().opts.showAds && vastUrlBuilder;
	}

	function adsCanBeplayedOnNextVideoViews() {
		return adContext && adContext.getContext() && adContext.getContext().opts.replayAdsForFV;
	}

	function get(videoDepth, correlator) {
		if (!isAbleToDisplayAds()) {
			return [];
		}

		videoDepth = videoDepth || 1;
		correlator = correlator || Math.round(Math.random() * 10000000000);

		var adSet = [],
			isReplay = videoDepth > 1,
			prerollAdVideoCapping = 3,
			isReplayAdSupported = adContext.getContext().opts.replayAdsForFV;

		if (!isReplay || (isReplayAdSupported && shouldPlayNextVideoAd(videoDepth, prerollAdVideoCapping))) {
			adSet.push(generateSet('preroll', 'p', 0, calculateRV(videoDepth, prerollAdVideoCapping), correlator));
		}

		if (!isReplay && adContext.getContext().opts.isFVMidrollEnabled) {
			adSet.push(generateSet('midroll', 'p', 50, 1, correlator));
		}

		if (!isReplay && adContext.getContext().opts.isFVPostrollEnabled) {
			// postroll should has more than 100% to correct working, if it is 100%
			adSet.push(generateSet('postroll', 'p', 101, 1, correlator));
		}

		return adSet;
	}

	return {
		adsCanBeplayedOnNextVideoViews: adsCanBeplayedOnNextVideoViews,
		isAbleToDisplayAds: isAbleToDisplayAds,
		get: get,
	};
});
