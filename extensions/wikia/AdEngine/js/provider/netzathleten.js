/*global define, require*/
define('ext.wikia.adEngine.provider.netzathleten', [
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'wikia.document',
	'wikia.window'
], function (slotTweaker, eventDispatcher, doc, win) {
	'use strict';

	var initialized = false,
		slotMap = {
			TOP_LEADERBOARD: 'SUPERBANNER',
			TOP_RIGHT_BOXAD: 'MEDIUM_RECTANGLE',
			PREFOOTER_LEFT_BOXAD: 'MEDIUM_RECTANGLE',
			MOBILE_TOP_LEADERBOARD: 'TOP',
			MOBILE_IN_CONTENT: 'MID',
			MOBILE_PREFOOTER: 'BOTTOM'
		};

	function init() {
		eventDispatcher.dispatch('wikia.not_uap');
		win.naMediaAd.setValue('homesite', false);
		initialized = true;
	}

	function canHandleSlot(slotName) {
		return !!slotMap[slotName];
	}

	function fillInSlot(slot) {
		var container = doc.createElement('div');

		if (!initialized) {
			init();
		}

		slotTweaker.show(slot.name);
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
