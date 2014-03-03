/* exported AdProviderGpt */
/* jshint maxparams: false, maxlen: 150 */

var AdProviderGpt = function (adTracker, log, window, Geo, slotTweaker, cacheStorage, adLogicHighValueCountry, wikiaGpt) {
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
		'CORP_TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'CORP_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'EXIT_STITIAL_BOXAD_1': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'exit'},
		'HOME_TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'HUB_TOP_LEADERBOARD':  {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'INVISIBLE_SKIN': {'size': '1000x1000,1x1', 'loc': 'top', 'gptOnly': true},
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
		'TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
		'WIKIA_BAR_BOXAD_1': {'size': '320x50,320x70,320x100', 'tile': 4, 'loc': 'bottom'},
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

	function incrementItemInStorage(storageKey) {
		log('incrementItemInStorage ' + storageKey, 'debug', logGroup);

		var numCallForSlot = cacheStorage.get(storageKey, now) || 0;

		numCallForSlot += 1;
		cacheStorage.set(storageKey, numCallForSlot, forgetAdsShownAfterTime, now);

		return numCallForSlot;
	}

	function getStorageKey(param, slotname) {
		return 'dart_' + param + '_' + slotname;
	}

	/**
	 * Flush GPT ads
	 *
	 * This function will cause all ads pushed to GPT to be fetched and rendered.
	 * All other ads will auto-flush because the gptFlush variable is set to true.
	 */
	function flushGpt() {
		log('flushGpt', 'debug', logGroup);

		gptFlushed = true;
		wikiaGpt.flushAds();
	}

	/**
	 * Given we're considering calling DART (right country, right slot), should we?
	 *
	 * @param slotname
	 * @returns {boolean}
	 */
	function shouldCallDart(slotname) {
		log(['shouldCallDart', slotname], 'debug', logGroup);

		var noAdLastTime = cacheStorage.get(getStorageKey('noad', slotname), now) || false,
			numCallForSlot = cacheStorage.get(getStorageKey('calls', slotname), now) || 0;

		// Show INVISIBLE_SKIN when leaderboard was to be shown
		if (slotname === 'INVISIBLE_SKIN') {
			if (leaderboardCalled) {
				return true;
			}
		}

		// Always have an ad for MODAL_INTERSTITIAL
		if (slotname.match(/^MODAL_INTERSTITIAL/)) {
			return true;
		}

		// Check if there was ad last time
		// If not, check if desired number of DART calls were made
		if (noAdLastTime && numCallForSlot >= maxCallsToDART) {
			log('There was no ad for this slot last time and reached max number of calls to DART', 'debug', logGroup);
			log({slot: slotname, numCalls: numCallForSlot, maxCalls: maxCallsToDART, geo: country}, 'debug', logGroup);
			return false;
		}

		if (slotname.search('LEADERBOARD') > -1) {
			leaderboardCalled = true;
		}
		return true;
	}

	// Public methods

	function canHandleSlot(slotname) {
		log(['canHandleSlot', slotname], 'debug', logGroup);

		if (!isHighValueCountry || !slotMap[slotname]) {
			return false;
		}

		if (gptConfig[slotname] === 'flushonly') {
			return true;
		}

		var canHandle = shouldCallDart(slotname);

		if (!canHandle && gptConfig[slotname] === 'flush') {
			flushGpt();
		}

		return canHandle;
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		var noAdStorageKey = getStorageKey('noad', slotname),
			numCallForSlotStorageKey = getStorageKey('calls', slotname),
			slotTracker = adTracker.trackSlot('addriver2', slotname);

		if (gptConfig[slotname] === 'flushonly') {
			flushGpt();
			success();
			return;
		}

		slotTracker.init();

		incrementItemInStorage(numCallForSlotStorageKey);
		cacheStorage.del(noAdStorageKey);

		wikiaGpt.pushAd(
			slotname,
			function () { // Success
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				// experimental hack: track LB success time
				if (slotname.search('LEADERBOARD') > -1) {
					// Track hop time
					slotTracker.success();
				}

				success();
			},
			function () { // Hop
				log(slotname + ' was not filled by DART', 'info', logGroup);
				cacheStorage.set(noAdStorageKey, true, forgetAdsShownAfterTime, now);

				// Track hop time
				slotTracker.hop();

				// hop to Liftium
				hop({method: 'hop'}, 'Liftium');
			}
		);

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
