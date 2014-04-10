/*global define*/
define('ext.wikia.adEngine.provider.null', ['wikia.log', 'ext.wikia.adEngine.slotTweaker'], function (log, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.null';

	function canHandleSlot() {
		return true;
	}

	function fillInSlot(slotname, success) {
		log(['fillInSlot', slotname], 5, logGroup);
		slotTweaker.hide(slotname);
		success();
	}

	return {
		name: 'Null',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
