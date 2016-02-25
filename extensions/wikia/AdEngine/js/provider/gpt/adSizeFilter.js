/*global define*/
define('ext.wikia.adEngine.provider.gpt.adSizeFilter', [
	'wikia.breakpointsLayout',
	'wikia.document',
	'wikia.log'
], function (breakpointsLayout, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeFilter',
		leaderboardFallbackSize = [728, 90],
		incontentLeaderboardFallbackSize = [300, 250],
		invisibleSkinFallbackSize = [1, 1];

	function filterOutLeaderboardSizes(sizes) {
		log(['filterOutLeaderboardSizes', sizes], 'debug', logGroup);
		var goodSizes = [], i, len, minWidth;

		minWidth = doc.documentElement.offsetWidth;

		for (i = 0, len = sizes.length; i < len; i += 1) {
			if (sizes[i][0] <= minWidth) {
				goodSizes.push(sizes[i]);
			}
		}

		if (goodSizes.length === 0) {
			log(['filterOutLeaderboardSizes', 'using fallback size', leaderboardFallbackSize], 'debug', logGroup);
			return [leaderboardFallbackSize];
		}

		log(['filterOutLeaderboardSizes', 'result', goodSizes], 'debug', logGroup);
		return goodSizes;
	}

	function filterOutIncontentLeaderboardSizes(sizes) {
		log(['filterOutIncontentLeaderboardSizes', sizes], 'debug', logGroup);
		var goodSizes = [], i, len, content;

		content = doc.getElementById('WikiaPageBackground');

		if (content.offsetWidth >= breakpointsLayout.getLargeContentWidth()) {
			log(['filterOutIncontentLeaderboardSizes', 'large breakpoint - no need to filter'], 'debug', logGroup);
			return sizes;
		}

		for (i = 0, len = sizes.length; i < len; i += 1) {
			if (sizes[i][0] < 728) {
				goodSizes.push(sizes[i]);
			}
		}

		if (goodSizes.length === 0) {
			log(['filterOutIncontentLeaderboardSizes',
				 'using fallback size', incontentLeaderboardFallbackSize], 'debug', logGroup);
			return [incontentLeaderboardFallbackSize];
		}

		log(['filterOutIncontentLeaderboardSizes', 'result', goodSizes], 'debug', logGroup);
		return goodSizes;
	}

	function filterOutInvisibleSkinSizes(sizes) {
		log(['filterOutInvisibleSkinSizes', sizes], 'debug', logGroup);

		if (doc.documentElement.offsetWidth < 1240) {
			log(['filterOutInvisibleSkinSizes', 'Skin not allowed', []], 'debug', logGroup);
			return [invisibleSkinFallbackSize];
		}

		log(['filterOutInvisibleSkinSizes', 'Skin allowed', sizes], 'info', logGroup);
		return sizes;
	}

	function filterSizes(slotName, slotSizes) {
		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);

		if (slotName.match(/TOP_LEADERBOARD/)) {
			slotSizes = filterOutLeaderboardSizes(slotSizes);
		}

		if (slotName === 'INCONTENT_LEADERBOARD') {
			slotSizes = filterOutIncontentLeaderboardSizes(slotSizes);
		}

		if (slotName === 'INVISIBLE_SKIN') {
			slotSizes = filterOutInvisibleSkinSizes(slotSizes);
		}

		log(['filterSizes', slotName, slotSizes], 'debug', logGroup);
		return slotSizes;
	}

	return {
		filter: filterSizes
	};
});
