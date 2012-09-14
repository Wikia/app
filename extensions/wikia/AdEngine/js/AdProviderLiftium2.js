window.AdProviderLiftium2 = function (WikiaTracker, log, window, ghostwriter, document) {
	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.callLiftium
	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderLiftium2');
		log(slot, 5, 'AdProviderLiftium2');

		slot[1] = slotMap[slot[0]].size || slot[1];
		log([slot[0], slot[1]], 7, 'AdProviderLiftium2');

		// TODO real deferred queue is needed...
		if (!window.Liftium) {
			log('Liftium not available, pushing to the AdDriver queue', 3, 'AdProviderLiftium2');
			log(slot, 3, 'AdProviderLiftium2');

			if(!window.adslots) {
				window.adslots = [];
			}
			window.adslots.push([slot[0], slot[1], 'Liftium', slot[3]]);
			return;
		}

		// this is *NOT* needed, liftium has it's own slot tracking
		//WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'liftium'}, 'ga');

		//LiftiumOptions.placement = slotname;
		var script = getLiftiumCallScript(slot[0], slot[1]);
		ghostwriter(
			document.getElementById(slot[0]),
			{
				insertType:"append",
				script:{text:script},
				done:function () {
					log('ghostwriter done', 5, 'AdProviderLiftium2');
					log([slot[0], script], 5, 'AdProviderLiftium2');
					ghostwriter.flushloadhandlers();
					// TODO un-comment this
					//window.AdDriver.adjustSlotDisplay(slotname);
				}
			}
		); // TODO get rid of ghostscript (inject iframe + call liftium)
		// TODO check AIC2 for an example
	}

	var slotMap = {
		'HOME_TOP_LEADERBOARD':{'size':'728x90'},
		'HOME_TOP_RIGHT_BOXAD':{'size':'300x250'},
		'LEFT_SKYSCRAPER_2':{'size':'160x600'},
		'TOP_LEADERBOARD':{'size':'728x90'},
		'TOP_RIGHT_BOXAD':{'size':'300x250'}
	};
	var adNum = 100; // TODO global-ize it!

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.getLiftiumCallScript
	function getLiftiumCallScript(slotname, size) {
		log('getLiftiumCallScript', 5, 'AdProviderLiftium2');
		log([slotname, size], 5, 'AdProviderLiftium2');

		var dims = size.split('x');
		var script = '';
		script += "document.write('<div id=\"Liftium_"+size+"_"+(++adNum)+"\"><iframe width=\""+dims[0]+"\" height=\""+dims[1]+"\" id=\""+slotname+"_iframe\" noresize=\"true\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"border:none;\" target=\"_blank\"></iframe><div>');";

		script += 'LiftiumOptions.placement = "'+slotname+'";';
		script += 'Liftium.callInjectedIframeAd("'+size+'", document.getElementById("'+slotname+'_iframe"));';

		log(script, 7, 'AdProviderLiftium2');
		return script;
	}

	var iface = {
		name: 'Liftium2',
		fillInSlot: fillInSlot
	};

	// TODO: @mech rethink
	// TODO: @rychu change tests
	if (window.wgInsideUnitTest) {
	}

	return iface;
};