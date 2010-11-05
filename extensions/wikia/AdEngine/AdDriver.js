alert('loading AdDriver.js');

var AdDriver = {
	isHighValue : true,
	minNumDARTCall : 3,
	cookieNameNumDARTCall : 'adDriverNumDARTCall',
	cookieDelimiter : '^',
	cookieSlotnameCallTimestampDelimiter : '%',
	cookieNameDARTCallNoAd : 'adDriverDARTCallNoAd',

	init: function() {
		window.adDriverDARTCallNoAds = new Array();
		window.adDriverAdCallComplete = new Array();
	}
}

AdDriver.getNumDARTCall = function(slotname) {
	var num = 0;

	numDARTCallCookie = Liftium.cookie(AdDriver.cookieNameNumDARTCall);
	if (typeof(numDARTCallCookie) != 'undefined' && numDARTCallCookie) {
		slotnameCallTimestamps = numDARTCallCookie.split(AdDriver.cookieDelimiter);
		for (var i = 0; i < slotnameCallTimestamps.length; i++) {
			slotnameCallTimestamp = slotnameCallTimestamps[i].split(AdDriver.cookieSlotnameCallTimestampDelimiter);	
			slotnameCall = slotnameCallTimestamp[0].split('=');
			if (slotnameCall[0] == slotname) {
				if (parseInt(slotnameCallTimestamp[1]) + window.wgAdDriverCookieLifetime*60000 > window.wgNow.getTime()) {
					num = slotnameCall[1];
				}
				break;
			}
		}
	}
	alert('num calls for ' + slotname + ': ' + num);

	return num;
}

AdDriver.incrementNumDARTCall = function(slotname) {
	var newCookie = '';

	numDARTCallCookie = Liftium.cookie(AdDriver.cookieNameNumDARTCall);
	if (typeof(numDARTCallCookie) != 'undefined' && numDARTCallCookie) {
		var slotnameInCookie = false;
		var newCookieElems = new Array();
		slotnameCallTimestamps = numDARTCallCookie.split(AdDriver.cookieDelimiter);
		for (var i = 0; i < slotnameCallTimestamps.length; i++) {
			slotnameCallTimestamp = slotnameCallTimestamps[i].split(AdDriver.cookieSlotnameCallTimestampDelimiter);	
			slotnameCall = slotnameCallTimestamp[0].split('=');
			if (slotnameCall[0] == slotname) {
				slotnameInCookie = true;
				var num = 0;
				var timestamp = window.wgNow.getTime();
				if (parseInt(slotnameCallTimestamp[1]) + window.wgAdDriverCookieLifetime*60000 > window.wgNow.getTime()) {
					num = slotnameCall[1];
					timestamp = slotnameCallTimestamp[1];
				}
				newCookieElems.push( slotname + '=' + (parseInt(num)+1) + AdDriver.cookieSlotnameCallTimestampDelimiter + timestamp );
			}
			else {
				newCookieElems.push( slotnameCallTimestamp );
			}
		}
		if (!slotnameInCookie) {
			newCookieElems.push( slotname + '=1' + AdDriver.cookieSlotnameCallTimestampDelimiter + window.wgNow.getTime() );
		}
		newCookie = newCookieElems.join(AdDriver.cookieDelimiter);
	}
	else {
		var newCookie = slotname + '=1' + AdDriver.cookieSlotnameCallTimestampDelimiter + window.wgNow.getTime();
	}

	var cookieOptions = {expires : window.wgAdDriverCookieLifetime*60000};
	Liftium.cookie(AdDriver.cookieNameNumDARTCall, newCookie, cookieOptions);

	return num;
}

