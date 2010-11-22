/* requires jquery */
/* requires Liftium.js */
/* requires extensions/wikia/Geo/geo.js */
/* requires extensions/wikia/QuantcastSegments/qcs.js */
/* requires extensions/wikia/AdEngine/ghost */
var AdDriver = {
	geoData: Geo.getGeoData(),
	minNumDARTCall: 3,
	cookieNameNumDARTCall: 'adDriverNumDARTCall',
	cookieNameLastDARTCallNoAd: 'adDriverLastDARTCallNoAd',

	init: function() {
		window.adDriverLastDARTCallNoAds = new Array();
		window.adDriverAdCallComplete = new Array();
	},

	log: function(msg) {
		$().log('AdDriver: ' + msg);
	}
}

AdDriver.isNoAdWiki = function() {
	switch (wgDB) {
		case 'diabetesindogs':
		case 'help':
		case 'lahomeless':
		case 'wikicities':
			return true;
	}

	return false;
}

AdDriver.getAdProviderForSpecialCase = function(slotname) {
	switch (wgDB) {
		case 'geekfeminism':
		case 'kinkontap':
		case 'lostpedia':
		case 'sexpositive':
		case 'wswiki':
		case 'valuewiki':
			return 'Liftium';
			break;
		case 'glee':
		case 'lyricwiki':
			switch (slotname) {
				case 'CORP_TOP_RIGHT_BOXAD':
				case 'HOME_TOP_RIGHT_BOXAD':
				case 'TOP_RIGHT_BOXAD':
					return 'Liftium';
					break;
				default:
			}
			break;
		case 'howto':
			switch (slotname) {
				case 'CORP_TOP_LEADERBOARD':
				case 'HOME_TOP_LEADERBOARD':
				case 'TOP_LEADERBOARD':
					return 'NO-AD';
					break;	
				default:
					return 'Liftium';
			}
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

	switch (skin) {
		case 'answers':
			switch (slotname) {
				case 'CORP_TOP_LEADERBOARD':
				case 'HOME_TOP_LEADERBOARD':
				case 'TOP_LEADERBOARD':
					return 'NO-AD';
					break;
				case 'INCONTENT_BOXAD_1':
					switch (wgDB) {
						case 'answers':
							return 'NO-AD';
							break;
						default:
					}
					break;
				default:
			}
			break;
		default:
	}

	return '';
}

AdDriver.isHighValue = function(slotname) {
	switch (slotname) {
		case 'CORP_TOP_LEADERBOARD':
		case 'HOME_TOP_LEADERBOARD':
		case 'TOP_LEADERBOARD':
		case 'CORP_TOP_RIGHT_BOXAD':
		case 'HOME_TOP_RIGHT_BOXAD':
		case 'TOP_RIGHT_BOXAD':
		case 'HOME_INVISIBLE_TOP':
		case 'INVISIBLE_TOP':	// skin
		case 'INVISIBLE_1':		// footer
			// continue processing after switch
			break;
		default:
			return false;
	}

	switch (AdDriver.geoData['country']) {
		case 'CA':
		case 'DE':
		case 'ES':
		case 'FR':
		case 'IT':
		case 'UK':
		case 'US':
			// continue processing after switch
			break;
		default:
			return false;
	}

	return true;
}

AdDriver.getNumDARTCall = function(slotname) {
	var num = 0;

	try {
		var numDARTCallCookie = $.cookies.get(AdDriver.cookieNameNumDARTCall);
		if (typeof(numDARTCallCookie) != 'undefined' && numDARTCallCookie) {
			var slotnameObjs = $.parseJSON(numDARTCallCookie);
			for (var i = 0; i < slotnameObjs.length; i++) {
				if (slotnameObjs[i].slotname == slotname) {
					if (parseInt(slotnameObjs[i].ts) + window.wgAdDriverCookieLifetime*3600000 > window.wgNow.getTime()) {	// wgAdDriverCookieLifetime in hours, convert to msec
						num = parseInt(slotnameObjs[i].num);
						break;
					}
				}
			}
		}
	}
	catch (e) {
		AdDriver.log(e.message);
	}

	AdDriver.log(slotname + ' has ' + num + ' DART calls');

	return num;
}

AdDriver.incrementNumDARTCall = function(slotname) {

	var newSlotnameObjs = new Array();
	var num = 0;
	var timestamp = window.wgNow.getTime();
	var slotnameInCookie = false;

	try {
		var numDARTCallCookie = $.cookies.get(AdDriver.cookieNameNumDARTCall);
		if (typeof(numDARTCallCookie) != 'undefined' && numDARTCallCookie) {
			// find slotname and increment count
			var slotnameObjs = $.parseJSON(numDARTCallCookie);
			for (var i = 0; i < slotnameObjs.length; i++) {
				if (slotnameObjs[i].slotname == slotname) {
					slotnameInCookie = true;
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
	}
	catch (e) {
		AdDriver.log(e.message);
	}

	if (!slotnameInCookie) {
		newSlotnameObjs.push( {slotname : slotname, num : ++num, ts : timestamp} );
	}

	var cookieOptions = {hoursToLive: window.wgAdDriverCookieLifetime, path: wgCookiePath};	// do not set cookie domain
	$.cookies.set(AdDriver.cookieNameNumDARTCall, JSON.stringify(newSlotnameObjs), cookieOptions);

	return num;
}

AdDriver.isLastDARTCallNoAd = function(slotname) {
	var value = false;

	try {
		var lastDARTCallNoAdCookie = $.cookies.get(AdDriver.cookieNameLastDARTCallNoAd);
		if (typeof(lastDARTCallNoAdCookie) != 'undefined' && lastDARTCallNoAdCookie) {
			var slotnameTimestamps = $.parseJSON(lastDARTCallNoAdCookie);
			for (var i = 0; i < slotnameTimestamps.length; i++) {
				if (slotnameTimestamps[i].slotname == slotname) {
					if (parseInt(slotnameTimestamps[i].ts) + window.wgAdDriverCookieLifetime*3600000 > window.wgNow.getTime()) {	// wgAdDriverCookieLifetime in hours, convert to msec
						value = true;
					}
					break;
				}
			}
		}
	}
	catch (e) {
		AdDriver.log(e.message);
	}

	AdDriver.log(slotname + ' last DART call had no ad? ' + value);

	return value;
}

AdDriver.setLastDARTCallNoAd = function(slotname, value) {
	var newSlotnameTimestamps = new Array();
	var slotnameInCookie = false;

	try {
		var lastDARTCallNoAdCookie = $.cookies.get(AdDriver.cookieNameLastDARTCallNoAd);
		if (typeof(lastDARTCallNoAdCookie) != 'undefined' && lastDARTCallNoAdCookie) {
			var slotnameTimestamps = $.parseJSON(lastDARTCallNoAdCookie);
			// look for slotname. If there is a new value, change the old value. If
			// the new value is null, simply do not include slotname in updated cookie.
			for (var i = 0; i < slotnameTimestamps.length; i++) {
				if (slotnameTimestamps[i].slotname == slotname) {
					slotnameInCookie = true;
					if (value) {
						newSlotnameTimestamps.push( {slotname: slotname, ts: value} );
					}
				}
				else {
					newSlotnameTimestamps.push(slotnameTimestamps[i]);
				}
			}
		}
	}
	catch (e) {
		AdDriver.log(e.message);
	}

	if (value && !slotnameInCookie) {
		newSlotnameTimestamps.push( {slotname: slotname, ts: value} );
	}

	if (newSlotnameTimestamps.length) {
		var cookieOptions = {hoursToLive: window.wgAdDriverCookieLifetime, path: wgCookiePath};	// do not set cookie domain
		$.cookies.set(AdDriver.cookieNameLastDARTCallNoAd, JSON.stringify(newSlotnameTimestamps), cookieOptions);
	}

	return value;
}

AdDriver.beforeCallDART = function(slotname) {
	AdDriver.incrementNumDARTCall(slotname);
	AdDriver.setLastDARTCallNoAd(slotname, null);
}

AdDriver.postProcessSlot = function(slotname) {
	switch (slotname) {
		case 'CORP_TOP_LEADERBOARD':
		case 'HOME_TOP_LEADERBOARD':
		case 'TOP_LEADERBOARD':
			// if jumbo/expanding leaderboard, change padding-top and padding-bottom
			if (($('#'+slotname).height() > 30 && $('#'+slotname).height() < 90) // expandable leaderboard, minimized state
			|| $('#'+slotname).height() > 95) { // jumbo leaderboard or expandable leaderboard, maximized state
				$('#'+slotname).css('padding-top', 0); 
			}
			break;
	}
}

AdDriver.callDARTCallback = function(slotname) {
	if (typeof(window.adDriverLastDARTCallNoAds[slotname]) == 'undefined' || !window.adDriverLastDARTCallNoAds[slotname]) {
		AdDriver.log(slotname + ' was filled by DART');
		AdDriver.postProcessSlot(slotname);
		return;
	}
	else {
		AdDriver.setLastDARTCallNoAd(slotname, window.wgNow.getTime());
		AdDriver.log(slotname + ' was not filled by DART');
		switch (slotname) {	// do not call Liftium for certain slots
			case 'INVISIBLE_TOP':
			case 'INVISIBLE_1':
				return;
				break;
		}
		return 'Liftium';
	}
}

AdDriver.getAdProvider = function(slotname, size, dartUrl) {
	var specialCaseAdProvider = AdDriver.getAdProviderForSpecialCase(slotname);
	if (specialCaseAdProvider) {
		return specialCaseAdProvider;
	}

	if (!dartUrl) {
		return 'Liftium';
	}

	if (AdDriver.isHighValue(slotname)) {
		if (AdDriver.getNumDARTCall(slotname) < AdDriver.minNumDARTCall || !AdDriver.isLastDARTCallNoAd(slotname)) {
			return 'DART';
		}
	}

	return 'Liftium';
}

AdDriver.init();


var AdDriverCall = function (slotname, size, dartUrl) {
	this.replaceTokensInDARTUrl = function(url) {

		// tile and ord are synchronized only for DART calls made by AdDriver.
		// DART calls made by Liftium will have different tile and ord values.

		// tile
		if (typeof(window.dartTile) == 'undefined') {
			window.dartTile = 1;
		}
		url = url.replace("tile=N;", "tile="+(window.dartTile++)+";");

		// ord
		if (typeof(window.dartOrd) == 'undefined') {
			window.dartOrd = Math.floor(Math.random()*10000000000000000);
		}
		url = url.replace("ord=N?", "ord="+window.dartOrd+"?");

		// Quantcast Segments
		if (typeof(QuantcastSegments) !== "undefined") {
			var qcsegs = QuantcastSegments.getQcsegAsDARTKeyValues();
			url = url.replace("qcseg=N;", qcsegs);
		}

		// A/B tests
		var nofooter = '';
		if(document.cookie.match(/wikia-ab=[^;]*(nofooter=1)/)) { 
			nofooter = "nofooter=1;"; 
		} 
		url = url.replace("nofooter=N;", nofooter);

		return url;
	};

	this.slotname = slotname;
	this.size = size;
	this.dartUrl = this.replaceTokensInDARTUrl(dartUrl);
}

var AdDriverDelayedLoader = {
	adDriverCalls : new Array(),
	currentAd : null
}

AdDriverDelayedLoader.appendCall = function(adDriverCall) {
	AdDriverDelayedLoader.adDriverCalls.push(adDriverCall);
}

AdDriverDelayedLoader.prependCall = function(adDriverCall) {
	AdDriverDelayedLoader.adDriverCalls.unshift(adDriverCall);
}

AdDriverDelayedLoader.callDART = function() {
	AdDriver.log(AdDriverDelayedLoader.currentAd.slotname + ': calling DART...');
	AdDriver.beforeCallDART(AdDriverDelayedLoader.currentAd.slotname);
	var slot = document.getElementById(AdDriverDelayedLoader.currentAd.slotname);

	ghostwriter(
		slot,
		{
			insertType: "append",
			script: { src: AdDriverDelayedLoader.currentAd.dartUrl },
			one: function() { 
				ghostwriter.flushloadhandlers();
				var callbackAdProvider = AdDriver.callDARTCallback(AdDriverDelayedLoader.currentAd.slotname); 
				if (callbackAdProvider == 'Liftium') { 
					var liftiumCall = new AdDriverCall(AdDriverDelayedLoader.currentAd.slotname, AdDriverDelayedLoader.currentAd.size, ''); 
					AdDriverDelayedLoader.prependCall(liftiumCall); 
				} 
				AdDriverDelayedLoader.loadNext();
			}
		}
	);
}

AdDriverDelayedLoader.callLiftium = function() {
	var slotname = AdDriverDelayedLoader.currentAd.slotname;
	AdDriver.log(slotname + ': calling Liftium...');
	var size = AdDriverDelayedLoader.currentAd.size;
	LiftiumOptions.placement = slotname;
	LiftiumDART.placement = slotname; 
	
	try {
		var slot = document.getElementById(slotname);
		ghostwriter(
			slot,
			{
				insertType: "append",
				script: { text: "Liftium.callAd(\""+size+"\");" },
				done: function() {
					ghostwriter.flushloadhandlers();
					AdDriver.postProcessSlot(slotname);
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
	if (AdDriverDelayedLoader.adDriverCalls.length) {
		AdDriverDelayedLoader.currentAd = AdDriverDelayedLoader.adDriverCalls.shift();

		var adProvider = AdDriver.getAdProvider(AdDriverDelayedLoader.currentAd.slotname, AdDriverDelayedLoader.currentAd.size, AdDriverDelayedLoader.currentAd.dartUrl);
		if (adProvider == 'DART') {
			AdDriverDelayedLoader.callDART();
		}
		else if (adProvider == 'Liftium') {
			AdDriverDelayedLoader.callLiftium();
		}
		else {
			AdDriverDelayedLoader.loadNext();
		}
	}
}

AdDriverDelayedLoader.load = function() {
	if (AdDriver.isNoAdWiki()) {
		return;
	}

	AdDriverDelayedLoader.loadNext();
}

