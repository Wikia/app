define('ext.wikia.adEngine.pageFairDetection', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, scriptLoader, doc, log, window) {
	'use strict';

	var context = null,
		logGroup = 'ext.wikia.adEngine.pageFairDetection';

	function getContext() {
		if (context === null) {
			context = adContext.getContext();
		}
		return context;
	}

	function isMobile() {
		var isMobileSkin = getContext().targeting.skin === 'mercury',
			userAgentIsMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

		return isMobileSkin || userAgentIsMobile;
	}

	function getWebsiteCode() {
		var websiteKeys = {
			mobile: 'FA8D90F8D9F54665',
			desktop: 'FE3882548B7E471A'
		};

		return isMobile() ? websiteKeys.mobile : websiteKeys.desktop;
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

		if (!getContext().opts.pageFairDetection) {
			log('PageFair disabled', 'debug', logGroup);
			return null;
		}

		log(['PageFair detection, adBlock detected:', adblockDetected], 'debug', logGroup);

		setRuntimeParams(adblockDetected);
		dispatchDetectionEvent(eventName);
	}

	function initDetection() {
		window.bm_website_code = getWebsiteCode();
		window.pf_notify = detector;

		var node = doc.getElementsByTagName('script')[0];
		scriptLoader.loadAsync(getContext().opts.pageFairDetectionUrl, node);
	}

	return {
		initDetection: initDetection
	};
});
