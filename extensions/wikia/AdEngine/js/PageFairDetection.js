define('ext.wikia.adEngine.pageFairDetection', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, scriptLoader, browserDetect, doc, log, win) {
	'use strict';

	var context = null,
		logGroup = 'ext.wikia.adEngine.pageFairDetection';

	function getContext() {
		if (context === null) {
			context = adContext.getContext();
		}
		return context;
	}

	function skinIsMobile() {
		return getContext().targeting.skin === 'mercury';
	}

	function getWebsiteCode() {
		var websiteKeys = {
			mobile: 'FA8D90F8D9F54665',
			desktop: 'FE3882548B7E471A'
		};

		return skinIsMobile() || browserDetect.isMobile() ? websiteKeys.mobile : websiteKeys.desktop;
	}

	function dispatchDetectionEvent(eventName){
		var event = doc.createEvent('Event');
		event.initEvent(eventName, true, false);

		doc.dispatchEvent(event);
	}

	function setRuntimeParams(adblockDetected){
		win.ads.runtime.pf = win.ads.runtime.pf || {};
		win.ads.runtime.pf.blocking = adblockDetected;
	}

	function detector(adblockDetected) {
		var eventName = adblockDetected ? 'pf.blocking' : 'pf.not_blocking';

		if (!getContext().opts.pageFairDetection) {
			log('PageFair disabled', 'debug', logGroup);
			return null;
		}

		log(['PageFair detection, adBlock detected:', adblockDetected], 'debug', logGroup);

		setRuntimeParams(adblockDetected);
		dispatchDetectionEvent(eventName);
	}

	function initDetection() {
		var node = doc.getElementsByTagName('script')[0];

		win.bm_website_code = getWebsiteCode();
		win.pf_notify = detector;
		scriptLoader.loadAsync(getContext().opts.pageFairDetectionUrl, node);
	}

	return {
		initDetection: initDetection
	};
});
