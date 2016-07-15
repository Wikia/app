define('ext.wikia.adEngine.pageFairDetection', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, scriptLoader, doc, log, window) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.pageFairDetection';

	window.pf_notify = detector;
	window.bm_website_code = getWebsiteCode();

	function getWebsiteCode() {
		return context.opts.pageFairWebsiteCode;
	}

	function detector(adblockDetected) {
		log(['PageFair detection, adBlock detected:', adblockDetected], 'debug', logGroup);

		window.ads.runtime.pf = window.ads.runtime.pf || {};
		window.ads.runtime.pf.blocking = adblockDetected;

		var eventName = adblockDetected ? 'pf.blocking' : 'pf.not_blocking';
			doc.dispatchEvent(new Event(eventName));
	}

	function initDetection() {
		var node = doc.getElementsByTagName('script')[0];
		scriptLoader.loadAsync('http://asset.pagefair.com/measure.min.js', node);
		scriptLoader.loadAsync('http://asset.pagefair.net/ads.min.js', node);
	}

	return {
		initDetection: initDetection
	};
});
