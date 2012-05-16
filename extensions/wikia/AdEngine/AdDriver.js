/* requires jquery */
/* requires AdEngine.js */
/* requires Liftium.js */
/* requires extensions/wikia/AdEngine/ghost */

///// BEGIN AdDriver
var AdDriver = {
	adProviderAdDriver: 'AdDriver',
	adProviderDart: 'DART',
	adProviderLiftium: 'Liftium',
	classNameDefaultHeight: 'default-height',
	storageNameNumAllCall: 'adDriverNumAllCall',
	storageNameNumDARTCall: 'adDriverNumDARTCall',
	storageNameLastDARTCallNoAd: 'adDriverLastDARTCallNoAd',
	country: '',
	debug: false,
	minNumDARTCall: 3,
	paramLiftiumTag: 'liftium_tag',
	standardLeaderboardMinHeight: 90,
	standardLeaderboardMaxHeight: 95,
	standardTopButtonMinHeight: 100,

	getMinNumDARTCall: function(country) {
		country = country.toUpperCase();
		if (country in window.wgHighValueCountries) {
			return window.wgHighValueCountries[country];
		}
		else {
			return AdDriver.minNumDARTCall;
		}
	},

	init: function() {
		window.adDriverLastDARTCallNoAds = [];
		window.adDriverAdCallComplete = [];
		AdDriver.debug = parseInt($.getUrlVar('debug'));
	},

	log: function(msg) {
		if (AdDriver.debug) {
			$().log('AdDriver: ' + msg);
		}
	}
}

AdDriver.getAdProviderForSpecialCase = function(slotname) {
	switch (wgDBname) {
		case 'geekfeminism':
		case 'kinkontap':
		case 'lostpedia':
		case 'sexpositive':
		case 'wswiki':
			return AdDriver.adProviderLiftium;
			break;
		case 'cookbook_import':
			//switch (slotname) {
				//case 'LEFT_SKYSCRAPER_2':
				//case 'LEFT_SKYSCRAPER_3':
				//case 'TOP_RIGHT_BOXAD':
					//return 'NO-AD';
					//break;
				//default:
					//return 'Liftium';
			//}
			break;
		default:
	}

	// Answers sites
	if (window.wgEnableWikiAnswers) {
		return AdDriver.adProviderLiftium;
	}

	switch (slotname) {
		case 'MIDDLE_RIGHT_BOXAD':
			// currently MIDDLE_RIGHT_BOXAD is reserved for partner widgets
			// (e.g. eBay search). Don't make ad call if prerequisites aren't
			// met
			if (typeof window.partnerKeywords == 'undefined' || !window.partnerKeywords) {
				return 'NO-AD';
			}
			break;
		default:
	}

	return '';
}

AdDriver.isHighValue = function(slotname) {
	if (AdConfig.isHighValueSlot(slotname)) {
		// FogBugz 9953: Liftium.geo may have country data when AdConfig.geo does not
		// Read from Liftium.geo first
		if (Liftium.geo) {
			AdDriver.country = Liftium.geo.country;
		}
		else if (AdConfig.geo) {
			AdDriver.country = AdConfig.geo.country;
		}

		if (AdDriver.country) {
			return AdConfig.isHighValueCountry(AdDriver.country);
		}
		else {
			WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "error", "no_geo"]), 'liftium.varia'); // FIXME NEF should be liftium.errors but the volume is too heavy...
		}
	}

	return false;
}

AdDriver.getNumDARTCall = function(slotname) {
	var num = 0;

	num = AdDriver.getNumCall(AdDriver.storageNameNumDARTCall, slotname);
	AdDriver.log(slotname + ' has ' + num + ' DART calls');

	return num;
}

AdDriver.getNumAllCall = function(slotname) {
	var num = 0;

	num = AdDriver.getNumCall(AdDriver.storageNameNumAllCall, slotname);

	return num;
}

