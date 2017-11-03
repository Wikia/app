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

	function addTestPrefixForTestWiki(originalSrc, extra) {
		if (adContext.get('opts.isAdTestWiki')) {
			originalSrc = extra && extra.testSrc ? extra.testSrc : 'test-' + originalSrc;
		}
		return originalSrc;
	}

	function get(originalSrc, extra) {
		if (adContext.get('opts.premiumOnly') && !adContext.get('opts.isAdTestWiki')) {
			originalSrc = 'premium';
		}
		if (isRecoverableByPF(extra) || isRecoverableByIL()) {
			originalSrc = 'rec';
		}

		return addTestPrefixForTestWiki(originalSrc, extra);
	}

	function getRecoverySrc() {
		return addTestPrefixForTestWiki('rec');
	}

	return {
		get: get,
		getRecoverySrc: getRecoverySrc
	};
});
