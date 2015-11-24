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
				TOP_LEADERBOARD: [[728, 90],[970, 250]],
				TOP_RIGHT_BOXAD: [[300, 250],[300, 600]],
				LEFT_SKYSCRAPER_2: [[160,600]],
				LEFT_SKYSCRAPER_3: [[160,600]],
				PREFOOTER_LEFT_BOXAD: [[300, 250]],
				PREFOOTER_RIGHT_BOXAD: [[300, 250]]
			},
			mercury: {
				MOBILE_IN_CONTENT: [[300, 250]],
				MOBILE_PREFOOTER: [[300, 250]],
				MOBILE_TOP_LEADERBOARD: [[320, 50]]
			}
		},
		logGroup = 'ext.wikia.adEngine.lookup.rubiconFastlane',
		response = false,
		rubiconSlots = [],
		slotPath = [
			'/5441',
			'wka.' + adLogicZoneParams.getSite(),
			adLogicZoneParams.getMappedVertical(),
			'',
			adLogicZoneParams.getPageType()
		].join('/'),
		slots = {},
		timing;

	function getSlots(skin) {
		var context = adContext.getContext(),
			pageType = context.targeting.pageType,
			slotName;

		slots = config[skin];
		if (skin === 'oasis' && pageType === 'home') {
			for (slotName in slots) {
				if (slots.hasOwnProperty(slotName) && slotName.indexOf('TOP') > -1) {
					slots['HOME_' + slotName] = slots[slotName];
					delete slots[slotName];
				}
			}
		}

		return slots;
	}

	function onResponse() {
		response = true;
	}

	function defineSingleSlot(slotName, sizes) {
		win.rubicontag.cmd.push(function () {
			var slot = win.rubicontag.defineSlot(
				'wikia_gpt' + slotPath + '/gpt/' + slotName,
				sizes,
				'wikia_gpt' + slotPath + '/gpt/' + slotName
			).setPosition('atf');
			rubiconSlots.push(slot);
			slots[slotName] = slot;
		});
	}

	function defineSlots(skin) {
		var definedSlots = getSlots(skin);
		Object.keys(definedSlots).forEach(function (slotName) {
			defineSingleSlot(slotName, definedSlots[slotName]);
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

		if (called) {
			log(['call', 'Already called'], 'debug', logGroup);
			return;
		}

		win.rubicontag = win.rubicontag || {};
		win.rubicontag.cmd = win.rubicontag.cmd || [];

		timing = adTracker.measureTime('rubicon_fastlane', {}, 'start');
		timing.track();

		rubicon.async = true;
		rubicon.type = 'text/javascript';
		rubicon.src = '//ads.rubiconproject.com/header/7450.js';

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
				parameters[params.key] = params.values;
			});
			log(['getSlotParams', slotName, parameters], 'debug', logGroup);
			return parameters;
		}
		return {};
	}

	return {
		call: call,
		getSlotParams: getSlotParams,
		trackState: function () {},
		wasCalled: wasCalled
	};
});
