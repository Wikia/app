/*global define, require*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.adSizeConverter',
	'wikia.abTest',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('wikia.breakpointsLayout')
], function (adContext, adSizeConverter, abTest, doc, log, win, breakpointsLayout) {
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
		var goodSizes = sizes.filter(function(size) {
				return size[0] <= maxWidth;
			});

		log(['getNewSizes', 'sizes: ', sizes, 'goodSizes: ', goodSizes], 'debug', logGroup);

		return goodSizes.length ? goodSizes : fallbackSizes;
	}

	function removeSize(slotSizes, sizeToRemove) {
		var adContext = win.Mercury ?
				win.Mercury.Modules.Ads.getInstance().adsContext :
				win.ads.context,
			re = new RegExp(',?' + sizeToRemove + ',?');

		if (adContext && adContext.targeting && adContext.targeting.hasFeaturedVideo) {
			slotSizes = slotSizes.replace(re, '');
		}

		return slotSizes;
	}

	function filterSizes(slotName, slotSizes) {
		var isPremiumLayout = context.opts.premiumAdLayoutEnabled,
			footerSize,
			sizesArray;
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		if (slotName === 'TOP_LEADERBOARD') {
			slotSizes = removeSize(slotSizes, '3x3');
		} else if (slotName === 'MOBILE_TOP_LEADERBOARD') {
			slotSizes = removeSize(slotSizes, '2x2');
		}

		sizesArray = adSizeConverter.toArray(slotSizes);

		switch (true) {
			case slotName.indexOf('TOP_LEADERBOARD') > -1:
				return getNewSizes(sizesArray, doc.documentElement.offsetWidth, [[728, 90]]);
			case slotName === 'INVISIBLE_SKIN':
				return doc.documentElement.offsetWidth >= minSkinWidth ? slotSizes : [[1, 1]];
			case slotName === 'PREFOOTER_LEFT_BOXAD' && context.opts.overridePrefootersSizes:
				return isLargeBreakpoints() ? sizesArray : getNewSizes(slotSizes, maxAdSize, [[300, 250]]);
			case slotName === 'BOTTOM_LEADERBOARD' && isPremiumLayout:
				footerSize = doc.getElementById('WikiaFooter').offsetWidth;
				return getNewSizes([[970, 250], [728, 90]], footerSize, [[728, 90]]);
			case slotName === 'BOTTOM_LEADERBOARD':
				footerSize = doc.getElementById('WikiaFooter').offsetWidth;
				return getNewSizes(sizesArray, footerSize, [[728, 90]]);
			case slotName === 'INCONTENT_BOXAD_1' && isPremiumLayout && context.targeting.hasFeaturedVideo:
				return [[300, 250]];
			default:
				return sizesArray;
		}
	}

	return {
		filter: filterSizes
	};
});
