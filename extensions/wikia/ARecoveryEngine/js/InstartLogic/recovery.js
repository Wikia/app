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
			isParamSet = gptLib && gptLib.indexOf('rec') > -1;

		log(['isBlocking', isParamSet], log.levels.debug, logGroup);
		return isParamSet;
	}

	return {
		isBlocking: isBlocking,
		isEnabled: isEnabled,
		isSlotRecoverable: isEnabled
	};
});
