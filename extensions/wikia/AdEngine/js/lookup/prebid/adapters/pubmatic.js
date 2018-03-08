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
					ids: [
						'/5441/TOP_LEADERBOARD_728x90@728x90',
						'/5441/TOP_LEADERBOARD_970x250@970x250'
					]
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					ids: [
						'/5441/TOP_RIGHT_BOXAD_300x250@300x250',
						'/5441/TOP_RIGHT_BOXAD_300x600@300x600'
					]
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					ids: [
						'/5441/BOTTOM_LEADERBOARD_728x90@728x90',
						'/5441/BOTTOM_LEADERBOARD_970x250@970x250'
					]
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					ids: [
						'/5441/INCONTENT_BOXAD_1_160x600@160x600',
						'/5441/INCONTENT_BOXAD_1_300x250@300x250',
						'/5441/INCONTENT_BOXAD_1_300x600@300x600'
					]
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					ids: [
						'/5441/MOBILE_TOP_LEADERBOARD_320x50@320x50'
					]
				},
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250],
						[320, 480]
					],
					ids: [
						'/5441/MOBILE_IN_CONTENT_300x250@300x250',
						'/5441/MOBILE_IN_CONTENT_320x480@320x480'
					]
				},
				MOBILE_PREFOOTER: {
					sizes: [
						[300, 250],
						[320, 50]
					],
					ids: [
						'/5441/MOBILE_PREFOOTER_300x250@300x250',
						'/5441/MOBILE_PREFOOTER_320x50@320x50'
					]
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
		log(['Requesting pubMatic ad', slotName, config.ids], log.levels.debug, logGroup);

		return {
			code: slotName,
			sizes: config.sizes,
			bids: config.ids.map(function (id) {
				return {
					bidder: bidderName,
					params: {
						adSlot: id,
						publisherId: publisherId
					}
				};
			})
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
