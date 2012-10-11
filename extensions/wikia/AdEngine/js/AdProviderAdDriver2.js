var AdProviderAdDriver2 = function (helper, WikiaDart, ScriptWriter, WikiaTracker, log, window, Geo, slotTweaker) {
	var slotMap = {
		'HOME_TOP_LEADERBOARD':{'tile':2, 'size':'728x90,468x60,980x130,980x65', 'loc':'top', 'dcopt':'ist'},
		'HOME_TOP_RIGHT_BOXAD':{'tile':1, 'size':'300x250,300x600', 'loc':'top'},
		'LEFT_SKYSCRAPER_2':{'tile':3, 'size':'160x600,120x600', 'loc':'middle'},
		'TOP_LEADERBOARD':{'tile':2, 'size':'728x90,468x60,980x130,980x65', 'loc':'top', 'dcopt':'ist'},
		'TOP_RIGHT_BOXAD':{'tile':1, 'size':'300x250,300x600', 'loc':'top'}
		, 'WIKIA_BAR_BOXAD_1':{'size':'320x50'}
		, 'TOP_BUTTON': {'tile': 3, size:'292x90', 'loc': 'top'}
	};

	function canHandleSlot(slot) {
		var slotname = slot[0];

		log('canHandleSlot', 5, 'AdProviderAdDriver2');
		log([slotname], 5, 'AdProviderAdDriver2');

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	}

	var slotTimer2 = {};

	// adapted and simplified copy of AdDriverDelayedLoader.loadNext
	// and AdDriverDelayedLoader.callDART
	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderAdDriver2');
		log(slot, 5, 'AdProviderAdDriver2');

		var slotname = slot[0];

		if (helper.AdDriver_isLastDARTCallNoAd(slot[0]) && helper.AdDriver_getNumDARTCall(slot[0]) >= helper.AdDriver_getMinNumDARTCall(Geo.getCountryCode())) {
			log('last call no ad && reached # of calls for this geo', 5, 'AdProviderAdDriver2');
			window.adslots2.push([slotname, slot[1], 'Liftium2', slot[3]]);
			return;
		}

		slot[1] = slotMap[slotname].size || slot[1];
		log([slotname, slot[1]], 7, 'AdProviderAdDriver2');

		// increment number of pageviews
		helper.AdDriver_incrementNumAllCall(slotname);

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slotname, 'ga_label':'addriver2'}, 'ga');

		slotTimer2[slotname] = new Date().getTime();
		log('slotTimer2 start for ' + slotname, 7, 'AdProviderAdDriver2');

		helper.AdDriver_incrementNumDARTCall(slotname);
		helper.AdDriver_setLastDARTCallNoAd(slotname, null);

		var url = WikiaDart.AdConfig_DART_getUrl(slotname, slot[1], false, 'AdDriver');
		ScriptWriter.injectScriptByUrl(
			slotname, url,
			function() {

				// TODO switch to addriver2_hop
				if (typeof(window.adDriverLastDARTCallNoAds[slotname]) == 'undefined' || !window.adDriverLastDARTCallNoAds[slotname]) {
					log(slotname + ' was filled by DART', 5, 'AdProviderAdDriver2');
					slotTweaker.removeDefaultHeight(slotname);
					//AdDriver.adjustSlotDisplay(AdDriverDelayedLoader.currentAd.slotname);
				}
				else {
					log(slotname + ' was not filled by DART', 2, 'AdProviderAdDriver2');
					helper.AdDriver_setLastDARTCallNoAd(slotname, window.wgNow.getTime());

					hop(slotname);
				}

			}
		);
	}

	function hop(slotname) {
		log('hop', 5, 'AdProviderAdDriver2');
		log(slotname, 5, 'AdProviderAdDriver2');

		//slotname = sanitizeSlotname(slotname);
		var size = (slotMap[slotname].size || '0x0').replace(/,.*/, '');
		log([slotname, size], 7, 'AdProviderAdDriver2');

		var time = new Date().getTime() - slotTimer2[slotname];
		log('slotTimer2 end for ' + slotname + ' after ' + time + ' ms', 7, 'AdProviderAdDriver2');
		WikiaTracker.trackAdEvent('liftium.hop2', {'ga_category':'hop2/addriver2', 'ga_action':'slot ' + slotname, 'ga_label':formatTrackTime(time, 5)}, 'ga');

		window.adslots2.push([slotname, size, 'Liftium2', null]);
	}

	// copy of Liftium.formatTrackTime
	// TODO refactor out... AdEngine2Helper? WikiaTracker?
	function formatTrackTime(t, max) {
		if (isNaN(t)) {
			log('Error, time tracked is NaN: ' + t, 7, 'AdProviderEvolve');
			return "NaN";
		}

		if (t < 0) {
			log('Error, time tracked is a negative number: ' + t, 7, 'AdProviderEvolve');
			return "negative";
		}

		t = t / 1000;
		if (t > max) {
			return "more_than_" + max;
		}

		return t.toFixed(1);
	}

	return {
		name: 'AdDriver2',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};