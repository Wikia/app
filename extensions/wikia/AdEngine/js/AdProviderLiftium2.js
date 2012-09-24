var AdProviderLiftium2 = function (scriptWriter, WikiaTracker, log, window) {
	'use strict';

	var module = 'AdProviderLiftium2'
		, canHandleSlot
		, fillInSlot
		, slotMap
		, getLiftiumCallScript
		, adNum = 100; // TODO global-ize it!

	slotMap = {
		'HOME_TOP_LEADERBOARD':{'size':'728x90'},
		'HOME_TOP_RIGHT_BOXAD':{'size':'300x250'},
		'LEFT_SKYSCRAPER_2':{'size':'160x600'},
		'TOP_LEADERBOARD':{'size':'728x90'},
		'TOP_RIGHT_BOXAD':{'size':'300x250'},
		'PREFOOTER_LEFT_BOXAD':{'size':'300x250'},
		'PREFOOTER_RIGHT_BOXAD':{'size':'300x250'},
		'INVISIBLE_1':{'size':'0x0'},
		'WIKIA_BAR_BOXAD_1':{'size':'300x250'}
	};

	canHandleSlot = function(slot) {
		var slotname = slot[0];

		log('fillInSlot', 5, module);
		log(slot, 5, module);

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	};

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.callLiftium
	fillInSlot = function(slot) {
		log('fillInSlot', 5, module);
		log(slot, 5, module);

		slot[1] = slotMap[slot[0]].size || slot[1];
		log([slot[0], slot[1]], 7, module);

		// TODO real deferred queue is needed...
		if (!window.Liftium) {
			log('Liftium not available, pushing to the AdDriver queue', 3, module);
			log(slot, 3, module);

			if(!window.adslots) {
				window.adslots = [];
			}
			window.adslots.push([slot[0], slot[1], 'Liftium', slot[3]]);
			return;
		}

		// this is *NOT* needed, liftium has it's own slot tracking
		//WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'liftium'}, 'ga');

		//LiftiumOptions.placement = slotname;

		// TODO get rid of ghostscript (inject iframe + call liftium)
		// TODO check AIC2 for an example

		var script = getLiftiumCallScript(slot[0], slot[1]);
		scriptWriter.injectScriptByText(slot[0], script, function() {
			// TODO un-comment this
			//window.AdDriver.adjustSlotDisplay(slotname);
		});
	};

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.getLiftiumCallScript
	getLiftiumCallScript = function(slotname, size) {
		log('getLiftiumCallScript', 5, module);
		log([slotname, size], 5, module);

		var dims = size.split('x');
		var script = '';
		script += "document.write('<div id=\"Liftium_"+size+"_"+(++adNum)+"\"><iframe width=\""+dims[0]+"\" height=\""+dims[1]+"\" id=\""+slotname+"_iframe\" noresize=\"true\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"border:none;\" target=\"_blank\"></iframe><div>');";

		script += 'LiftiumOptions.placement = "'+slotname+'";';
		script += 'Liftium.callInjectedIframeAd("'+size+'", document.getElementById("'+slotname+'_iframe"));';

		log(script, 7, module);
		return script;
	};

	return {
		name: 'Liftium2',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};