/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.gptHelper', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.provider.gptAdElement',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.wikiaGptAdDetect',
	require.optional('ext.wikia.adEngine.gptSraHelper')
], function (log, window, document, AdElement, slotTweaker, gptAdDetect, sraHelper) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wikiaGptHelper',
		gptLoaded = false,
		slotQueue = [],
		gptSlots = {},
		gptCallbacks = {},
		googletag,
		pubads;

	function registerGptCallback(adElementId, gptCallback) {
		log(['registerGptCallback', adElementId], 'info', logGroup);
		gptCallbacks[adElementId] = gptCallback;
	}

	function dispatchGptEvent(event) {
		var adElementId;

		log(['dispatchGptEvent', event], 'info', logGroup);

		for (adElementId in gptCallbacks) {
			if (gptCallbacks.hasOwnProperty(adElementId)) {
				if (gptCallbacks[adElementId] && event.slot && event.slot === gptSlots[adElementId]) {
					log(['dispatchGptEvent', event, 'Launching registered callback'], 'debug', logGroup);
					gptCallbacks[adElementId](event);
					return;
				}
			}
		}

		log(['dispatchGptEvent', event, 'No callback registered for this slot render ended event'], 'error', logGroup);
	}

	function loadGptOnce() {
		if (!gptLoaded) {
			log('loadGpt', 'debug', logGroup);

			var gads = document.createElement('script'),
				node = document.getElementsByTagName('script')[0];

			gptLoaded = true;

			window.googletag = window.googletag || {};
			window.googletag.cmd = window.googletag.cmd || [];

			gads.async = true;
			gads.type = 'text/javascript';
			gads.src = '//www.googletagservices.com/tag/js/gpt.js';

			log('Appending GPT script to head', 'debug', logGroup);

			node.parentNode.insertBefore(gads, node);
			googletag = window.googletag;

			// Enable services
			log(['loadGpt', 'googletag.cmd.push'], 'info', logGroup);
			googletag.cmd.push(function () {
				pubads = googletag.pubads();

				pubads.collapseEmptyDivs();
				pubads.enableSingleRequest();
				pubads.disableInitialLoad(); // manually request ads using refresh
				pubads.addEventListener('slotRenderEnded', dispatchGptEvent);

				googletag.enableServices();

				log(['loadGpt', 'googletag.cmd.push', 'done'], 'debug', logGroup);
			});
		}
	}

	/**
	 * Push ad to queue and flush if it should be
	 *
	 * @param {string}   slotName           - slot name
	 * @param {Object}   slotElement        - slot div container
	 * @param {string}   slotPath           - slot path
	 * @param {Object}   slotTargeting      - slot targeting details
	 * @param {Object}   extra              - optional parameters
	 * @param {function} extra.success      - on success callback
	 * @param {function} extra.error        - on error callback
	 * @param {boolean}  extra.sraEnabled   - whether to use Single Request Architecture
	 * @param {string}   extra.forcedAdType - ad type for callbacks info
	 */
	function pushAd(slotName, slotElement, slotPath, slotTargeting, extra) {
		var element = new AdElement('wikia_gpt_helper' + slotPath);

		extra = extra || {};
		slotTargeting = JSON.parse(JSON.stringify(slotTargeting)); // copy value

		function callSuccess(adInfo) {
			if (typeof extra.success === 'function') {
				extra.success(adInfo);
			}
		}

		function callError(adInfo) {
			slotTweaker.hide(element.getId());
			if (typeof extra.error === 'function') {
				adInfo = adInfo || {};
				adInfo.method = 'hop';
				extra.error(adInfo);
			}
		}

		function queueAd() {
			var slot;

			element.setPageLevelParams(pubads);

			log(['queueAd', slotName, slotDiv, element], 'debug', logGroup);
			slotElement.appendChild(element.getNode());

			if (!gptSlots[element.getId()]) {
				element.setSizes(slotName, slotTargeting.size);

				log(['defineSlot', 'googletag.defineSlot', slotPath, element], 'debug', logGroup);
				slot = googletag.defineSlot(slotPath, element.getSizes(), element.getId());
				slot.addService(pubads);

				// Display div through GPT
				log(['googletag.display', element.getId()], 'debug', logGroup);
				googletag.display(element.getId());

				gptSlots[element.getId()] = slot;
			}

			// Some broken ads never fire "success" event, so we show the div now (and maybe hide later)
			slotTweaker.show(element.getId());
			log(['adding slot to the queue', element.getId()], 'debug', logGroup);
			slotQueue.push(gptSlots[element.getId()]);
		}

		function gptCallback(event) {
			log(['gptCallback', element.getId(), event], 'info', logGroup);
			element.setResponseLevelParams(event);

			var iframe = element.getNode().querySelector('div[id*="_container_"] iframe');

			// IE doesn't allow us to inspect GPT iframe at this point.
			// Let's launch our callback in a setTimeout instead.
			setTimeout(function () {
				gptAdDetect.onAdLoad(element.getId(), event, iframe, callSuccess, callError, extra.forcedAdType);
			}, 0);
		}

		log(['pushAd', slotName], 'info', logGroup);
		if (!slotTargeting.flushOnly) {
			loadGptOnce();
			registerGptCallback(element.getId(), gptCallback);
			googletag.cmd.push(queueAd);
		}

		if (!extra.sraEnabled || sraHelper.shouldFlush(slotName)) {
			flushAds();
		}
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
		pushAd: pushAd
	};

});
