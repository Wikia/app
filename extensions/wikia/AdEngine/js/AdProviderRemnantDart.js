/*exported AdProviderRemnantDart*/
var AdProviderRemnantDart = function (log, slotTweaker) {
	'use strict';

	var logGroup = 'AdProviderRemnantDart';

	function canHandleSlot() {
		return true;
	}

	function fillInSlot(slotname, success) {
		log(['fillInSlot', slotname], 5, logGroup);
		slotTweaker.hide(slotname);
		slotTweaker.hideSelfServeUrl(slotname);
		success();
	}

	return {
		name: 'RemnantDart',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};
