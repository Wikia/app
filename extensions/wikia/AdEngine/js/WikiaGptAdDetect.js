/*global define, setTimeout*/
define('ext.wikia.adEngine.wikiaGptAdDetect', [
	'wikia.log',
	'wikia.window'
], function (log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wikiaGptAdDetect',
		specialAdSelector = [
			'script[src*="/ads.saymedia.com/"]',
			'script[src*="/native.sharethrough.com/"]',
			'.celtra-ad-v3, script[src$="/mmadlib.js"]'
		].join(',');

	function isImagePresent(document) {
		var imgs, i, len, w, h;
		imgs = document.querySelectorAll('img[width][height]');

		for (i = 0, len = imgs.length; i < len; i += 1) {
			w = imgs[i].getAttribute('width');
			h = imgs[i].getAttribute('height');
			if (w > 1 && h > 1) {
				log(['findAdImage', 'found non-1x1 img'], 'info', logGroup);
				return true;
			}
		}

		return false;
	}

	function findAdInIframe(iframe, adCallback, noAdCallback) {
		var iframeHeight, iframeContentHeight, iframeId, iframeDoc;

		iframeId = iframe.id;
		iframeDoc = iframe.contentWindow.document;

		// Because Chrome reports document.body.offsetHeight as the outer
		// iframe height, we're setting the outer height to 0, so the innerHeight
		// reports real height of the content. Then we reset the height back
		iframeHeight = iframe.height;
		iframe.height = 0;
		iframeContentHeight = iframeDoc.body.offsetHeight;
		iframe.height = iframeHeight;

		log(['findAdInIframe', 'height (iframe content)', iframeContentHeight], 'info', logGroup);

		if (iframeContentHeight > 1) {
			log(['findAdInIframe', iframeId, 'height > 1, launching adCallback'], 'info', logGroup);
			return adCallback();
		}

		// Check for > 1x1 images
		// This is needed because DART returns a position:absolute div for very simple ads
		// and thus the body's offsetHeight is 0 :-(
		if (isImagePresent(iframeDoc)) {
			log(['findAdInIframe', iframeId, 'image, launching adCallback'], 'info', logGroup);
			return adCallback();
		}

		// No ad found
		log(['findAdInIframe', iframeId, 'launching noAdCallback'], 'info', logGroup);
		noAdCallback();
	}

	function inspectIframe(slotname, iframe, adCallback, noAdCallback) {
		if (iframe.contentWindow.document.readyState === 'complete') {
			log(['onAdLoad', slotname, 'iframe state complete'], 'info', logGroup);
			setTimeout(function () {
				findAdInIframe(iframe, adCallback, noAdCallback);
			}, 0);
		} else {
			log(['onAdLoad', slotname, 'binding to iframe onload'], 'info', logGroup);
			iframe.contentWindow.addEventListener('load', function () {
				findAdInIframe(iframe, adCallback, noAdCallback);
			});
		}
	}

	function getAdDetectMethod(slotname, gptEvent, iframe) {
		var status, height, gptEmpty, iframeOk = false;

		log(['getAdDetectMethod', slotname], 'info', logGroup);

		status = window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotname];

		if (status === 'success') {
			return 'forced_success';
		}

		height = gptEvent.size && gptEvent.size[1];
		gptEmpty = gptEvent.isEmpty;

		if (gptEmpty || height <= 1) {
			return 'empty';
		}

		if (window.skin !== 'wikiamobile') {
			return 'always_success';
		}

		try {
			iframeOk = !!iframe.contentWindow.document.querySelector;
		} catch (e) {}

		if (!iframeOk) {
			log(
				['getAdDetectMethod', slotname, 'running ad callback (no ad iframe found)'],
				'error',
				logGroup
			);
			return 'always_success';
		}

		// Check specifically for some ads
		if (iframe.contentWindow.document.querySelector(specialAdSelector)) {
			log(['getAdDetectMethod', slotname, 'special ad'], 'info', logGroup);
			return 'always_success';
		}

		return 'inspect_iframe';
	}

	function onAdLoad(slotname, gptEvent, iframe, adCallback, noAdCallback) {

		var hopMethod = getAdDetectMethod(slotname, gptEvent, iframe);

		log(['onAdLoad', slotname, 'hopStrategy' , hopMethod], 'info', logGroup);

		if (hopMethod === 'forced_success' || hopMethod === 'always_success') {
			return adCallback();
		}

		if (hopMethod === 'empty') {
			return noAdCallback();
		}

		// On mobile skin we investigate the iframe contents
		if (hopMethod === 'inspect_iframe') {
			return inspectIframe(slotname, iframe, adCallback, noAdCallback);
		}

		throw 'Incorrect hop method. Cannot detect ad state.';
	}

	return {
		onAdLoad: onAdLoad
	};
});
