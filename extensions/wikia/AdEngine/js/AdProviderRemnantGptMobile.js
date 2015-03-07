/*global define*/
define('ext.wikia.adEngine.provider.remnantGptMobile', [
	'wikia.log',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.gptSlotConfig'
], function (log, wikiaGpt, gptSlotConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.remnantGptMobile',
		slotMap = gptSlotConfig.getConfig('mobile_remnant');

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 5, logGroup);

		wikiaGpt.pushAd(slotname, success, hop, 'mobile_remnant');
		wikiaGpt.flushAds();
	}

	return {
		name: 'RemnantGptMobile',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
