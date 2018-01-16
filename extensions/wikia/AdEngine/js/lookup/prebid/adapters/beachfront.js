/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.beachfront', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.location',
	'wikia.log'
], function (adContext, slotsContext, instartLogic, loc, log) {
	'use strict';

	var bidderName = 'beachfront',
		bidfloor = 0.01,
		debugAppId = '2e55f7ad-3558-49eb-a3e1-056ccd0e74e2',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.beachfront',
		slots = {
			oasis: {
				INCONTENT_PLAYER: {
					appId: 'd239e601-dd57-4163-fe5d-35012d77395f'
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					appId: 'f377a8b1-c5c0-4108-f932-0102a81ff43d'
				}
			}
		};

	function isEnabled() {
		return adContext.getContext().bidders.beachfront && !instartLogic.isBlocking();
	}

	function prepareAdUnit(slotName, config) {
		var isDebugMode = loc.href.indexOf('beachfront_debug_mode=1') >= 0;

		var adUnit =  {
			code: slotName,
			sizes: [640, 480],
			mediaType: 'video',
			bids: [
				{
					bidder: bidderName,
					params: {
						bidfloor: bidfloor,
						appId: isDebugMode ? debugAppId : config.appId
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
