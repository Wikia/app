/* exported AdProviderGpt */
/* jshint maxparams: false, maxlen: 150 */

var AdProviderGpt = function (adTracker, log, window, Geo, slotTweaker, cacheStorage, adLogicHighValueCountry, wikiaGpt, adSlots) {
	'use strict';

	var logGroup = 'AdProviderGpt',
		forgetAdsShownAfterTime = 3600, // an hour
		country = Geo.getCountryCode(),
		now = window.wgNow || new Date(),
		maxCallsToDART,
		isHighValueCountry,
		leaderboardCalled = false, // save if leaderboard was called, so we know whether to call INVISIBLE slot as well
		gptFlushed = false,
		slotMap = adSlots.map;

	maxCallsToDART = adLogicHighValueCountry.getMaxCallsToDART(country);
	isHighValueCountry = adLogicHighValueCountry.isHighValueCountry(country);

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
			if (!leaderboardCalled) {
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

		if (slotMap[slotname].gpt === 'flushonly') {
			return true;
		}

		var canHandle = shouldCallDart(slotname);

		if (!canHandle && slotMap[slotname].gpt === 'flush') {
			flushGpt();
		}

		return canHandle;
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		var noAdStorageKey = getStorageKey('noad', slotname),
			numCallForSlotStorageKey = getStorageKey('calls', slotname),
			slotTracker = adTracker.trackSlot('addriver2', slotname);

		if (slotMap[slotname].gpt === 'flushonly') {
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

		if (slotMap[slotname].gpt === 'flush' || gptFlushed) {
			flushGpt();
		}
	}

	return {
		name: 'Gpt',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
