/*global define*/
define('ext.wikia.adEngine.provider.gpt.targeting', [
	'ext.wikia.adEngine.provider.gpt.googleSlots',
	'wikia.window'
], function (googleSlots, win) {
	'use strict';

	function getPageLevelTargetingValue(key) {
		var pubads;

		if (win.googletag && typeof win.googletag.pubads === "function") {
			pubads = win.googletag.pubads();
		}

		return pubads &&
			typeof pubads.getTargeting === "function" &&
			pubads.getTargeting(key);
	}

	function getSlotLevelTargetingValue(slotName, key) {
		var gptSlot = googleSlots.getSlotByName(slotName);

		if (gptSlot) {
			return gptSlot.getTargeting(key)[0];
		}
	}

	function getSlotLevelTargeting(slotName) {
		var gptSlot = googleSlots.getSlotByName(slotName),
			targeting = {},
			keys;

		if (gptSlot) {
			keys = gptSlot.getTargetingKeys();
			keys.forEach(function (key) {
				targeting[key] = gptSlot.getTargeting(key)[0];
			});
		}

		return targeting;
	}

	return {
		getPageLevelTargetingValue: getPageLevelTargetingValue,
		getSlotLevelTargetingValue: getSlotLevelTargetingValue,
		getSlotLevelTargeting: getSlotLevelTargeting
	};
});
