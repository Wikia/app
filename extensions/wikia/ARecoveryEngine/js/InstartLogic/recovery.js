/*global define*/
define('ext.wikia.aRecoveryEngine.instartLogic.recovery', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.targeting',
	'wikia.log'
], function (adContext, targeting, log) {
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
		var srcKeyVal = targeting.getPageLevelTargetingValue('src'),
			isParamSet = srcKeyVal && srcKeyVal.indexOf('rec') > -1;

		log(['isBlocking', isParamSet], log.levels.debug, logGroup);
		return isParamSet;
	}

	return {
		isBlocking: isBlocking,
		isEnabled: isEnabled,
		isSlotRecoverable: isEnabled
	};
});
