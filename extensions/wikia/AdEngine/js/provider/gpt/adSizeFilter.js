/*global define, require*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'ext.wikia.adEngine.context.uapContext',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (uapContext, doc, log, win) {
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

	function removeUAPForFeaturedVideoPages(slotName, slotSizes) {
		var adContext = getAdContext();

		if (slotName.indexOf('TOP_LEADERBOARD') > -1 &&
			adContext &&
			adContext.targeting &&
			adContext.targeting.hasFeaturedVideo
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
		var isUapLoaded = uapContext.isUapLoaded(),
			skin = getAdContext().targeting.skin;

		if (isUapLoaded) {
			return skin === 'oasis' ? [[728, 90], [3, 3]] : [[2, 2]];
		}

		return removeUAPFromSlotSizes(slotSizes);
	}

	function filterSizes(slotName, slotSizes) {
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		var context = getAdContext();

		slotSizes = removeUAPForFeaturedVideoPages(slotName, slotSizes);

		switch (true) {
			case slotName.indexOf('TOP_LEADERBOARD') > -1:
				return getNewSizes(slotSizes, doc.documentElement.offsetWidth, [[728, 90]]);
			case slotName === 'INVISIBLE_SKIN':
				return doc.documentElement.offsetWidth >= minSkinWidth ? slotSizes : [[1, 1]];
			case slotName === 'INCONTENT_BOXAD_1' && context.targeting.hasFeaturedVideo:
				return [[300, 250]];
			case slotName === 'BOTTOM_LEADERBOARD':
			case slotName === 'MOBILE_BOTTOM_LEADERBOARD':
				return getBottomLeaderboardSizes(slotSizes);
			default:
				return slotSizes;
		}
	}

	return {
		filter: filterSizes
	};
});
