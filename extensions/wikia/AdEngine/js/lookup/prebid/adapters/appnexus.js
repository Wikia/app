/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexus',[
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (slotsContext, appnexusPlacements, geo, instantGlobals, log) {
	'use strict';

	var bidderName = 'appnexus',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexus',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					position: 'atf'
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					position: 'atf'
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					position: 'btf'
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					position: 'hivi'
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					]
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
					]
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAppNexusBidderCountries);
	}

	function prepareAdUnit(slotName, config, skin, isRecovering) {
		var placementId = appnexusPlacements.getPlacement(skin, config.position, isRecovering);

		if (!placementId) {
			return;
		}

		log(['Requesting appnexus ad', slotName, placementId], log.levels.debug, logGroup);

		return {
			code: slotName,
			sizes: config.sizes,
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

	return {
		isEnabled: isEnabled,
		getName: getName,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