AdDriver.hasDARTCallNoAd = function(slotname) {
	var value = false;

	DARTCallNoAdCookie = Liftium.cookie(AdDriver.cookieNameDARTCallNoAd);
	if (typeof(DARTCallNoAdCookie) != 'undefined' && DARTCallNoAdCookie) {
		slotnameTimestamps = DARTCallNoAdCookie.split(AdDriver.cookieDelimiter);
		for (var i = 0; i < slotnameTimestamps.length; i++) {
			slotnameTimestamp = slotnameTimestamps[i].split('=');
			if (slotnameTimestamp[0] == slotname) {
				if (parseInt(slotnameTimestamp[1]) + window.wgAdDriverCookieLifetime*60000 > window.wgNow.getTime()) {
					value = true;
				}
				break;
			}
		}
	}
	alert('hasDARTCallNoAd for ' + slotname + ': ' + value);

	return value;
}

AdDriver.setDARTCallNoAd = function(slotname, value) {
	var newCookie = '';

	DARTCallNoAdCookie = Liftium.cookie(AdDriver.cookieNameDARTCallNoAd);
	if (typeof(DARTCallNoAdCookie) != 'undefined' && DARTCallNoAdCookie) {
		var slotnameInCookie = false;
		var newCookieElems = new Array();
		slotnameTimestamps = DARTCallNoAdCookie.split(AdDriver.cookieDelimiter);
		for (var i = 0; i < slotnameTimestamps.length; i++) {
			slotnameTimestamp = slotnameTimestamps[i].split('=');
			if (slotnameTimestamp[0] == slotname && value) {
				newCookieElems.push( slotname + '=' + value );
			}
		}
		if (!slotnameInCookie && value) {
			newCookieElems.push( slotname + '=' + value );
		}
		newCookie = newCookieElems.join(AdDriver.cookieDelimiter);
	}
	else if (value) {
		var newCookie = slotname + '=' + value;
	}

	var cookieOptions = {expires : window.wgAdDriverCookieLifetime*60000};
	Liftium.cookie(AdDriver.cookieNameDARTCallNoAd, newCookie, cookieOptions);

	return value;
}

AdDriver.callDART = function(slotname, url) {
	document.write('<scri'+'pt type="text/javascript" src="'+url+'"></scri'+'pt>');
}

AdDriver.callDARTCallback = function(slotname, size) {
alert('dart callback');
	if (typeof(window.adDriverDARTCallNoAds[slotname]) == 'undefined' || !window.adDriverDARTCallNoAds[slotname]) {
		return;
	}
	else {
	alert('setting dart call no ad');
		AdDriver.setDARTCallNoAd(slotname, window.wgNow.getTime());
		alert('calling liftium');
		//AdDriver.callLiftium(slotname, size);
	}
}

AdDriver.callDARTCallbackTimerTest = function(slotname, dartUrl) {
	if (window.adDriverAdCallComplete[slotname]) {	// DART returned no ad
		return true;
	}
	else {
		var lastChild = document.getElementById(slotname).lastChild;
		if (lastChild.nodeName.toLowerCase() == 'script') {
			// check if DART returned a script
			if (!lastChild.attributes.getNamedItem('src').value) {
				return true;
			}
			else if (lastChild.attributes.getNamedItem('src').value != dartUrl) {
				return true;
			}
		}
		else {	// DART returned an img or some other non-script
			return true;
		}
	}

	return false;
}

AdDriver.callLiftium = function(slotname, size) {
	LiftiumOptions.placement = slotname;
	LiftiumDART.placement = slotname;
	Liftium.callAd(size);
}

AdDriver.callAd = function(slotname, size, dartUrl) {
	alert("callAd on " + slotname);
	if (AdDriver.isHighValue) {
		if (AdDriver.getNumDARTCall(slotname) < AdDriver.minNumDARTCall || !AdDriver.hasDARTCallNoAd(slotname)) {
			AdDriver.incrementNumDARTCall(slotname);
			AdDriver.setDARTCallNoAd(slotname, null);
			AdDriver.callDART(slotname, dartUrl);
			var callbackTimer = setInterval(function() {
				if (AdDriver.callDARTCallbackTimerTest(slotname, dartUrl)) {
					clearInterval(callbackTimer);
					AdDriver.callDARTCallback(slotname, size);
				}
			}, 100);
		}
	}
	else {
		AdDriver.callLiftium(slotname, size);
	}
}

AdDriver.init();
