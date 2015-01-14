/* jshint maxparams: false, maxlen: 150 */
/*global define*/
define('ext.wikia.adEngine.provider.directGpt', [
	'wikia.cache',
	'wikia.geo',
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.adLogicHighValueCountry',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.gptSlotConfig'
], function (cacheStorage, Geo, log, window, adContext, slotTweaker, adLogicHighValueCountry, wikiaGpt, slotMapConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.directGpt',
		srcName = 'gpt',
		slotMap = slotMapConfig.getConfig(srcName),
		forgetAdsShownAfterTime = 3600, // an hour
		country = Geo.getCountryCode(),
		now = window.wgNow || new Date(),
		maxCallsToDART = adLogicHighValueCountry.getMaxCallsToDART(country),
		isHighValueCountry = adLogicHighValueCountry.isHighValueCountry(country),
		leaderboardCalled = false, // save if leaderboard was called, so we know whether to call INVISIBLE slot as well
		gptConfig,
		gptFlushed = false,
		alwaysCallDart = adContext.getContext().opts.alwaysCallDart;

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

		if (!slotMap[slotname]) {
			log(['canHandleSlot', slotname, 'no DART for this slot', false], 'info', logGroup);
			return false;
		}

		if (alwaysCallDart) {
			log(['canHandleSlot', slotname, 'always calling DART', true], 'info', logGroup);
			return true;
		}

		if (adContext.getContext().forceProviders.directGpt) {
			log(['canHandleSlot', slotname, 'forced through adContext', true], 'info', logGroup);
			return true;
		}

		if (!isHighValueCountry) {
			log(['canHandleSlot', slotname, 'no high value country', false], 'info', logGroup);
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
			function (adInfo) { // Success
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				success(adInfo);
			},
			function (adInfo) { // Hop
				log(slotname + ' was not filled by DART', 'info', logGroup);
				cacheStorage.set(noAdStorageKey, true, forgetAdsShownAfterTime, now);

				// hop to Liftium
				adInfo.method = 'hop';
				hop(adInfo);
			},
			srcName
		);

		if (gptConfig[slotname] === 'flush' || gptFlushed) {
			flushGpt();
		}
	}

	return {
		name: 'DirectGpt',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
