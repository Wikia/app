/*global setTimeout */
var WikiaGptHelper = function (log, window, document, adLogicPageLevelParams) {
	'use strict';

	var logGroup = 'WikiaGptHelper',
		gptLoaded = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '/' + pageLevelParams.s2,
		slotsToDisplay = [],
		doneCallbacks = {},// key: slot name, value: callback
		googletag;

	function triggerDone(slotname) {
		var callback = doneCallbacks[slotname];

		log(['triggerDone', slotname], 3, logGroup);

		if (callback) {
			delete doneCallbacks[slotname];
			setTimeout(callback, 0); // escape from GPT's error-catching
		}
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

			log(['loadGpt', 'googletag.cmd.push', 'bind to GPT events'], 4, logGroup);
			googletag.cmd.push(function () {
				var debug_log = googletag.debug_log,
					oldLog = debug_log.log;

				// We're plugging into the log function in GPT so we get some insight of what
				// happens in GPT internals. We're looking for logging messages and comparing them
				// to the pattern that is the most interesting for us. We chose out of those 4
				// (listed here in the order of appearing for each slot GPT loads):
				//
				//  /^Fetching ad/i
				//  /^Receiving ad/i
				//  /^Rendering ad/i
				//  /^Completed rendering ad/i
				//
				// Inspiration: https://github.com/mcountis/dfp-events

				googletag.debug_log.log = function (level, message, service, slot) {
					var domId,
						donePattern = /^Rendering ad/i;

					// Play extra-safe with this
					try {
						domId = slot.getSlotId().getDomId();

						if (typeof message === 'string') {
							if (message.search(donePattern) === 0) {
								// If the message is what we look for, trigger the event
								triggerDone(domId);
							}
						}
					} catch (e) {
					}

					// Call the original function
					return oldLog.apply(debug_log, arguments);
				};
			});

			// Set page level params
			log(['loadGpt', 'googletag.cmd.push', 'page level targeting'], 4, logGroup);
			googletag.cmd.push(function () {
				var name, value, pubads = googletag.pubads();

				pubads.setTargeting('src', 'gpt');

				log(['loadGpt', 'pageLevelParams', pageLevelParams], 9, logGroup);

				for (name in pageLevelParams) {
					if (pageLevelParams.hasOwnProperty(name)) {
						value = pageLevelParams[name];
						if (value) {
							log(['pubads.setTargetingload', name, value], 9, logGroup);
							pubads.setTargeting(name, value);
						}
					}
				}
			});
		}
	}

	function convertSizesToGpt(slotsize) {
		log(['convertSizeToGpt', slotsize], 9, logGroup);
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

	function pushAd(slotParams, done) {
		var slotname = slotParams.slotname,
			sizes = convertSizesToGpt(slotParams.slotsize),
			params = {};

		loadGpt();

		params.pos = slotParams.slotname;
		params.positionfixed = slotParams.positionfixed;
		params.loc = slotParams.loc;
		params.dcopt = slotParams.dcopt;

		log(['googletag.cmd.push', path, sizes, slotname, params], 4, logGroup);

		googletag.cmd.push(function () {
			var slot = googletag.defineSlot(path, sizes, slotname),
				name,
				value;

			slot.addService(googletag.pubads());

			for (name in params) {
				if (params.hasOwnProperty(name)) {
					value = params[name];
					if (value) {
						slot.setTargeting(name, value);
					}
				}
			}

			slotsToDisplay.push(slotname);
			if (typeof done === 'function') {
				doneCallbacks[slotname] = done;
			}
		});
	}

	function flushAds() {
		log(['googletag.cmd.push', 'enableServices'], 4, logGroup);
		log(['googletag.cmd.push', 'display', slotsToDisplay], 4, logGroup);

		googletag.cmd.push(function () {
			var callback, slotname;

			log(['flushAds', 'start'], 4, logGroup);

			googletag.pubads().enableSingleRequest();
			googletag.enableServices();

			while (slotsToDisplay.length > 0) {
				slotname = slotsToDisplay.shift();

				log(['flushAds', 'display', slotname], 8, logGroup);

				googletag.display(slotname);
			}

			log(['flushAds', 'done'], 4, logGroup);
		});
	}

	return {
		pushAd: pushAd,
		flushAds: flushAds
	};
};
