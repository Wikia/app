/*global define*/
define('ext.wikia.adengine.provider.remnantgptmobile', ['wikia.log', 'ext.wikia.adengine.slottweaker', 'ext.wikia.adengine.gpthelper', 'ext.wikia.adengine.gptslotconfig'], function (log, slotTweaker, wikiaGpt, gptSlotConfig) {
	'use strict';

	var logGroup = 'AdProviderDartRemnantMobile',
		slotMap = gptSlotConfig.getConfig('mobile_remnant');

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 5, logGroup);

		function hopToNull() {
			hop({method: 'hop'}, 'Null')
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
