/*global define*/
define('ext.wikia.aRecoveryEngine.sourcePoint.recovery', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.window'
], function (adContext, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.sourcePoint.recovery',
		context = adContext.getContext(),
		recoverableSlots = [
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',
			'INCONTENT_BOXAD_1',
			'BOTTOM_LEADERBOARD',
			'GPT_FLUSH'
		];

	/**
	 * SourcePoint can be enabled only if PF recovery is disabled
	 *
	 * @returns {boolean}
	 */
	function isEnabled() {
		var enabled = !!context.opts.sourcePointRecovery && !context.opts.pageFairRecovery;

		log(['isEnabled', enabled], log.levels.debug, logGroup);
		return enabled;
	}

	function isBlocking() {
		var isBlocking = !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking);

		log(['isBlocking', isBlocking], log.levels.debug, logGroup);
		return isBlocking;
	}

	function isSlotRecoverable(slotName) {
		var result = isEnabled() && recoverableSlots.indexOf(slotName) !== -1;

		log(['isSlotRecoverable', result], log.levels.info, logGroup);
		return result;
	}

	function getSafeUri(url) {
		if (isBlocking()) {
			url = win._sp_.getSafeUri(url);
		}

		return url;
	}

	return {
		getSafeUri: getSafeUri,
		isBlocking: isBlocking,
		isSlotRecoverable: isSlotRecoverable,
		isEnabled: isEnabled
	};
});
