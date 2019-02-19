/*global define*/
define('ext.wikia.adEngine.slot.service.srcProvider', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.babDetection'
], function (
	adContext,
	babDetection
) {
	'use strict';

	function addTestPrefixForTestWiki(originalSrc, extra) {
		if (adContext.get('opts.isAdTestWiki') && adContext.get('targeting.testSrc')) {
			originalSrc = originalSrc + ',' + adContext.get('targeting.testSrc');
		} else if (adContext.get('opts.isAdTestWiki')) {
			originalSrc = extra && extra.testSrc ? extra.testSrc : 'test-' + originalSrc;
		}

		return originalSrc;
	}

	function get(originalSrc, extra) {
		if (adContext.get('targeting.skin') === 'oasis' && babDetection.isBlocking()) {
			return getRecSrc();
		}

		return addTestPrefixForTestWiki(originalSrc, extra);
	}

	function getRecSrc() {
		return addTestPrefixForTestWiki('rec');
	}

	return {
		get: get,
		getRecSrc: getRecSrc
	};
});
