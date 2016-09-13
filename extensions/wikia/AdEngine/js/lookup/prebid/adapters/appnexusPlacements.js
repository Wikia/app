define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.adContext',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, instantGlobals, log) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
		placementsMap = instantGlobals.wgAdDriverAppNexusBidderPlacementsConfig;

	function getPlacement(skin) {
		var vertical = context.targeting.mappedVerticalName;

		if (placementsMap && placementsMap[skin] && placementsMap[skin][vertical]) {
			return placementsMap[skin][vertical];
		} else {
			log([
					'getPlacement', skin, vertical,
					'wgAdDriverAppNexusBidderPlacementsConfig variable not set or not configured correctly'
				], 'error', logGroup
			);
		}
	}

	return {
		getPlacement: getPlacement
	};
});
