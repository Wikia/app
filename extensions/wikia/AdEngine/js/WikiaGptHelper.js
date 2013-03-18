
var WikiaGptHelper = function (log, window, document, adLogicPageLevelParams) {
	'use strict';

	var logGroup = 'WikiaGptHelper',
		gptLoaded = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '/' + pageLevelParams.s2,
		slotsToDisplay = [],
		doneCallbacks = [],
		googletag;

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
			log(['loadGpt', 'googletag.cmd.push', 'page level targeting'], 4, logGroup);
			googletag.cmd.push(function () {
				var name, value, pubads = googletag.pubads();

				pubads.setTargeting('src', 'driver');

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
				doneCallbacks.push(done);
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

			while (doneCallbacks.length > 0) {
				callback = doneCallbacks.shift();
				callback();
			}
			log(['flushAds', 'done'], 4, logGroup);
		});
	}

	return {
		pushAd: pushAd,
		flushAds: flushAds
	};
};
