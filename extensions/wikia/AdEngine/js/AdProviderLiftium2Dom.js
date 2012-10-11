var AdProviderLiftium2Dom = function (WikiaTracker, log, document, slotTweaker) {
	'use strict';

	var log_group = 'AdProviderLiftium2'
		, adNum = 200 // TODO global-ize it!
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

		log('canHandleSlot', 5, log_group);
		log(slot, 5, log_group);

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	};

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.callLiftium
	fillInSlot = function(slot) {
		log('fillInSlot', 5, log_group);
		log(slot, 5, log_group);

		slot[1] = slotMap[slot[0]].size || slot[1];
		log([slot[0], slot[1]], 7, log_group);

		// this is *NOT* needed, liftium has it's own slot tracking
		//WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'liftium'}, 'ga');

		callLiftium(slot[0], slot[1]);
	};

	// c&p from Lifitum.callIframeAd
	callLiftium = function(slotname, size) {
		log('callLiftium', 5, log_group);
		log([slotname, size], 5, log_group);

		var adDiv = document.createElement("div");
		adDiv.id = "Liftium_" + size + '_' + (++adNum);

		var adIframe = document.createElement("iframe");
		var s = size.split("x");
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

		LiftiumOptions.placement = slotname;
		Liftium.callInjectedIframeAd(size, document.getElementById(slotname + '_iframe'));
		slotTweaker.removeDefaultHeight(slotname);
	};

	return {
		name: 'Liftium2Dom'
		, canHandleSlot: canHandleSlot
		, fillInSlot: fillInSlot
	};

};