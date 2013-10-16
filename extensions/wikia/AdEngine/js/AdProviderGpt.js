// TODO: move Wikia.Tracker outside

var AdProviderGpt = function (tracker, log, window, Geo, slotTweaker, cacheStorage, adLogicHighValueCountry, wikiaGpt) {
	'use strict';

	var logGroup = 'AdProviderGpt',
		slotMap,
		forgetAdsShownAfterTime = 3600, // an hour
		country = Geo.getCountryCode(),
		now = window.wgNow || new Date(),
		maxCallsToDART,
		isHighValueCountry,
		leaderboardCalled = false, // save if leaderboard was called, so we know whether to call INVISIBLE slot as well
		gptConfig,
		gptFlushed = false;

	maxCallsToDART = adLogicHighValueCountry.getMaxCallsToDART(country);
	isHighValueCountry = adLogicHighValueCountry.isHighValueCountry(country);

	// TODO: tile is not used, keys without apostrophes
	// GPT: only loc, pos and size keys are used
	slotMap = {
		'CORP_TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'CORP_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'EXIT_STITIAL_BOXAD_1': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': "exit"},
		'HOME_TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'HUB_TOP_LEADERBOARD':  {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'INVISIBLE_SKIN': {'size': '1x1', 'loc': 'top', 'gptOnly': true},
		'LEFT_SKYSCRAPER_2': {'size': '160x600', 'tile': 3, 'loc': 'middle'},
		'LEFT_SKYSCRAPER_3': {'size': '160x600', 'tile': 6, 'loc': 'footer'},
		'MODAL_INTERSTITIAL':   {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_1': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_2': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_3': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_4': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
		'MODAL_RECTANGLE': {'size': '300x100', 'tile': 2, 'loc': 'modal'},
		'TEST_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'TEST_HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'WIKIA_BAR_BOXAD_1': {'size': '320x50', 'tile': 4, 'loc': 'bottom'},
		'GPT_FLUSH': 'flushonly'
	};
	// TODO: integrate this array to slotMap if it makes sense
	gptConfig = { // slots to use SRA with
		CORP_TOP_LEADERBOARD: 'wait',
		HUB_TOP_LEADERBOARD: 'wait',
		TOP_LEADERBOARD: 'wait',
		HOME_TOP_LEADERBOARD: 'wait',
		INVISIBLE_SKIN: 'wait',
		CORP_TOP_RIGHT_BOXAD: 'flush',
		TOP_RIGHT_BOXAD: 'flush',
		HOME_TOP_RIGHT_BOXAD: 'flush',
		GPT_FLUSH: 'flushonly'
	};

	wikiaGpt.init(slotMap);

	// Private methods

	function formatTrackTime(t, max) {
		if (isNaN(t)) {
			log('Error, time tracked is NaN: ' + t, 7, logGroup);
			return "NaN";
		}

		if (t < 0) {
			log('Error, time tracked is a negative number: ' + t, 7, logGroup);
			return "negative";
		}

		t /= 1000;
		if (t > max) {
			return "more_than_" + max;
		}

		return t.toFixed(1);
	}

	function incrementItemInStorage(storageKey) {
		log('incrementItemInStorage ' + storageKey, 5, logGroup);

		var numCallForSlot = cacheStorage.get(storageKey, now) || 0;

		numCallForSlot += 1;
		cacheStorage.set(storageKey, numCallForSlot, forgetAdsShownAfterTime, now);

		return numCallForSlot;
	}

	function canHandleSlot(slotinfo) {
		log(['canHandleSlot', slotinfo], 5, logGroup);

		return !!slotMap[slotinfo[0]];
	}

	// Public methods

	/**
	 * Flush GPT ads (if not flushed already).
	 *
	 * This function will cause all ads pushed to GPT to be fetched and rendered.
	 * All other ads will go through the legacy DART API.
	 */
	function flushGpt() {
		log('flushGpt', 5, logGroup);

		gptFlushed = true;
		wikiaGpt.flushAds();
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot], 5, logGroup);

		if (gptConfig[slot[0]] === 'flushonly') {
			flushGpt();
			return;
		}

		var slotname = slot[0],
			slotsize = slotMap[slotname].size,

			noAdStorageKey = 'dart_noad_' + slotname,
			numCallForSlotStorageKey = 'dart_calls_' + slotname,

			noAdLastTime = cacheStorage.get(noAdStorageKey, now) || false,
			numCallForSlot = cacheStorage.get(numCallForSlotStorageKey, now) || 0,
			dontCallDart = false,

			hopTimer,
			hopTime,

			// Do this when DART hops or doesn't handle
			error = function () {
				log(slotname + ' was not filled by DART', 2, logGroup);
				cacheStorage.set(noAdStorageKey, true, forgetAdsShownAfterTime, now);

				// don't track hop if not high value country
				// don't track hop if dart was not called but rather skipped
				if (isHighValueCountry && !dontCallDart) {
					// Track hop time
					hopTime = new Date().getTime() - hopTimer;
					log('slotTimer2 end for ' + slotname + ' after ' + hopTime + ' ms (hop)', 7, logGroup);
					tracker.track({
						eventName: 'liftium.hop2',
						ga_category: 'hop2/addriver2',
						ga_action: 'slot ' + slotname,
						ga_label: formatTrackTime(hopTime, 5),
						trackingMethod: 'ad'
					});
				}

				slot[2] = 'Liftium2';
				window.adslots2.push(slot);
			},

			// Do this when filling slot by DART
			success = function () {
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				// experimental hack: track LB success time
				if (slotname.search('LEADERBOARD') > -1) {
					// Track hop time
					hopTime = new Date().getTime() - hopTimer;
					log('slotTimer2 end for ' + slotname + ' after ' + hopTime + ' ms (success)', 7, logGroup);
					tracker.track({
						eventName: 'liftium.hop2',
						ga_category: 'success2/addriver2',
						ga_action: 'slot ' + slotname,
						ga_label: formatTrackTime(hopTime, 5),
						trackingMethod: 'ad'
					});
				}
			};

		if (!isHighValueCountry) {
			error();
			return;
		}

		// Show INVISIBLE_SKIN when leaderboard was shown
		if (slotname === 'INVISIBLE_SKIN') {
			if (!leaderboardCalled) {
				dontCallDart = true;
			}
		} else if (!slotname.match(/^MODAL_INTERSTITIAL/)) {
			// Always have an ad for MODAL_INTERSTITIAL
			// Otherwise check if there was ad last time
			// If not, check if desired number of DART calls were made
			if (noAdLastTime && numCallForSlot >= maxCallsToDART) {
				log('There was no ad for this slot last time and reached max number of calls to DART', 5, logGroup);
				log({slot: slotname, numCalls: numCallForSlot, maxCalls: maxCallsToDART, geo: country}, 6, logGroup);

				dontCallDart = true;
			}
		}

		if (dontCallDart) {
			if (gptConfig[slotname] === 'flush') {
				flushGpt();
			}
			error();
			return;
		}

		if (slotname.search('LEADERBOARD') > -1) {
			leaderboardCalled = true;
		}

		hopTimer = new Date().getTime();
		log('hopTimer start for ' + slotname, 7, logGroup);

		incrementItemInStorage(numCallForSlotStorageKey);
		cacheStorage.del(noAdStorageKey);

		tracker.track({
			eventName: 'liftium.slot2',
			ga_category: 'slot2/' + slotsize.split(',')[0],
			ga_action: slotname,
			ga_label: 'addriver2',
			trackingMethod: 'ad'
		});

		log('Use the new GPT library for ' + slotname, 5, logGroup);

		wikiaGpt.pushAd(slotname, success, error);

		if (gptConfig[slotname] === 'flush' || gptFlushed) {
			flushGpt();
		}
	}

	return {
		name: 'Gpt',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
