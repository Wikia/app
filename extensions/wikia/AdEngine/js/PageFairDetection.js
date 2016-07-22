define('ext.wikia.adEngine.pageFairDetection', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, scriptLoader, doc, log, window) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.pageFairDetection';

	window.pf_notify = detector;
	window.bm_website_code = getWebsiteCode();

	function getWebsiteCode() {
		return context.opts.pageFairWebsiteCode;
	}

	function dispatchDetectionEvent(eventName){
		var event = document.createEvent('Event');
		event.initEvent(eventName, true, false);

		doc.dispatchEvent(event);
	}

	function setRuntimeParams(adblockDetected){
            window.ads.runtime.pf = window.ads.runtime.pf || {};
            window.ads.runtime.pf.blocking = adblockDetected;
        }

	function detector(adblockDetected) {
		var eventName = adblockDetected ? 'pf.blocking' : 'pf.not_blocking';

		if (!context.opts.pageFairDetection) {
			log('PageFair disabled', 'debug', logGroup);
			return null;
		}

		log(['PageFair detection, adBlock detected:', adblockDetected], 'debug', logGroup);

		setRuntimeParams(adblockDetected);
		dispatchDetectionEvent(eventName);
	}

	function initDetection() {
		var node = doc.getElementsByTagName('script')[0];
		scriptLoader.loadAsync(context.opts.pageFairDetectionUrl, node);
	}

	return {
		initDetection: initDetection
	};
});
