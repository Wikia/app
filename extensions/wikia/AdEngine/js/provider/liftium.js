/*global define, require, Liftium*/
/*jshint maxparams:false*/
define('ext.wikia.adEngine.provider.liftium', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('wikia.instantGlobals')
], function (adContext, doc, log, win, slotTweaker, instantGlobals) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.liftium',
		slotMap,
		canHandleSlot,
		fillInSlot;

	slotMap = {
		'HOME_TOP_LEADERBOARD': {'size': '728x90'},
		'HOME_TOP_RIGHT_BOXAD': {'size': '300x250'},
		'INCONTENT_BOXAD_1': {'size': '300x250'},
		'LEFT_SKYSCRAPER_2': {'size': '160x600'},
		'LEFT_SKYSCRAPER_3': {'size': '160x600'},
		'TEST_TOP_RIGHT_BOXAD': {'size': '300x250'},
		'TEST_HOME_TOP_RIGHT_BOXAD': {'size': '300x250'},

		'TOP_LEADERBOARD': {'size': '728x90'},
		'TOP_RIGHT_BOXAD': {'size': '300x250'},
		'PREFOOTER_LEFT_BOXAD': {'size': '300x250'},
		'PREFOOTER_MIDDLE_BOXAD': {'size': '300x250'},
		'PREFOOTER_RIGHT_BOXAD': {'size': '300x250'}
	};

	if (adContext.getContext().opts.overridePrefootersSizes) {
		delete slotMap.PREFOOTER_RIGHT_BOXAD;
	}

	canHandleSlot = function (slotname) {
		log(['canHandleSlot', slotname], 'debug', logGroup);

		if (instantGlobals && instantGlobals.wgSitewideDisableLiftium) {
			log('Liftium disabled through InstantGlobals', 'error', logGroup);
			return false;
		}

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	};

	fillInSlot = function (slot) {
		log(['fillInSlot', slot.name], 'debug', logGroup);

		if (!doc.getElementById(slot.name)) {
			log('No such element in DOM: #' + slot.name, 'info', logGroup);
			return;
		}

		var slotsize = slotMap[slot.name].size;

		log('using iframe for #' + slot.name, 'debug', logGroup);
		Liftium.injectAd(doc, slot.name, slot.container, slotsize);

		slotTweaker.removeDefaultHeight(slot.name);

		// Fake success, because we don't have the success event in Liftium
		slot.success();
	};

	return {
		name: 'Liftium',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
