/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.openx',[
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals'
], function (slotsContext, geo, instantGlobals) {
	'use strict';

	var bidderName = 'openx',
		delDomain = 'ox-d.wikia.servedbyopenx.com',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					unit: 538229265
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					unit: 538229265
				},
				LEFT_SKYSCRAPER_2: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					unit: 538229265
				},
				LEFT_SKYSCRAPER_3: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					unit: 538229265
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[300, 250],
						[300, 600],
						[160, 600]
					],
					unit: 538229265
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: [
						[300, 250]
					],
					unit: 538229265
				},
				PREFOOTER_MIDDLE_BOXAD: {
					sizes: [
						[300, 250]
					],
					unit: 538229265
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: [
						[300, 250]
					],
					unit: 538229265
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250],
						[320, 480]
					],
					unit: 538229265
				},
				MOBILE_PREFOOTER: {
					sizes: [
						[300, 250],
						[320, 50]
					],
					unit: 538229265
				},
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					unit: 538229265
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverOpenXPrebidBidderCountries);
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: {
						unit: config.unit, // TODO add real unit ids to slots
						delDomain: delDomain
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
