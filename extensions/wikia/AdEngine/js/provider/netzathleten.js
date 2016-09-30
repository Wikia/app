/*global define, require*/
define('ext.wikia.adEngine.provider.netzathleten', [
	'wikia.document',
	'wikia.window'
], function (doc, win) {
	'use strict';

	var slotMap = {
			TOP_LEADERBOARD: 'SUPERBANNER',
			TOP_RIGHT_BOXAD: 'MEDIUM_RECTANGLE'
		};

	function canHandleSlot(slotName) {
		return !!slotMap[slotName];
	}

	function fillInSlot(slot) {
		var container = doc.createElement('div');

		container.id = 'naMediaAd_' + slotMap[slot.name];
		slot.container.appendChild(container);

		win.naMediaAd.includeAd(slotMap[slot.name]);
	}

	return {
		name: 'NetzAthleten',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
