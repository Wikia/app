/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.onemobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.wad.babDetection'
], function (adContext, slotsContext, babDetection) {
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
				BOTTOM_LEADERBOARD: {
					size: [300, 250],
					pos: 'wikia_mw_pre_footer_hb'
				}
			}
		};

	function isEnabled() {
		return adContext.get('targeting.skin') === 'mercury' &&
			adContext.get('bidders.onemobile') && !babDetection.isBlocking();
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			mediaTypes: {
				banner: {
					sizes: [config.size]
				}
			},
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
