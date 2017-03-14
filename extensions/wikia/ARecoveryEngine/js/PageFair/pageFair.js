define('ext.wikia.aRecoveryEngine.recovery.pageFair', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.window'
], function (adContext, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.pageFair',
		context = adContext.getContext(),
		recoverableSlots = {
			'TOP_LEADERBOARD': true,
			'TOP_RIGHT_BOXAD': true
		};

	function isPageFairRecoveryEnabled() {
		var enabled = !!context.opts.pageFairRecovery;

		log(['isPageFairRecoveryEnabled', enabled, 'debug', logGroup]);
		return enabled;
	}

	function isSlotRecoverable(slotName) {
		var result = isPageFairRecoveryEnabled() && !!recoverableSlots[slotName];

		log(['isSlotRecoverable', result], log.levels.info, logGroup);
		return result;
	}

	function isBlocking() {
		var isBlocking = !!(win.ads && win.ads.runtime.pf && win.ads.runtime.pf.blocking);

		log(['isBlocking', isBlocking], 'debug', logGroup);
		return isBlocking;
	}

	function addMarker(slotId) {
		var slot = document.getElementById(slotId);

		slot.setAttribute('adonis-marker', '');
	}

	return {
		isBlocking: isBlocking,
		isPageFairRecoveryEnabled: isPageFairRecoveryEnabled,
		isSlotRecoverable: isSlotRecoverable,
		addMarker: addMarker
	};
});
