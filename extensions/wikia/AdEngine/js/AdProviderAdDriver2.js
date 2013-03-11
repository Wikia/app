// TODO: move Wikia.Tracker outside

var AdProviderAdDriver2 = function (wikiaDart, scriptWriter, tracker, log, window, Geo, slotTweaker, cacheStorage, adLogicHighValueCountry, adLogicDartSubdomain, abTest, wikiaGpt) {
	'use strict';

	var logGroup = 'AdProviderAdDriver2',
		slotMap,
		forgetAdsShownAfterTime = 3600, // an hour
		incrementItemInStorage,
		fillInSlot,
		canHandleSlot,
		formatTrackTime,
		country = Geo.getCountryCode(),
		now = window.wgNow || new Date(),
		maxCallsToDART,
		isHighValueCountry;

	maxCallsToDART = adLogicHighValueCountry.getMaxCallsToDART(country);
	isHighValueCountry = adLogicHighValueCountry.isHighValueCountry(country);

	// TODO: tile is not used, keys without apostrophes

	slotMap = {
		'CORP_TOP_LEADERBOARD': {'size': '728x90,468x60,980x130,1030x130,1030x70,1x1', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'CORP_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,1x1', 'tile': 1, 'loc': 'top'},
		'EXIT_STITIAL_BOXAD_1': {'size': '600x400,300x250,1x1', 'tile': 2, 'loc': "exit"},
		'HOME_TOP_LEADERBOARD': {'size': '728x90,468x60,980x130,1030x130,1030x70,1x1', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,1x1', 'tile': 1, 'loc': 'top'},
		'HUB_TOP_LEADERBOARD': {'size': '728x90,468x60,980x130,1030x130,1030x70,1x1', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'LEFT_SKYSCRAPER_2': {'size': '160x600,120x600,1x1', 'tile': 3, 'loc': 'middle'},
		'LEFT_SKYSCRAPER_3': {'size': '160x600,1x1', 'tile': 6, 'loc': 'footer'},
		'MODAL_INTERSTITIAL': {'size': '600x400,300x250,1x1', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_1': {'size': '600x400,300x250,1x1', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_2': {'size': '600x400,300x250,1x1', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_3': {'size': '600x400,300x250,1x1', 'tile': 2, 'loc': 'modal'},
		'MODAL_INTERSTITIAL_4': {'size': '600x400,300x250,1x1', 'tile': 2, 'loc': 'modal'},
		'MODAL_RECTANGLE': {'size': '300x100,1x1', 'tile': 2, 'loc': 'modal'},
		'TEST_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,1x1', 'tile': 1, 'loc': 'top'},
		'TEST_HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,1x1', 'tile': 1, 'loc': 'top'},
		'TOP_LEADERBOARD': {'size': '728x90,468x60,980x130,1030x130,1030x70,1x1', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x100,1x1', 'tile': 1, 'loc': 'top'},
		'WIKIA_BAR_BOXAD_1': {'size': '320x50,1x1', 'tile': 4, 'loc': 'bottom'}
	};

	incrementItemInStorage = function (storageKey) {
		log('incrementNumCall ' + storageKey, 5, logGroup);

		var numCallForSlot = cacheStorage.get(storageKey, now) || 0;

		numCallForSlot += 1;
		cacheStorage.set(storageKey, numCallForSlot, forgetAdsShownAfterTime, now);

		return numCallForSlot;
	};

	canHandleSlot = function (slotinfo) {
		log(['canHandleSlot', slotinfo], 5, logGroup);

		if (slotMap[slotinfo[0]]) {
			return true;
		}
		return false;
	};

	fillInSlot = function (slot) {
		log(['fillInSlot', slot], 5, logGroup);

		var slotname = slot[0],

			slotsize = slotMap[slotname].size,
			loc = slotMap[slotname].loc,
			dcopt = slotMap[slotname].dcopt,
			ord,

			// Do this when DART hops or doesn't handle
			error = function () {
				slot[2] = 'Liftium2';
				window.adslots2.push(slot);
			},

			// Do this when filling slot by DART
			success = function () {
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
			},

			noAdStorageKey = 'dart_noad_' + slotname,
			numCallForSlotStorageKey = 'dart_calls_' + slotname,

			noAdLastTime = cacheStorage.get(noAdStorageKey, now) || false,
			numCallForSlot = cacheStorage.get(numCallForSlotStorageKey, now) || 0,
			url,

			hopTimer,
			hopTime,
			inLeaderboardTest = abTest && abTest.getGroup('LEADERBOARD_TESTS'),
			inMedRecTest = abTest && abTest.getGroup('MEDREC_TESTS'),
			inSkinTest = abTest && abTest.getGroup('SKIN_TESTS');

		// Always have an ad when user is in a relevant AB experiment
		if (!(inLeaderboardTest && slotname === 'TOP_LEADERBOARD')
				&& !(inMedRecTest && slotname === 'TOP_RIGHT_BOXAD')
				&& !(inSkinTest && slotname === 'TOP_LEADERBOARD')
				) {
			if (!isHighValueCountry) {
				error();
				return;
			}

			// Always have an ad for MODAL_INTERSTITIAL
			if (!slotname.match(/^MODAL_INTERSTITIAL/)) {
				// Otherwise check if there was ad last time
				// If not, check if desired number of DART calls were made
				if (noAdLastTime && numCallForSlot >= maxCallsToDART) {
					log('There was no ad for this slot last time and reached max number of calls to DART', 5, logGroup);
					log({slot: slotname, numCalls: numCallForSlot, maxCalls: maxCallsToDART, geo: country}, 6, logGroup);
					error();
					return;
				}
			}
		}

		// Don't show skin ads for logged in users
		if (window.wgUserName && !window.wgUserShowAds) {
			dcopt = false;
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

		if (window.wgAdDriverUseGpt) {
			// Use the new GPT library:

			wikiaGpt.pushAd({
				slotname: slotname,
				slotsize: slotsize,
				dcopt: dcopt,
				loc: loc
			}, function () {
				// TODO: detect success and hop situations and handle them

				success();
			});
		} else {
			// Legacy DART call:

			// Random ord for MODAL_INTERSTITIAL
			// This disables synchronisation of Lightbox ads, but allows ads to repeat
			if (slotname.match(/^MODAL_INTERSTITIAL/)) {
				ord = Math.floor(Math.random() * 100000000000);
			}

			url = wikiaDart.getUrl({
				slotname: slotname,
				slotsize: slotsize,
				subdomain: adLogicDartSubdomain.getSubdomain(),
				dcopt: dcopt,
				loc: loc,
				ord: ord
			});

			scriptWriter.injectScriptByUrl(slotname, url, function () {
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
					tracker.track({
						eventName: 'liftium.hop2',
						ga_category: 'hop2/addriver2',
						ga_action: 'slot ' + slotname,
						ga_label: formatTrackTime(hopTime, 5),
						trackingMethod: 'ad'
					});

					error();
				} else {
					log(slotname + ' was filled by DART', 5, logGroup);
					success();
				}
			});
		}
	};

	formatTrackTime = function (t, max) {
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
