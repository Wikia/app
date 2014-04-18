/*global define*/
define('ext.wikia.adEngine.provider.remnantGptMobile', [
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.gptSlotConfig'
], function (log, document, slotTweaker, wikiaGpt, gptSlotConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.remnantGptMobile',
		slotMap = gptSlotConfig.getConfig('mobile_remnant');

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 5, logGroup);

		function hopToNull() {
			hop({method: 'hop'}, 'Null');
		}

		function showAdAndCallSuccess() {
			document.getElementById(slotname).className += ' show';
			success();
		}

		wikiaGpt.pushAd(slotname, showAdAndCallSuccess, hopToNull, 'mobile_remnant');
		wikiaGpt.flushAds();
	}

	return {
		name: 'RemnantGptMobile',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
