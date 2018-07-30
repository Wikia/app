/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.prebid.adaptersHelper',
	'ext.wikia.adEngine.wad.babDetection',
	'wikia.log'
], function (adContext, slotsContext, adaptersHelper, babDetection, log) {
	'use strict';

	var bidderName = 'rubicon', // aka rubicon vulcan
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.rubicon',
		rubiconAccountId = '7450',
		slots = {
			oasis: {
				FEATURED: {
					disabled: true,
					siteId: '147980',
					sizeId: '201',
					zoneId: '699374',
					position: 'btf'
				},
				INCONTENT_PLAYER: {
					siteId: '55412',
					sizeId: '203',
					zoneId: '260296',
					position: 'btf'
				}
			},
			mercury: {
				FEATURED: {
					disabled: true,
					siteId: '147980',
					sizeId: '201',
					zoneId: '699374',
					position: 'btf'
				},
				MOBILE_IN_CONTENT: {
					siteId: '55412',
					sizeId: '203',
					zoneId: '563110',
					position: 'btf'
				}
			}
		};

	function isEnabled() {
		return adContext.get('bidders.rubicon') && !babDetection.isBlocking();
	}

	function prepareAdUnit(slotName, config, skin) {
		var targeting = adaptersHelper.getTargeting(slotName, skin),
			adUnit,
			bidParams;

		if (config.disabled) {
			return;
		}

		bidParams = {
			accountId: rubiconAccountId,
			siteId: config.siteId,
			zoneId: config.zoneId,
			name: slotName,
			position: config.position,
			inventory: targeting,
			video: {
				playerHeight: '480',
				playerWidth: '640',
				size_id: config.sizeId,
				language: (targeting.lang && targeting.lang[0]) || 'en'
			}
		};

		adUnit = {
			code: slotName,
			mediaType: 'video',
			mediaTypes: {
				video: {
					playerSize: [640, 480]
				}
			},
			bids: [
				{
					bidder: bidderName,
					params: bidParams
				}
			]
		};

		log(['prepareAdUnit', adUnit], log.levels.debug, logGroup);
		return adUnit;
	}

	function getSlots(skin) {
		var enabledSlots = slots[skin];

		if (adContext.get('bidders.rubiconInFV')) {
			enabledSlots.FEATURED.disabled = false;
		}

		return slotsContext.filterSlotMap(enabledSlots);
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
