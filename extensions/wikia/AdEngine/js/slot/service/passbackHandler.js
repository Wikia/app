/*global define, require*/
define('ext.wikia.adEngine.slot.service.passbackHandler', [
	'ext.wikia.adEngine.slot.service.stateMonitor'
], function (slotStateMonitor) {
	'use strict';

	function get(slotName) {
		var slotHops = slotStateMonitor.getSlotStatuses(slotName, 'hop');

		if (slotHops.length > 0) {
			var lastHop = slotHops[slotHops.length - 1];
			return lastHop && lastHop.adInfo && lastHop.adInfo.source ? lastHop.adInfo.source : 'unknown';
		}

		return null;
	}

	return {
		get: get
	};
});
