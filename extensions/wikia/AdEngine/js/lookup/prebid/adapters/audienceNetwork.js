/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork',[
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.geo',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.adContext',
	'wikia.querystring'
], function (slotsContext, instartLogic, geo, instantGlobals, adContext, querystring) {
	'use strict';

	var bidderName = 'audienceNetwork',
		// only first size for each slot will be requested anyways - this is how Audience Network works
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
						[300, 250]
					],
					placementId: '963689110376230_1245838625494609'
				},
				MOBILE_PREFOOTER: {
					sizes: [
						[300, 250]
					],
					placementId: '963689110376230_1245839585494513'
				}
			}
		};

	function isEnabled() {
		var isAudienceNetworkAvailable = adContext.getContext().providers.audienceNetwork;

		return adContext.getContext().targeting.skin === 'mercury' &&
			isAudienceNetworkAvailable &&
			geo.isProperGeo(instantGlobals.wgAdDriverAudienceNetworkBidderCountries) &&
			!instartLogic.isBlocking();
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
						testMode: querystring().getVal('audiencenetworktest', '') === 'true',
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
