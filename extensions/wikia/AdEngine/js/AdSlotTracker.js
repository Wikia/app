/*global define*/
define('ext.wikia.adEngine.adSlotTracker',  [
	'ext.wikia.adEngine.adTracker',
	'wikia.log',
	'wikia.window'
], function (adTracker, log, win) {
	'use strict';

	var slotHistoryMap = {};

	function remember(data) {
		if (!slotHistoryMap[data.slot.name]) {
			slotHistoryMap[data.slot.name] = [];
		}

		slotHistoryMap[data.slot.name].push(data);
	}

	function getLastHop(slotName) {
		var allHops = slotHistoryMap[slotName]
			.filter(function (e) {
				return e.status === 'hop';
			});
		return allHops.length > 0 ? allHops[allHops.length - 1] : null;
	}

	function getPassback(slotName) {
		if (slotHistoryMap[slotName]) {
			var lastHop = getLastHop(slotName);
			return lastHop && lastHop.adInfo ? lastHop.adInfo.source : null;
		}

		return null;
	}

	function run() {
		win.addEventListener('adengine.slot.status', function (e) {
			remember(e.detail);
		});
	}

	return {
		run: run,
		getPassback: getPassback
	};

});
