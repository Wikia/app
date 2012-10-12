var AdProviderLiftium2Dom = function (wikiaTracker, log, document, slotTweaker, Liftium) {
	'use strict';

	var logGroup = 'AdProviderLiftium2'
		, adNum = 200 // TODO global-ize it (move to Liftium?)!
		, slotMap
		, canHandleSlot
		, fillInSlot
		, callLiftium
	;

	slotMap = {
		'HOME_TOP_LEADERBOARD':{'size':'728x90'},
		'HOME_TOP_RIGHT_BOXAD':{'size':'300x250'},
		'LEFT_SKYSCRAPER_2':{'size':'160x600'},
		'TOP_LEADERBOARD':{'size':'728x90'},
		'TOP_RIGHT_BOXAD':{'size':'300x250'},
		'PREFOOTER_LEFT_BOXAD':{'size':'300x250'},
		'PREFOOTER_RIGHT_BOXAD':{'size':'300x250'},
		'INVISIBLE_1':{'size':'0x0'},
		'INCONTENT_BOXAD_1':{'size':'300x250'},
		'WIKIA_BAR_BOXAD_1':{'size':'300x250'},
		'TOP_BUTTON': {'size':'242x90'}
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
			, adDiv = document.createElement("div")
			, adIframe = document.createElement("iframe")
			, s = slotsize && slotsize.split('x')
		;

		log('fillInSlot', 5, logGroup);
		log(slot, 5, logGroup);
		log('size: ' + slotsize, 7, logGroup);

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
	};

	return {
		name: 'Liftium2Dom'
		, canHandleSlot: canHandleSlot
		, fillInSlot: fillInSlot
	};
};
