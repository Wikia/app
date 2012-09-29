var AdProviderAdDriver2 = function (ScriptWriter, WikiaTracker, log, window, document, Cookies, Geo) {
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

		if (AdDriver_isLastDARTCallNoAd(slot[0]) && AdDriver_getNumDARTCall(slot[0]) >= AdDriver_getMinNumDARTCall(Geo.getCountryCode())) {
			log('last call no ad && reached # of calls for this geo', 5, 'AdProviderAdDriver2');
			window.adslots2.push([slot[0], slot[1], 'Liftium2', slot[3]]);
			return;
		}

		// increment number of pageviews
		AdDriver_incrementNumAllCall(slot[0]);

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'addriver2'}, 'ga');

		slotTimer2[slot[0]] = new Date().getTime();
		log('slotTimer2 start for ' + slot[0], 7, 'AdProviderAdDriver2');

		AdDriver_incrementNumDARTCall(slot[0]);
		AdDriver_setLastDARTCallNoAd(slot[0], null);

		// TODO FIXME this requires AdConfig.js high in AssetManager's config.php
		var url = AdConfig.DART.getUrl(slot[0], slot[1], false, 'AdDriver');
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
					AdDriver_setLastDARTCallNoAd(slot[0], window.wgNow.getTime());

					hop(slot[0]);
				}


			}
		);
	}

	// TODO refactor...
	// AdDriver c&p begin

	function AdDriver_isLastDARTCallNoAd(slotname) {
		log('isLastDARTCallNoAd ' + slotname, 5, 'AdProviderAdDriver2');

		var cookieValue = false;

		try {
				var lastDARTCallNoAdCookie = Cookies.get('adDriverLastDARTCallNoAd');
				cookieValue = AdDriver_getLastDARTCallNoAdFromStorageContents(lastDARTCallNoAdCookie, slotname);
		}
		catch (e) {
			log(e.message, 1, 'AdProviderAdDriver2');
		}

		log(slotname + ' last DART call had no ad? ' + cookieValue, 1, 'AdProviderAdDriver2');

		return cookieValue;
	}

	function AdDriver_getLastDARTCallNoAdFromStorageContents(lastDARTCallNoAdStorage, slotname) {
		log('getLastDARTCallNoAdFromStorageContents ' + lastDARTCallNoAdStorage + ', ' + slotname, 5, 'AdProviderAdDriver2');

		var value = false;

		if (typeof(lastDARTCallNoAdStorage) != 'undefined' && lastDARTCallNoAdStorage) {
			var slotnameTimestamps = JSON.parse(lastDARTCallNoAdStorage);
			for (var i = 0; i < slotnameTimestamps.length; i++) {
				if (slotnameTimestamps[i].slotname == slotname) {
					if (parseInt(slotnameTimestamps[i].ts) + 3600 * 1000 > window.wgNow.getTime()) {
						value = true;
					}
					break;
				}
			}
		}

		return value;
	}

	function AdDriver_getNumDARTCall(slotname) {
		log('getNumDARTCall ' + slotname, 5, 'AdProviderAdDriver2');

		var num = 0;

		num = AdDriver_getNumCall('adDriverNumDARTCall', slotname);
		log(slotname + ' has ' + num + ' DART calls', 3, 'AdProviderAdDriver2');

		return num;
	}

	function AdDriver_getNumCall(storageName, slotname) {
		log('getNumCall ' + storageName + ', ' + slotname, 5, 'AdProviderAdDriver2');

		var cookieNum = 0;

		try {
				var numCallStorage = Cookies.get(storageName);
				cookieNum = AdDriver_getNumCallFromStorageContents(numCallStorage, slotname);
		}
		catch (e) {
			log(e.message, 1, 'AdProviderAdDriver2');
		}

		return cookieNum;
	}

	function AdDriver_getNumCallFromStorageContents(numCallStorage, slotname) {
		log('getNumCallFromStorageContents ' + numCallStorage + ', ' + slotname, 5, 'AdProviderAdDriver2');

		var num = 0;

		if (typeof(numCallStorage) != 'undefined' && numCallStorage) {
			var slotnameObjs = JSON.parse(numCallStorage);
			for (var i = 0; i < slotnameObjs.length; i++) {
				if (slotnameObjs[i].slotname == slotname) {
					if (parseInt(slotnameObjs[i].ts) + 3600 * 1000 > window.wgNow.getTime()) {
						num = parseInt(slotnameObjs[i].num);
						break;
					}
				}
			}
		}

		return num;
	}

	function AdDriver_getMinNumDARTCall(country) {
		log('getMinNumDARTCall ' + country, 5, 'AdProviderAdDriver2');

		country = country.toUpperCase();
		if (window.wgHighValueCountries && window.wgHighValueCountries[country]) {
			return window.wgHighValueCountries[country];
		}
		return 3;
	}

	function AdDriver_incrementNumAllCall(slotname) {
		log('incrementNumAllCall ' + slotname, 5, 'AdProviderAdDriver2');

		return AdDriver_incrementNumCall('adDriverNumAllCall', slotname);
	}

	function AdDriver_incrementNumCall(storageName, slotname) {
		log('incrementNumCall ' + storageName + ', ' + slotname, 5, 'AdProviderAdDriver2');

		var newSlotnameObjs = new Array();
		var numInCookie = 0;
		var slotnameInStorage = false;

			try {
				var numCallStorage = Cookies.get(storageName);
				var incrementResult = AdDriver_incrementStorageContents(numCallStorage, slotname);
				slotnameInStorage = incrementResult.slotnameInStorage;
				numInCookie = incrementResult.num;
				newSlotnameObjs = incrementResult.newSlotnameObjs;
			}
			catch (e) {
				log(e.message, 1, 'AdProviderAdDriver2');
			}

			if (!slotnameInStorage) {
				newSlotnameObjs.push( {slotname : slotname, num : ++numInCookie, ts : window.wgNow.getTime()} );
			}

			var cookieOptions = {hoursToLive: 1, path: '/'};	// do not set cookie domain
			Cookies.set(storageName, JSON.stringify(newSlotnameObjs), cookieOptions);

		return numInCookie;
	}

	function AdDriver_incrementStorageContents(numCallStorage, slotname) {
		log('incrementStorageContents ' + numCallStorage + ', ' + slotname, 5, 'AdProviderAdDriver2');

		var newSlotnameObjs = new Array();
		var num = 0;
		var slotnameInStorage = false;

		if (typeof(numCallStorage) != 'undefined' && numCallStorage) {
			var slotnameObjs = JSON.parse(numCallStorage);
			for (var i = 0; i < slotnameObjs.length; i++) {
				if (slotnameObjs[i].slotname == slotname) {
					slotnameInStorage = true;
					if (parseInt(slotnameObjs[i].ts) + 3600 * 1000 > window.wgNow.getTime()) {
						num = parseInt(slotnameObjs[i].num);
						timestamp = parseInt(slotnameObjs[i].ts);
					}
					newSlotnameObjs.push( {slotname : slotname, num : ++num, ts : window.wgNow.getTime()} );
				}
				else {
					newSlotnameObjs.push(slotnameObjs[i]);
				}
			}
		}

		var retObj = new Object();
		retObj.newSlotnameObjs = newSlotnameObjs;
		retObj.num = num;
		retObj.slotnameInStorage = slotnameInStorage;
		return retObj;
	}

	function AdDriver_incrementNumDARTCall(slotname) {
		log('incrementNumDARTCall ' + slotname, 5, 'AdProviderAdDriver2');

		return AdDriver_incrementNumCall('adDriverNumDARTCall', slotname);
	}

	function AdDriver_setLastDARTCallNoAd(slotname, value) {
		log('setLastDARTCallNoAd ' + slotname + ', ' + value, 5, 'AdProviderAdDriver2');

			var newSlotnameTimestamps = new Array();
			var slotnameInStorage = false;
			try {
				var lastDARTCallNoAdCookie = Cookies.get('adDriverLastDARTCallNoAd');
				var setResult = AdDriver_setLastDARTCallNoAdInStorageContents(lastDARTCallNoAdCookie, slotname, value);
				newSlotnameTimestamps = setResult.newSlotnameTimestamps;
				slotnameInStorage = setResult.slotnameInStorage;
			}
			catch (e) {
				log(e.message, 1, 'AdProviderAdDriver2');
			}

			if (value && !slotnameInStorage) {
				newSlotnameTimestamps.push( {slotname: slotname, ts: value} );
			}

			if (newSlotnameTimestamps.length) {
				var cookieOptions = {hoursToLive: 1, path: '/'};	// do not set cookie domain
				Cookies.set('adDriverLastDARTCallNoAd', JSON.stringify(newSlotnameTimestamps), cookieOptions);
			}

		return value;
	}

	function AdDriver_setLastDARTCallNoAdInStorageContents(lastDARTCallNoAdStorage, slotname, value) {
		log('setLastDARTCallNoAdInStorageContents ' + lastDARTCallNoAdStorage + ', ' + slotname + ', ' + value, 5, 'AdProviderAdDriver2');

		var slotnameInStorage = false;
		var newSlotnameTimestamps = new Array();

		if (typeof(lastDARTCallNoAdStorage) != 'undefined' && lastDARTCallNoAdStorage) {
			var slotnameTimestamps = JSON.parse(lastDARTCallNoAdStorage);
			// look for slotname. If there is a new value, change the old value. If
			// the new value is null, simply do not include slotname in updated cookie.
			for (var i = 0; i < slotnameTimestamps.length; i++) {
				if (slotnameTimestamps[i].slotname == slotname) {
					slotnameInStorage = true;
					if (value) {
						newSlotnameTimestamps.push( {slotname: slotname, ts: value} );
					}
				}
				else {
					newSlotnameTimestamps.push(slotnameTimestamps[i]);
				}
			}
		}

		var retObj = new Object();
		retObj.slotnameInStorage = slotnameInStorage;
		retObj.newSlotnameTimestamps = newSlotnameTimestamps;
		return retObj;
	}

	// AdDriver c&p end

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
