/*global define*/
define('ext.wikia.adEngine.lookup.adapter.appnexus',[
	'wikia.geo',
	'wikia.instantGlobals'
], function (geo, instantGlobals) {
	'use strict';

	var bidderName = 'appnexus',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					placementId: '5823300'
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					placementId: '5823309'
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					placementId: '5823309'
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAppNexusBidderCountries);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: config.placementId
					}
				}
			]
		};
	}

	function getAdUnits(skin) {
		var adUnits = [];

		Object.keys(slots[skin]).forEach(function(slotName) {
			adUnits.push(prepareAdUnit(slotName, slots[skin][slotName]));
		});

		return adUnits;
	}

	return {
		getAdUnits: getAdUnits,
		isEnabled: isEnabled
	};
});
