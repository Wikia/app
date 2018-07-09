/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds',[
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.wad.babDetection',
	'wikia.log'
], function (adContext, slotsContext, babDetection, log) {
	'use strict';

	var bidderName = 'appnexusWebAds',
		aliases = {
			'appnexus': [bidderName]
		},
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds',
		priorityLevel = 0,
		slots = {
			oasis: {
				/* WIKIA_LB_AS */
				TOP_LEADERBOARD: {
					placementId: '13104394',
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				/* WIKIA_MR_AS */
				TOP_RIGHT_BOXAD: {
					placementId: '13104393',
					sizes: [
						[300, 250],
						[300, 600]
					]
				},
				/* WIKIA_BLB_AS */
				BOTTOM_LEADERBOARD: {
					placementId: '13104395',
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				/* WIKIA_FMR_AS */
				INCONTENT_BOXAD_1: {
					placementId: '12939349',
					sizes: [
						[120, 600],
						[160, 600]
					]
				}
			},
			mercury: {
				/* WIKIA_mLB_AS */
				MOBILE_TOP_LEADERBOARD: {
					placementId: '13104396',
					sizes: [
						[320, 50]
					]
				},
				/* WIKIA_mIC_AS */
				MOBILE_IN_CONTENT: {
					placementId: '13104397',
					sizes: [
						[300, 250],
						[320, 100],
						[320, 50]
					]
				},
				/* WIKIA_BLB_AS */
				BOTTOM_LEADERBOARD: {
					placementId: '13104398',
					sizes: [
						[300, 250],
						[320, 100],
						[320, 50]
					]
				}
			}
		};

	function isEnabled() {
		return adContext.get('bidders.appnexusWebAds') && !babDetection.isBlocking();
	}

	function prepareAdUnit(slotName, config) {
		var placementId = config.placementId;

		log(['Requesting appnexusWebAds ad', slotName, placementId], log.levels.debug, logGroup);

		return {
			code: slotName,
			mediaTypes: {
				banner: {
					sizes: config.sizes
				}
			},
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: placementId
					}
				}
			]
		};
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function getName() {
		return bidderName;
	}

	function getPriority() {
		return priorityLevel;
	}

	function getAliases() {
		return aliases;
	}

	return {
		isEnabled: isEnabled,
		getName: getName,
		getPriority: getPriority,
		getAliases: getAliases,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
