define('ext.wikia.adEngine.pageFairDetection', [
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (scriptLoader, browserDetect, doc, log, win) {
	'use strict';

	var context = null,
		logGroup = 'ext.wikia.adEngine.pageFairDetection';

	function isMobileSkin() {
		return context.targeting.skin === 'mercury';
	}

	function getWebsiteCode() {
		var websiteKeys = {
			mobile: 'EFB8C00E91C84764',
			desktop: '954076792F3C4693'
		};

		return isMobileSkin() || browserDetect.isMobile() ? websiteKeys.mobile : websiteKeys.desktop;
	}

	function dispatchDetectionEvent(eventName) {
		var event = doc.createEvent('Event');
		event.initEvent(eventName, true, false);

		doc.dispatchEvent(event);
	}

	function setRuntimeParams(isAdBlockDetected) {
		win.ads.runtime.pf = win.ads.runtime.pf || {};
		win.ads.runtime.pf.blocking = isAdBlockDetected;
	}

	function detector(isAdBlockDetected) {
		var eventName = isAdBlockDetected ? 'pf.blocking' : 'pf.not_blocking';

		if (!context.opts.pageFairDetection) {
			log('PageFair disabled', 'debug', logGroup);
			return null;
		}

		log(['PageFair detection, adBlock detected:', isAdBlockDetected], 'debug', logGroup);

		setRuntimeParams(isAdBlockDetected);
		dispatchDetectionEvent(eventName);
	}

	function initDetection(injectedContext) {
		var node = doc.getElementsByTagName('script')[0];
		context = injectedContext;

		win.bm_website_code = getWebsiteCode();
		win.pf_notify = detector;
		scriptLoader.loadAsync(context.opts.pageFairDetectionUrl, node);
	}

	return {
		initDetection: initDetection
	};
});
