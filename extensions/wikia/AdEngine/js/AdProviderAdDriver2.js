// TODO: move WikiaTracker outside

var AdProviderAdDriver2 = function(wikiaDart, scriptWriter, WikiaTracker, log, window, Geo, slotTweaker, cacheStorage) {
	'use strict';

	var logGroup = 'AdProviderAdDriver2'
		, slotMap
		, forgetAdsShownAfterTime = 3600 // an hour
		, incrementItemInStorage
		, fillInSlot, canHandleSlot
		, formatTrackTime
		, country = Geo.getCountryCode()
		, now = window.wgNow || new Date()
		, highValueCountries, defaultHighValueCountries
		, isHighValueCountry, maxCallsToDART
	;

	// copy of CommonSettings wgHighValueCountries
	defaultHighValueCountries = {
		'CA': 3,
		'DE': 3,
		'DK': 3,
		'ES': 3,
		'FI': 3,
		'FR': 3,
		'GB': 3,
		'IT': 3,
		'NL': 3,
		'NO': 3,
		'SE': 3,
		'UK': 3,
		'US': 3
	};

	highValueCountries = window.wgHighValueCountries || defaultHighValueCountries;

	// Fetch number of calls to make to DART
	if (country) {
		maxCallsToDART = highValueCountries[country.toUpperCase()];
	}
	maxCallsToDART = maxCallsToDART || 0;
	isHighValueCountry = !!maxCallsToDART;

	// TODO: tile is not used, keys without apostrophes

	slotMap = {
		'CORP_TOP_LEADERBOARD': {'size': '728x90,468x60,980x130,1030x130', 'tile':2, 'loc': 'top', 'dcopt': 'ist'},
		'CORP_TOP_RIGHT_BOXAD': {'size': '300x250,300x600', 'tile':1, 'loc': 'top'},
		'EXIT_STITIAL_BOXAD_1': {'size':'600x400,300x250', 'tile':2, 'loc': "exit"},
		'HOME_TOP_LEADERBOARD': {'size':'728x90,468x60,980x130,1030x130', 'tile':2, 'loc':'top', 'dcopt':'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'size':'300x250,300x600', 'tile':1, 'loc':'top'},
		'LEFT_SKYSCRAPER_2': {'size':'160x600,120x600', 'tile':3, 'loc':'middle'},
		'LEFT_SKYSCRAPER_3': {'size': '160x600', 'tile':6, 'loc':'footer'},
		'MODAL_INTERSTITIAL': {'size':'600x400','tile':2,'loc':'modal'},
		'MODAL_RECTANGLE': {'size':'300x100','tile':2,'loc':'modal'},
		'TEST_TOP_RIGHT_BOXAD': {'size':'300x250,300x600', 'tile':1, 'loc':'top'},
		'TEST_HOME_TOP_RIGHT_BOXAD': {'size':'300x250,300x600', 'tile':1, 'loc':'top'},
		'TOP_LEADERBOARD': {'size':'728x90,468x60,980x130,1030x130', 'tile':2, 'loc':'top', 'dcopt':'ist'},
		'TOP_RIGHT_BOXAD': {'size':'300x250,300x600', 'tile':1, 'loc':'top'},
		'WIKIA_BAR_BOXAD_1': {'size':'320x50', 'tile': 4, 'loc':'bottom'}
	};

// FORMER SLOTS {
//		'DOCKED_LEADERBOARD': {'tile': 8, 'loc': "bottom"},
//		'EXIT_STITIAL_INVISIBLE': {'tile':1, 'loc': "exit", 'dcopt': "ist"},
//		'FOOTER_BOXAD': {'tile': 5, 'loc': "footer"},
//		'HOME_LEFT_SKYSCRAPER_1': {'tile':3, 'loc': "top"},
//		'HOME_LEFT_SKYSCRAPER_2': {'tile':3, 'loc': "middle"},
//		'HOME_TOP_RIGHT_BUTTON': {'tile': 3, 'loc': "top"},
//		'HUB_TOP_LEADERBOARD': {'tile':2, 'loc': 'top', 'dcopt': 'ist'},
//		'INCONTENT_BOXAD_1': {'tile':4, 'loc': "middle"},
//		'INCONTENT_BOXAD_2': {'tile':5, 'loc': "middle"},
//		'INCONTENT_BOXAD_3': {'tile':6, 'loc': "middle"},
//		'INCONTENT_BOXAD_4': {'tile':7, 'loc': "middle"},
//		'INCONTENT_BOXAD_5': {'tile':8, 'loc': "middle"},
//		'INCONTENT_LEADERBOARD_1': {'tile':4, 'loc': "middle"},
//		'INCONTENT_LEADERBOARD_2': {'tile':5, 'loc': "middle"},
//		'INCONTENT_LEADERBOARD_3': {'tile':6, 'loc': "middle"},
//		'INCONTENT_LEADERBOARD_4': {'tile':7, 'loc': "middle"},
//		'INCONTENT_LEADERBOARD_5': {'tile':8, 'loc': "middle"},
//		'INVISIBLE_1': {'tile':10, 'loc': "invisible"},
//		'INVISIBLE_2': {'tile':11, 'loc': "invisible"},
//		'INVISIBLE_MODAL': {'tile':14, 'loc': "invisible"},
//		'JWPLAYER': {'tile': 2, 'loc': "top"},
//		'LEFT_SKYSCRAPER_1': {'tile': 3, 'loc': "top"},
//		'MIDDLE_RIGHT_BOXAD': {'tile': 1, 'loc': "middle"},
//		'PREFOOTER_BIG': {'tile': 5, 'loc': "footer"},
//		'PREFOOTER_LEFT_BOXAD': {'tile': 5, 'loc': "footer"},
//		'PREFOOTER_RIGHT_BOXAD': {'tile': 5, 'loc': "footer"},
//		'TEST_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
//		'TOP_BUTTON': {'tile': 3, 'loc': 'top'},
//		'TOP_RIGHT_BUTTON': {'tile': 3, 'loc': "top"}
// }

	incrementItemInStorage = function(storageKey) {
		log('incrementNumCall ' + storageKey, 5, logGroup);

		var numCallForSlot = cacheStorage.get(storageKey, now) || 0;

		numCallForSlot += 1;
		cacheStorage.set(storageKey, numCallForSlot, forgetAdsShownAfterTime, now);

		return numCallForSlot;
	};

	canHandleSlot = function(slotinfo) {
		log(['canHandleSlot', slotinfo], 5, logGroup);

		if (slotMap[slotinfo[0]]) {
			return true;
		}
		return false;
	};

	fillInSlot = function(slotinfo) {
		log(['fillInSlot', slotinfo], 5, logGroup);

		var slotname = slotinfo[0]

			, slotsize = slotMap[slotname].size
			, loc = slotMap[slotname].loc
			, dcopt = slotMap[slotname].dcopt

			// Do this when DART hops or doesn't handle
			, error = function() {
				slotinfo[2] = 'Liftium2';
				window.adslots2.push(slotinfo);
			}

			// Do this when filling slot by DART
			, success = function() {
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
			}

			, noAdStorageKey = 'dart_noad_' + slotname
			, numCallForSlotStorageKey = 'dart_calls_' + slotname

			, noAdLastTime = cacheStorage.get(noAdStorageKey, now) || false
			, numCallForSlot = cacheStorage.get(numCallForSlotStorageKey, now) || 0
			, url

			, hopTimer, hopTime
		;

		if (!isHighValueCountry) {
			error();
			return;
		}

		if (window.wgUserName && !window.wgUserShowAds) {
			dcopt = false;
		}

		// Always have an ad for MODAL_INTERSTITIAL
		if (slotname !== 'MODAL_INTERSTITIAL') {
			// Otherwise check if there was ad last time
			// If not, check if desired number of DART calls were made
			if (noAdLastTime && numCallForSlot >= maxCallsToDART) {
				log('There was no ad for this slot last time and reached max number of calls to DART', 5, logGroup);
				log({slot: slotname, numCalls: numCallForSlot, maxCalls: maxCallsToDART, geo: country}, 6, logGroup);
				error();
				return;
			}
		}

		WikiaTracker.trackAdEvent('liftium.slot2', {
			ga_category: 'slot2/' + slotsize,
			ga_action: slotname,
			ga_label: 'addriver2'
		}, 'ga');

		hopTimer = new Date().getTime();
		log('hopTimer start for ' + slotname, 7, logGroup);

		incrementItemInStorage(numCallForSlotStorageKey);
		cacheStorage.del(noAdStorageKey);

		url = wikiaDart.getUrl({
			slotname: slotname,
			slotsize: slotsize,
			dcopt: dcopt,
			loc: loc
		});

		scriptWriter.injectScriptByUrl(slotname, url, function() {
			/**
			 * Our DART server when having no ads returns
			 *
			 * window.adDriverLastDARTCallNoAds[slotname] = true
			 *
			 * We're handling this here.
			 */
			if (window.adDriverLastDARTCallNoAds && window.adDriverLastDARTCallNoAds[slotname]) {
				log(slotname + ' was not filled by DART', 2, logGroup);
				cacheStorage.set(noAdStorageKey, true, forgetAdsShownAfterTime, now);

				// Track hop time
				hopTime = new Date().getTime() - hopTimer;
				log('slotTimer2 end for ' + slotname + ' after ' + hopTime + ' ms', 7, logGroup);
				WikiaTracker.trackAdEvent('liftium.hop2', {
					ga_category: 'hop2/addriver2',
					ga_action: 'slot ' + slotname,
					ga_label: formatTrackTime(hopTime, 5)
				}, 'ga');

				error();
			} else {
				log(slotname + ' was filled by DART', 5, logGroup);
				success();
			}
		});
	};

	formatTrackTime = function(t, max) {
		if (isNaN(t)) {
			log('Error, time tracked is NaN: ' + t, 7, logGroup);
			return "NaN";
		}

		if (t < 0) {
			log('Error, time tracked is a negative number: ' + t, 7, logGroup);
			return "negative";
		}

		t = t / 1000;
		if (t > max) {
			return "more_than_" + max;
		}

		return t.toFixed(1);
	};

	return {
		name: 'AdDriver2',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
