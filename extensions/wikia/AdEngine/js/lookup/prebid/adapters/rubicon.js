/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', [
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (slotsContext, geo, instantGlobals, log) {
	'use strict';

	var bidderName = 'rubicon',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.rubicon',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[640, 480]
					],
					siteId: 55412,
					zoneId: 519058,
					accountId: 7450,
					name: 'outstream-desktop',
					position: 'atf',
					video: {
						playerHeight: 480,
						playerWidth: 640,
						size_id: 203
					}
				},
				INCONTENT_PLAYER: {
					sizes: [
						[640, 480]
					],
					siteId: 55412,
					zoneId: 519058,
					accountId: 7450,
					name: 'outstream-desktop',
					position: 'atf',
					video: {
						playerHeight: 480,
						playerWidth: 640,
						size_id: 203
					}
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [
						[640, 480]
					],
					siteId: 55412,
					zoneId: 563110,
					accountId: 5441,
					name: 'outstream-mobile',
					position: 'atf',
					video: {
						playerHeight: 480,
						playerWidth: 640,
						size_id: 203
					}
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverRubiconPrebidCountries);
	}

	function prepareAdUnit(slotName, config) {
		var adUnit = {
			code: slotName,
			sizes: config.sizes,
			mediaType: 'video',
			bids: [
				{
					bidder: bidderName,
					params: {
						accountId: config.accountId,
						siteId: config.siteId,
						zoneId: config.zoneId,
						name: config.name,
						position: config.position,
						video: config.video
					}
				}
			]
		};

		log(['prepareAdUnit', adUnit], log.levels.debug, logGroup);
		return adUnit;
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