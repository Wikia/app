/*global define, setTimeout, clearTimeout*/
/*jshint camelcase:false, maxlen:127*/
/*jslint regexp:true*/
define('ext.wikia.adEngine.provider.gpt.adDetect', [
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.messageListener'
], function (log, window, adContext, messageListener) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adDetect',
		specialAdSelector = [
			'script[src*="/ads.saymedia.com/"]',
			'script[src*="/native.sharethrough.com/"]',
			'.celtra-ad-v3, script[src$="/mmadlib.js"]'
		].join(',');

	function isMobile() {
		var skin = adContext.getContext().targeting.skin;
		return (skin === 'wikiamobile' || skin === 'mercury');
	}

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

	function findAdInIframe(slotName, iframe, adCallback, noAdCallback) {
		var iframeHeight, iframeContentHeight, iframeDoc;

		try {
			iframeDoc = iframe.contentWindow.document;
		} catch (e) {
			// Frame with origin "http://tpc.googlesyndication.com" is used for SafeFrame ads
			log(['findAdInIframe', slotName, 'ad iframe not accessible (or not found): assuming success'], 'error', logGroup);
			return adCallback();
		}

		// Because Chrome reports document.body.offsetHeight as the outer
		// iframe height, we're setting the outer height to 0, so the innerHeight
		// reports real height of the content. Then we reset the height back
		iframeHeight = iframe.height;
		iframe.height = 0;
		iframeContentHeight = iframeDoc.body.offsetHeight;
		iframe.height = iframeHeight;

		log(['findAdInIframe', slotName, 'height (iframe content)', iframeContentHeight], 'info', logGroup);

		if (iframeContentHeight > 1) {
			log(['findAdInIframe', slotName, 'height > 1, launching adCallback'], 'info', logGroup);
			return adCallback();
		}

		// Check for > 1x1 images
		// This is needed because DART returns a position:absolute div for very simple ads
		// and thus the body's offsetHeight is 0 :-(
		if (isImagePresent(iframeDoc)) {
			log(['findAdInIframe', slotName, 'image, launching adCallback'], 'info', logGroup);
			return adCallback();
		}

		// No ad found
		log(['findAdInIframe', slotName, 'launching noAdCallback'], 'info', logGroup);
		noAdCallback();
	}

	function inspectIframe(slotName, iframe, adCallback, noAdCallback) {
		if (iframe.contentWindow.document.readyState === 'complete') {
			log(['onAdLoad', slotName, 'iframe state complete'], 'info', logGroup);
			setTimeout(function () {
				findAdInIframe(slotName, iframe, adCallback, noAdCallback);
			}, 0);
		} else {
			log(['onAdLoad', slotName, 'binding to iframe onload'], 'info', logGroup);
			iframe.contentWindow.addEventListener('load', function () {
				findAdInIframe(slotName, iframe, adCallback, noAdCallback);
			});
		}
	}

	function getAdType(slotName, gptEvent, iframe) {
		var status, height, gptEmpty, iframeOk = false;

		log(['getAdType', slotName], 'info', logGroup);

		try {
			iframeOk = !!iframe.contentWindow.document.querySelector;
		} catch (e) {
			// Frame with origin "http://tpc.googlesyndication.com" is used for SafeFrame ads
			log(['getAdType', slotName, 'ad iframe not accessible (or not found)'], 'error', logGroup);
		}

		if (iframeOk && iframe.contentWindow.AdEngine_adType) {
			log(['getAdType', slotName, 'iframe AdEngine_adType = ', iframe.contentWindow.AdEngine_adType], 'info', logGroup);

			return iframe.contentWindow.AdEngine_adType;
		}

		status = window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotName];

		if (status === 'success') {
			return 'forced_success';
		}

		height = gptEvent.size && gptEvent.size[1];
		gptEmpty = gptEvent.isEmpty;

		if (gptEmpty || height <= 1) {
			log(['getAdType', slotName, 'ad is empty (GPT event)', 'empty'], 'info', logGroup);
			return 'empty';
		}

		if (!isMobile()) {
			log(['getAdType', slotName, 'not mobile', 'always_success'], 'info', logGroup);
			return 'always_success';
		}

		if (!iframeOk) {
			log(['getAdType', slotName, 'running ad callback (!iframeOk)', 'always_success'], 'info', logGroup);
			return 'always_success';
		}

		// A special case for AdSense/AdX. They serve with creative and line item ids null
		// Most of the time their iframes are inspectable, but when inspecting the inner height is 0
		if (gptEvent.creativeId === null && gptEvent.lineItemId === null) {
			log(['getAdType', slotName, 'creativeId and lineItemId are null', 'always_success'], 'error', logGroup);
			return 'always_success';
		}

		// Check specifically for some ads
		if (iframe.contentWindow.document.querySelector(specialAdSelector)) {
			log(['getAdType', slotName, 'special ad'], 'info', logGroup);
			return 'always_success';
		}

		log(['getAdType', slotName, 'inspect_iframe'], 'info', logGroup);
		return 'inspect_iframe';
	}

	function getShortSlotName(slotName) {
		return slotName.replace(/^.*\/([^\/]*)$/, '$1');
	}

	function onAdLoad(slotName, gptEvent, iframe, adCallback, noAdCallback, forcedAdType) {

		var adType = forcedAdType || getAdType(slotName, gptEvent, iframe),
			shouldPollForSuccess = false,
			expectAsyncHop = false,
			expectAsyncHopWithSlotName = false,
			expectAsyncSuccessWithSlotName = false,
			expectAsyncSuccess = false,
			successTimer,
			shortSlotName = getShortSlotName(slotName);

		function noop() { return; }

		function callAdCallback(extra) {
			extra = extra || {};
			extra.adType = adType;

			clearTimeout(successTimer);
			adCallback(extra);
		}

		function callNoAdCallback(extra) {
			extra = extra || {};
			extra.adType = adType;

			clearTimeout(successTimer);
			noAdCallback(extra);
		}

		function pollForSuccess() {
			successTimer = setTimeout(function () {
				log(['pollForSuccess', slotName], 'info', logGroup);
				pollForSuccess();
				findAdInIframe(slotName + ' (poll)', iframe, callAdCallback, noop);
			}, 500);
		}

		function msgCallback(data) {
			log(['msgCallback', slotName, 'caught message', data], 'info', logGroup);

			if (data.status === 'success') {
				if (expectAsyncSuccess || expectAsyncSuccessWithSlotName) {
					callAdCallback(data.extra);
				} else {
					log(
						['msgCallback', slotName, 'Got asynchronous success message, while not expecting it'],
						'error',
						logGroup
					);
				}
			}

			if (data.status === 'hop') {
				if (expectAsyncHop || expectAsyncHopWithSlotName) {
					callNoAdCallback(data.extra);
				} else {
					log(
						['msgCallback', slotName, 'Got asynchronous hop message, while not expecting it'],
						'error',
						logGroup
					);
				}
			}
		}

		if (adType === 'openx' || adType === 'rubicon' || adType === 'saymedia' || adType === 'turtle') {
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

		if (adType === 'floor') {
			expectAsyncHopWithSlotName = true;
			expectAsyncSuccessWithSlotName = true;
		}

		log(['onAdLoad', slotName, 'adType', adType], 'info', logGroup);

		if (adType === 'forced_success' || adType === 'always_success' || adType === 'collapse') {
			return callAdCallback();
		}

		if (adType === 'empty') {
			return callNoAdCallback();
		}

		if (adType === 'inspect_iframe') {
			return inspectIframe(slotName, iframe, callAdCallback, callNoAdCallback);
		}

		if (shouldPollForSuccess) {
			pollForSuccess();
		}

		if (expectAsyncHop || expectAsyncSuccess) {
			messageListener.register({source: iframe.contentWindow, dataKey: 'status'}, msgCallback);
		}

		if (expectAsyncHopWithSlotName || expectAsyncSuccessWithSlotName) {
			messageListener.register({dataKey: 'slot_' + shortSlotName}, msgCallback);
		}

		if (expectAsyncHop || expectAsyncHopWithSlotName) {
			if (shouldPollForSuccess || expectAsyncSuccess || expectAsyncSuccessWithSlotName) {
				// Hops and successes handled. We can safely return now
				return;
			}
		}

		log(['onAdLoad', 'Unknown ad type (launching starting ad callback)', adType], 'error', logGroup);
		adType = 'unknown';
		return callAdCallback();
	}

	return {
		onAdLoad: onAdLoad,
		//For tests purpose, if you want to use it, consider creating new class (AdSlot?)
		getShortSlotName: getShortSlotName
	};
});
