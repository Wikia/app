/*global define, require*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'ext.wikia.adEngine.adContext',
	'wikia.abTest',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('wikia.breakpointsLayout')
], function (adContext, abTest, doc, log, win, breakpointsLayout) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeFilter',
		context = adContext.getContext(),
		maxAdSize = 704,
		minSkinWidth = 1240;

	function isLargeBreakpoints() {
		return breakpointsLayout &&
			doc.getElementById('WikiaPageBackground').offsetWidth >= breakpointsLayout.getLargeContentWidth();
	}

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
		var isPremiumLayout = context.opts.premiumAdLayoutEnabled,
			footerSize;
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		removeUAPForFeaturedVideoPages(slotName, slotSizes);

		switch (true) {
			case slotName.indexOf('TOP_LEADERBOARD') > -1:
				return getNewSizes(slotSizes, doc.documentElement.offsetWidth, [[728, 90]]);
			case slotName === 'INVISIBLE_SKIN':
				return doc.documentElement.offsetWidth >= minSkinWidth ? slotSizes : [[1, 1]];
			case slotName === 'PREFOOTER_LEFT_BOXAD' && context.opts.overridePrefootersSizes:
				return isLargeBreakpoints() ? slotSizes : getNewSizes(slotSizes, maxAdSize, [[300, 250]]);
			case slotName === 'BOTTOM_LEADERBOARD' && isPremiumLayout:
				footerSize = doc.getElementById('WikiaFooter').offsetWidth;
				return getNewSizes([[970, 250], [728, 90]], footerSize, [[728, 90]]);
			case slotName === 'BOTTOM_LEADERBOARD':
				footerSize = doc.getElementById('WikiaFooter').offsetWidth;
				return getNewSizes(slotSizes, footerSize, [[728, 90]]);
			case slotName === 'INCONTENT_BOXAD_1' && isPremiumLayout && context.targeting.hasFeaturedVideo:
				return [[300, 250]];
			default:
				return slotSizes;
		}
	}

	return {
		filter: filterSizes
	};
});