AdDriver.getNumCall = function(storageName, slotname) {
	var storageNum = 0,
		cookieNum = 0,
		numCallStorage;

	try {
		if (window.wgAdDriverUseExpiryStorage) {
			numCallStorage = $.expiryStorage.get(storageName);
			storageNum = AdDriver.getNumCallFromStorageContents(numCallStorage, slotname);
		}

		if (window.wgAdDriverUseCookie) {
			numCallStorage = $.cookies.get(storageName);
			cookieNum = AdDriver.getNumCallFromStorageContents(numCallStorage, slotname);
		}

		if (window.wgAdDriverUseExpiryStorage && window.wgAdDriverUseCookie) {
			// compare and report error if they're not equal
			if (storageNum != cookieNum) {
				WikiaTracker.track([LiftiumOptions.pubid, "error", "numcalloutofsync", storageName, slotname, window.wgDBname, storageNum, cookieNum], 'liftium.errors');
				AdDriver.log('Cookie and ExpiryStorage for ' + storageName + ':' + slotname + ' are out of sync!');
				AdDriver.log('Cookie contents: ' + cookieNum);
				AdDriver.log('ExpiryStogage contents: ' + storageNum);
			}
		}
	}
	catch (e) {
		AdDriver.log(e.message);
	}

	return window.wgAdDriverUseExpiryStorage ? storageNum : cookieNum;
}

AdDriver.getNumCallFromStorageContents = function(numCallStorage, slotname) {
	var num = 0;

	if (typeof(numCallStorage) != 'undefined' && numCallStorage) {
		var slotnameObjs = JSON.parse(numCallStorage);
		for (var i = 0; i < slotnameObjs.length; i++) {
			if (slotnameObjs[i].slotname == slotname) {
				if (parseInt(slotnameObjs[i].ts) + window.wgAdDriverCookieLifetime*3600000 > window.wgNow.getTime()) {	// wgAdDriverCookieLifetime in hours, convert to msec
					num = parseInt(slotnameObjs[i].num);
					break;
				}
			}
		}
	}

	return num;
}

AdDriver.incrementNumDARTCall = function(slotname) {
	return AdDriver.incrementNumCall(AdDriver.storageNameNumDARTCall, slotname);
}

AdDriver.incrementNumAllCall = function(slotname) {
	return AdDriver.incrementNumCall(AdDriver.storageNameNumAllCall, slotname);
}

AdDriver.incrementNumCall = function(storageName, slotname) {

	var newSlotnameObjs = new Array();
	var numInStorage = 0;
	var numInCookie = 0;
	var timestamp = window.wgNow.getTime();
	var slotnameInStorage = false;

	if (window.wgAdDriverUseExpiryStorage) {
		try {
			var numCallStorage = $.expiryStorage.get(storageName);
			var incrementResult = AdDriver.incrementStorageContents(numCallStorage, slotname);
			slotnameInStorage = incrementResult.slotnameInStorage;
			numInStorage = incrementResult.num;
			newSlotnameObjs = incrementResult.newSlotnameObjs;
		}
		catch (e) {
			AdDriver.log(e.message);
		}

		if (!slotnameInStorage) {
			newSlotnameObjs.push( {slotname : slotname, num : ++numInStorage, ts : timestamp} );
		}

		$.expiryStorage.set(storageName, $.toJSON(newSlotnameObjs), window.wgAdDriverCookieLifetime*3600000);	// wgAdDriverCookieLifetime expressed in hours
	}

	if (window.wgAdDriverUseCookie) {
		newSlotnameObjs = new Array();
		slotnameInStorage = false;

		try {
			var numCallStorage = $.cookies.get(storageName);
			var incrementResult = AdDriver.incrementStorageContents(numCallStorage, slotname);
			slotnameInStorage = incrementResult.slotnameInStorage;
			numInCookie = incrementResult.num;
			newSlotnameObjs = incrementResult.newSlotnameObjs;
		}
		catch (e) {
			AdDriver.log(e.message);
		}

		if (!slotnameInStorage) {
			newSlotnameObjs.push( {slotname : slotname, num : ++numInCookie, ts : timestamp} );
		}

		var cookieOptions = {hoursToLive: window.wgAdDriverCookieLifetime, path: wgCookiePath};	// do not set cookie domain
		$.cookies.set(storageName, $.toJSON(newSlotnameObjs), cookieOptions);
	}

	return window.wgAdDriverUseExpiryStorage ? numInStorage : numInCookie;
}

