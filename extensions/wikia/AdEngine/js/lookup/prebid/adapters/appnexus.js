/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexus',[
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
	'wikia.geo',
	'wikia.instantGlobals'
], function (slotsContext, appnexusPlacements, geo, instantGlobals) {
	'use strict';

	var bidderName = 'appnexus',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					position: 'atf'
				},
				HOME_TOP_LEADERBOARD: {
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
				HOME_TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					position: 'atf'
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: [
						[300, 250]
					],
					position: 'btf'
				},
				PREFOOTER_MIDDLE_BOXAD: {
					sizes: [
						[300, 250]
					],
					position: 'btf'
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: [
						[300, 250]
					],
					position: 'btf'
				},
				LEFT_SKYSCRAPER_2: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					position: 'btf'
				},
				LEFT_SKYSCRAPER_3: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
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

	function prepareAdUnit(slotName, config, skin) {
		var placementId = appnexusPlacements.getPlacement(skin, config.position);

		if (!placementId) {
			return;
		}

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
