/*exported AdProviderNull*/
var AdProviderNull = function (log, slotTweaker) {
	'use strict';

	var logGroup = 'AdProviderNull';

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
		name: 'Null',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};
