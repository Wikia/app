/*global define*/
define('ext.wikia.adEngine.slot.adSlot', [
	'ext.wikia.adEngine.utils.hooks'
], function (registerHooks) {
	'use strict';

	function create(slotName, slotElement) {
		var slot = {};

		slot.getName = function () {
			return slotName;
		};

		slot.getElement = function () {
			return slotElement;
		};

		slot.success = function () {};
		slot.collapse = function () {};
		slot.hop = function () {};

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
