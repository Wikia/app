/*global define, Array */
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
		slots = Array.isArray(slots) ? slots : [slots];
		win.googletag.pubads().clear(slots);
		if (updateCorrelator) {
			win.googletag.pubads().updateCorrelator();
		}
		window.adslots2.push(slots);
	}

	return {
		addSlot: addSlot,
		getSlot: getSlot,
		refreshSlots: refreshSlots,
		removeSlots: removeSlots
	};
});
