/*global define*/
define('ext.wikia.adEngine.slot.adSlot', [], function () {
	'use strict';

	function create(name, container, callbacks) {
		var slot = {
			name: name,
			container: container
		};

		slot.success = function (adInfo) {
			if (typeof callbacks.success === 'function') {
				callbacks.success(adInfo);
			}
		};
		slot.collapse = function (adInfo) {
			if (typeof callbacks.collapse === 'function') {
				callbacks.collapse(adInfo);
			}
		};
		slot.hop = function (adInfo) {
			if (typeof callbacks.hop === 'function') {
				callbacks.hop(adInfo);
			}
		};

		return slot;
	}

	function getShortSlotName(slotName) {
		return slotName.replace(/^.*\/([^\/]*)$/, '$1');
	}

	return {
		create: create,
		getShortSlotName: getShortSlotName
	};
});
