/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.indexExchange',[
	'wikia.geo',
	'wikia.instantGlobals'
], function (geo, instantGlobals) {
	'use strict';

	var bidderName = 'indexExchange',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					id: '1',
					siteID: 183423
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					id: '2',
					siteID: 183567
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					id: '3',
					siteID: 183568
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverIndexExchangeBidderCountries);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: {
						id: config.id,
						siteID: config.siteID
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
		prepareAdUnit: prepareAdUnit,
		getSlots: getSlots
	};
});
