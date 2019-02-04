/*global define*/
define('ext.wikia.adEngine.slot.service.slotRegistry',  [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.bridge',
	'wikia.window'
], function (adContext, bridge, win) {
	'use strict';

	var slots = {},
		slotStates = {},
		slotQueueCount = {};

	function incrementSlotQueueCount(slotName) {
		slotQueueCount[slotName] = slotQueueCount[slotName] || 0;

		if (slots[slotName].length === 0) {
			slotQueueCount[slotName] += 1;
		}
	}

	function add(slot, providerName) {
		slots[slot.name] = slots[slot.name] || [];
		incrementSlotQueueCount(slot.name);
		// FIXME: This is getting ugly as hell
		// Since it's going to be removed once we adopt AE3
		// Let's unify slot interfaces through bridge over here
		slot = bridge.unifySlotInterface(slot);

		slots[slot.name].push({
			providerName: providerName,
			slot: slot
		});

		if (slotStates[slot.name] === false) {
			slot.disable();
		}
		if (slotStates[slot.name] === true) {
			slot.enable();
		}
	}

	function setState(slotName, state) {
		var slot = get(slotName);
		slotStates[slotName] = state;

		if (slot) {
			if (state) {
				slot.enable();
			} else {
				slot.disable();
			}
		}
	}

	function enable(slotName) {
		setState(slotName, true);
	}

	function disable(slotName) {
		setState(slotName, false);
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

	function getRefreshCount(slotName) {
		return slotQueueCount[slotName] || 0;
	}

	function reset(slotName) {
		slots[slotName] = [];
	}

	adContext.addCallback(function () {
		slots = {};
		slotQueueCount = {};
		slotStates = {};
	});

	function getCurrentScrollY() {
		return win.scrollY || win.pageYOffset;
	}

	return {
		add: add,
		disable: disable,
		enable: enable,
		get: get,
		getCurrentScrollY: getCurrentScrollY,
		getRefreshCount: getRefreshCount,
		reset: reset
	};
});
