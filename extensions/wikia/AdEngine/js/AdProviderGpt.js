/* exported AdProviderGpt */
/* jshint maxparams: false, maxlen: 150, camelcase:false */

var AdProviderGpt = function (log, window, Geo, slotTweaker, cacheStorage, adLogicHighValueCountry, wikiaGpt, slotMapConfig) {
	'use strict';

	var logGroup = 'AdProviderGpt',
		srcName = 'gpt',
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
	slotMap = slotMapConfig.getConfig(srcName);

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
		return true;
	}

	function isAmznOnPage(slotname, slot) {
		log(['isAmznOnPage', slotname], 'debug', logGroup);

		var matches, i;

		if (!window.amzn_targs || !slot.size) {
			return false;
		}

		matches = window.amzn_targs.match(/\d+x\d+/g);

		for (i = 0; i < matches.length; i += 1) {

			if (slot.size.indexOf(matches[i].toLowerCase()) !== -1) {
				return true;
			}

		}

		return false;
	}

	function canHandleSlot(slotname) {
		log(['canHandleSlot', slotname], 'debug', logGroup);

		var canHandle = false;

		// Show INVISIBLE_SKIN when leaderboard was to be shown
		if (slotname === 'INVISIBLE_SKIN') {
			if (leaderboardCalled) {
				canHandle = true;
			}
		}

		if (!isHighValueCountry || !slotMap[slotname]) {
			canHandle = false;
		}

		if (gptConfig[slotname] === 'flushonly') {
			canHandle = true;
		}

		canHandle = shouldCallDart(slotname);

		if (canHandle && slotname.search('LEADERBOARD') > -1) {
			leaderboardCalled = true;
		}

		if (!canHandle && isAmznOnPage(slotname, slotMap[slotname])) {
			canHandle = true;
		}

		return canHandle;
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		var noAdStorageKey = getStorageKey('noad', slotname),
			numCallForSlotStorageKey = getStorageKey('calls', slotname);

		if (gptConfig[slotname] === 'flushonly') {
			flushGpt();
			success();
			return;
		}

		incrementItemInStorage(numCallForSlotStorageKey);
		cacheStorage.del(noAdStorageKey);

		wikiaGpt.pushAd(
			slotname,
			function () { // Success
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				success();
			},
			function () { // Hop
				log(slotname + ' was not filled by DART', 'info', logGroup);
				cacheStorage.set(noAdStorageKey, true, forgetAdsShownAfterTime, now);

				// hop to Liftium
				hop({method: 'hop'}, 'Liftium');
			},
			srcName
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
