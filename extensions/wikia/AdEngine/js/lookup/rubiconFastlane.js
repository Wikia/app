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
				TOP_LEADERBOARD: [[728, 90], [970, 250]],
				TOP_RIGHT_BOXAD: [[300, 250], [300, 600]],
				LEFT_SKYSCRAPER_2: [[160,600]],
				LEFT_SKYSCRAPER_3: [[160,600]],
				INCONTENT_BOXAD_1: [[300, 250]],
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
		priceMap = {},
		response = false,
		rubiconSlots = [],
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

	function trackState(trackEnd) {
		log(['trackState', response], 'debug', logGroup);
		var eventName = 'lookupError';

		if (response) {
			eventName = 'lookupSuccess';
		}

		if (trackEnd) {
			eventName = 'lookupEnd';
		}

		adTracker.track(eventName + '/rubicon_fastlane', priceMap || '(unknown)', 0);
	}

	function addSlotPrice(slotName, rubiconTargeting) {
		rubiconTargeting.forEach(function (params) {
			if (params.key === 'rpfl_7450') {
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

		trackState(true);
	}

	function defineSingleSlot(slotName, sizes, skin) {
		var position = slotName.indexOf('TOP') !== -1 ? 'atf' : 'btf',
			provider = skin === 'oasis' ? 'gpt' : 'mobile',
			slotPath = [
				'/5441',
				'wka.' + adLogicZoneParams.getSite(),
				adLogicZoneParams.getMappedVertical(),
				'',
				adLogicZoneParams.getPageType()
			].join('/'),
			unit = 'wikia_gpt' + slotPath + '/' + provider + '/' + slotName;

		win.rubicontag.cmd.push(function () {
			var slot = win.rubicontag.defineSlot(unit, sizes, unit).setPosition(position);
			rubiconSlots.push(slot);
			slots[slotName] = slot;
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

		if (adLogicZoneParams.getSite() !== 'life') {
			log(['call', 'Not wka.life vertical'], 'debug', logGroup);
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
		trackState: trackState,
		wasCalled: wasCalled
	};
});
