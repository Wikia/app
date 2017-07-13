define('ext.wikia.aRecoveryEngine.instartLogic.recovery', [
	'wikia.log',
	'wikia.window'
], function (log, win) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.instartLogic.recovery';

	/**
	 * When IL detects that user is blocking, it sets src=rec on page level params
	 *
	 * @returns {boolean}
	 */
	function isBlocking() {
		var gptLib = win.googletag.pubads && win.googletag.pubads() && win.googletag.pubads().getTargeting('src'),
			isBlocking = gptLib && gptLib.indexOf('rec') > -1;

		log(['isBlocking', isBlocking], log.levels.debug, logGroup);
		return isBlocking;
	}

	return {
		isBlocking: isBlocking};
});
