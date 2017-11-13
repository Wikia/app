/*global define, require*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeFilter',
		context = adContext.getContext(),
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
			slotSizes.forEach(function(size, index, array) {
				var str = size.toString();

				if (str === '2,2' || str === '3,3') {
					array.splice(index, 1);
				}
			});
		}

		return slotSizes;
	}

	function filterSizes(slotName, slotSizes) {
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		removeUAPForFeaturedVideoPages(slotName, slotSizes);

		switch (true) {
			case slotName.indexOf('TOP_LEADERBOARD') > -1:
				return getNewSizes(slotSizes, doc.documentElement.offsetWidth, [[728, 90]]);
			case slotName === 'INVISIBLE_SKIN':
				return doc.documentElement.offsetWidth >= minSkinWidth ? slotSizes : [[1, 1]];
			case slotName === 'BOTTOM_LEADERBOARD':
				return getNewSizes(slotSizes, doc.getElementById('WikiaFooter').offsetWidth, [[728, 90]]);
			case slotName === 'INCONTENT_BOXAD_1' && context.targeting.hasFeaturedVideo:
				return [[300, 250]];
			default:
				return slotSizes;
		}
	}

	return {
		filter: filterSizes
	};
});
