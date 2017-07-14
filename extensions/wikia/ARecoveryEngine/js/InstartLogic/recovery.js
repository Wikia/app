define('ext.wikia.aRecoveryEngine.instartLogic.recovery', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.window'
], function (adContext, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.instartLogic.recovery',
		context = adContext.getContext();

	function isEnabled() {
		var enabled = !!context.opts.instartLogicRecovery;

		log(['isEnabled', enabled, log.levels.debug, logGroup]);
		return enabled;
	}

	/**
	 * When IL detects that user is blocking, it sets src=rec on page level params
	 *
	 * @returns {boolean}
	 */
	function isBlocking() {
		var gptLib = win.googletag.pubads && win.googletag.pubads() && win.googletag.pubads().getTargeting('src'),
			isBlocking = gptLib && gptLib.indexOf('rec') > -1;
console.warn('NASZE LOGI IE BLOCKING', isBlocking);
		log(['isBlocking', isBlocking], log.levels.debug, logGroup);
		return isBlocking;
	}

	return {
		isBlocking: isBlocking,
		isEnabled: isEnabled,
		isSlotRecoverable: isEnabled
	};
});