AdDriver.incrementStorageContents = function(numCallStorage, slotname) {
	var newSlotnameObjs = new Array();
	var num = 0;
	var slotnameInStorage = false;
	var timestamp = window.wgNow.getTime();

	if (typeof(numCallStorage) != 'undefined' && numCallStorage) {
		var slotnameObjs = JSON.parse(numCallStorage);
		for (var i = 0; i < slotnameObjs.length; i++) {
			if (slotnameObjs[i].slotname == slotname) {
				slotnameInStorage = true;
				if (parseInt(slotnameObjs[i].ts) + window.wgAdDriverCookieLifetime*3600000 > window.wgNow.getTime()) {	// wgAdDriverCookieLifetime in hours, convert to msec
					num = parseInt(slotnameObjs[i].num);
					timestamp = parseInt(slotnameObjs[i].ts);
				}
				newSlotnameObjs.push( {slotname : slotname, num : ++num, ts : timestamp} );
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

AdDriver.isLastDARTCallNoAd = function(slotname) {
	var storageValue = false;
	var cookieValue = false;

	try {
		if (window.wgAdDriverUseExpiryStorage) {
			var lastDARTCallNoAdStorage = $.expiryStorage.get(AdDriver.storageNameLastDARTCallNoAd);
			storageValue = AdDriver.getLastDARTCallNoAdFromStorageContents(lastDARTCallNoAdStorage, slotname);
		}

		if (window.wgAdDriverUseCookie) {
			var lastDARTCallNoAdCookie = $.cookies.get(AdDriver.storageNameLastDARTCallNoAd);
			cookieValue = AdDriver.getLastDARTCallNoAdFromStorageContents(lastDARTCallNoAdCookie, slotname);
		}

		if (window.wgAdDriverUseExpiryStorage && window.wgAdDriverUseCookie) {
			if (storageValue != cookieValue) {
				WikiaTracker.track([LiftiumOptions.pubid, "error", "lastdartcallnoadoutofsync", slotname, window.wgDBname], 'liftium.errors');
			}
		}
	}
	catch (e) {
		AdDriver.log(e.message);
	}

	AdDriver.log(slotname + ' last DART call had no ad? ' + (window.wgAdDriverUseExpiryStorage ? storageValue : cookieValue));

	return window.wgAdDriverUseExpiryStorage ? storageValue : cookieValue;
}

AdDriver.getLastDARTCallNoAdFromStorageContents = function(lastDARTCallNoAdStorage, slotname) {
	var value = false;

	if (typeof(lastDARTCallNoAdStorage) != 'undefined' && lastDARTCallNoAdStorage) {
		var slotnameTimestamps = JSON.parse(lastDARTCallNoAdStorage);
		for (var i = 0; i < slotnameTimestamps.length; i++) {
			if (slotnameTimestamps[i].slotname == slotname) {
				if (parseInt(slotnameTimestamps[i].ts) + window.wgAdDriverCookieLifetime*3600000 > window.wgNow.getTime()) {	// wgAdDriverCookieLifetime in hours, convert to msec
					value = true;
				}
				break;
			}
		}
	}

	return value;
}

AdDriver.setLastDARTCallNoAd = function(slotname, value) {
	var newSlotnameTimestamps = new Array();
	var slotnameInStorage = false;

	if (window.wgAdDriverUseExpiryStorage) {
		try {
			var lastDARTCallNoAdStorage = $.expiryStorage.get(AdDriver.storageNameLastDARTCallNoAd);
			var setResult = AdDriver.setLastDARTCallNoAdInStorageContents(lastDARTCallNoAdStorage, slotname, value);
			newSlotnameTimestamps = setResult.newSlotnameTimestamps;
			slotnameInStorage = setResult.slotnameInStorage;
		}
		catch (e) {
			AdDriver.log(e.message);
		}

		if (value && !slotnameInStorage) {
			newSlotnameTimestamps.push( {slotname: slotname, ts: value} );
		}

		if (newSlotnameTimestamps.length) {
			$.expiryStorage.set(AdDriver.storageNameLastDARTCallNoAd, $.toJSON(newSlotnameTimestamps), window.wgAdDriverCookieLifetime*3600000);
		}
	}

	if (window.wgAdDriverUseCookie) {
		var newSlotnameTimestamps = new Array();
		var slotnameInStorage = false;
		try {
			var lastDARTCallNoAdCookie = $.cookies.get(AdDriver.storageNameLastDARTCallNoAd);
			var setResult = AdDriver.setLastDARTCallNoAdInStorageContents(lastDARTCallNoAdCookie, slotname, value);
			newSlotnameTimestamps = setResult.newSlotnameTimestamps;
			slotnameInStorage = setResult.slotnameInStorage;
		}
		catch (e) {
			AdDriver.log(e.message);
		}

		if (value && !slotnameInStorage) {
			newSlotnameTimestamps.push( {slotname: slotname, ts: value} );
		}

		if (newSlotnameTimestamps.length) {
			var cookieOptions = {hoursToLive: window.wgAdDriverCookieLifetime, path: wgCookiePath};	// do not set cookie domain
			$.cookies.set(AdDriver.storageNameLastDARTCallNoAd, $.toJSON(newSlotnameTimestamps), cookieOptions);
		}
	}

	return value;
}

AdDriver.setLastDARTCallNoAdInStorageContents = function(lastDARTCallNoAdStorage, slotname, value) {
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

AdDriver.adjustSlotDisplay = function(slotname) {
	switch (slotname) {
		case 'CORP_TOP_LEADERBOARD':
		case 'HOME_TOP_LEADERBOARD':
		case 'HUB_TOP_LEADERBOARD':
		case 'TOP_LEADERBOARD':
			$('#'+slotname).removeClass(AdDriver.classNameDefaultHeight);
			// if jumbo/expanding leaderboard, center ad
			if (($('#'+slotname).height() >= 0 && $('#'+slotname).height() < AdDriver.standardLeaderboardMinHeight) // expandable leaderboard, minimized state
			|| $('#'+slotname).height() > AdDriver.standardLeaderboardMaxHeight) { // jumbo leaderboard or expandable leaderboard, maximized state
				$('#'+slotname).addClass('jumbo-leaderboard');
				$('#WikiaTopAds').removeClass('WikiaTopButtonLeft WikiaTopButtonRight');
				AdDriverDelayedLoader.removeItemsBySlotname('TOP_BUTTON');
			}
			return true;
			break;
		case 'CORP_TOP_RIGHT_BOXAD':
		case 'HOME_TOP_RIGHT_BOXAD':
		case 'TEST_HOME_TOP_RIGHT_BOXAD':
		case 'TEST_TOP_RIGHT_BOXAD':
		case 'TOP_RIGHT_BOXAD':
		case 'PREFOOTER_LEFT_BOXAD':
		case 'PREFOOTER_RIGHT_BOXAD':
			$('#'+slotname).removeClass(AdDriver.classNameDefaultHeight);
			return true;
			break;
		case 'HOME_TOP_RIGHT_BUTTON':
			if ($('#'+slotname).height() >= AdDriver.standardTopButtonMinHeight) {
				$('#'+slotname).addClass('home-top-right-button-visible');
			}
			break;

	}

	return false;
}

AdDriver.canCallLiftium = function(slotname) {
	switch (slotname) {
		case 'HOME_INVISIBLE_TOP':
		case 'HUB_TOP_LEADERBOARD':
		case 'INVISIBLE_MODAL':
		case 'INVISIBLE_TOP':
		case 'MIDDLE_RIGHT_BOXAD':
		case 'MODAL_VERTICAL_BANNER':
			return false;
			break;
	}

	return true;
}

AdDriver.doesUrlParameterExist = function(param) {
	if ($.getUrlVar(param) != null) {
		return true;
	}

	return false;
}

AdDriver.isForceLiftium = function() {
	var forceLiftiumParams = new Array(AdDriver.paramLiftiumTag);

	for (var i=0; i<forceLiftiumParams.length; i++) {
		if (AdDriver.doesUrlParameterExist(forceLiftiumParams[i])) {
			return true;
		}
	}

	return false;
}

AdDriver.getAdProvider = function(slotname, size, defaultAdProvider) {
	if (AdDriver.isForceLiftium()) {
		return AdDriver.adProviderLiftium;
	}

	var specialCaseAdProvider = AdDriver.getAdProviderForSpecialCase(slotname);
	if (specialCaseAdProvider) {
		return specialCaseAdProvider;
	}

	if (defaultAdProvider == AdDriver.adProviderLiftium) {
		return AdDriver.adProviderLiftium;
	}

	if (AdDriver.isHighValue(slotname)) {
		if (AdDriver.getNumDARTCall(slotname) < AdDriver.getMinNumDARTCall(AdDriver.country) || !AdDriver.isLastDARTCallNoAd(slotname)) {
			return AdDriver.adProviderDart;
		}
	}

	return AdDriver.adProviderLiftium;
}

AdDriver.init();
//// END AdDriver

//// BEGIN AdDriverDelayedLoaderItem
var AdDriverDelayedLoaderItem = function (slotname, size, defaultAdProvider) {
	this.clientWidth = 0;
	this.clientHeight = 0;
	this.hasPrefooters = null;
	this.slotname = slotname;
	this.size = size;
	this.defaultAdProvider = defaultAdProvider;
	this.dartUrl = null;
	// do not generate DART url until it is needed. This allows
	// for last-minute reordering of slots, and correct value of tile
	this.getDARTUrl = function (){
		if (!this.dartUrl) {
			this.dartUrl = AdConfig.DART.getUrl(slotname, size, false, AdDriver.adProviderAdDriver);
		}

		return this.dartUrl;
	};
}
//// END AdDriverDelayedLoaderItem

//// BEGIN AdDriverDelayedLoader
var AdDriverDelayedLoader = {
	adDriverItems: null,
	adNum: 0,
	currentAd: null,
	currentSlot: null,
	highLoadPriorityFloor: 11,
	runFinalize: false,
	started: false,
	init: function(adDriverItems) {
		AdDriverDelayedLoader.adDriverItems = adDriverItems ? adDriverItems : new Array();
		AdDriverDelayedLoader.adNum = 0;
		AdDriverDelayedLoader.currentAd = null;
		AdDriverDelayedLoader.currentSlot = null;
		AdDriverDelayedLoader.runFinalize = false;
		AdDriverDelayedLoader.started = false;
	}
}

AdDriverDelayedLoader.init();

AdDriverDelayedLoader.appendItem = function(adDriverItem) {
	AdDriverDelayedLoader.adDriverItems.push(adDriverItem);
}

AdDriverDelayedLoader.prependItem = function(adDriverItem) {
	AdDriverDelayedLoader.adDriverItems.unshift(adDriverItem);
}

AdDriverDelayedLoader.removeItemsBySlotname = function(slotname) {
	// iterate through AdDriverDelayedLoader.adDriverItems and look for
	// items to remove. Remove the highest index first
	var itemIdxs = [];
	for (var i=0; i < AdDriverDelayedLoader.adDriverItems.length; i++) {
		if (slotname == AdDriverDelayedLoader.adDriverItems[i].slotname) {
			itemIdxs.unshift(i);
		}
	}
	for (var i=0; i < itemIdxs.length; i++) {
		AdDriverDelayedLoader.adDriverItems.splice(itemIdxs[i], 1);
	}
}

AdDriverDelayedLoader.callDART = function() {
	AdDriver.log(AdDriverDelayedLoader.currentAd.slotname + ': calling DART...');
	AdDriver.incrementNumDARTCall(AdDriverDelayedLoader.currentAd.slotname);
	AdDriver.setLastDARTCallNoAd(AdDriverDelayedLoader.currentAd.slotname, null);
	var slot = document.getElementById(AdDriverDelayedLoader.currentAd.slotname);
	ghostwriter(
		slot,
		{
			insertType: "append",
			script: {src: AdDriverDelayedLoader.currentAd.getDARTUrl()},
			done: function() {

				ghostwriter.flushloadhandlers();

				var nextAdProvider = null;

				if (typeof(window.adDriverLastDARTCallNoAds[AdDriverDelayedLoader.currentAd.slotname]) == 'undefined' || !window.adDriverLastDARTCallNoAds[AdDriverDelayedLoader.currentAd.slotname]) {
					AdDriver.log(AdDriverDelayedLoader.currentAd.slotname + ' was filled by DART');
					AdDriver.adjustSlotDisplay(AdDriverDelayedLoader.currentAd.slotname);
				}
				else {
					AdDriver.log(AdDriverDelayedLoader.currentAd.slotname + ' was not filled by DART');
					AdDriver.setLastDARTCallNoAd(AdDriverDelayedLoader.currentAd.slotname, window.wgNow.getTime());
					if (AdDriver.canCallLiftium(AdDriverDelayedLoader.currentAd.slotname)) {
						nextAdProvider = AdDriver.adProviderLiftium;
					}
				}

				if (nextAdProvider == AdDriver.adProviderLiftium) {
					var liftiumItem = new AdDriverDelayedLoaderItem(AdDriverDelayedLoader.currentAd.slotname, AdDriverDelayedLoader.currentAd.size, AdDriver.adProviderLiftium);
					AdDriverDelayedLoader.prependItem(liftiumItem);
				}
				else {
					// track ad call in Google Analytics, for forecasting.
					// Track only calls that do not fall back to Liftium.
					// (Those calls will be tracked by Liftium.)
					// Based on Liftium.callInjectedIframeAd
					WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "slot", AdDriverDelayedLoader.currentAd.size+ "_" + AdDriverDelayedLoader.currentAd.slotname]) + '/addriver', 'liftium.slot');
				}
				AdDriverDelayedLoader.loadNext();
			}
		}
	);
}

AdDriverDelayedLoader.getPlaceHolderIframeScript = function(slotname, size) {
	var dims = size.split('x');
	return "document.write('<div id=\"Liftium_"+size+"_"+(++AdDriverDelayedLoader.adNum)+"\"><iframe width=\""+dims[0]+"\" height=\""+dims[1]+"\" id=\""+escape(slotname)+"_iframe\" noresize=\"true\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"border:none;\" target=\"_blank\"></iframe><div>');";
}

AdDriverDelayedLoader.getLiftiumCallScript = function(slotname, size) {
	var script = '';

	if (slotname in AdConfig.adSlotsRequiringJSInvocation) {
		script = 'Liftium.callAd("'+size+'");';
	}
	else {
		script = AdDriverDelayedLoader.getPlaceHolderIframeScript(slotname, size);
		script += 'Liftium.callInjectedIframeAd("'+size+'", document.getElementById("'+escape(slotname)+'_iframe"));';
	}

	return script;
}

AdDriverDelayedLoader.callLiftium = function() {
	var slotname = AdDriverDelayedLoader.currentAd.slotname;

	if (!AdDriver.canCallLiftium(slotname)) {
		AdDriverDelayedLoader.loadNext();
		return;
	}

	AdDriver.log(slotname + ': calling Liftium...');

	var size = AdDriverDelayedLoader.currentAd.size;
	LiftiumOptions.placement = slotname;

	try {
		var script = AdDriverDelayedLoader.getLiftiumCallScript(slotname, size);
		var slot = document.getElementById(slotname);
		ghostwriter(
			slot,
			{
				insertType: "append",
				script: {text: script},
				done: function() {
					ghostwriter.flushloadhandlers();
					AdDriver.adjustSlotDisplay(slotname);
					AdDriverDelayedLoader.loadNext();
				}
			}
		);
	}
	catch (e) {
		AdDriver.log(e.message);
		AdDriverDelayedLoader.loadNext();
	}
}

AdDriverDelayedLoader.loadNext = function() {
	if (AdDriverDelayedLoader.adDriverItems.length) {
		AdDriverDelayedLoader.currentAd = AdDriverDelayedLoader.adDriverItems.shift();
		if (AdEngine.isSlotDisplayableOnCurrentPage(AdDriverDelayedLoader.currentAd.slotname)) {
			var adProvider = AdDriver.getAdProvider(AdDriverDelayedLoader.currentAd.slotname, AdDriverDelayedLoader.currentAd.size, AdDriverDelayedLoader.currentAd.defaultAdProvider);

			// increment number of pageviews
			if (adProvider == AdDriver.adProviderDart || adProvider == AdDriver.adProviderLiftium) {
				if (AdDriverDelayedLoader.currentSlot != AdDriverDelayedLoader.currentAd.slotname) {
					AdDriver.incrementNumAllCall(AdDriverDelayedLoader.currentAd.slotname);
					AdDriverDelayedLoader.currentSlot = AdDriverDelayedLoader.currentAd.slotname;
				}
			}

			if (adProvider == AdDriver.adProviderDart) {
				AdDriverDelayedLoader.callDART();
			}
			else if (adProvider == AdDriver.adProviderLiftium) {
				AdDriverDelayedLoader.callLiftium();
			}
			else {
				AdDriverDelayedLoader.loadNext();
			}
		}
		else {
			// hide slot and load next one
			$('#' + AdDriverDelayedLoader.currentAd.slotname).css("display", "none");
			AdDriverDelayedLoader.loadNext();
		}
	}
	else {
		var tgId = getTreatmentGroup(EXP_AD_LOAD_TIMING);
		if (window.wgLoadAdDriverOnLiftiumInit || tgId == TG_AS_WRAPPERS_ARE_RENDERED) {
			if (AdDriverDelayedLoader.runFinalize) {
				AdDriverDelayedLoader.finalize();
			}						
		}
		else {
			AdDriverDelayedLoader.finalize();
		}
	}

	if (!AdDriverDelayedLoader.adDriverItems.length && typeof Liftium != 'undefined' && Liftium) {
		Liftium.hasMoreCalls = 0;
	}
}

// This functions reorders the queue of slots so that TOP_LEADERBOARD and
// TOP_RIGHT_BOXAD are first. It does not guarantee the order of the rest of
// the slots.
AdDriverDelayedLoader.reorderItems = function() {
	var highPriorityItems = ['TOP_LEADERBOARD', 'TOP_RIGHT_BOXAD'];
	var tmpItems = [];
	for (var i=0; i<AdDriverDelayedLoader.adDriverItems.length; i++) {
		var foundHighPriorityItem = false;
		for (var j=0; j<highPriorityItems.length; j++) {
			if (AdDriverDelayedLoader.adDriverItems[i].slotname.indexOf(highPriorityItems[j]) > -1) {
				// we have a high priority item. make sure TOP_LEADERBOARD is first in the reordered queue
				if (tmpItems.length && tmpItems[0].slotname.indexOf('TOP_LEADERBOARD') > -1) {
					tmpItems.splice(1, 0, AdDriverDelayedLoader.adDriverItems[i]);
				}
				else {
					tmpItems.unshift(AdDriverDelayedLoader.adDriverItems[i]);
				}
				foundHighPriorityItem = true;
				break;
			}
		}
		if (!foundHighPriorityItem) {
			tmpItems.push(AdDriverDelayedLoader.adDriverItems[i]);
		}
	}

	AdDriverDelayedLoader.adDriverItems = tmpItems;
}

// Move slots from the window.adslots buffer to AdDriverDelayedLoader's internal
// queue. Slots that are moved are based on load priority. After all eligible
// slots are moved. process internal queue.
// @param int loadPriorityFloor process slots with a minimum load priority
AdDriverDelayedLoader.prepareSlots = function(loadPriorityFloor) {
	if (!AdDriverDelayedLoader.isRunning()) {
		AdDriverDelayedLoader.reset();
	}

	var slots;
	while (slots = AdDriverDelayedLoader.getNextSlotFromBuffer(loadPriorityFloor)) {
		var slot = slots[0];
		AdDriverDelayedLoader.appendItem(new AdDriverDelayedLoaderItem(slot[0], slot[1], slot[2]));
	}	
	
	if (!AdDriverDelayedLoader.started) {
		AdDriverDelayedLoader.load();
	}
}

// Get highest priority slot from buffer and remove. Destructively changes 
// window.adslots
// @param int loadPriorityFloor 
// 
AdDriverDelayedLoader.getNextSlotFromBuffer = function(loadPriorityFloor) {
	var highestPriority = -1;
	var highestPriorityIndex = -1;
	for (var i=0; i<window.adslots.length; i++) {
		if (window.adslots[i][3] >= loadPriorityFloor) {
			if (window.adslots[i][3] > highestPriority) {
				highestPriority = window.adslots[i][3];
				highestPriorityIndex = i;
			}			
		}
	}	
	
	if (highestPriorityIndex >= 0) {
		return window.adslots.splice(highestPriorityIndex, 1);
	}
	
	return null;
}

AdDriverDelayedLoader.load = function() {
	AdDriverDelayedLoader.started = true;

	// Temporary AdDriver tracking by Inez
	if((typeof abBeingTracked != "undefined") && (typeof abBeingTracked[EXP_AD_LOAD_TIMING] != "undefined") && abBeingTracked[EXP_AD_LOAD_TIMING]){
		$.internalTrack( 'AdDriver', { pos: 'start' } );
	}

	if (typeof wgNow != 'undefined' && AdDriverDelayedLoader.adDriverItems.length) {
		var loadTime = (new Date()).getTime() - wgNow.getTime();
		$().log('AdDriver started loading after ' + loadTime + ' ms');
	}

	// there used to be a check for no-ad wikis here. In practice, no-ad wikis
	// have wgShowAds set to false, so this function will never execute

	AdDriverDelayedLoader.reorderItems();

	AdDriverDelayedLoader.loadNext();
}

AdDriverDelayedLoader.reset = function() {
	AdDriverDelayedLoader.init();
}

AdDriverDelayedLoader.isRunning = function() {
	return AdDriverDelayedLoader.started && AdDriverDelayedLoader.adDriverItems.length;
}

AdDriverDelayedLoader.finalize = function() {

	// Temporary AdDriver tracking by Inez
	if((typeof abBeingTracked != "undefined") && (typeof abBeingTracked[EXP_AD_LOAD_TIMING] != "undefined") && abBeingTracked[EXP_AD_LOAD_TIMING]){
		$.internalTrack( 'AdDriver', { pos: 'stop' } );
	}
    
	if (window.wgEnableKruxTargeting) {
		AdDriver.log('loading krux');
		Krux.load(window.wgKruxCategoryId);
	}

	var loadTime = (new Date()).getTime() - wgNow.getTime();
	$().log('AdDriver finished at ' + loadTime + ' ms');
}
//// END AdDriverDelayedLoader

if (window.wgEnableKruxTargeting) {
	// krux ad targeting. must come before dart urls are constructed
	window.Krux||((Krux=function(){Krux.q.push(arguments)}).q=[]);
	Krux.load = function(confid){
		var k=document.createElement('script');k.type='text/javascript';k.async=true;var m,src=(m=location.href.match(/\bkxsrc=([^&]+)\b/))&&decodeURIComponent(m[1]);
		k.src=src||(location.protocol==='https:'?'https:':'http:')+'//cdn.krxd.net/controltag?confid='+confid;
		var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(k,s);
	};

	window.Krux||((Krux=function(){Krux.q.push(arguments)}).q=[]);
		(function(){
			function store(n){var m,k='kx'+n;return((m=this.localStorage)?m[k]||'':(m=document.cookie)&&(m=m.match('\\b'+k+'=([^;]*)'))&&decodeURIComponent(m[1]))||''}
			var segs = store('segs'), key = 'ksgmnt='; Krux.dartKeyValues = segs ? key+segs.split(',').join(key) + ';u='+store('user')+';' : '';
		})(); 
}

var tgId = getTreatmentGroup(EXP_AD_LOAD_TIMING);

if (!window.wgLoadAdDriverOnLiftiumInit && tgId != TG_AS_WRAPPERS_ARE_RENDERED) {
	if (window.adslots) {
		for (var i=0; i < window.adslots.length; i++) {
			AdDriverDelayedLoader.appendItem(new AdDriverDelayedLoaderItem(window.adslots[i][0], window.adslots[i][1], window.adslots[i][2]));
		}
	}
}
	
if (!window.wgLoadAdDriverOnLiftiumInit && tgId == TG_ONLOAD) {
	$(window).load(function() {
		AdDriverDelayedLoader.load();
	});
}
else {
	
	var adDriverFuncsToExecute = [];
	
	if (window.wgLoadAdDriverOnLiftiumInit || tgId == TG_AS_WRAPPERS_ARE_RENDERED) {
		adDriverFuncsToExecute.push( function () {
			window.adDriverCanInit = true;
			AdDriverDelayedLoader.prepareSlots(AdDriverDelayedLoader.highLoadPriorityFloor);
		})
		
		var prepareLowPrioritySlots = function() {
			AdDriverDelayedLoader.prepareSlots(0);
			if (!AdDriverDelayedLoader.isRunning()) {
				AdDriverDelayedLoader.finalize();
			}
			else {
				AdDriverDelayedLoader.runFinalize = true;
			}
		}
		
		$(document).ready(function() {
			if (window.adDriverCanInit === false) {
				adDriverFuncsToExecute.push(prepareLowPrioritySlots);	
			}
			else {
				prepareLowPrioritySlots();
			}
		})
	}
	else {
		adDriverFuncsToExecute.push(function() {
			AdDriverDelayedLoader.load();
		})
	}

	Liftium.init(function() {
		for(var i=0; i<adDriverFuncsToExecute.length; i++) {
			adDriverFuncsToExecute[i]()
		}
			
	});
}
