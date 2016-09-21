/*global define, setTimeout, clearTimeout*/
/*jshint camelcase:false, maxlen:127*/
/*jslint regexp:true*/
define('ext.wikia.adEngine.provider.gpt.adDetect', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.log',
	'wikia.window'
], function (adContext, messageListener, slotTweaker, log, win) {
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

		status = win.adDriver2ForcedStatus && win.adDriver2ForcedStatus[slotName];

		if (status === 'success') {
			return 'forced_success';
		}

		height = gptEvent.size && gptEvent.size[1];
		gptEmpty = gptEvent.isEmpty;

		if (gptEvent.slot && gptEvent.slot.getOutOfPage && gptEvent.slot.getOutOfPage()) {
			log(['getAdType', slotName, 'out of page ad', 'always_success'], 'info', logGroup);
			return 'always_success';
		}

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

	function isPartnerAdType(adType) {
		return (/^partner\/[a-zA-Z0-9]{1,30}$/).test(adType);
	}

	function onAdLoad(slot, gptEvent, iframe, forcedAdType) {

		var adType = forcedAdType || getAdType(slot.name, gptEvent, iframe),
			isCollapsed = false,
			shouldPollForSuccess = false,
			expectAsyncCollapse = false,
			expectAsyncHop = false,
			expectAsyncHopWithSlotName = false,
			expectAsyncSuccessWithSlotName = false,
			expectAsyncSuccess = false,
			successTimer;

		function noop() { return; }

		function callAdCallback(adInfo) {
			adInfo = adInfo || {};
			adInfo.adType = adType;

			clearTimeout(successTimer);
			slot.success(adInfo);
		}

		function callCollapseAdCallback(adInfo) {
			adInfo = adInfo || {};
			adInfo.adType = adType;

			isCollapsed = true;
			clearTimeout(successTimer);
			slot.collapse(adInfo);
		}

		function callNoAdCallback(adInfo) {
			adInfo = adInfo || {};
			adInfo.adType = adType;

			clearTimeout(successTimer);
			slot.hop(adInfo);
		}

		function pollForSuccess() {
			if (isCollapsed) {
				return;
			}

			successTimer = setTimeout(function () {
				log(['pollForSuccess', slot.name], 'info', logGroup);
				pollForSuccess();
				findAdInIframe(slot.name + ' (poll)', iframe, callAdCallback, noop);
			}, 500);
		}

		function handleAsyncMessage(status, isExpected, callback) {
			if (isExpected) {
				callback();
			} else {
				log(
					['msgCallback', slot.name, status, 'Got asynchronous message, while not expecting it'],
					'error',
					logGroup
				);
			}
		}

		function msgCallback(data) {
			log(['msgCallback', slot.name, 'caught message', data], 'info', logGroup);

			switch (data.status) {
				case 'success':
					handleAsyncMessage('success', expectAsyncSuccess || expectAsyncSuccessWithSlotName, function () {
						callAdCallback(data.extra);
					});
					break;
				case 'collapse':
					handleAsyncMessage('collapse', expectAsyncCollapse, function () {
						callCollapseAdCallback(data.extra);
					});
					break;
				case 'hop':
					handleAsyncMessage('hop', expectAsyncHop || expectAsyncHopWithSlotName, function () {
						callNoAdCallback(data.extra);
					});
					break;
			}
		}

		if (['openx', 'rubicon', 'saymedia', 'turtle', 'evolve2'].indexOf(adType) !== -1 || isPartnerAdType(adType)) {
			shouldPollForSuccess = true;
			expectAsyncCollapse = true;
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

		if (adType === 'highimpact') {
			expectAsyncHopWithSlotName = true;
			expectAsyncSuccessWithSlotName = true;
		}

		log(['onAdLoad', slot.name, 'adType', adType], 'info', logGroup);

		if (adType === 'forced_success' || adType === 'always_success') {
			return callAdCallback();
		}

		if (adType === 'collapse') {
			return callCollapseAdCallback();
		}

		if (adType === 'empty') {
			return callNoAdCallback();
		}

		if (adType === 'inspect_iframe') {
			return inspectIframe(slot.name, iframe, callAdCallback, callNoAdCallback);
		}

		if (shouldPollForSuccess) {
			slotTweaker.onReady(slot.name, pollForSuccess);
		}

		if (expectAsyncHop || expectAsyncSuccess || expectAsyncCollapse) {
			messageListener.register({source: iframe.contentWindow, dataKey: 'status'}, msgCallback);
		}

		if (expectAsyncHopWithSlotName || expectAsyncSuccessWithSlotName) {
			messageListener.register({dataKey: 'slot_' + slot.name}, msgCallback);
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
		onAdLoad: onAdLoad
	};
});
