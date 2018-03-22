/*global define*/
define('ext.wikia.adEngine.slot.service.stateMonitor',  [
	'wikia.window'
], function (win) {
	'use strict';

	var slotHistoryMap = {};

	function store(data) {
		if (!slotHistoryMap[data.slot.name]) {
			slotHistoryMap[data.slot.name] = [];
		}

		slotHistoryMap[data.slot.name].push(data);
	}

	function run() {
		win.addEventListener('adengine.slot.status', function (e) {
			store(e.detail);
		});
	}

	function filterByStatus(data, status) {
		return data.filter(function (e) {
			return e.status === status;
		});
	}

	function getSlotStatuses(slotName, statusType) {
		var result = slotHistoryMap[slotName];

		if (!result) {
			return [];
		}

		return statusType ? filterByStatus(result, statusType) : result;
	}

	return {
		getSlotStatuses: getSlotStatuses,
		run: run
	};

});
