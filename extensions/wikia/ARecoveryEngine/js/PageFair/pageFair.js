define('ext.wikia.aRecoveryEngine.recovery.pageFair', ['wikia.log'], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.pageFair',
		recoverableSlots = {
		'TOP_LEADERBOARD': true,
		'TOP_RIGHT_BOXAD': true
	};

	function isSlotRecoverable(slot) {
		var result = !!recoverableSlots[slot.name];
		log(['isSlotRecoverable', result], log.levels.info, logGroup);
		return result;
	}

	function addMarker(slot) {
		slot.container.setAttribute('adonis-marker', '');
	}

	return {
		isSlotRecoverable: isSlotRecoverable,
		addMarker: addMarker
	};
});
