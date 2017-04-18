/*global define*/
define('ext.wikia.adEngine.slot.service.viewabilityHandler',  [
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.log',
	'wikia.window'
], function (googleTag, slotRegistry, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.service.viewabilityHandler';

	function refreshSlot(slotName, delay) {
		delay = delay !== undefined ? delay : 1000;

		win.setTimeout(function () {
			googleTag.destroySlots([slotName]);
			if (win.adslots2) {
				win.adslots2.push([slotName]);
			} else {
				win.Mercury.Modules.Ads.getInstance().pushSlotToQueue(slotName);
			}
		}, delay);
	}

	function refreshOnView(slotName, delay) {
		var slot = slotRegistry.get(slotName);

		log(['refresh on view', slotName, slot], log.levels.debug, logGroup);

		if (slot) {
			if (slot.isViewed) {
				refreshSlot(slot.name, delay);
			} else {
				slot.post('viewed', function () {
					refreshSlot(slot.name, delay);
				});
			}
		}
	}

	return {
		refreshOnView: refreshOnView
	};
});
