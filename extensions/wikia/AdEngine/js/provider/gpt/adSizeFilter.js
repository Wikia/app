/*global define*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeFilter';

	function filterOutLeaderboardSizes(sizes) {
		log(['filterOutLeaderboardSizes', sizes], 'debug', logGroup);
		var goodSizes = [], i, len, minWidth;

		minWidth = doc.documentElement.offsetWidth;

		for (i = 0, len = sizes.length; i < len; i += 1) {
			if (sizes[i][0] <= minWidth) {
				goodSizes.push(sizes[i]);
			}
		}

		log(['filterOutLeaderboardSizes', 'result', goodSizes], 'debug', logGroup);
		return goodSizes;
	}

	function filterOutInvisibleSkinSizes(sizes) {
		log(['filterOutInvisibleSkinSizes', sizes], 'debug', logGroup);

		if (doc.documentElement.offsetWidth < 1064) {
			log(['filterOutInvisibleSkinSizes', 'Skin not allowed', []], 'debug', logGroup);
			return [];
		}

		log(['filterOutInvisibleSkinSizes', 'Skin allowed', sizes], 'info', logGroup);
		return sizes;
	}

	function filterSizes(slotName, slotSizes) {
		var fallbackSize = slotSizes[0];

		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		if (slotName.match(/TOP_LEADERBOARD/)) {
			slotSizes = filterOutLeaderboardSizes(slotSizes);
		}

		if (slotName === 'INVISIBLE_SKIN') {
			slotSizes = filterOutInvisibleSkinSizes(slotSizes);
		}

		if (slotSizes.length) {
			log(['filterSizes', slotName, slotSizes], 'debug', logGroup);
			return slotSizes;
		}

		// Return the first size as the fallback size
		log(['filterSizes', slotName, fallbackSize], 'debug', logGroup);
		return [fallbackSize];
	}

	return {
		filter: filterSizes
	};
});
