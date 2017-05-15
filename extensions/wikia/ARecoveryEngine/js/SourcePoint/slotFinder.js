/*global define*/
define('ext.wikia.aRecoveryEngine.sourcePoint.slotFinder', [
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'wikia.document',
	'wikia.window'
], function (
	adUnitBuilder,
	doc,
	win
) {
	'use strict';

	function getRecoveredSlot(slotName) {
		var recoveredId = win._sp_.getElementId(getAdUnit(slotName));

		if (!recoveredId) {
			return null;
		}

		return doc.getElementById(recoveredId);
	}

	function getAdUnit(slotName) {
		return 'wikia_gpt' + adUnitBuilder.build(slotName, 'gpt');
	}

	return {
		getRecoveredSlot: getRecoveredSlot
	};
});
