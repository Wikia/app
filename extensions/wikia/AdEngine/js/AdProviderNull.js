/*exported AdProviderNull*/
/*global define*/
var AdProviderNull = function (log, slotTweaker) {
	'use strict';

	var logGroup = 'AdProviderNull';

	function canHandleSlot() {
		return true;
	}

	function fillInSlot(slotname, success) {
		log(['fillInSlot', slotname], 5, logGroup);
		slotTweaker.hide(slotname, true);
		slotTweaker.hideSelfServeUrl(slotname);
		success();
	}

	return {
		name: 'Null',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};

define('ext.wikia.adengine.provider.null', ['wikia.log', 'ext.wikia.adengine.slottweaker'], AdProviderNull);
