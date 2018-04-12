/*global define, require*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'ext.wikia.adEngine.bridge',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	'wikia.abTest'
], function (bridge, doc, log, win, abTest) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeFilter',
		minSkinWidth = 1240;

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
			runsRecommendedVideoABTest = abTest.getGroup(recommendedVideoTestName) && win.location.hostname.match(
				/(dragonage|dragonball|elderscrolls|gta|memory-alpha|monsterhunter|naruto|marvelcinematicuniverse)((\.wikia\.com)|(\.wikia-dev\.pl))/g
			);

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
		return slotSizes.filter(function(size) {
			var str = size.toString();

			return !(str === '2,2' || str === '3,3');
		});
	}

	function getBottomLeaderboardSizes(slotSizes) {
		var skin = getAdContext().targeting.skin;

		if (bridge.universalAdPackage.isFanTakeoverLoaded()) {
			return skin === 'oasis' ? [[728, 90], [3, 3]] : [[2, 2]];
		}

		return removeUAPFromSlotSizes(slotSizes);
	}

	function filterSizes(slotName, slotSizes) {
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		var context = getAdContext();

		slotSizes = removeFanTakeoverSizes(slotName, slotSizes);

		switch (true) {
			case slotName.indexOf('TOP_LEADERBOARD') > -1:
				return getNewSizes(slotSizes, doc.documentElement.offsetWidth, [[728, 90]]);
			case slotName === 'INVISIBLE_SKIN':
				return doc.documentElement.offsetWidth >= minSkinWidth ? slotSizes : [[1, 1]];
			case slotName === 'INCONTENT_BOXAD_1' && context.targeting.hasFeaturedVideo:
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
