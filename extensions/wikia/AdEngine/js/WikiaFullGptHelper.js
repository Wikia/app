/*jshint camelcase:false, maxdepth:6*/
/*global setTimeout*/
var WikiaFullGptHelper = function (log, window, document, adLogicPageLevelParams, adSlotMapConfig) {
	'use strict';

	if ( WikiaFullGptHelper.prototype._singletonInstance ) {
		return WikiaFullGptHelper.prototype._singletonInstance;
	}

	if (!(this instanceof WikiaFullGptHelper)){
		return new WikiaFullGptHelper(log, window, document, adLogicPageLevelParams, adSlotMapConfig);
	}

	WikiaFullGptHelper.prototype._singletonInstance = this;

	var logGroup = 'WikiaFullGptHelper',
		gptLoaded = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		path = '/5441/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 + '//' + pageLevelParams.s2,
		slotQueue = [],
		doneCallbacks = {},// key: slot name, value: callback
		providerSlotMap = adSlotMapConfig.getConfig(),
		gptSlots = {},
		dataAttribs = {},
		googletag;

	function triggerDone(slotnameGpt) {
		var callback = doneCallbacks[slotnameGpt];

		log(['triggerDone', slotnameGpt], 3, logGroup);

		if (callback) {
			delete doneCallbacks[slotnameGpt];
			setTimeout(callback, 0); // escape from GPT's error-catching
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
				// happens in GPT internals. The message parameter is an object with getMessageId()
				// method returning the following integer for the interesting events:
				//
				// 3, /Fetching ad for slot ([\/\w]*)/ig);
				// 4, /Receiving ad for slot ([\/\w]*)/ig);
				// 5, /^Rendering ad for slot ([\/\w]*)/ig);
				// 6, /Completed rendering ad for slot ([\/\w]*)/
				//
				// Inspiration: https://github.com/mcountis/dfp-events
				//
				// 23 Oct 2013: the method changed as explained in this bug and pull request:
				//
				// https://github.com/mcountis/dfp-events/pull/5

				googletag.debug_log.log = function (level, message, service, slot) {
					var domId,
						doneMessageId = 5;

					// Play extra-safe with this
					try {
						domId = slot && slot.getSlotId().getDomId();

						if (domId && typeof message === 'object' && message.getMessageId) {
							if (message.getMessageId() === doneMessageId) {
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

				for ( slotMapSrc in providerSlotMap ) {
					if ( !providerSlotMap.hasOwnProperty( slotMapSrc ) ) {
						continue;
					}

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

			doneCallbacks[slotnameGpt] = function () {
				var status, height;

				status = window.adDriver2ForcedStatus && window.adDriver2ForcedStatus[slotname];

				if (status === 'success') {
					log(['doneCallback', slotname, 'running success callback (forced status)'], 4, logGroup);
					if (typeof success === 'function') {
						success();
					}
				} else {
					height = slotDiv.offsetHeight;
					log(['doneCallback', slotname, 'height', height], 4, logGroup);
					if (height <= 1) {
						log(['doneCallback', slotname, 'running error callback (hop)'], 4, logGroup);
						if (typeof error === 'function') {
							error();
						}
					} else {
						log(['doneCallback', slotname, 'running success callback'], 4, logGroup);
						if (typeof success === 'function') {
							success();
						}
					}
				}
			};

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
