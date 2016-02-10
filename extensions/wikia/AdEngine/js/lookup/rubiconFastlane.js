/*global define*/
define('ext.wikia.adEngine.lookup.rubiconFastlane', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, factory, adLogicZoneParams, doc, log, win) {
	'use strict';

	var config = {
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
					sizes: [[300, 250], [300, 600]],
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
					sizes: [[320, 50], [300, 250]]
				}
			}
		},
		context,
		logGroup = 'ext.wikia.adEngine.lookup.rubiconFastlane',
		priceMap = {},
		rubiconSlots = [],
		rubiconElementKey = 'rpfl_elemid',
		rubiconTierKey = 'rpfl_7450',
		rubiconLibraryUrl = '//ads.rubiconproject.com/header/7450.js',
		slots = {};

	function compareTiers(a,b) {
		var aMatches = /^(\d+)/.exec(a),
			bMatches = /^(\d+)/.exec(b);

		if (aMatches && bMatches) {
			return parseInt(aMatches[1], 10) > parseInt(bMatches[1], 10) ? 1 : -1;
		}

		return 0;
	}

	function addSlotPrice(slotName, rubiconTargeting) {
		rubiconTargeting.forEach(function (params) {
			if (params.key === rubiconTierKey) {
				priceMap[slotName] = params.values.sort(compareTiers).join(',');
			}
		});
	}

	function setTargeting(slotName, targeting, rubiconSlot, provider) {
		var s1 = context.targeting.wikiIsTop1000 ? adLogicZoneParams.getName() : 'not a top1k wiki';
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

	function configureHomePageSlots() {
		var slotName;
		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName) && slotName.indexOf('TOP') > -1) {
				slots['HOME_' + slotName] = slots[slotName];
				delete slots[slotName];
			}
		}
		slots.PREFOOTER_MIDDLE_BOXAD = {
			sizes: [[300, 250]],
			targeting: {loc: 'footer'}
		};
	}

	function getSlots(skin) {
		slots = config[skin];
		if (skin === 'oasis' && context.targeting.pageType === 'home') {
			configureHomePageSlots();
		}

		if (context.opts.overridePrefootersSizes) {
			slots.PREFOOTER_LEFT_BOXAD.sizes = [[300, 250], [728, 90], [970, 250]];
			delete slots.PREFOOTER_RIGHT_BOXAD;
		}

		return slots;
	}

	function defineSlots(skin, onResponse) {
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

	function getSlotParams(slotName) {
		var targeting,
			values,
			parameters = {};

		targeting = slots[slotName].getAdServerTargeting();
		targeting.forEach(function (params) {
			if (params.key !== rubiconElementKey) {
				values = params.values;
				if (typeof values.sort === 'function') {
					values.sort(compareTiers);
				}
				parameters[params.key] = params.values;
			}
		});
		log(['getSlotParams', slotName, parameters], 'debug', logGroup);
		return parameters;
	}

	function encodeParamsForTracking(params) {
		if (!params[rubiconTierKey]) {
			return;
		}

		return params[rubiconTierKey].join(';');
	}

	function calculatePrices() {
		var slotName;

		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				addSlotPrice(slotName, slots[slotName].getAdServerTargeting());
			}
		}
	}

	function call(skin, onResponse) {
		var rubicon = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		win.rubicontag = win.rubicontag || {};
		win.rubicontag.cmd = win.rubicontag.cmd || [];

		rubicon.async = true;
		rubicon.type = 'text/javascript';
		rubicon.src = rubiconLibraryUrl;

		node.parentNode.insertBefore(rubicon, node);
		context = adContext.getContext();
		defineSlots(skin, onResponse);
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return slots[slotName];
	}

	return factory.create({
		logGroup: logGroup,
		name: 'rubicon_fastlane',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
