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
		var gptLibSrcKeyVal = win.googletag.pubads && win.googletag.pubads() &&
			typeof win.googletag.pubads().getTargeting === "function" &&
			win.googletag.pubads().getTargeting('src'),

			isParamSet = gptLibSrcKeyVal && gptLibSrcKeyVal.indexOf('rec') > -1;

		log(['isBlocking', isParamSet], log.levels.debug, logGroup);
		return isParamSet;
	}

	return {
		isBlocking: isBlocking,
		isEnabled: isEnabled,
		isSlotRecoverable: isEnabled
	};
});
