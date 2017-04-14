/*global define*/
define('ext.wikia.adEngine.slot.service.slotRegistry',  [], function () {
	'use strict';

	var slots = {};

	function add(slot, providerName) {
		slots[slot.name] = slots[slot.name] || [];

		slots[slot.name].push({
			providerName: providerName,
			slot: slot
		});
	}

	function get(slotName, providerName) {
		var slotsCount,
			foundSlots;

		if (!slots[slotName]) {
			return null;
		}

		slotsCount = slots[slotName].length;
		if (!slotsCount) {
			return null;
		}

		if (!providerName) {
			return slots[slotName][slotsCount - 1].slot;
		}

		foundSlots = slots[slotName].filter(function (registryRow) {
			if (registryRow.providerName === providerName) {
				return registryRow.slot;
			}
		});

		if (foundSlots.length) {
			return foundSlots[0].slot;
		}

		return null;
	}

	function reset(slotName) {
		slots[slotName] = [];
	}

	return {
		add: add,
		get: get,
		reset: reset
	};
});
