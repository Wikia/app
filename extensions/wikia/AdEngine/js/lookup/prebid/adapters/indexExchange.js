/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.indexExchange',[
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals'
], function (slotsContext, geo, instantGlobals) {
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
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: '9',
					siteID: 185049
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					id: '12',
					siteID: 209250
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					id: '3',
					siteID: 183568
				},
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250],
						[320, 480]
					],
					id: '10',
					siteID: 185055
				},
				MOBILE_PREFOOTER: {
					sizes: [
						[300, 250],
						[320, 50]
					],
					id: '11',
					siteID: 185056
				}
			},
			recovery: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					id: '1',
					siteID: 215807
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					id: '2',
					siteID: 215808
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: '9',
					siteID: 215809
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					id: '12',
					siteID: 215810
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverIndexExchangeBidderCountries);
	}

	function getSlots(skin, isRecovering) {
		var key = isRecovering ? 'recovery' : skin;

		return slotsContext.filterSlotMap(slots[key]);
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

	function getName() {
		return bidderName;
	}

	return {
		isEnabled: isEnabled,
		getName: getName,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
