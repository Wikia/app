/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.sourcePoint', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	doc,
	instantGlobals,
	lazyQueue,
	log,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.sourcePoint',
		context = adContext.getContext(),
		recoverableSlots = [
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',
			'LEFT_SKYSCRAPER_2',
			'LEFT_SKYSCRAPER_3',
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

	return {
		isBlocking: isBlocking,
		isSlotRecoverable: isSlotRecoverable,
		isEnabled: isEnabled
	};
});
