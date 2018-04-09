/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.prebid.adaptersHelper',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.log'
], function (adContext, slotsContext, adaptersHelper, instartLogic, log) {
	'use strict';

	var bidderName = 'rubicon', // aka rubicon vulcan
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.rubicon',
		outstreamSizeId = 203,
		rubiconAccountId = 7450,
		rubiconSiteId = 55412,
		slots = {
			oasis: {
				FEATURED: {
					disabled: true,
					zoneId: 260296,
					position: 'btf'
				},
				INCONTENT_PLAYER: {
					zoneId: 260296,
					position: 'btf'
				}
			},
			mercury: {
				FEATURED: {
					disabled: true,
					zoneId: 563110,
					position: 'btf'
				},
				MOBILE_IN_CONTENT: {
					zoneId: 563110,
					position: 'btf'
				}
			}
		};

	function isEnabled() {
		return adContext.get('bidders.rubicon') && !instartLogic.isBlocking();
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
			siteId: rubiconSiteId,
			zoneId: config.zoneId,
			name: slotName,
			position: config.position,
			inventory: targeting,
			video: {
				playerHeight: 480,
				playerWidth: 640,
				size_id: outstreamSizeId
			}
		};

		adUnit = {
			code: slotName,
			sizes: [
				[640, 480]
			],
			mediaType: 'video',
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
