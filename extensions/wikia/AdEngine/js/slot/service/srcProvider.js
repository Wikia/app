/*global define*/
define('ext.wikia.adEngine.slot.service.srcProvider',  [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'ext.wikia.aRecoveryEngine.adBlockRecovery',
	'wikia.log',
	require.optional('ext.wikia.aRecoveryEngine.instartLogic.recovery')
], function (
	adContext,
	adBlockDetection,
	adBlockRecovery,
	log,
	instartLogic
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.service.srcProvider';

	function adIsRecoverable(extra) {
		var isAdRecoverable = (extra.isPageFairRecoverable || extra.isInstartLogicRecoverable);
		log(['adIsRecoverable', isAdRecoverable], log.levels.debug, logGroup);
		return extra && isAdRecoverable;
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
			log(['addTestPrefixForTestWiki - test wiki', originalSrc], log.levels.debug, logGroup);
		}

		return originalSrc;
	}

	function get(originalSrc, extra) {
		log(['get - start', originalSrc], log.levels.debug, logGroup);

		if (adContext.get('opts.premiumOnly') && !adContext.get('opts.isAdTestWiki')) {
			originalSrc = 'premium';
			log(['get - premium and not test wiki', originalSrc], log.levels.debug, logGroup);
		}

		if (isRecoverableByPF(extra) || isRecoverableByIL()) {
			originalSrc = 'rec';
			log(['get - recoverable', originalSrc], log.levels.debug, logGroup);
		}

		return addTestPrefixForTestWiki(originalSrc, extra);
	}

	function getRecoverySrc() {
		var recoverySrc = addTestPrefixForTestWiki('rec');
		log(['getRecoverySrc', recoverySrc], log.levels.debug, logGroup);
		return recoverySrc;
	}

	return {
		get: get,
		getRecoverySrc: getRecoverySrc
	};
});
