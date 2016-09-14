/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexus',[
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
	'wikia.geo',
	'wikia.instantGlobals'
], function (appnexusPlacements, geo, instantGlobals) {
	'use strict';

	var bidderName = 'appnexus',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					]
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					]
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAppNexusBidderCountries);
	}

	function prepareAdUnit(slotName, config, skin) {
		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: appnexusPlacements.getPlacement(skin)
					}
				}
			]
		};
	}

	function getSlots(skin) {
		return slots[skin];
	}

	return {
		isEnabled: isEnabled,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
