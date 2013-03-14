
var WikiaGptHelper = function (log, window, document, adLogicPageLevelParams) {
	'use strict';

	var logGroup = 'WikiaGptHelper',
		gptLoaded = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '/' + pageLevelParams.s2,
		slotQueue = [],
		doneCallbacks = [],
		slotMap,
		gptSlots = {},
		googletag;

	function init(paramSlotMap) {
		slotMap = paramSlotMap;
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
			log(['loadGpt', 'googletag.cmd.push', 'page level targeting'], 4, logGroup);
			googletag.cmd.push(function () {
				var name,
					value,
					pubads = googletag.pubads(),
					slotname,
					sizes,
					slot,
					slotItem;

				// Set page level params
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

				// Define all possible slots
				for (slotname in slotMap) {
					if (slotMap.hasOwnProperty(slotname)) {

						log(['loadGpt', 'defining slot', slotname], 9, logGroup);

						slotItem = slotMap[slotname];
						sizes = convertSizesToGpt(slotItem.size);

						slot = googletag.defineSlot(path, sizes, slotname);
						slot.addService(googletag.pubads());

						slot.setTargeting('pos', slotname);
						if (slotItem.loc) {
							slot.setTargeting('loc', slotItem.loc);
						}
						if (slotItem.dcopt) {
							slot.setTargeting('dcopt', slotItem.dcopt);
						}

						gptSlots[slotname] = slot;

						log(['loadGpt', 'defined slot', slotname, slot], 9, logGroup);

					}
				}

				log(['loadGpt', 'all slots defined'], 9, logGroup);

				// Enable services
				googletag.pubads().enableSingleRequest();
				googletag.pubads().disableInitialLoad(); // manually request ads
				googletag.enableServices();

				log(['loadGpt', 'services enabled'], 9, logGroup);
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

	function pushAd(slotname, done) {
		loadGpt();

		log(['pushAd', slotname], 9, logGroup);
		googletag.cmd.push(function () {
			googletag.display(slotname);
			slotQueue.push(gptSlots[slotname]);

			if (typeof done === 'function') {
				doneCallbacks.push(done);
			}
		});
	}

	function flushAds() {
		googletag.cmd.push(function () {
			var i, len, callback;

			log(['flushAds', 'start'], 4, logGroup);

			log(['flushAds', 'refresh', slotQueue], 9, logGroup);

			if (slotQueue.length) {
				googletag.pubads().refresh(slotQueue);
				slotQueue = [];
			}

			for (i = 0, len = doneCallbacks.length; i < len; i += 1) {
				callback = doneCallbacks.shift();
				callback();
			}

			log(['flushAds', 'done'], 4, logGroup);
		});
	}

	return {
		init: init,
		pushAd: pushAd,
		flushAds: flushAds
	};
};
