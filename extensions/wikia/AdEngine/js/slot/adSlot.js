/*global define*/
define('ext.wikia.adEngine.slot.adSlot', [],
function () {
	'use strict';

	function getShortSlotName(slotName) {
		return slotName.replace(/^.*\/([^\/]*)$/, '$1');
	}

	return {
		getShortSlotName: getShortSlotName
	};
});
