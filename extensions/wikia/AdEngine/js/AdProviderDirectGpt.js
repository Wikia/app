/*global define*/
/*jshint maxlen: 150*/
define('ext.wikia.adEngine.provider.directGpt', [
	'wikia.cache',
	'wikia.geo',
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicHighValueCountry',
	'ext.wikia.adEngine.gptHelper',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slotTweaker'
], function (
	cacheStorage,
	geo,
	log,
	window,
	adContext,
	adLogicHighValueCountry,
	gptHelper,
	factory,
	slotTweaker
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.directGpt',
		slotMap = {
			BOTTOM_LEADERBOARD:         {size: '728x90,300x250', loc: 'bottom'},
			CORP_TOP_LEADERBOARD:       {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			CORP_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			EXIT_STITIAL_BOXAD_1:       {size: '300x250,600x400,800x450,550x480', loc: 'exit'},
			HOME_TOP_LEADERBOARD:       {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			HOME_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			HUB_TOP_LEADERBOARD:        {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			INCONTENT_1A:               {size: '300x250', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1B:               {size: '300x250,160x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1C:               {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_2A:               {size: '300x250', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_2B:               {size: '300x250,160x600', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_2C:               {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_3A:               {size: '300x250', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_3B:               {size: '300x250,160x600', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_3C:               {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_BOXAD_1:          {size: '300x250', loc: 'middle'},
			INCONTENT_LEADERBOARD_1:    {size: '728x90,468x90', loc: 'middle'},
			INCONTENT_LEADERBOARD_2:    {size: '728x90,468x90', loc: 'middle'},
			INCONTENT_LEADERBOARD_3:    {size: '728x90,468x90', loc: 'middle'},
			INVISIBLE_SKIN:             {size: '1000x1000,1x1', loc: 'top'},
			LEFT_SKYSCRAPER_2:          {size: '160x600', loc: 'middle'},
			LEFT_SKYSCRAPER_3:          {size: '160x600', loc: 'footer'},
			MODAL_INTERSTITIAL:         {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_1:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_2:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_3:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_4:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_5:       {size: '300x250,300x600,728x90,970x250,160x600', loc: 'modal'},
			MODAL_RECTANGLE:            {size: '300x100', loc: 'modal'},
			PREFOOTER_LEFT_BOXAD:       {size: '300x250', loc: 'footer'},
			PREFOOTER_RIGHT_BOXAD:      {size: '300x250', loc: 'footer'},
			TOP_LEADERBOARD:            {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			TOP_RIGHT_BOXAD:            {size: '300x250,300x600,300x1050', loc: 'top'},
			GPT_FLUSH: 'flushonly'
		},
		forgetAdsShownAfterTime = 3600, // an hour
		country = geo.getCountryCode(),
		now = window.wgNow || new Date(),
		maxCallsToDART = adLogicHighValueCountry.getMaxCallsToDART(country),
		isHighValueCountry = adLogicHighValueCountry.isHighValueCountry(country),
		leaderboardCalled = false, // save if leaderboard was called, so we know whether to call INVISIBLE slot as well
		gptFlushed = false,
		alwaysCallDart = adContext.getContext().opts.alwaysCallDart,

		gptConfig = { // slots to use SRA with
			CORP_TOP_LEADERBOARD: 'wait',
			HUB_TOP_LEADERBOARD:  'wait',
			TOP_LEADERBOARD:      'wait',
			HOME_TOP_LEADERBOARD: 'wait',
			INVISIBLE_SKIN:       'wait',
			CORP_TOP_RIGHT_BOXAD: 'flush',
			TOP_RIGHT_BOXAD:      'flush',
			HOME_TOP_RIGHT_BOXAD: 'flush',
			GPT_FLUSH:            'flushonly'
		},

		factoryFillInSlot = factory.getFillInSlot(logGroup, 'gpt', slotMap, {
			noFlush: true
		});

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
		gptHelper.flushAds();
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

	function fillInSlot(slotName, success, hop) {
		log(['fillInSlot', slotName], 'debug', logGroup);

		var noAdStorageKey = getStorageKey('noad', slotName),
			numCallForSlotStorageKey = getStorageKey('calls', slotName);

		if (gptConfig[slotName] === 'flushonly') {
			flushGpt();
			success();
			return;
		}

		incrementItemInStorage(numCallForSlotStorageKey);
		cacheStorage.del(noAdStorageKey);

		factoryFillInSlot(slotName, function (adInfo) {
			// Success
			slotTweaker.removeDefaultHeight(slotName);
			slotTweaker.removeTopButtonIfNeeded(slotName);
			slotTweaker.adjustLeaderboardSize(slotName);
			success(adInfo);
		}, function (adInfo) {
			// Hop
			cacheStorage.set(noAdStorageKey, true, forgetAdsShownAfterTime, now);
			hop(adInfo);
		});

		if (gptConfig[slotName] === 'flush' || gptFlushed) {
			flushGpt();
		}
	}

	return {
		name: 'DirectGpt',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
