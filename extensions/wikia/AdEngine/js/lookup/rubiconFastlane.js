/*global define*/
define('ext.wikia.adEngine.lookup.rubiconFastlane', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, adLogicZoneParams, doc, log, win) {
	'use strict';

	var called = false,
		config = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [[728, 90], [970, 250]],
					targeting: {loc: 'top'}
				},
				TOP_RIGHT_BOXAD: {
					sizes: [[300, 250], [300, 600]],
					targeting: {loc: 'top'}
				},
				LEFT_SKYSCRAPER_2: {
					sizes: [[160, 600], [300, 600]],
					targeting: {loc: 'middle'}
				},
				LEFT_SKYSCRAPER_3: {
					sizes: [[160, 600], [300, 600]],
					targeting: {loc: 'footer'}
				},
				INCONTENT_BOXAD_1: {
					sizes: [[300, 250]],
					targeting: {loc: 'middle'}
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: [[300, 250]],
					targeting: {loc: 'footer'}
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: [[300, 250]],
					targeting: {loc: 'footer'}
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [[300, 250]]
				},
				MOBILE_PREFOOTER: {
					sizes: [[300, 250]]
				},
				MOBILE_TOP_LEADERBOARD: {
					sizes: [[320, 50]]
				}
			}
		},
		context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.lookup.rubiconFastlane',
		name = 'rubicon_fastlane',
		priceMap = {},
		response = false,
		rubiconSlots = [],
		rubiconElementKey = 'rpfl_elemid',
		rubiconTierKey = 'rpfl_7450',
		rubiconLibraryUrl = '//ads.rubiconproject.com/header/7450.js',
		slots = {},
		timing;

	function configureHomePageSlots() {
		var slotName;
		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName) && slotName.indexOf('TOP') > -1) {
				slots['HOME_' + slotName] = slots[slotName];
				delete slots[slotName];
			}
		}
	}

	function getSlots(skin) {
		slots = config[skin];
		if (skin === 'oasis' && context.targeting.pageType === 'home') {
			configureHomePageSlots();
		}

		return slots;
	}

	function encodeParamsForTracking(params) {
		if (params[rubiconTierKey]) {
			return params[rubiconTierKey].join(';');
		}
	}

	function trackState(providerName, slotName, params) {
		log(['trackState', response, providerName, slotName], 'debug', logGroup);
		var category,
			eventName = 'lookup_error';

		if (!slots[slotName]) {
			log(['trackState', 'Not supported slot', slotName], 'debug', logGroup);
			return;
		}
		if (response) {
			eventName = 'lookup_success';
		}
		category = name + '/' + eventName + '/' + providerName;
		adTracker.track(category, slotName, 0, encodeParamsForTracking(params) || 'nodata');
	}

	function trackLookupEnd() {
		adTracker.track(name + '/lookup_end', priceMap || 'nodata', 0);
	}

	function addSlotPrice(slotName, rubiconTargeting) {
		rubiconTargeting.forEach(function (params) {
			if (params.key === rubiconTierKey) {
				priceMap[slotName] = params.values.join(',');
			}
		});
	}

	function onResponse() {
		timing.measureDiff({}, 'end').track();
		log('Rubicon Fastlane done', 'info', logGroup);
		var slotName;

		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				addSlotPrice(slotName, slots[slotName].getAdServerTargeting());
			}
		}
		response = true;
		log(['Rubicon Fastlane prices', priceMap], 'info', logGroup);
		trackLookupEnd();
	}

	function setTargeting(slotName, targeting, rubiconSlot, provider) {
		var s1 = context.targeting.wikiIsTop1000 ? adLogicZoneParams.getMappedVertical() : 'not a top1k wiki';
		if (targeting) {
			Object.keys(targeting).forEach(function (key) {
				rubiconSlot.setFPI(key, targeting[key]);
			});
		}
		rubiconSlot.setFPI('pos', slotName);
		rubiconSlot.setFPI('src', provider);
		rubiconSlot.setFPI('s0', adLogicZoneParams.getSite());
		rubiconSlot.setFPI('s1', s1);
		rubiconSlot.setFPI('s2', adLogicZoneParams.getPageType());
		rubiconSlot.setFPI('lang', adLogicZoneParams.getLanguage());
		rubiconSlot.setFPI('passback', 'fastlane');
	}

	function defineSingleSlot(slotName, slot, skin) {
		var position = slotName.indexOf('TOP') !== -1 ? 'atf' : 'btf',
			provider = skin === 'oasis' ? 'gpt' : 'mobile';

		win.rubicontag.cmd.push(function () {
			var rubiconSlot = win.rubicontag.defineSlot(slotName, slot.sizes, slotName);
			if (skin === 'oasis') {
				rubiconSlot.setPosition(position);
			}
			setTargeting(slotName, slot.targeting, rubiconSlot, provider);
			rubiconSlots.push(rubiconSlot);
			slots[slotName] = rubiconSlot;
		});
	}

	function defineSlots(skin) {
		var definedSlots = getSlots(skin);
		Object.keys(definedSlots).forEach(function (slotName) {
			defineSingleSlot(slotName, definedSlots[slotName], skin);
		});
		win.rubicontag.cmd.push(function () {
			win.rubicontag.run(onResponse, {
				slots: rubiconSlots
			});
		});
	}

	function call(skin) {
		log('call', 'debug', logGroup);

		var rubicon = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		if (!context.opts.rubiconFastlaneOnAllVerticals && adLogicZoneParams.getSite() !== 'life') {
			log(['call', 'Not wka.life vertical'], 'debug', logGroup);
			return;
		}

		win.rubicontag = win.rubicontag || {};
		win.rubicontag.cmd = win.rubicontag.cmd || [];

		timing = adTracker.measureTime('rubicon_fastlane', {}, 'start');
		timing.track();

		rubicon.async = true;
		rubicon.type = 'text/javascript';
		rubicon.src = rubiconLibraryUrl;

		node.parentNode.insertBefore(rubicon, node);
		defineSlots(skin);
		called = true;
	}

	function wasCalled() {
		log(['wasCalled', called], 'debug', logGroup);
		return called;
	}

	function getSlotParams(slotName) {
		var targeting,
			parameters = {};
		if (response && slots[slotName]) {
			targeting = slots[slotName].getAdServerTargeting();
			targeting.forEach(function (params) {
				// exclude redundant rpfl_elemid parameter
				if (params.key !== rubiconElementKey) {
					parameters[params.key] = params.values;
				}
			});
			log(['getSlotParams', slotName, parameters], 'debug', logGroup);
			return parameters;
		}
		return {};
	}

	return {
		call: call,
		getSlotParams: getSlotParams,
		trackState: trackState,
		wasCalled: wasCalled
	};
});
