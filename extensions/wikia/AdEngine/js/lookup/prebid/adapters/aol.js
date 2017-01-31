/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.aol', [
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals'
], function (slotsContext, geo, instantGlobals) {
	'use strict';

	var bidderName = 'aol',
		network = '9435.1',
		slots = {
			oasis: {
				TOP_LEADERBOARD: [
					{
						size: [728, 90],
						placement: '4431497',
						network: network,
						alias: '4431497',
						sizeId: '225'
					},
					{//x
						size: [970, 250],
						placement: '4431493',
						network: network,
						alias: '4431493',
						sizeId: '2466'
					}
				],
				TOP_RIGHT_BOXAD: [
					{
						size: [300, 250],
						placement: '4431473',
						network: network,
						alias: '4431473',
						sizeId: '170'
					},
					{//x
						size: [300, 600],
						placement: '4431476',
						network: network,
						alias: '4431476',
						sizeId: '529'
					}
				],
				PREFOOTER_LEFT_BOXAD: [
					{
						size: [300, 250],
						placement: '4431479',
						network: network,
						alias: '4431479',
						sizeId: '170'
					}
				],
				PREFOOTER_MIDDLE_BOXAD: [
					{
						size: [300, 250],
						placement: '4431480',
						network: network,
						alias: '4431480',
						sizeId: '170'
					}
				],
				PREFOOTER_RIGHT_BOXAD: [
					{
						size: [300, 250],
						placement: '4431478',
						network: network,
						alias: '4431478',
						sizeId: '170'
					}
				],
				LEFT_SKYSCRAPER_2: [
					{//ok
						size: [160, 600],
						placement: '4431477',
						network: network,
						alias: '4431477',
						sizeId: '154'
					},
					{
						size: [300, 250],
						placement: '4431482',
						network: network,
						alias: '4431482',
						sizeId: '170'
					},
					{
						size: [300, 600],
						placement: '4431474',
						network: network,
						alias: '4431474',
						sizeId: '529'
					}
				],
				LEFT_SKYSCRAPER_3: [
					{
						size: [160, 600],
						placement: '4431481',
						network: network,
						alias: '4431481',
						sizeId: '154'
					},
					{
						size: [300, 250],
						placement: '4431496',
						network: network,
						alias: '4431496',
						sizeId: '170'
					},
					{//ok
						size: [300, 600],
						placement: '4431475',
						network: network,
						alias: '4431475',
						sizeId: '529'
					}
				],
				INCONTENT_BOXAD_1: [
					{
						size: [160, 600],
						placement: '4431492',
						network: network,
						alias: '4431492',
						sizeId: '154'
					},
					{//ok
						size: [300, 250],
						placement: '4431494',
						network: network,
						alias: '4431494',
						sizeId: '170'
					},
					{
						size: [300, 600],
						placement: '4431495',
						network: network,
						alias: '4431495',
						sizeId: '529'
					}
				]
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: [
					{
						size: [320, 50],
						placement: '4436772',
						network: network,
						alias: '4436772',
						sizeId: '3055'
					}
				],
				MOBILE_IN_CONTENT: [
					{//ok
						size: [300, 250],
						placement: '4431565',
						network: network,
						alias: '4431565',
						sizeId: '170'
					},
					{
						size: [320, 480],
						placement: '4431564',
						network: network,
						alias: '4431564',
						sizeId: '3037'
					}
				],
				MOBILE_PREFOOTER: [
					{//ok
						size: [320, 50],
						placement: '4431563',
						network: network,
						alias: '4431563',
						sizeId: '3055'
					},
					{
						size: [300, 250],
						placement: '4431566',
						network: network,
						alias: '4431566',
						sizeId: '170'
					}
				]
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAolBidderCountries);
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function prepareAdUnit(slotName, config) {
		return config.map(function (c) {
			return {
				code: slotName,
				sizes: [c.size],
				bids: [
					{
						bidder: bidderName,
						params: {
							placement: c.placement,
							network: c.network,
							alias: c.alias,
							sizeId: c.sizeId
						}
					}
				]
			};
		});

		// return {
		// 	code: slotName,
		// 	sizes: [c.size],
		// 	bids: [
		// 		{
		// 			bidder: bidderName,
		// 			params: {
		// 				placement: c.placement,
		// 				network: c.network,
		// 				alias: c.alias,
		// 				sizeId: c.sizeId
		// 			}
		// 		}
		// 	]
		// };
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
