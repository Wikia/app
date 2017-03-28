/*global define*/
define('ext.wikia.adEngine.provider.gpt.googleSlots', [
	'ext.wikia.aRecoveryEngine.recovery.sourcePoint',
	'wikia.window'
], function (sourcePoint, win) {
	'use strict';
	var slots = {};

	function addSlot(slot) {
		var slotId = slot.getSlotElementId();

		slots[slotId] = slot;
	}

	function removeSlots(slotsToRemove) {
		slotsToRemove.forEach(function(slot) {
			slots[slot.getSlotElementId()] = undefined;
		});
	}

	function getSlot(id) {
		var slotId = id;

		if (sourcePoint.isBlocking() && win._sp_.getElementId) {
			slotId = win._sp_.getElementId(slotId);
		}

		return slots[slotId];
	}

	return {
		addSlot: addSlot,
		getSlot: getSlot,
		removeSlots: removeSlots
	};
});
