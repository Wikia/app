/*global define*/
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
	 * When IL detects that user is blocking, the I11C.Morph is equal 1
	 *
	 * @returns {boolean}
	 */
	function isBlocking() {
		var isBlocking = !!(win.I11C && win.I11C.Morph);

		log(['isBlocking', isBlocking], log.levels.debug, logGroup);
		return isEnabled() && isBlocking;
	}

	return {
		isBlocking: isBlocking,
		isEnabled: isEnabled,
		isSlotRecoverable: isEnabled
	};
});
