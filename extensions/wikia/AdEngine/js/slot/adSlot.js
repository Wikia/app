/*global define*/
define('ext.wikia.adEngine.slot.adSlot', [
	'ext.wikia.adEngine.utils.hooks'
], function (registerHooks) {
	'use strict';

	function create(slotName, slotElement, callbacks) {
		var slot = {};

		slot.getName = function () {
			return slotName;
		};

		slot.getElement = function () {
			return slotElement;
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

		registerHooks(slot, ['success', 'collapse', 'hop']);

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
