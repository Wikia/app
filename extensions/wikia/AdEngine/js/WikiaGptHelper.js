/*global define*/
/*jshint maxlen:150, camelcase:false, maxdepth:5*/
var WikiaGptHelper = function (log, window, document, adLogicPageLevelParams, gptSlotConfig) {
	'use strict';

	if (WikiaGptHelper.prototype.singletonInstance) {
		return WikiaGptHelper.prototype.singletonInstance;
	}

	if (!(this instanceof WikiaGptHelper)) {
		return new WikiaGptHelper(log, window, document, adLogicPageLevelParams, gptSlotConfig);
	}

	WikiaGptHelper.prototype.singletonInstance = this;

	var logGroup = 'WikiaGptHelper',
		gptLoaded = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '//' + pageLevelParams.s2,
		specialAdSelector = 'script[src*="/ads.saymedia.com/"], .celtra-ad-v3',
		slotQueue = [],
		providerSlotMap = gptSlotConfig.getConfig(),
		gptSlots = {},
		dataAttribs = {},
		googletag;

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
					slotnameGpt,
					sizes,
					slot,
					slotMap,
					slotMapSrc,
					slotItem,
					slotPath,
					slotParams;

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

				for (slotMapSrc in providerSlotMap) {
					if (providerSlotMap.hasOwnProperty(slotMapSrc)) {

						slotMap = providerSlotMap[slotMapSrc];

						// Define all possible slots
						for (slotname in slotMap) {
							if (slotMap.hasOwnProperty(slotname) && slotMap[slotname].size) {
								log(['loadGpt', 'defining slot', slotname], 9, logGroup);

								slotnameGpt = slotname + '_' + slotMapSrc;
								slotItem = slotMap[slotname];
								sizes = convertSizesToGpt(slotItem.size);

								slotPath = path + '/' + slotname + '_' + slotMapSrc;

								log(['googletag.defineSlot', slotPath, sizes, slotnameGpt], 9, logGroup);
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
											log(['slot.setTargeting', name, value], 9, logGroup);
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

								log(['loadGpt', 'defined slot', slotname, slot], 9, logGroup);

							}
						}
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

	function pushAd(slotname, success, error, slotMapSrc) {
		var slotnameGpt = slotname + '_' + slotMapSrc,
			slotDiv = document.createElement('div');

		loadGpt();

		// Create a div for the GPT ad
		slotDiv.id = slotnameGpt;

		document.getElementById(slotname).appendChild(slotDiv);

		log(['pushAd', slotname], 9, logGroup);
		googletag.cmd.push(function () {
			var attrName;

			log(['googletag.display', slotnameGpt], 9, logGroup);
			googletag.display(slotnameGpt);

			slotQueue.push(gptSlots[slotnameGpt]);

			googletag.pubads().addEventListener('slotRenderEnded', function (event) {
				var status, height, gptEmpty, empty, iframeContent;

				if (event.slot === gptSlots[slotnameGpt]) {
					log(['slotRenderEnded', slotname, event], 'info', logGroup);

					// Add debug info
					slotDiv.setAttribute('data-gpt-line-item-id', JSON.stringify(event.lineItemId));
					slotDiv.setAttribute('data-gpt-creative-id', JSON.stringify(event.creativeId));
					slotDiv.setAttribute('data-gpt-creative-size', JSON.stringify(event.size));

					// Check the explicit status
					status = window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotname];

					if (status === 'success') {
						log(['slotRenderEnded', slotname, 'running success callback (forced status)'], 4, logGroup);
						if (typeof success === 'function') {
							success();
						}
						return;
					}

					// Now, let's base our decision on slot height (1x1 means hop)
					height = event.size && event.size[1];
					gptEmpty = event.isEmpty;
					log(['slotRenderEnded', slotname, 'height', height, 'gptEmpty', gptEmpty], 4, logGroup);

					empty = gptEmpty || height <= 1;

					// On mobile skin check GPT iframe contents
					if (window.skin === 'wikiamobile' && !empty) {
						try {
							iframeContent = slotDiv.querySelector('div[id*="_container_"] iframe').contentWindow;
							height = iframeContent.innerHeight;
							log(['slotRenderEnded', slotname, 'height (iframe content)', height], 4, logGroup);
						} catch (e) {
							log(['slotRenderEnded', slotname, 'height (iframe content)', 'exception'], 4, logGroup);
						}

						// Check specifically for ads which can appear empty, even when successful
						if (height <= 1) {
							empty = !iframeContent.document.querySelector(specialAdSelector);
							log(['slotRenderEnded', slotname, 'empty (iframe content)', empty], 4, logGroup);
						}
					}

					if (empty) {
						log(['slotRenderEnded', slotname, 'running error callback (hop)'], 4, logGroup);
						if (typeof error === 'function') {
							error();
						}
					} else {
						log(['slotRenderEnded', slotname, 'running success callback'], 4, logGroup);
						if (typeof success === 'function') {
							success();
						}
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
			log(['flushAds', 'done', 'no slots to flush'], 4, logGroup);
			return;
		}

		googletag.cmd.push(function () {
			log(['flushAds', 'start'], 4, logGroup);

			log(['flushAds', 'refresh', slotQueue], 9, logGroup);

			if (slotQueue.length) {
				googletag.pubads().refresh(slotQueue);
				slotQueue = [];
			}

			log(['flushAds', 'done'], 4, logGroup);
		});
	}

	this.pushAd = pushAd;
	this.flushAds = flushAds;
};

define(
	'ext.wikia.adengine.gpthelper',
	['wikia.log', 'wikia.window', 'wikia.document', 'wikia.adlogicpageparams', 'ext.wikia.adengine.gptslotconfig'],
	WikiaGptHelper
);
