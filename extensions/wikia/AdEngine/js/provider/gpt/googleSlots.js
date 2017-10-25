/*global define, Array */
define('ext.wikia.adEngine.provider.gpt.googleSlots', [
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.window'
], function (adUnitBuilder, adBlockDetection, win) {
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

		if (adBlockDetection.isBlocking() && win._sp_ && win._sp_.getElementId) {
			slotId = win._sp_.getElementId(slotId);
		}

		return slots[slotId];
	}

	function getSlotByName(slotName) {
		var adUnit = adUnitBuilder.build(slotName, 'gpt');
		return getSlot('wikia_gpt' + adUnit);
	}

	return {
		addSlot: addSlot,
		getSlot: getSlot,
		getSlotByName: getSlotByName,
		removeSlots: removeSlots
	};
});
