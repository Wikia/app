/*global setTimeout */
var WikiaGptHelper = function (log, window, document, adLogicPageLevelParams) {
	'use strict';

	var logGroup = 'WikiaGptHelper',
		gptLoaded = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '//' + pageLevelParams.s2,
		slotsToDisplay = [],
		doneCallbacks = {},// key: slot name, value: callback
		googletag;

	pageLevelParams.src = 'gpt';

	function triggerDone(slotnameGpt) {
		var callback = doneCallbacks[slotnameGpt];

		log(['triggerDone', slotnameGpt], 3, logGroup);

		if (callback) {
			delete doneCallbacks[slotnameGpt];
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

				pubads.collapseEmptyDivs();

				log(['loadGpt', 'pageLevelParams', pageLevelParams], 9, logGroup);

				for (name in pageLevelParams) {
					if (pageLevelParams.hasOwnProperty(name)) {
						value = pageLevelParams[name];
						if (value) {
							log(['pubads.setTargeting', name, value], 9, logGroup);
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

	function pushAd(slotParams, success, error) {
		var slotname = slotParams.slotname,
			slotnameGpt = slotname + '_gpt',
			slotDiv = document.createElement('div'),
			sizes = convertSizesToGpt(slotParams.slotsize),
			params = {},
			slotPath = window.wgAdDriverUseNewGptZones ? path + '/' + slotname : path;

		loadGpt();

		params.pos = slotParams.slotname;
		params.positionfixed = slotParams.positionfixed;
		params.loc = slotParams.loc;
		//params.dcopt = slotParams.dcopt;

		// Create a div for the GPT ad
		slotDiv.id = slotnameGpt;
		// Save page level and slot level params for easier ad delivery debugging
		slotDiv.setAttribute('data-gpt-page-params', JSON.stringify(pageLevelParams));
		slotDiv.setAttribute('data-gpt-slot-params', JSON.stringify(params));
		slotDiv.setAttribute('data-gpt-slot-sizes', JSON.stringify(sizes));
		document.getElementById(slotname).appendChild(slotDiv);

		log(['googletag.cmd.push', slotPath, sizes, slotnameGpt, params], 4, logGroup);

		googletag.cmd.push(function () {
			var slot = googletag.defineSlot(slotPath, sizes, slotnameGpt),
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

			slotsToDisplay.push(slotnameGpt);
			doneCallbacks[slotnameGpt] = function () {
				// TODO: unify forced status and height based status?
				if (window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotname]) {
					var status = window.adDriver2ForcedStatus[slotname];
					log(['doneCallback', slotname, 'forced status', status], 4, logGroup);
					if (status === 'success' && typeof success === 'function') {
						success();
					}
				} else {

				var height = slotDiv.offsetHeight;
				log(['doneCallback', slotname, 'height', height], 4, logGroup);
				if (height <= 1) {
					log(['doneCallback', slotname, 'running error callback (hop)'], 4, logGroup);
					if (typeof error === 'function') {
						error();
					}
				} else {



					// ADEN-502 HACK STARTS HERE
					log('Detecting passBack in slot ' + slotname, 1, logGroup);
					var hasPassBack = false;
					try {
						hasPassBack = document.getElementById(slotnameGpt).getElementsByTagName('iframe')[0].contentDocument.getElementById('passbackIframe');
					} catch (e) {
					}
					if (hasPassBack) {
						log('passback in slot ' + slotname, 1, logGroup);
						document.getElementById(slotnameGpt).style.display = 'none';
						if (typeof error === 'function') {
							error();
							return;
						}
					}
					// ADEN-502 HACK ENDS HERE




					log(['doneCallback', slotname, 'running success callback'], 4, logGroup);
					if (typeof success === 'function') {
						success();
					}
				}

				}
			};
		});
	}

	function flushAds() {
		loadGpt();

		log(['googletag.cmd.push', 'enableServices'], 4, logGroup);
		log(['googletag.cmd.push', 'display', slotsToDisplay], 4, logGroup);

		googletag.cmd.push(function () {
			var callback, slotnameGpt;

			log(['flushAds', 'start'], 4, logGroup);

			googletag.pubads().enableSingleRequest();
			googletag.enableServices();

			while (slotsToDisplay.length > 0) {
				slotnameGpt = slotsToDisplay.shift();

				log(['flushAds', 'display', slotnameGpt], 8, logGroup);

				googletag.display(slotnameGpt);
			}

			log(['flushAds', 'done'], 4, logGroup);
		});
	}

	return {
		pushAd: pushAd,
		flushAds: flushAds
	};
};
