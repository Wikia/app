/*exported AdProviderNull*/
var AdProviderNull = function (log, slotTweaker) {
	'use strict';

	var logGroup = 'AdProviderNull';

	function canHandleSlot(slotname) { // jshint unused:false
		return true;
	}

	function fillInSlot(slotname) {
		log(['fillInSlot', slotname], 5, logGroup);
		slotTweaker.hide(slotname);
		return;
	}

	return {
		name: 'Null',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};
