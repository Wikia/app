/*global define*/
define('ext.wikia.adEngine.slot.service.viewabilityHandler',  [
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.log',
	'wikia.window'
], function (googleTag, slotRegistry, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.service.viewabilityHandler';

	function refreshSlot(slotName, delay, options) {
		var slotObject = {
			slotName: slotName,
			onSuccess: options.onSuccess
		};

		delay = delay !== undefined ? delay : 1000;

		win.setTimeout(function () {
			googleTag.destroySlots([slotName]);
			if (win.adslots2) {
				win.adslots2.push(slotObject);
			} else {
				win.Mercury.Modules.Ads.getInstance().pushSlotToQueue(slotObject);
			}
		}, delay);
	}

	function refreshOnView(slotName, delay, options) {
		var slot = slotRegistry.get(slotName);

		log(['refresh on view', slotName, slot], log.levels.debug, logGroup);
		options = options || {};

		if (slot) {
			if (slot.isViewed) {
				refreshSlot(slot.name, delay, options);
			} else {
				slot.post('viewed', function () {
					refreshSlot(slot.name, delay, options);
				});
			}
		}
	}

	return {
		refreshOnView: refreshOnView
	};
});
