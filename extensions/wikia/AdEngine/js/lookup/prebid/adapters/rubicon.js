/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.log'
], function (adContext, slotsContext, adLogicZoneParams, instartLogic, log) {
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

	function getAdContext() {
		return adContext.getContext();
	}

	function getTargeting(slotName, skin) {
		var provider = skin === 'oasis' ? 'gpt' : 'mobile',
			s1 = getAdContext().targeting.wikiIsTop1000 ? adLogicZoneParams.getName() : 'not a top1k wiki';

		return {
			pos: slotName,
			src: provider,
			s0: adLogicZoneParams.getSite(),
			s1: s1,
			s2: adLogicZoneParams.getPageType(),
			lang: adLogicZoneParams.getLanguage()
		};
	}

	function isEnabled() {
		return getAdContext().bidders.rubicon && !instartLogic.isBlocking();
	}

	function prepareAdUnit(slotName, config, skin) {
		var targeting = getTargeting(slotName, skin),
			adUnit,
			bidParams;

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
