/*global define*/
define('ext.wikia.aRecoveryEngine.pageFair.recovery', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.window'
], function (adContext, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.pageFair.recovery',
		context = adContext.getContext(),
		recoverableSlots = [
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',
			'BOTTOM_LEADERBOARD'
		];

	function isEnabled() {
		var enabled = !!context.opts.pageFairRecovery;

		log(['isEnabled', enabled, log.levels.debug, logGroup]);
		return enabled;
	}

	function isSlotRecoverable(slotName) {
		var result = isEnabled() && recoverableSlots.indexOf(slotName) !== -1;

		log(['isSlotRecoverable', result], log.levels.info, logGroup);
		return result;
	}

	function isBlocking() {
		var isBlocking = !!(win.ads && win.ads.runtime.pf && win.ads.runtime.pf.recovering);

		log(['isBlocking', isBlocking], log.levels.debug, logGroup);
		return isBlocking;
	}

	function addMarker(slotElement) {
		slotElement.setAttribute('adonis-marker', '');
	}

	return {
		isBlocking: isBlocking,
		isEnabled: isEnabled,
		isSlotRecoverable: isSlotRecoverable,
		addMarker: addMarker
	};
});
