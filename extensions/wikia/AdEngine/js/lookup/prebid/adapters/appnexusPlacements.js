define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.instantGlobals',
	'wikia.log'
], function (zoneParams, instantGlobals, log) {
	'use strict';

	var placementsMap = instantGlobals.wgAdDriverAppNexusBidderPlacementsConfig,
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements';

	function getPlacement(skin) {
		var vertical = zoneParams.getVertical();

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
