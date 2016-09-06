/*global define*/
define('ext.wikia.adEngine.lookup.rubicon.rubiconFastlane', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'ext.wikia.adEngine.lookup.rubicon.rubiconTargeting',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, factory, rubiconTargeting, doc, log, win) {
	'use strict';

	var config = {
			// check also method configureSlots() as it's overriding defaults
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [[728, 90], [970, 250]],
					targeting: {loc: 'top'}
				},
				TOP_RIGHT_BOXAD: {
					sizes: [[300, 250], [300, 600], [300, 1050]],
					targeting: {loc: 'top'}
				},
				LEFT_SKYSCRAPER_2: {
					sizes: [[120, 600], [160, 600], [300, 250], [300, 600], [300, 1050]],
					targeting: {loc: 'middle'}
				},
				LEFT_SKYSCRAPER_3: {
					sizes: [[120, 600], [160, 600], [300, 250], [300, 600]],
					targeting: {loc: 'footer'}
				},
				INCONTENT_BOXAD_1: {
					sizes: [[120, 600], [160, 600], [300, 250], [300, 600]],
					targeting: {loc: 'hivi'}
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: [[300, 250], [336, 280]],
					targeting: {loc: 'footer'}
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: [[300, 250]],
					targeting: {loc: 'footer'}
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [[300, 50], [300, 250], [320, 50], [320, 480]]
				},
				MOBILE_PREFOOTER: {
					sizes: [[300, 50], [300, 250], [320, 50]]
				},
				MOBILE_TOP_LEADERBOARD: {
					sizes: [[300, 50], [300, 250], [320, 50], [320, 480]]
				}
			}
		},
		context,
		logGroup = 'ext.wikia.adEngine.lookup.rubicon.rubiconFastlane',
		priceMap = {},
		response,
		rubiconSlots = [],
		rubiconElementKey = 'rpfl_elemid',
		rubiconTierKey = 'rpfl_7450',
		rubiconLibraryUrl = '//ads.rubiconproject.com/header/7450.js',
		sizeMap = {
			'468x60': 1,
			'728x90': 2,
			'120x600': 8,
			'160x600': 9,
			'300x600': 10,
			'300x250': 15,
			'320x50': 43,
			'300x50': 44,
			'336x280': 49,
			'300x1050': 54,
			'970x250': 57,
			'320x480': 67,
			'480x320': 101
		},
		slots;

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

	function setTargeting(slotName, slotTargeting, rubiconSlot, skin) {
		var targeting = rubiconTargeting.getTargeting(slotName, skin, 'fastlane');
		if (slotTargeting) {
			Object.keys(slotTargeting).forEach(function (key) {
				rubiconSlot.setFPI(key, slotTargeting[key]);
			});
		}

		Object.keys(targeting).forEach(function (key) {
			rubiconSlot.setFPI(key, targeting[key]);
		});
	}

	function defineSingleSlot(slotName, slot, skin) {
		var position = slotName.indexOf('TOP') !== -1 ? 'atf' : 'btf';
		log(['defineSlot', slotName, slot], 'debug', logGroup);

		win.rubicontag.cmd.push(function () {
			var rubiconSlot = win.rubicontag.defineSlot(slotName, slot.sizes, slotName);
			if (skin === 'oasis') {
				rubiconSlot.setPosition(position);
			}
			setTargeting(slotName, slot.targeting, rubiconSlot, skin);
			rubiconSlots.push(rubiconSlot);
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

	function configureSlots(skin) {
		slots = config[skin];
		if (skin === 'oasis' && context.targeting.pageType === 'home') {
			configureHomePageSlots();
		}

		if (context.opts.overridePrefootersSizes) {
			slots.PREFOOTER_LEFT_BOXAD.sizes = [[300, 250], [336, 280], [468, 60], [728, 90]];
			delete slots.PREFOOTER_RIGHT_BOXAD;
		}

		if (context.slots.invisibleHighImpact2) {
			slots.INVISIBLE_HIGH_IMPACT_2 = {
				sizes: [[728, 90], [970, 250], [480, 320], [300, 250], [300, 600], [320, 480]],
				targeting: {loc: 'hivi'}
			};
		}

		if (context.slots.incontentLeaderboard) {
			slots.INCONTENT_LEADERBOARD = {
				sizes: [[300, 250], [728, 90], [468, 60]],
				targeting: {loc: 'hivi'}
			};
		}
	}

	function defineSlots(skin, onResponse) {
		Object.keys(slots).forEach(function (slotName) {
			defineSingleSlot(slotName, slots[slotName], skin);
		});
		win.rubicontag.cmd.push(function () {
			win.rubicontag.run(onResponse, {
				slots: rubiconSlots
			});
		});
	}

	function fillInWithMissingTiers(slotName, parameters) {
		var allTiers;
		if (!response) {
			return;
		}

		parameters[rubiconTierKey] = parameters[rubiconTierKey] || [];
		allTiers = ';' + parameters[rubiconTierKey].join(';');
		slots[slotName].sizes.forEach(function (dimensions) {
			var size = dimensions[0] + 'x' + dimensions[1],
				tierSize = sizeMap[size] + '_tier';

			if (allTiers.indexOf(';' + tierSize) === -1) {
				parameters[rubiconTierKey].push(tierSize + 'NONE');
			}
		});
	}

	function getSlotParams(slotName) {
		var targeting,
			parameters = {};

		if (!win.rubicontag || typeof win.rubicontag.getSlot !== 'function' || !win.rubicontag.getSlot(slotName)) {
			return {};
		}

		targeting = win.rubicontag.getSlot(slotName).getAdServerTargeting();
		targeting.forEach(function (params) {
			if (params.key !== rubiconElementKey) {
				parameters[params.key] = params.values;
			}
		});
		fillInWithMissingTiers(slotName, parameters);
		if (parameters[rubiconTierKey] && typeof parameters[rubiconTierKey].sort === 'function') {
			parameters[rubiconTierKey].sort(compareTiers);
		}
		if (parameters[rubiconTierKey] && parameters[rubiconTierKey].length > 0) {
			parameters.bid = 'Rxx';
		}

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
		var allSlots;
		if (!win.rubicontag || typeof win.rubicontag.getAllSlots !== 'function') {
			return;
		}
		allSlots = win.rubicontag.getAllSlots();
		if (allSlots.length) {
			win.rubicontag.getAllSlots().forEach(function (slot) {
				addSlotPrice(slot.getSlotName(), slot.getAdServerTargeting());
			});
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
		configureSlots(skin);
		response = false;
		defineSlots(skin, function () {
			response = true;
			onResponse();
		});
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
