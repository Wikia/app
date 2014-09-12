/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.gptSlotConfig'
], function (log, document, adContext, wikiaGpt, gptSlotConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.directGptMobile',
		slotMap = gptSlotConfig.getConfig('mobile');

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		function showAdAndCallSuccess() {
			document.getElementById(slotname).className += ' show';
			success();
		}

		function doHop() {
			if (adContext.getContext().providers.remnantGptMobile) {
				hop({method: 'hop'}, 'RemnantGptMobile');
			} else {
				hop({method: 'hop'}, 'Null');
			}
		}

		wikiaGpt.pushAd(slotname, showAdAndCallSuccess, doHop, 'mobile');
		wikiaGpt.flushAds();
	}

	return {
		name: 'DirectGptMobile',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
