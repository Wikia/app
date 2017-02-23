define('ext.wikia.aRecoveryEngine.recovery.pageFair', [
	'ext.wikia.adEngine.adContext',
	'wikia.log'
], function (adContext, log) {
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

	function addMarker(slotId) {
		var slot = document.getElementById(slotId);

		slot.setAttribute('adonis-marker', '');
	}

	function track(label) {
		if (Wikia && Wikia.Tracker) {
			Wikia.Tracker.track({
				eventName: 'ads.recovery',
				category: 'ads-recovery-page-fair',
				action: Wikia.Tracker.ACTIONS.IMPRESSION,
				label: label,
				trackingMethod: 'analytics'
			});
		}
	}

	return {
		isPageFairRecoveryEnabled: isPageFairRecoveryEnabled,
		isSlotRecoverable: isSlotRecoverable,
		addMarker: addMarker
	};
});
