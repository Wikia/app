/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.adContext',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, instantGlobals, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
		placementsMap = instantGlobals.wgAdDriverAppNexusBidderPlacementsConfig;

	function getPlacement(skin, position, recovery) {
		var vertical = recovery ? 'recovery' : adContext.getContext().targeting.mappedVerticalName;

		if (placementsMap && placementsMap[skin] && placementsMap[skin][vertical]) {
			if (position && placementsMap[skin][vertical][position]) {
				return placementsMap[skin][vertical][position];
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
