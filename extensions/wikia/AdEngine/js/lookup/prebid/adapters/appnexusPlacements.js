define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.instantGlobals'
], function (zoneParams, instantGlobals) {
	'use strict';

	var placementsMap = instantGlobals.wgAdDriverAppNexusBidderPlacementsConfig;

	function getPlacement(skin) {
		return placementsMap[skin][zoneParams.getVertical()];
	}

	return {
		getPlacement: getPlacement
	};
});
