/*global define*/
define('ext.wikia.adengine.provider.remnantdartmobile', ['wikia.log', 'ext.wikia.adengine.slottweaker'], function (log, slotTweaker) {
	'use strict';

	var logGroup = 'AdProviderDartRemnantMobile';

	function canHandleSlot() {
		return true;
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 5, logGroup);

		// just hop to null
		hop({method: 'hop'}, 'Null');

	}

	return {
		name: 'RemnantDartMobile',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
