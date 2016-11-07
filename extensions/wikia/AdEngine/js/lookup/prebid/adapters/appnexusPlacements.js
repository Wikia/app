/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.adContext',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, instantGlobals, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
		placementsMap = instantGlobals.wgAdDriverAppNexusBidderPlacementsConfig;

	function getPlacement(skin, position) {
		var vertical = adContext.getContext().targeting.mappedVerticalName;

		if (placementsMap && placementsMap[skin] && placementsMap[skin][vertical]) {
			if (position && placementsMap[skin][vertical][position]) {
				return placementsMap[skin][vertical][position];
			}

			// TODO: remove if statement after switching config from old structure (conf[skin][vertical] = pId)
			// ADEN-4116 done + 24h
			if (!position || position === 'atf') {
				return placementsMap[skin][vertical];
			}
		}

		log([
				'getPlacement', skin, vertical, position,
				'wgAdDriverAppNexusBidderPlacementsConfig variable not set or not configured correctly'
			], 'error', logGroup
		);
	}

	return {
		getPlacement: getPlacement
	};
});
