/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.gptSlotConfig'
], function (log, window, document, wikiaGpt, gptSlotConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.directGptMobile',
		slotMap = gptSlotConfig.getConfig('mobile');

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		function hopToNull() {
			hop({method: 'hop'}, 'Null');
		}

		function hopToRemnant() {
			hop({method: 'hop'}, 'RemnantGptMobile');
		}

		function showAdAndCallSuccess() {
			document.getElementById(slotname).className += ' show';
			success();
		}

		wikiaGpt.pushAd(slotname, showAdAndCallSuccess, (window.wgAdDriverEnableRemnantGptMobile ? hopToRemnant : hopToNull), 'mobile');
		wikiaGpt.flushAds();
	}

	return {
		name: 'DirectGptMobile',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
