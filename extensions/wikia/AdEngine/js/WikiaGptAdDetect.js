/*global define, setTimeout, clearTimeout*/
/*jshint camelcase:false*/
/*jshint maxlen:127*/
define('ext.wikia.adEngine.wikiaGptAdDetect', [
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.messageListener'
], function (log, window, adContext, messageListener) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wikiaGptAdDetect',
		specialAdSelector = [
			'script[src*="/ads.saymedia.com/"]',
			'script[src*="/native.sharethrough.com/"]',
			'.celtra-ad-v3, script[src$="/mmadlib.js"]'
		].join(','),
		isMobile = adContext.getContext().targeting.skin === 'wikiamobile';

	function isImagePresent(document) {
		var imgs, i, len, w, h;
		imgs = document.querySelectorAll('img[width], img[height]');

		for (i = 0, len = imgs.length; i < len; i += 1) {
			w = imgs[i].getAttribute('width');
			h = imgs[i].getAttribute('height');
			if (w > 1 || h > 1) {
				log(['findAdImage', 'found non-1x1 img'], 'info', logGroup);
				return true;
			}
		}

		return false;
	}

	function findAdInIframe(slotname, iframe, adCallback, noAdCallback) {
		var iframeHeight, iframeContentHeight, iframeDoc;

		iframeDoc = iframe.contentWindow.document;

		// Because Chrome reports document.body.offsetHeight as the outer
		// iframe height, we're setting the outer height to 0, so the innerHeight
		// reports real height of the content. Then we reset the height back
		iframeHeight = iframe.height;
		iframe.height = 0;
		iframeContentHeight = iframeDoc.body.offsetHeight;
		iframe.height = iframeHeight;

		log(['findAdInIframe', slotname, 'height (iframe content)', iframeContentHeight], 'info', logGroup);

		if (iframeContentHeight > 1) {
			log(['findAdInIframe', slotname, 'height > 1, launching adCallback'], 'info', logGroup);
			return adCallback();
		}

		// Check for > 1x1 images
		// This is needed because DART returns a position:absolute div for very simple ads
		// and thus the body's offsetHeight is 0 :-(
		if (isImagePresent(iframeDoc)) {
			log(['findAdInIframe', slotname, 'image, launching adCallback'], 'info', logGroup);
			return adCallback();
		}

		// No ad found
		log(['findAdInIframe', slotname, 'launching noAdCallback'], 'info', logGroup);
		noAdCallback();
	}

	function inspectIframe(slotname, iframe, adCallback, noAdCallback) {
		if (iframe.contentWindow.document.readyState === 'complete') {
			log(['onAdLoad', slotname, 'iframe state complete'], 'info', logGroup);
			setTimeout(function () {
				findAdInIframe(slotname, iframe, adCallback, noAdCallback);
			}, 0);
		} else {
			log(['onAdLoad', slotname, 'binding to iframe onload'], 'info', logGroup);
			iframe.contentWindow.addEventListener('load', function () {
				findAdInIframe(slotname, iframe, adCallback, noAdCallback);
			});
		}
	}

	function getAdType(slotname, gptEvent, iframe) {
		var status, height, gptEmpty, iframeOk = false;

		log(['getAdType', slotname], 'info', logGroup);

		if (iframe && iframe.contentWindow && iframe.contentWindow.AdEngine_adType) {
			log(['getAdType', slotname, 'iframe AdEngine_adType = ', iframe.contentWindow.AdEngine_adType], 'info', logGroup);

			return iframe.contentWindow.AdEngine_adType;
		}

		status = window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotname];

		if (status === 'success') {
			return 'forced_success';
		}

		height = gptEvent.size && gptEvent.size[1];
		gptEmpty = gptEvent.isEmpty;

		if (gptEmpty || height <= 1) {
			return 'empty';
		}

		if (!isMobile) {
			return 'always_success';
		}

		try {
			iframeOk = !!iframe.contentWindow.document.querySelector;
		} catch (ignore) {}

		if (!iframeOk) {
			log(
				['getAdType', slotname, 'running ad callback (no ad iframe found)'],
				'error',
				logGroup
			);
			return 'always_success';
		}

		// Check specifically for some ads
		if (iframe.contentWindow.document.querySelector(specialAdSelector)) {
			log(['getAdType', slotname, 'special ad'], 'info', logGroup);
			return 'always_success';
		}

		return 'inspect_iframe';
	}

	function onAdLoad(slotname, gptEvent, iframe, adCallback, noAdCallback) {

		var adType = getAdType(slotname, gptEvent, iframe),
			shouldPollForSuccess = false,
			expectAsyncHop = false,
			expectAsyncHopWithSlotName = false,
			expectAsyncSuccess = false,
			successTimer;

		function noop() { return; }

		function callAdCallback() {
			clearTimeout(successTimer);
			adCallback({adType: adType});
		}

		function callNoAdCallback() {
			clearTimeout(successTimer);
			noAdCallback({adType: adType});
		}

		function pollForSuccess() {
			successTimer = setTimeout(function () {
				log(['pollForSuccess', slotname], 'info', logGroup);
				pollForSuccess();
				findAdInIframe(slotname + ' (poll)', iframe, callAdCallback, noop);
			}, 500);
		}

		function msgCallback(data) {
			log(['msgCallback', slotname, 'caught message', data], 'info', logGroup);

			if (data.status === 'success') {
				if (expectAsyncSuccess) {
					callAdCallback();
				} else {
					log(
						['msgCallback', slotname, 'Got asynchronous success message, while not expecting it'],
						'error',
						logGroup
					);
				}
			}

			if (data.status === 'hop') {
				if (expectAsyncHop || expectAsyncHopWithSlotName) {
					callNoAdCallback();
				} else {
					log(
						['msgCallback', slotname, 'Got asynchronous hop message, while not expecting it'],
						'error',
						logGroup
					);
				}
			}
		}

		if (adType === 'openx' || adType === 'rubicon' || adType === 'saymedia') {
			shouldPollForSuccess = true;
			expectAsyncHop = true;
		}

		if (adType === 'async') {
			expectAsyncHop = true;
			expectAsyncSuccess = true;
		}

		if (adType === 'gumgum') {
			expectAsyncHopWithSlotName = true;
			shouldPollForSuccess = true; // TODO: there's no way to detect the GumGum success :-(
		}

		log(['onAdLoad', slotname, 'adType', adType], 'info', logGroup);

		if (adType === 'forced_success' || adType === 'always_success') {
			return callAdCallback();
		}

		if (adType === 'empty') {
			return callNoAdCallback();
		}

		if (adType === 'inspect_iframe') {
			return inspectIframe(slotname, iframe, callAdCallback, callNoAdCallback);
		}

		if (shouldPollForSuccess) {
			pollForSuccess();
		}

		if (expectAsyncHop || expectAsyncSuccess) {
			messageListener.register({source: iframe.contentWindow, dataKey: 'status'}, msgCallback);
		}

		if (expectAsyncHopWithSlotName) {
			messageListener.register({dataKey: 'slot_' + slotname}, msgCallback);
		}

		if (expectAsyncHop && (shouldPollForSuccess || expectAsyncSuccess)) {
			// Hops and successes handled. We can safely return now
			return;
		}

		log(['onAdLoad', 'Unknown ad type (launching starting ad callback)', adType], 'error', logGroup);
		adType = 'unknown';
		return callAdCallback();
	}

	return {
		onAdLoad: onAdLoad
	};
});
