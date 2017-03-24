/*global define*/
define('ext.wikia.adEngine.provider.gpt.googleSlots', [
	'ext.wikia.aRecoveryEngine.recovery.sourcePointHelper',
	'wikia.window'
], function (recoveryHelper, win) {
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

		if (recoveryHelper.isBlocking() && win._sp_.getElementId) {
			slotId = win._sp_.getElementId(slotId);
		}

		return slots[slotId];
	}

	function refreshSlots(slots, updateCorrelator) {
		slots = slots.isArray() ? slots : [slots];
		win.googletag.pubads().clear(slots);
		if (updateCorrelator) {
			win.googletag.pubads().updateCorrelator();
		}
		win.googletag.pubads().refresh(slots);
	}

	return {
		addSlot: addSlot,
		getSlot: getSlot,
		refreshSlots: refreshSlots,
		removeSlots: removeSlots
	};
});
