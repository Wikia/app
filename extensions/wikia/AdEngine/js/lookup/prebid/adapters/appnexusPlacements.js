/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.adContext',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, instantGlobals, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
		placementsMap = instantGlobals.wgAdDriverAppNexusBidderPlacementsConfig,
		palPlacementsMap = {
			oasis: {
				atf: '3143028',
				btf: '3143029',
				hivi: '3142398',
				other: '3140173'
			}
		};

	function getPlacement(skin, position, isRecovering) {
		var context = adContext.getContext(),
			vertical = isRecovering ? 'recovery' : context.targeting.mappedVerticalName,
			skinVertical;

		if (context.premiumAdLayoutEnabled) {
			return palPlacementsMap[skin] && palPlacementsMap[skin][position];
		} else if (placementsMap && placementsMap[skin] && placementsMap[skin][vertical]) {
			skinVertical = placementsMap[skin][vertical];

			return position && skinVertical[position] ?
				skinVertical[position] :
				skinVertical;
		} else {
			log([
					'getPlacement', skin, vertical, position,
					'wgAdDriverAppNexusBidderPlacementsConfig variable not set or not configured correctly'
				], 'error', logGroup
			);
		}
	}

	return {
		getPlacement: getPlacement
	};
});
