
var WikiaGptHelper = function (log, window, document, adLogicPageLevelParams) {
	'use strict';

	var logGroup = 'WikiaGptHelper',
		gptLoaded = false,
		loadGpt,
		pushAd,
		convertSizesToGpt,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '/' + pageLevelParams.s2,
		googletag;

	loadGpt = function () {
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
	};

	convertSizesToGpt = function (slotsize) {
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
	};

	pushAd = function (slotParams, done) {
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

			googletag.enableServices();
			googletag.display(slotname);

			if (typeof done === 'function') {
				done();
			}
		});
	};

	return {
		pushAd: pushAd
	};
};
