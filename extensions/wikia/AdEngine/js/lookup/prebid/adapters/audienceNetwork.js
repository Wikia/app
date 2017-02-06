/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork',[
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.adContext'
], function (slotsContext, geo, instantGlobals, adContext) {
	'use strict';

	var bidderName = 'audienceNetwork',
		// only first size for each slot will be requested anyways
		slots = {
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					placementId: '963689110376230_1245837502161388'
				},
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250],
						[320, 480]
					],
					placementId: '963689110376230_1245838625494609'
				},
				MOBILE_PREFOOTER: {
					sizes: [
						[300, 250],
						[320, 50]
					],
					placementId: '963689110376230_1245839585494513'
				}
			}
		};

	function isEnabled() {
		// TODO: add and set and check here instantGlobals.wgAdDriverAudienceNetworkBidderCountries
		// https://wikia-inc.atlassian.net/browse/ADEN-4638
		return adContext.getContext().targeting.skin === 'mercury';
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
						placementId: config.placementId
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
