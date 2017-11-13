/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.pubmatic',[
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (slotsContext, instartLogic, geo, instantGlobals, log) {
	'use strict';

	var bidderName = 'pubmatic',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.pubmatic',
		publisherId = 156260,
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					id: 'xxx'
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					id: 'xxx'
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					id: 'xxx'
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					id: 'xxx'
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					id: 'xxx'
				},
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250],
						[320, 480]
					]
				},
				MOBILE_PREFOOTER: {
					sizes: [
						[300, 250],
						[320, 50]
					],
					id: 'xxx'
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverPubMaticBidderCountries) && !instartLogic.isBlocking();
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function prepareAdUnit(slotName, config) {
		log(['Requesting pubMatic ad', slotName, config.id], log.levels.debug, logGroup);

		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: {
						adSlot: config.id,
						publisherId: publisherId
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
