/*global define*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.log',
	require.optional('wikia.breakpointsLayout')
], function (adContext, doc, log, breakpointsLayout) {
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
		var goodSizes = [];

		for (var i = 0; i < sizes.length; i += 1) {
			if (sizes[i][0] <= maxWidth) {
				goodSizes.push(sizes[i]);
			}
		}

		log(['getNewSizes', 'sizes: ', sizes, 'goodSizes: ', goodSizes], 'debug', logGroup);

		return goodSizes.length ? goodSizes : fallbackSizes;
	}

	function filterSizes(slotName, slotSizes) {
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		switch (true) {
			case slotName.indexOf('TOP_LEADERBOARD') > -1:
				return getNewSizes(slotSizes, doc.documentElement.offsetWidth, [[728, 90]]);
			case slotName === 'INVISIBLE_SKIN':
				return doc.documentElement.offsetWidth >= minSkinWidth ? slotSizes : [[1, 1]];
			case slotName === 'INCONTENT_LEADERBOARD':
			case slotName === 'PREFOOTER_LEFT_BOXAD' && context.opts.overridePrefootersSizes:
				return isLargeBreakpoints() ? slotSizes : getNewSizes(slotSizes, maxAdSize, [[300, 250]]);
			case slotName === 'LEFT_SKYSCRAPER_3':
				var footerSize = doc.getElementById('WikiaFooter').offsetWidth;
				return getNewSizes(slotSizes, footerSize, [[300, 250]]);
			default:
				return slotSizes;
		}
	}

	return {
		filter: filterSizes
	};
});
