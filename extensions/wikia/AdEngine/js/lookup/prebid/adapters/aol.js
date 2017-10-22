/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.aol', [
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.geo',
	'wikia.instantGlobals'
], function (slotsContext, instartLogic, geo, instantGlobals) {
	'use strict';

	var bidderName = 'aol',
		network = '9435.1',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					size: [728, 90],
					placement: '4431497',
					network: network,
					alias: '4431497',
					sizeId: '225'
				},
				TOP_RIGHT_BOXAD: {
					size: [300, 250],
					placement: '4431473',
					network: network,
					alias: '4431473',
					sizeId: '170'
				},
				PREFOOTER_LEFT_BOXAD: {
					size: [300, 250],
					placement: '4431479',
					network: network,
					alias: '4431479',
					sizeId: '170'
				},
				PREFOOTER_MIDDLE_BOXAD: {
					size: [300, 250],
					placement: '4431480',
					network: network,
					alias: '4431480',
					sizeId: '170'
				},
				PREFOOTER_RIGHT_BOXAD: {
					size: [300, 250],
					placement: '4431478',
					network: network,
					alias: '4431478',
					sizeId: '170'
				},
				LEFT_SKYSCRAPER_2: {
					size: [160, 600],
					placement: '4431477',
					network: network,
					alias: '4431477',
					sizeId: '154'
				},
				LEFT_SKYSCRAPER_3: {
					size: [300, 600],
					placement: '4431475',
					network: network,
					alias: '4431475',
					sizeId: '529'
				}
				// TODO: fill with proper numbers https://wikia-inc.atlassian.net/browse/ADEN-5517
				// BOTTOM_LEADERBOARD: {
				// 	size: [728, 90],
				// 	placement: 'XXXX',
				// 	network: network,
				// 	alias: 'XXXX',
				// 	sizeId: 'XXXX'
				// }
				// Because of differences in AOL dashboard and DFP (ADEN-4750) this slot was disabled. To avoid making
				// additional calls it is turned off. For more details see epic (ADEN-4580).
				// INCONTENT_BOXAD_1: {
				// 	size: [300, 250],
				// 	placement: '4431494',
				// 	network: network,
				// 	alias: '4431494',
				// 	sizeId: '170'
				// }
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					size: [320, 50],
					placement: '4436772',
					network: network,
					alias: '4436772',
					sizeId: '3055'
				},
				MOBILE_IN_CONTENT: {
					size: [300, 250],
					placement: '4431565',
					network: network,
					alias: '4431565',
					sizeId: '170'
				},
				MOBILE_PREFOOTER: {
					size: [300, 250],
					placement: '4431566',
					network: network,
					alias: '4431566',
					sizeId: '170'
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAolBidderCountries) && !instartLogic.isBlocking();
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			sizes: [config.size],
			bids: [
				{
					bidder: bidderName,
					params: {
						placement: config.placement,
						network: config.network,
						alias: config.alias,
						sizeId: config.sizeId
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
