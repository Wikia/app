/*global define, Liftium*/
/*jshint maxparams:false*/
define('ext.wikia.adEngine.provider.liftium', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'wikia.scriptwriter',
	'ext.wikia.adEngine.slotTweaker'
], function (log, window, document, scriptWriter, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.liftium',
		adNum = 200, // TODO global-ize it (move to Liftium?)!
		slotMap,
		canHandleSlot,
		fillInSlot;

	slotMap = {
		'BOTTOM_LEADERBOARD': {'size': '728x90'},
		'EXIT_STITIAL_BOXAD_1': {'size': '300x250'},
		'HOME_TOP_LEADERBOARD': {'size': '728x90'},
		'HOME_TOP_RIGHT_BOXAD': {'size': '300x250'},
		'INCONTENT_BOXAD_1': {'size': '300x250'},
		'INVISIBLE_1': {'size': '0x0', 'useGw': true},
		'INVISIBLE_2': {'size': '0x0', 'useGw': true},
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
		log(['canHandleSlot', slotname], 5, logGroup);

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	};

	fillInSlot = function (slotname, success) {
		log(['fillInSlot', slotname], 5, logGroup);

		// TOP_BUTTON_WIDE after TOP_LEADERBOARD hack:
		if (slotname === 'TOP_BUTTON_WIDE') {
			log('Tried TOP_BUTTON_WIDE. Disabled (waiting for leaderboard ads)', 2, logGroup);
			return;
		}
		if (slotname === 'TOP_BUTTON_WIDE.force') {
			log('Forced TOP_BUTTON_WIDE call (this means leaderboard is ready and standard)', 2, logGroup);
			slotname = slotname.replace('.force', '');
		}
		if (slotname.indexOf('LEADERBOARD') !== -1) {
			log('LEADERBOARD-ish slot handled by Liftium. Running the forced TOP_BUTTON_WIDE now', 2, logGroup);

			window.adslots2.push('TOP_BUTTON_WIDE.force');
		}
		// END of hack
		if (!document.getElementById(slotname)) {
			log('No such element in DOM: #' + slotname, 2, logGroup);
			return;
		}

		var slotsize = slotMap[slotname].size,
			useGw = slotMap[slotname].useGw,
			adDiv = document.createElement('div'),
			adIframe = document.createElement('iframe'),
			s = slotsize && slotsize.split('x'),
			script;

		if (useGw) {
			log('using ghostwriter for #' + slotname, 6, logGroup);
			script = 'Liftium.callAd(' + JSON.stringify(slotsize) + ', ' + JSON.stringify(slotname) + ');';
			scriptWriter.injectScriptByText(slotname, script);
		} else {
			log('using iframe for #' + slotname, 6, logGroup);
			// TODO: move the following to Liftium.js and refactor
			adNum += 1;
			adDiv.id = 'Liftium_' + slotsize + '_' + adNum;

			adIframe.width = s[0];
			adIframe.height = s[1];
			adIframe.scrolling = 'no';
			adIframe.frameBorder = 0;
			adIframe.marginHeight = 0;
			adIframe.marginWidth = 0;
			adIframe.allowTransparency = true; // For IE
			adIframe.id = slotname + '_iframe';
			adIframe.style.display = 'block';

			adDiv.appendChild(adIframe);
			document.getElementById(slotname).appendChild(adDiv);

			Liftium.callInjectedIframeAd(slotsize, document.getElementById(slotname + '_iframe'), slotname);

			slotTweaker.removeDefaultHeight(slotname);
		}

		// Fake success, because we don't have the success event in Liftium
		success();
	};

	return {
		name: 'Liftium',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
