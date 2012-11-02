// TODO: remove WikiaTracker dependency
var AdProviderLiftium2Dom = function (wikiaTracker, log, document, slotTweaker, Liftium, scriptWriter) {
	'use strict';

	var logGroup = 'AdProviderLiftium2'
		, adNum = 200 // TODO global-ize it (move to Liftium?)!
		, slotMap
		, canHandleSlot
		, fillInSlot
	;

	slotMap = {
		'HOME_TOP_LEADERBOARD':{'size':'728x90'},
		'HOME_TOP_RIGHT_BOXAD':{'size':'300x250'},
		'LEFT_SKYSCRAPER_2':{'size':'160x600'},
		'TOP_LEADERBOARD':{'size':'728x90'},
		'TOP_RIGHT_BOXAD':{'size':'300x250'},
		'PREFOOTER_LEFT_BOXAD':{'size':'300x250'},
		'PREFOOTER_RIGHT_BOXAD':{'size':'300x250'},
		'INCONTENT_BOXAD_1':{'size':'300x250'},
		'WIKIA_BAR_BOXAD_1':{'size':'300x250'},
		'TOP_BUTTON': {'size':'242x90'},
		'EXIT_STITIAL_BOXAD_1': {'size':'300x250'},
		'INVISIBLE_1':{'size':'0x0', 'useGw': true},
		'INVISIBLE_2':{'size':'0x0', 'useGw': true}
	};

	canHandleSlot = function(slot) {
		var slotname = slot[0];

		log('canHandleSlot', 5, logGroup);
		log(slot, 5, logGroup);

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	};

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.callLiftium
	fillInSlot = function(slot) {
		var slotname = slot[0]
			, slotsize = slotMap[slotname].size
			, useGw = slotMap[slotname].useGw
			, adDiv = document.createElement("div")
			, adIframe = document.createElement("iframe")
			, s = slotsize && slotsize.split('x')
			, script
		;

		log('fillInSlot', 5, logGroup);
		log(slot, 5, logGroup);
		log('size: ' + slotsize, 7, logGroup);

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
			adIframe.scrolling = "no";
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
	};

	return {
		name: 'Liftium2Dom'
		, canHandleSlot: canHandleSlot
		, fillInSlot: fillInSlot
	};
};
