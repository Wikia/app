/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.log'
], function (adContext, slotsContext, instartLogic, log) {
	'use strict';

	var bidderName = 'rubicon', // aka rubicon vulcan
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.rubicon',
		outstreamSizeId = 203,
		rubiconAccountId = 7450,
		rubiconSiteId = 55412,
		slots = {
			oasis: {
				INCONTENT_PLAYER: {
					zoneId: 260296,
					position: 'btf'
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					zoneId: 563110,
					position: 'btf'
				}
			}
		};

	function isEnabled() {
		return adContext.getContext().bidders.rubicon && !instartLogic.isBlocking();
	}

	function prepareAdUnit(slotName, config) {
		var adUnit = {
			code: slotName,
			sizes: [
				[640, 480]
			],
			mediaType: 'video',
			bids: [
				{
					bidder: bidderName,
					params: {
						accountId: rubiconAccountId,
						siteId: rubiconSiteId,
						zoneId: config.zoneId,
						name: slotName,
						position: config.position,
						video: {
							playerHeight: 480,
							playerWidth: 640,
							size_id: outstreamSizeId
						}
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
