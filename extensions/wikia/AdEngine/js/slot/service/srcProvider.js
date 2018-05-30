/*global define, require*/
define('ext.wikia.adEngine.slot.service.srcProvider',  [
	'ext.wikia.adEngine.adContext'
], function (
	adContext,
) {
	'use strict';

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
