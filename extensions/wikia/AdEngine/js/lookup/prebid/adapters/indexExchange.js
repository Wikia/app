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
				PREFOOTER_LEFT_BOXAD: {
					sizes: [
						[300, 250]
					],
					id: '4',
					siteID: 185052
				},
				PREFOOTER_MIDDLE_BOXAD: {
					sizes: [
						[300, 250]
					],
					id: '5',
					siteID: 185054
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: [
						[300, 250]
					],
					id: '6',
					siteID: 185053
				},
				LEFT_SKYSCRAPER_2: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: '7',
					siteID: 185050
				},
				LEFT_SKYSCRAPER_3: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: '8',
					siteID: 185051
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
					id: '215807',
					siteID: 183085
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					id: '215808',
					siteID: 183085
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: [
						[300, 250]
					],
					id: '215813',
					siteID: 183085
				},
				PREFOOTER_MIDDLE_BOXAD: {
					sizes: [
						[300, 250]
					],
					id: '215815',
					siteID: 183085
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: [
						[300, 250]
					],
					id: '215814',
					siteID: 183085
				},
				LEFT_SKYSCRAPER_2: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: '215811',
					siteID: 183085
				},
				LEFT_SKYSCRAPER_3: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: '215812',
					siteID: 183085
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: '215809',
					siteID: 183085
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					id: '215810',
					siteID: 183085
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
