var AdProviderAdDriver2 = function (helper, WikiaDart, ScriptWriter, WikiaTracker, log, window, Geo) {
	var slotMap = {
		'HOME_TOP_LEADERBOARD':{'tile':2, 'size':'728x90,468x60,980x130,980x65', 'loc':'top', 'dcopt':'ist'},
		'HOME_TOP_RIGHT_BOXAD':{'tile':1, 'size':'300x250,300x600', 'loc':'top'},
		'LEFT_SKYSCRAPER_2':{'tile':3, 'size':'160x600,120x600', 'loc':'middle'},
		'TOP_LEADERBOARD':{'tile':2, 'size':'728x90,468x60,980x130,980x65', 'loc':'top', 'dcopt':'ist'},
		'TOP_RIGHT_BOXAD':{'tile':1, 'size':'300x250,300x600', 'loc':'top'}
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

		if (helper.AdDriver_isLastDARTCallNoAd(slot[0]) && helper.AdDriver_getNumDARTCall(slot[0]) >= helper.AdDriver_getMinNumDARTCall(Geo.getCountryCode())) {
			log('last call no ad && reached # of calls for this geo', 5, 'AdProviderAdDriver2');
			window.adslots2.push([slot[0], slot[1], 'Liftium2', slot[3]]);
			return;
		}

		// increment number of pageviews
		helper.AdDriver_incrementNumAllCall(slot[0]);

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'addriver2'}, 'ga');

		slotTimer2[slot[0]] = new Date().getTime();
		log('slotTimer2 start for ' + slot[0], 7, 'AdProviderAdDriver2');

		helper.AdDriver_incrementNumDARTCall(slot[0]);
		helper.AdDriver_setLastDARTCallNoAd(slot[0], null);

		var url = WikiaDart.AdConfig_DART_getUrl(slot[0], slot[1], false, 'AdDriver');
		ScriptWriter.injectScriptByUrl(
			slot[0], url,
			function() {

				// TODO switch to addriver2_hop
				if (typeof(window.adDriverLastDARTCallNoAds[slot[0]]) == 'undefined' || !window.adDriverLastDARTCallNoAds[slot[0]]) {
					log(slot[0] + ' was filled by DART', 5, 'AdProviderAdDriver2');
					//AdDriver.adjustSlotDisplay(AdDriverDelayedLoader.currentAd.slotname);
				}
				else {
					log(slot[0] + ' was not filled by DART', 2, 'AdProviderAdDriver2');
					helper.AdDriver_setLastDARTCallNoAd(slot[0], window.wgNow.getTime());

					hop(slot[0]);
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
