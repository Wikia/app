/*global define*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'ext.wikia.adEngine.bridge',
	'wikia.abTest',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adEngineBridge, abTest, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeFilter',
		minSkinWidth = 1240,
		BLBSize = {
			desktop: [[728, 90], [3, 3]],
			desktopSpecial: [[3, 3]],
			mobile: [[2, 2]]
		};

	function getNewSizes(sizes, maxWidth, fallbackSizes) {
		var goodSizes = (sizes || []).filter(function(size) {
				return size[0] <= maxWidth;
			});

		log(['getNewSizes', 'sizes: ', sizes, 'goodSizes: ', goodSizes], 'debug', logGroup);

		return goodSizes.length ? goodSizes : fallbackSizes;
	}

	function getAdContext() {
		return win.Mercury ?
			win.Mercury.Modules.Ads.getInstance().adsContext :
			win.ads.context;
	}

	function removeFanTakeoverSizes(slotName, slotSizes) {
		var adContext = getAdContext(),
			recommendedVideoTestName = 'RECOMMENDED_VIDEO_AB',
			hasRecommendedVideoABTestPlaylistOnOasis = win.wgRecommendedVideoABTestPlaylist,
			hasRecommendedVideoABTestPlaylistOnMobile = win.M && win.M.getFromHeadDataStore &&
				!!win.M.getFromHeadDataStore('wikiVariables.recommendedVideoPlaylist'),
			runsRecommendedVideoABTest = abTest.getGroup(recommendedVideoTestName) &&
				(hasRecommendedVideoABTestPlaylistOnOasis || hasRecommendedVideoABTestPlaylistOnMobile);

		if (slotName.indexOf('TOP_LEADERBOARD') > -1 &&
			adContext &&
			adContext.targeting &&
			(adContext.targeting.hasFeaturedVideo || runsRecommendedVideoABTest)
		) {
			slotSizes = removeUAPFromSlotSizes(slotSizes);
		}

		return slotSizes;
	}

	function removeUAPFromSlotSizes(slotSizes) {
		return slotSizes.filter(function (size) {
			var str = size.toString();

			return !(str === '2,2' || str === '3,3');
		});
	}

	function getFanTakeoverBLBSizes(skin) {
		if (skin !== 'oasis') {
			return BLBSize.mobile;
		} else {
			return getAdContext().opts.isBLBSingleSizeForUAPEnabled ? BLBSize.desktopSpecial : BLBSize.desktop;
		}
	}

	function getBottomLeaderboardSizes(slotSizes) {
		return adEngineBridge.universalAdPackage.isFanTakeoverLoaded() ?
			getFanTakeoverBLBSizes(getAdContext().targeting.skin) : removeUAPFromSlotSizes(slotSizes);
	}

	function filterSizes(slotName, slotSizes) {
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		slotSizes = removeFanTakeoverSizes(slotName, slotSizes);

		switch (true) {
			case slotName.indexOf('TOP_LEADERBOARD') > -1:
				return getNewSizes(slotSizes, doc.documentElement.offsetWidth, [[728, 90]]);
			case slotName === 'INVISIBLE_SKIN':
				return doc.documentElement.offsetWidth >= minSkinWidth ? slotSizes : [[1, 1]];
			case slotName === 'INCONTENT_BOXAD_1' && getAdContext().targeting.hasFeaturedVideo:
				return [[300, 250]];
			case slotName === 'BOTTOM_LEADERBOARD':
				return getBottomLeaderboardSizes(slotSizes);
			default:
				return slotSizes;
		}
	}

	return {
		filter: filterSizes
	};
});
