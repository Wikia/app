/*global define, setTimeout, clearTimeout*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.wikiaGptAdDetect', [
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.messageListener'
], function (log, window, messageListener) {
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

		log(['findAdInIframe', iframe.name, 'height (iframe content)', iframeContentHeight], 'info', logGroup);

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

		if (window.skin !== 'wikiamobile') {
			return 'always_success';
		}

		try {
			iframeOk = !!iframe.contentWindow.document.querySelector;
		} catch (e) {}

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

		var adType = getAdType(slotname, gptEvent, iframe);

		function callAdCallback() {
			adCallback({adType: adType});
		}

		function callNoAdCallback() {
			noAdCallback({adType: adType});
		}

		log(['onAdLoad', slotname, 'adType' , adType], 'info', logGroup);

		if (adType === 'forced_success' || adType === 'always_success') {
			return callAdCallback();
		}

		if (adType === 'empty') {
			return callNoAdCallback();
		}

		if (adType === 'async') {
			return messageListener.register({source: iframe.contentWindow, dataKey: 'status'}, function (data) {

				log(['onAdLoad', slotname, 'caught message' , data.status], 'info', logGroup);

				if (data.status === 'success') {
					return callAdCallback();
				}

				return callNoAdCallback();
			});
		}

		if (adType === 'openx') {

			var openxSuccess, successTrigger, waitForSuccess = function () {

				if (openxSuccess) {
					return;
				}
				successTrigger = setTimeout(function () {
					log(['onAdLoad', slotname, 'verify openX ad' ], 'info', logGroup);

					if (openxSuccess) {
						return;
					}
					inspectIframe(slotname, iframe, function () {
						openxSuccess = true;
						callAdCallback();
					}, waitForSuccess);
				}, 500);
			};

			waitForSuccess();

			return messageListener.register({source: iframe.contentWindow, dataKey: 'status'}, function (data) {

				log(['onAdLoad', slotname, 'caught message' , data.status], 'info', logGroup);

				openxSuccess = true;
				clearTimeout(successTrigger);

				return callNoAdCallback();
			});
		}

		// On mobile skin we investigate the iframe contents
		if (adType === 'inspect_iframe') {
			return inspectIframe(slotname, iframe, callAdCallback, callNoAdCallback);
		}

		throw 'Incorrect ad type. Cannot detect ad state.';
	}

	return {
		onAdLoad: onAdLoad
	};
});
