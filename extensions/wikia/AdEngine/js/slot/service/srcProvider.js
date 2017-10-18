/*global define*/
define('ext.wikia.adEngine.slot.service.srcProvider',  [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'ext.wikia.aRecoveryEngine.adBlockRecovery',
	require.optional('ext.wikia.aRecoveryEngine.instartLogic.recovery')
], function (
	adContext,
	adBlockDetection,
	adBlockRecovery,
	instartLogic
) {
	'use strict';

	function adIsRecoverable(extra) {
		return extra && (extra.isPageFairRecoverable || extra.isInstartLogicRecoverable);
	}

	function isRecoverableByPF(extra) {
		return adBlockRecovery.isEnabled() && adBlockDetection.isBlocking() && adIsRecoverable(extra);
	}

	function isRecoverableByIL() {
		return instartLogic && instartLogic.isEnabled() && instartLogic.isBlocking();
	}

	function get(originalSrc, extra) {
		if (adContext.get('opts.premiumOnly') && !adContext.get('opts.isAdTestWiki')) {
			originalSrc = 'premium';
		} else if (isRecoverableByPF(extra) || isRecoverableByIL()) {
			originalSrc = 'rec';
		}

		if (adContext.get('opts.isAdTestWiki')) {
			return extra && extra.testSrc ? extra.testSrc : 'test-' + originalSrc;
		}

		return originalSrc;
	}

	return {
		get: get
	};
});
