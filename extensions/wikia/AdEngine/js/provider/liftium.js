/*global define, require, Liftium*/
/*jshint maxparams:false*/
define('ext.wikia.adEngine.provider.liftium', [
	'wikia.document',
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('wikia.instantGlobals')
], function (doc, log, win, slotTweaker, instantGlobals) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.liftium',
		slotMap,
		canHandleSlot,
		fillInSlot;

	slotMap = {
		'BOTTOM_LEADERBOARD': {'size': '728x90'},
		'EXIT_STITIAL_BOXAD_1': {'size': '300x250'},
		'HOME_TOP_LEADERBOARD': {'size': '728x90'},
		'HOME_TOP_RIGHT_BOXAD': {'size': '300x250'},
		'INCONTENT_BOXAD_1': {'size': '300x250'},
		'LEFT_SKYSCRAPER_2': {'size': '160x600'},
		'LEFT_SKYSCRAPER_3': {'size': '160x600'},
		'TEST_TOP_RIGHT_BOXAD': {'size': '300x250'},
		'TEST_HOME_TOP_RIGHT_BOXAD': {'size': '300x250'},
		'TOP_BUTTON_WIDE': {'size': '292x90'},

		// TOP_BUTTON_WIDE after TOP_LEADERBOARD hack:
		'TOP_BUTTON_WIDE.force': 'hack',

		'INCONTENT_1A': {'size': '300x250'},
		'INCONTENT_1B': {'size': '300x250'},
		'INCONTENT_1C': {'size': '300x250'},
		'TOP_LEADERBOARD': {'size': '728x90'},
		'TOP_RIGHT_BOXAD': {'size': '300x250'},
		'PREFOOTER_LEFT_BOXAD': {'size': '300x250'},
		'PREFOOTER_RIGHT_BOXAD': {'size': '300x250'},
		'WIKIA_BAR_BOXAD_1': {'size': '300x250'}
	};

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

	fillInSlot = function (slotname, success) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		// TOP_BUTTON_WIDE after TOP_LEADERBOARD hack:
		if (slotname === 'TOP_BUTTON_WIDE') {
			log('Tried TOP_BUTTON_WIDE. Disabled (waiting for leaderboard ads)', 'info', logGroup);
			return;
		}
		if (slotname === 'TOP_BUTTON_WIDE.force') {
			log('Forced TOP_BUTTON_WIDE call (this means leaderboard is ready and standard)', 'info', logGroup);
			slotname = slotname.replace('.force', '');
		}
		if (slotname.indexOf('LEADERBOARD') !== -1) {
			log('LEADERBOARD-ish slot handled by Liftium. Running the forced TOP_BUTTON_WIDE now', 'info', logGroup);

			win.adslots2.push('TOP_BUTTON_WIDE.force');
		}
		// END of hack
		if (!doc.getElementById(slotname)) {
			log('No such element in DOM: #' + slotname, 'info', logGroup);
			return;
		}

		var slotsize = slotMap[slotname].size;

			log('using iframe for #' + slotname, 'debug', logGroup);
			Liftium.injectAd(doc, slotname, slotsize);

			slotTweaker.removeDefaultHeight(slotname);

		// Fake success, because we don't have the success event in Liftium
		success();
	};

	return {
		name: 'Liftium',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
