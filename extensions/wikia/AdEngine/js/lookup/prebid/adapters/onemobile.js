/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.onemobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.geo',
	'wikia.instantGlobals'
], function (adContext, slotsContext, instartLogic, geo, instantGlobals) {
	'use strict';

	var bidderName = 'onemobile',
		siteId = '2c9d2b50015e5e9a6540a64f3eac0266',
		slots = {
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					size: [320, 50],
					pos: 'wikia_mw_top_leaderboard_hb'
				},
				MOBILE_IN_CONTENT: {
					size: [300, 250],
					pos: 'wikia_mw_incontent_hb'
				},
				MOBILE_PREFOOTER: {
					size: [300, 250],
					pos: 'wikia_mw_pre_footer_hb'
				}
			}
		};

	function isEnabled() {
		return adContext.get('targeting.skin') === 'mercury' &&
			geo.isProperGeo(instantGlobals.wgAdDriverAolOneMobileBidderCountries) && !instartLogic.isBlocking();
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
						dcn: siteId,
						pos: config.pos
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
