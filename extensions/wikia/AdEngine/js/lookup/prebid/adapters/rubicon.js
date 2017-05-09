/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', [
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (geo, instantGlobals, log) {
	'use strict';

	var bidderName = 'rubicon',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.rubicon',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[640, 360]
					],
					siteId: '55412',
					zoneId: '519058',
					accountId: '7450',
					name: 'outstream-desktop',
					video: {
						playerHeight: 360,
						playerWidth: 640,
						size_id: 201
					}
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [
						[640, 360]
					],
					siteId: 55412,
					zoneId: 563110,
					accountId: 5441,
					name: 'outstream-desktop',
					video: {
						language: 'en',
						playerHeight: 360,
						playerWidth: 640,
						size_id: 201
					}
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverRubiconLiteCountries);
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
						video: config.video
					}
				}
			]
		};
console.log(adUnit);
		log(['prepareAdUnit', adUnit], log.levels.debug, logGroup);
		return adUnit;
	}

	function getSlots(skin) {
		return slots[skin];
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
