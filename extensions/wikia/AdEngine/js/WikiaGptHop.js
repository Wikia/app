/*global define, setTimeout*/
define('ext.wikia.adEngine.wikiaGptHop', [
	'wikia.log',
	'wikia.window'
], function (log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wikiaGptHop',
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

		// Check specifically for ads which can appear empty, even when successful
		if (iframeDoc.querySelector(specialAdSelector)) {
			log(['findAdInIframe', iframeId, 'special ad, launching adCallback'], 'info', logGroup);
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

	function onAdLoad(slotname, gptEvent, iframe, adCallback, noAdCallback) {
		var status, height, gptEmpty, empty;

		// Check the explicit status
		status = window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotname];

		if (status === 'success') {
			log(['onAdLoad', slotname, 'running ad callback (forced status)'], 'info', logGroup);
			return adCallback();
		}

		// Now, let's base our decision on slot height (1x1 means hop)
		height = gptEvent.size && gptEvent.size[1];
		gptEmpty = gptEvent.isEmpty;
		log(['onAdLoad', slotname, 'height', height, 'gptEmpty', gptEmpty], 'info', logGroup);

		empty = gptEmpty || height <= 1;

		if (empty) {
			log(['onAdLoad', slotname, 'running noAd callback (hop)'], 'info', logGroup);
			return noAdCallback();
		}

		// On non-mobile skin that's it, success!
		if (window.skin !== 'wikiamobile') {
			log(['onAdLoad', slotname, 'running ad callback'], 'info', logGroup);
			return adCallback();
		}

		// On mobile skin we investigate the iframe contents

		// No iframe, this is weird, but we assume this means an ad, no hopping!
		if (!iframe) {
			log(
				['onAdLoad', slotname, 'running ad callback (no ad iframe found)'],
				'error',
				logGroup
			);
			adCallback();
		}

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

	return {
		onAdLoad: onAdLoad
	};
});
