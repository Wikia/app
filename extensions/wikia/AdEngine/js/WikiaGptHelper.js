
var WikiaGptHelper = function (log, window, document, adLogicPageLevelParams) {
	'use strict';

	var logGroup = 'WikiaGptHelper',
		gptLoaded = false,
		loadGpt,
		pushAd,
		convertSizesToGpt,
		googletag;

	loadGpt = function() {
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
			sizes.push([parseInt(tmp2[0]), parseInt(tmp2[1])]);
		}

		return sizes;
	};

	pushAd = function (slotParams, done) {
		var slotname = slotParams.slotname,
			sizes = convertSizesToGpt(slotParams.slotsize),
			params = adLogicPageLevelParams.getPageLevelParams(),
			path = '/5441/wka.' + params.s0 + '/' + params.s1 + '/' + params.s2;

		loadGpt();

		params.src = 'driver';
		params.pos = slotParams.slotname;
		params.positionfixed = slotParams.positionfixed;
		params.loc = slotParams.loc;
		params.dcopt = slotParams.dcopt;

		log(['googletag.cmd.push', path, sizes, slotname, params], 4, logGroup);

		googletag.cmd.push(function() {
			var slot = googletag.defineSlot(path, sizes, slotname),
				name,
				value;

			slot.addService(googletag.pubads());

			for (name in params) {
				value = params[name];
				if (value) {
					slot.setTargeting(name, value);
				}
			}

			googletag.enableServices();
			googletag.display(slotname);

			if (typeof(done) === 'function') {
				done();
			}
		});
	};

	return {
		pushAd: pushAd
	};
};
