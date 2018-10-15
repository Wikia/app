/*global define*/
define('ext.wikia.adEngine.slot.service.slotRegistry',  [
	'ext.wikia.adEngine.adContext',
	'wikia.window'
], function (adContext, win) {
	'use strict';

	var slots = {},
		slotStates = {},
		slotQueueCount = {},
		scrollYOnDfpRequest = {};

	function incrementSlotQueueCount(slotName) {
		slotQueueCount[slotName] = slotQueueCount[slotName] || 0;

		if (slots[slotName].length === 0) {
			slotQueueCount[slotName] += 1;
		}
	}

	function add(slot, providerName) {
		slots[slot.name] = slots[slot.name] || [];
		incrementSlotQueueCount(slot.name);

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

	function storeScrollY(slotName) {
		scrollYOnDfpRequest[slotName] = getCurrentScrollY();
	}

	function getScrollY(slotName) {
		return scrollYOnDfpRequest[slotName] || 0;
	}

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
		getScrollY: getScrollY,
		reset: reset,
		storeScrollY: storeScrollY
	};
});
