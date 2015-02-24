/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'wikia.log',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.gptSlotConfig'
], function (log, wikiaGpt, gptSlotConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.directGptMobile',
		slotMap = gptSlotConfig.getConfig('mobile');

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		wikiaGpt.pushAd(slotname, success, hop, 'mobile');
		wikiaGpt.flushAds();
	}

	return {
		name: 'DirectGptMobile',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
