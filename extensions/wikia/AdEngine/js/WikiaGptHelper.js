/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.wikiaGptHelper', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.gptSlotConfig',
	'ext.wikia.adEngine.wikiaGptAdDetect'
], function (log, window, document, adLogicPageParams, gptSlotConfig, gptAdDetect) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wikiaGptHelper',
		gptLoaded = false,
		slotQueue = [],
		gptSlots = {},
		dataAttribs = {},
		googletag,
		pubads,
		fallbackSize = [1, 1]; // Size to return if there are no sizes matching the screen dimensions

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

	function filterOutSizesBiggerThanScreenSize(sizes) {
		log(['filterOutSizesBiggerThanScreenSize', sizes], 'debug', logGroup);
		var goodSizes = [], i, len, minWidth;

		minWidth = document.documentElement.offsetWidth;

		for (i = 0, len = sizes.length; i < len; i += 1) {
			if (sizes[i][0] <= minWidth) {
				goodSizes.push(sizes[i]);
			}
		}

		if (goodSizes.length === 0) {
			log(['filterOutSizesBiggerThanScreenSize', 'No sizes left. Returning fallbackSize only'], 'error', logGroup);
			goodSizes.push(fallbackSize);
		}

		log(['filterOutSizesBiggerThanScreenSize', 'result', goodSizes], 'debug', logGroup);
		return goodSizes;
	}

	function setPageLevelParams() {
		var name,
			value,
			pageLevelParams = adLogicPageParams.getPageLevelParams();

		log(['setPageLevelParams', pageLevelParams], 'debug', logGroup);

		for (name in pageLevelParams) {
			if (pageLevelParams.hasOwnProperty(name)) {
				value = pageLevelParams[name];
				if (value) {
					log(['setPageLevelParams', 'pubads.setTargeting', name, value], 'debug', logGroup);
					pubads.setTargeting(name, value);
				}
			}
		}
	}

	function defineSlots() {
		var	pageLevelParams = adLogicPageParams.getPageLevelParams(),
			providerSlotMap = gptSlotConfig.getConfig(),
			path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '//' + pageLevelParams.s2,
			slotname,
			slotnameGpt,
			sizes,
			slot,
			slotMap,
			slotMapSrc,
			slotItem,
			slotPath,
			slotParams,
			name,
			value;

		log(['defineSlots', providerSlotMap], 'info', logGroup);

		for (slotMapSrc in providerSlotMap) {
			if (providerSlotMap.hasOwnProperty(slotMapSrc)) {

				slotMap = providerSlotMap[slotMapSrc];

				for (slotname in slotMap) {
					if (slotMap.hasOwnProperty(slotname) && slotMap[slotname].size) {
						log(['defineSlots', 'defining slot', slotname], 'debug', logGroup);

						slotnameGpt = slotname + '_' + slotMapSrc;
						slotItem = slotMap[slotname];

						sizes = convertSizesToGpt(slotItem.size);
						delete slotItem.size;

						if (slotname.match(/TOP_LEADERBOARD/)) {
							sizes = filterOutSizesBiggerThanScreenSize(sizes);
						}

						slotPath = path + '/' + slotname + '_' + slotMapSrc;

						log(['defineSlots', 'googletag.defineSlot', slotPath, sizes, slotnameGpt], 'debug', logGroup);
						slot = googletag.defineSlot(slotPath, sizes, slotnameGpt);
						slot.addService(pubads);
						for (name in slotItem) {
							if (slotItem.hasOwnProperty(name)) {
								value = slotItem[name];
								if (value) {
									log(['defineSlots', 'slot.setTargeting', name, value], 'debug', logGroup);
									slot.setTargeting(name, value);
								}
							}
						}

						gptSlots[slotnameGpt] = slot;

						dataAttribs[slotnameGpt] = {
							'data-gpt-page-params': JSON.stringify(pageLevelParams),
							'data-gpt-slot-params': JSON.stringify(slotItem),
							'data-gpt-slot-sizes': JSON.stringify(sizes)
						};

						log(['defineSlots', 'defined slot', slotname, slot], 'debug', logGroup);
					}
				}
			}
		}

		log(['defineSlots', 'all slots defined'], 'debug', logGroup);
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

			// Enable services
			log(['loadGpt', 'googletag.cmd.push'], 'info', logGroup);
			googletag.cmd.push(function () {
				pubads = googletag.pubads();

				setPageLevelParams();
				defineSlots();

				pubads.collapseEmptyDivs();
				pubads.enableSingleRequest();
				pubads.disableInitialLoad(); // manually request ads

				googletag.enableServices();

				log(['loadGpt', 'googletag.cmd.push', 'done'], 'debug', logGroup);
			});
		}
	}

	function pushAd(slotname, success, error, slotMapSrc) {
		var slotnameGpt = slotname + '_' + slotMapSrc,
			slotDiv = document.createElement('div');

		function callSuccess(adInfo) {
			if (typeof success === 'function') {
				success(adInfo);
			}
		}

		function callError(adInfo) {
			slotDiv.className += ' hidden';
			if (typeof error === 'function') {
				error(adInfo);
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
				if (event.slot === gptSlots[slotnameGpt]) {
					log(['slotRenderEnded', slotname, event], 'info', logGroup);

					// Add debug info
					slotDiv.setAttribute('data-gpt-line-item-id', JSON.stringify(event.lineItemId));
					slotDiv.setAttribute('data-gpt-creative-id', JSON.stringify(event.creativeId));
					slotDiv.setAttribute('data-gpt-creative-size', JSON.stringify(event.size));

					var iframe = slotDiv.querySelector('div[id*="_container_"] iframe');

					// IE doesn't allow us to inspect GPT iframe at this point.
					// Let's launch our callback in a setTimeout instead.
					setTimeout(function () {
						gptAdDetect.onAdLoad(slotname, event, iframe, callSuccess, callError);
					}, 0);
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
