/*global define, setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.wikiaGptHelper', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.gptSlotConfig'
], function (log, window, document, adLogicPageParams, gptSlotConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wikiaGptHelper',
		gptLoaded = false,
		pageLevelParams = adLogicPageParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '//' + pageLevelParams.s2,
		specialAdSelector = 'script[src*="/ads.saymedia.com/"], script[src*="/native.sharethrough.com/"], .celtra-ad-v3, script[src$="/mmadlib.js"]',
		slotQueue = [],
		providerSlotMap = gptSlotConfig.getConfig(),
		gptSlots = {},
		dataAttribs = {},
		googletag;

	function convertSizesToGpt(slotsize) {
		log(['convertSizeToGpt', slotsize], 'debug', logGroup);
		var tmp1 = slotsize.split(','),
			sizes = [],
			tmp2,
			i;

		for (i = 0; i < tmp1.length; i += 1) {
			tmp2 = tmp1[i].split('x');
			sizes.push([parseInt(tmp2[0], 10), parseInt(tmp2[1], 10)]);
		}

		return sizes;
	}

	function loadGpt() {
		if (!gptLoaded) {
			log('loadGpt', 7, logGroup);

			var gads = document.createElement('script'),
				node = document.getElementsByTagName('script')[0];

			gptLoaded = true;

			window.googletag = window.googletag || {};
			window.googletag.cmd = window.googletag.cmd || [];

			gads.async = true;
			gads.type = 'text/javascript';
			gads.src = '//www.googletagservices.com/tag/js/gpt.js';

			log('Appending GPT script to head', 7, logGroup);

			node.parentNode.insertBefore(gads, node);
			googletag = window.googletag;

			// Set page level params
			log(['loadGpt', 'googletag.cmd.push', 'page level targeting'], 'info', logGroup);
			googletag.cmd.push(function () {
				var name,
					value,
					pubads = googletag.pubads(),
					slotname,
					slotnameGpt,
					sizes,
					slot,
					slotMap,
					slotMapSrc,
					slotItem,
					slotPath,
					slotParams;

				pubads.collapseEmptyDivs();

				log(['loadGpt', 'pageLevelParams', pageLevelParams], 'debug', logGroup);

				for (name in pageLevelParams) {
					if (pageLevelParams.hasOwnProperty(name)) {
						value = pageLevelParams[name];
						if (value) {
							log(['pubads.setTargeting', name, value], 'debug', logGroup);
							pubads.setTargeting(name, value);
						}
					}
				}

				for (slotMapSrc in providerSlotMap) {
					if (providerSlotMap.hasOwnProperty(slotMapSrc)) {

						slotMap = providerSlotMap[slotMapSrc];

						// Define all possible slots
						for (slotname in slotMap) {
							if (slotMap.hasOwnProperty(slotname) && slotMap[slotname].size) {
								log(['loadGpt', 'defining slot', slotname], 'debug', logGroup);

								slotnameGpt = slotname + '_' + slotMapSrc;
								slotItem = slotMap[slotname];
								sizes = convertSizesToGpt(slotItem.size);

								slotPath = path + '/' + slotname + '_' + slotMapSrc;

								log(['googletag.defineSlot', slotPath, sizes, slotnameGpt], 'debug', logGroup);
								slot = googletag.defineSlot(slotPath, sizes, slotnameGpt);
								slot.addService(googletag.pubads());

								// Per-slot targeting keys
								slotParams = {
									pos: slotname,
									loc: slotItem.loc,
									src: slotMapSrc
								};
								for (name in slotParams) {
									if (slotParams.hasOwnProperty(name)) {
										value = slotParams[name];
										if (value) {
											log(['slot.setTargeting', name, value], 'debug', logGroup);
											slot.setTargeting(name, value);
										}
									}
								}

								gptSlots[slotnameGpt] = slot;

								dataAttribs[slotnameGpt] = {
									'data-gpt-page-params': JSON.stringify(pageLevelParams),
									'data-gpt-slot-params': JSON.stringify(slotParams),
									'data-gpt-slot-sizes': JSON.stringify(sizes)
								};

								log(['loadGpt', 'defined slot', slotname, slot], 'debug', logGroup);

							}
						}
					}
				}

				log(['loadGpt', 'all slots defined'], 'debug', logGroup);

				// Enable services
				googletag.pubads().enableSingleRequest();
				googletag.pubads().disableInitialLoad(); // manually request ads
				googletag.enableServices();

				log(['loadGpt', 'services enabled'], 'debug', logGroup);
			});
		}
	}

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

	function pushAd(slotname, success, error, slotMapSrc) {
		var slotnameGpt = slotname + '_' + slotMapSrc,
			slotDiv = document.createElement('div');

		function callSuccess() {
			if (typeof success === 'function') {
				success();
			}
		}

		function callError() {
			slotDiv.className += ' hidden';
			if (typeof error === 'function') {
				error();
			}
		}

		loadGpt();

		// Create a div for the GPT ad
		slotDiv.id = slotnameGpt;

		document.getElementById(slotname).appendChild(slotDiv);

		log(['pushAd', slotname], 'debug', logGroup);
		googletag.cmd.push(function () {
			var attrName;

			log(['googletag.display', slotnameGpt], 'debug', logGroup);
			googletag.display(slotnameGpt);

			slotQueue.push(gptSlots[slotnameGpt]);

			googletag.pubads().addEventListener('slotRenderEnded', function (event) {
				var status, height, gptEmpty, empty, iframe;

				if (event.slot === gptSlots[slotnameGpt]) {
					log(['slotRenderEnded', slotname, event], 'info', logGroup);

					// Add debug info
					slotDiv.setAttribute('data-gpt-line-item-id', JSON.stringify(event.lineItemId));
					slotDiv.setAttribute('data-gpt-creative-id', JSON.stringify(event.creativeId));
					slotDiv.setAttribute('data-gpt-creative-size', JSON.stringify(event.size));

					// Check the explicit status
					status = window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotname];

					if (status === 'success') {
						log(['slotRenderEnded', slotname, 'running success callback (forced status)'], 'info', logGroup);
						return callSuccess();
					}

					// Now, let's base our decision on slot height (1x1 means hop)
					height = event.size && event.size[1];
					gptEmpty = event.isEmpty;
					log(['slotRenderEnded', slotname, 'height', height, 'gptEmpty', gptEmpty], 'info', logGroup);

					empty = gptEmpty || height <= 1;

					if (empty) {
						log(['slotRenderEnded', slotname, 'running error callback (hop)'], 'info', logGroup);
						return callError();
					}

					// On non-mobile skin that's it, success!
					if (window.skin !== 'wikiamobile') {
						log(['slotRenderEnded', slotname, 'running success callback'], 'info', logGroup);
						return callSuccess();
					}

					// On mobile skin we investigate the iframe contents
					iframe = slotDiv.querySelector('div[id*="_container_"] iframe');

					// No iframe, this is weird, but we assume this means an ad, no hopping!
					if (!iframe) {
						log(
							['slotRenderEnded', slotname, 'running success callback (no ad iframe found)'],
							'error',
							logGroup
						);
						callSuccess();
					}

					if (iframe.contentWindow.document.readyState === 'complete') {
						log(['slotRenderEnded', slotname, 'iframe state complete'], 'info', logGroup);
						setTimeout(function () {
							findAdInIframe(iframe, callSuccess, callError);
						}, 0);
					} else {
						log(['slotRenderEnded', slotname, 'binding to iframe onload'], 'info', logGroup);
						iframe.contentWindow.addEventListener('load', function () {
							findAdInIframe(iframe, callSuccess, callError);
						});
					}
				}
			});

			// Save page level and slot level params for easier ad delivery debugging
			for (attrName in dataAttribs[slotnameGpt]) {
				if (dataAttribs[slotnameGpt].hasOwnProperty(attrName)) {
					slotDiv.setAttribute(attrName, dataAttribs[slotnameGpt][attrName]);
				}
			}
		});
	}

	function flushAds() {
		if (!gptLoaded) {
			log(['flushAds', 'done', 'no slots to flush'], 'info', logGroup);
			return;
		}

		googletag.cmd.push(function () {
			log(['flushAds', 'start'], 'info', logGroup);

			log(['flushAds', 'refresh', slotQueue], 'debug', logGroup);

			if (slotQueue.length) {
				googletag.pubads().refresh(slotQueue);
				slotQueue = [];
			}

			log(['flushAds', 'done'], 'info', logGroup);
		});
	}

	return {
		pushAd: pushAd,
		flushAds: flushAds
	};

});
