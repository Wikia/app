define('ext.wikia.adEngine.provider.gpt.googleSlots', function() {
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

	function getSlot(slotId) {
		return slots[slotId];
	}

	return {
		addSlot: addSlot,
		getSlot: getSlot,
		removeSlots: removeSlots
	}
});
