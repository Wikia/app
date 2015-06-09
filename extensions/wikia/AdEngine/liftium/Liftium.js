/* Ad Network Optimizer written in Javascript */


/* LiftiumOptions is where the publisher sets up the ad call.
 * params:
 * pubid - (required) - Liftium Publisher id
 * maxHops - the maximum size of the chain (default is 5)
 * baseUrl - the prefix url for the config and beacon services (default http://delivery.liftium.com)
 * geoUrl - the url to pull the geo targeting data from (default http://geoip.liftium.com/)
 * callAd - call this size of an ad once the Liftium code is loaded (without a separate call)
 * offline - disable ads
 * placement - the placement of the ad, for targeting
 * referrer - use this for the referrer instead of document.referrer (used in unit tests)
 * exclude_tags - for this page, skip these specific tag ids
 * domain - use this for the domain instead of document.domain (used in unit tests)
 * config_delay - simulate a slow loading config (used in unit tests)
 * error_beacon - turn on/off the error beacon reporting (set to false to turn off)
 * google_* - pass these options to the Google AdSense tag. example, google_hints
 * kv_* - User defined key values that can be targeted
 */
// If it's not set, define it as an empty object.
var LiftiumOptions = LiftiumOptions || {};


if (! window.Liftium ) { // No need to do this twice

var Liftium = {
	baseUrl		: LiftiumOptions.baseUrl || "http://liftium.wikia.com/",
	chain		: [],
	currents 	: [],
	eventsTracked	: 0,
	geoUrl		: LiftiumOptions.geoUrl || "http://liftium.wikia.com/",
	loadDelay	: 100,
	maxHops		: LiftiumOptions.maxHops || 5,
	slotHops	: [],
	rejTags		: [],
	slotPlacements 	: [],
	slotTimeouts	: 0,
	slotTimer2	: [],
	hopRegister	: [],
	maxLoadDelay : LiftiumOptions.maxLoadDelay || 2500,
	isCalledAfterOnload : LiftiumOptions.isCalledAfterOnload || 0,
	hasMoreCalls : LiftiumOptions.hasMoreCalls || 0,
	slotnames	: [],
	fingerprint	: 'a',
	adNum       : 200,
	queue       : []
};


/* ##### Methods are in alphabetical order, call to Liftium.init at the bottom */


/* Simple convenience function for getElementById */
Liftium._ = function(id){
	return document.getElementById(id);
};


/* Simple abstraction layer for event handling across browsers */
Liftium.addEventListener = function(item, eventName, callback){
	if (window.addEventListener) { // W3C
		return item.addEventListener(eventName, callback, false);
	}
    if (window.attachEvent) { // IE
		return item.attachEvent("on" + eventName, callback);
	}
    return false;
};

Liftium.addAdDiv = function (doc, slotname, slotsize) {
	'use strict';

	var adDiv = doc.createElement('div'),
		adIframe;

	Liftium.adNum++;
	adDiv.id = 'Liftium_' + slotsize + '_' + Liftium.adNum;
	adIframe = Liftium.createAdIframe(doc, slotname, slotsize);

	adDiv.appendChild(adIframe);
	doc.getElementById(slotname).appendChild(adDiv);
};

Liftium.createAdIframe = function (doc, slotname, slotsize, src) {
	'use strict';

	var adIframe = doc.createElement('iframe'),
		s = slotsize && slotsize.split('x');

	adIframe.width = s[0];
	adIframe.height = s[1];
	adIframe.scrolling = 'no';
	adIframe.frameBorder = 0;
	adIframe.marginHeight = 0;
	adIframe.marginWidth = 0;
	adIframe.allowTransparency = true; // For IE
	adIframe.id = slotname + '_iframe';
	adIframe.style.display = 'block';

	if (src) {
		adIframe.src = src;
	}

	return adIframe;
};

Liftium.beaconCall = function (url, cb){
	if (window.Wikia && window.Wikia.InstantGlobals && window.Wikia.InstantGlobals.wgSitewideDisableLiftium) {
		Liftium.d('(beaconCall) Liftium Disaster Recovery enabled.', 1);
		return;
	}
	// Create an image and call the beacon
	var img = new Image(0, 0);
	// Append a cache buster
	if (cb !== false){
		url += '&cb=' + Math.random().toString().substring(2,8);
	}
	if (url.length > 1000){
		Liftium.d("Truncating beacon call url to 1000 characters");
		url = url.substring(0,1000);
	}
	Liftium.d("Beacon call: " + url, 7);
	img.src = url;
};


/*  Set up chain for slot
 *    a) See if there is a "sampled ad" to try
 *    b) Check against targeting criteria
 *    c) Check against frequency/rejection capping criteria
 *    d) Consider the maximum number of hops, have the last one be a always_fill
 */
Liftium.buildChain = function(slotname) {

	Liftium.slotTimer = Liftium.slotTimer || [];

	var size = Liftium.getSizeForSlotname(slotname);

	// Start the timer;
	var now = new Date();
	Liftium.slotTimer[slotname] = now.getTime();

	var networks = [];
	Liftium.chain[slotname] = [];

	// Store the placement, clear the source
	if (Liftium.slotPlacements[slotname]) {
		Liftium.d('Slot placement for ' + slotname + ' already set to ' + Liftium.slotPlacements[slotname], 7);
	} else {
		if (window.LiftiumPlacement) {
			Liftium.slotPlacements[slotname] = window.LiftiumPlacement;
			window.LiftiumPlacement = null;
		} else {
			Liftium.slotPlacements[slotname] = LiftiumOptions.placement;
			LiftiumOptions.placement = null;
		}
	}

	// 1x1 is the same thing as 0x0
	if (size == "1x1") { size = "0x0"; }


	if (Liftium.e(Liftium.config) || Liftium.e(Liftium.config.sizes)){
		Liftium.d('Error, config is empty in buildChain(' + slotname + ')', 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/no_config',
			ga_action: 'buildChain',
			ga_label: slotname,
			trackingMethod: 'ad'
		});
		return false;
	}
	// Do we have this slot?
	if (Liftium.e(Liftium.config.sizes) || Liftium.e(Liftium.config.sizes[size])){
		//Liftium.reportError("Unrecognized size in Liftium: " + size, "publisher");
		Liftium.d('Error, unrecognized size ' + size + ' (' + slotname + ')', 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/unrecognized_size',
			ga_action: size,
			ga_label: slotname,
			trackingMethod: 'ad'
		});
		return false;
	}

	if (typeof window.top.wgEnableAdMeldAPIClient != 'undefined' && window.top.wgEnableAdMeldAPIClient) {
		Liftium.d('Calling AdMeldAPIClient.adjustLiftiumChain for ' + size, 3);
		window.top.AdMeldAPIClient.adjustLiftiumChain(Liftium.config.sizes[size]);
	}

	Liftium.setAdjustedValues(Liftium.config.sizes[size]);

	// Sort the chain. Done client side for better caching and randomness
	Liftium.config.sizes[size].sort(Liftium.chainSort);

	// Forced Ad (for troubleshooting)
	var forcedAd = Liftium.getRequestVal('liftium_tag');
	if (!Liftium.e(forcedAd)){
		for (var j = 0, l2 = Liftium.config.sizes[size].length; j < l2; j++){
			var tf = Liftium.clone(Liftium.config.sizes[size][j]);
			if (tf.tag_id == forcedAd){
				Liftium.d("Forcing tagid #" + forcedAd + " on the front of the chain.", 1, tf);
				Liftium.config.sizes[size][j].inChain = true;
				Liftium.chain[slotname].push(tf);
				networks.push(tf.network_name + ", #" + tf.tag_id);
			}
		}
	}


	// Build the chain
	for (var i = 0, l = Liftium.config.sizes[size].length; i < l; i++){
		var t = Liftium.clone(Liftium.config.sizes[size][i]);
		if (Liftium.isValidCriteria(t, slotname)){
			Liftium.config.sizes[size][i].inChain = true;
			Liftium.chain[slotname].push(t);
			networks.push(t.network_name + ", #" + t.tag_id);

			if (t.always_fill == 1){
				Liftium.d("Chain complete - last ad is always_fill", 2, networks);
				break;
			} else if (Liftium.chain[slotname].length == Liftium.maxHops - 1){
				// Chain is full
				break;
			}
		} else {
			Liftium.rejTags.push(t.tag_id);
		}
	}

	if (Liftium.chain[slotname].length === 0){
		//Liftium.reportError("Error building chain for " + slotname + ".  No matching tags?");
		Liftium.d('Error building chain for ' + slotname + '. No matching tags?', 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/no_matching_tags',
			ga_action: slotname,
			trackingMethod: 'ad'
		});

		return false;
	}

	// AlwaysFill ad.
	if (Liftium.chain[slotname][Liftium.chain[slotname].length-1].always_fill != 1){
		var gAd = Liftium.getAlwaysFillAd(size, slotname);
		if ( gAd !== false) {
			Liftium.chain[slotname].push(gAd);
			networks.push("AlwaysFill: " + gAd.network_name + ", #" + gAd.tag_id);
		}
	}

	// Sampled ad
	var sampledAd = Liftium.getSampledAd(size);
	// Business rule: Don't do sampling if a tier 1 ad is present (exclusive)
	if (sampledAd !== false && Liftium.isValidCriteria(sampledAd, slotname) && Liftium.chain[slotname][0].tier != "1"){
		// HACK: No easy way to put an element on to the beginning of an array in javascript, so reverse/push/reverse
		Liftium.chain[slotname].reverse();
		Liftium.chain[slotname].push(sampledAd);
		Liftium.chain[slotname].reverse();
		networks.push("Sampled: " + sampledAd.network_name + ", #" + sampledAd.tag_id);
	}

	Liftium.d("Chain for " + slotname + " = ", 3, networks);
	return true;
};


/* Build up a query string from the supplied array (nvpairs). Optional separator, default ';' */
Liftium.buildQueryString = function(nvpairs, sep){
	if (Liftium.e(nvpairs)){
		return '';
	}
	if (typeof sep == "undefined"){
		sep = '&';
	}

	var out = '';
	for(var name in nvpairs){
		if (Liftium.e(nvpairs[name])){
			continue;
		}
		out += sep + encodeURIComponent(name) + '=' + encodeURIComponent(nvpairs[name]);
	}

	return out.substring(sep.length);
};


Liftium.callAd = function (sizeOrSlot, slotPlacement) {
	if (window.Wikia && window.Wikia.InstantGlobals && window.Wikia.InstantGlobals.wgSitewideDisableLiftium) {
		Liftium.d('(callAd) Liftium Disaster Recovery enabled.', 1);
		return;
	}

	if (LiftiumOptions.offline){
		Liftium.d("Not printing tag because LiftiumOptions.offline is set");
		return false;
	}

	// FIXME. Seems wrong to do this config check every time an add is called.
	// Catch config errors
	if (Liftium.e(Liftium.config)){
		//Liftium.reportError("Error downloading config");
		Liftium.d('Error downloading config (' + sizeOrSlot + ')', 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/error_downloading_config',
			ga_action: sizeOrSlot,
			trackingMethod: 'ad'
		});
		var t = Liftium.fillerAd(sizeOrSlot, "Error downloading config");
		document.write(t.tag);
		return false;
	} else if (Liftium.config.error){
		//Liftium.reportError("Config error " + Liftium.config.error);
		Liftium.d('Config error ' + Liftium.config.error + ' (' + sizeOrSlot + ')', 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/config_error',
			ga_action: sizeOrSlot,
			ga_label: (Liftium.config.error || 'unknown'),
			trackingMethod: 'ad'
		});
		var t2 = Liftium.fillerAd(sizeOrSlot, Liftium.config.error);
		document.write(t2.tag);
		return false;
	}

	// Write out a _load div and call the ad
	var slotname = Liftium.getUniqueSlotname(sizeOrSlot);

	if (slotPlacement) {
		Liftium.d('Setting placement of slot ' + slotname + ' to ' + slotPlacement, 3);
		Liftium.slotPlacements[slotname] = slotPlacement;
	}

	Wikia.Tracker.track({
		eventName: 'liftium.slot',
		ga_category: 'slot/' + sizeOrSlot,
		ga_action: slotPlacement,
		ga_label: 'liftium js',
		trackingMethod: 'ad'
	});

	document.write('<div id="' + slotname + '">');
	Liftium._callAd(slotname);
	document.write("</div>");
	return true;
};


/* Do the work of calling the ad tag */
Liftium._callAd = function (slotname, iframe) {
	Liftium.d("Calling ad for " + slotname, 1);
	var t = Liftium.getNextTag(slotname);
	if (t === false) {
		t = Liftium.fillerAd(slotname, "getNextTag returned false");
		if (iframe) {
			Liftium.clearPreviousIframes(slotname);
		} else {
			document.write("<!-- Liftium Tag #" + t.tag_id + "-->\n");
			document.write(t.tag);
		}
		return false;
	}

	// Network Options
	Liftium.handleNetworkOptions(t);

	Liftium.d("Ad #" + t.tag_id + " for " + t.network_name + " called in " + slotname);
	Liftium.d("Config = ", 6, t);

	try { // try/catch block to isolate ad tag errors

		if (!Liftium.e(iframe)){
			// Clear other load divs for the current slot
			Liftium.clearPreviousIframes(slotname);
			Liftium.callIframeAd(slotname, t);
		} else {
			// Capture the current tag for error handling
			Liftium.d("Tag :" + t.tag, 5);
			Liftium.lastTag = t;
			Liftium.lastSlot = slotname;
			document.write(t.tag);
			Liftium.lastTag = null;
		}
	} catch (e) {
		// This is probably never called, because the document.write hides it...
		//Liftium.reportError("Error loading tag #" + t.tag_id + ": " + Liftium.print_r(e), "tag");
		Liftium.d('Error loading tag #' + t.tag_id + ' (' + slotname + ')', 1, e);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/_callAd',
			ga_action: slotname,
			ga_label: 'tag ' + t.tag_id,
			trackingMethod: 'ad'
		});
	}

	return true;
};


Liftium.callIframeAd = function(slotname, tag, adIframe){
	Liftium.d("Calling Iframe Ad for " + slotname, 1);
	var iframeUrl = Liftium.getIframeUrl(slotname, tag);
	if (Liftium.e(iframeUrl) || iframeUrl == "about:blank"){
		Liftium.d("Skipping No iframe ad called for No Ad for " + slotname, 3);
		return;
	}

	Liftium.slotTimer2[slotname + "-" + tag.tag_id] = Liftium.debugTime();
	Liftium.d("slotTimer2 begin for #" + tag.tag_id + " in " + slotname, 3, Liftium.slotTimer2);

	if (typeof adIframe == "object"){
		// Iframe passed in, use it
		adIframe.setAttribute('data-tag-id', tag.tag_id);
		adIframe.src = iframeUrl;
	} else {
		// Otherwise, create one and append it to load dive
		adIframe = Liftium.createAdIframe(document, slotname, tag.size, iframeUrl);
		adIframe.id = slotname + '_' + tag.tag_id;
		adIframe.setAttribute('data-tag-id', tag.tag_id);

		// expandable slots via in-tag-name magic phrase
		// eg. 300x250 with "foo 600x250 bar"
		var fs = tag.tag_name && tag.tag_name.match(/ [0-9]+x[0-9]+ /);
		if (fs) {
			fs = fs[0].match(/[0-9]+x[0-9]+/);
			fs = fs[0].split("x");
			if (fs[0] == adIframe.width && fs[1] == adIframe.height) {
				//return;
			} else {

			Liftium.d("Forced size " + fs[0] + "x" + fs[1] + " for " + slotname, 3);
			adIframe.className += " jumbo";
			adIframe.width = fs[0];
			adIframe.height = fs[1];

			var sz = iframeUrl.match(/;sz=[0-9x,]+;/);
			if (sz) {
				iframeUrl = iframeUrl.replace(/;sz=[0-9x,]+;/, ";sz=" + fs[0] + "x" + fs[1] + ";");
				Liftium.d("Forced size " + fs[0] + "x" + fs[1] + " in Dart URL: " + iframeUrl, 3);
				adIframe.src = iframeUrl;
			}
			//return;
			}
		}

		Liftium._(slotname).appendChild(adIframe);
	}

};


Liftium.callInjectedIframeAd = function (sizeOrSlot, iframeElement, slotPlacement){
	Liftium.d("Calling injected Iframe Ad for " + sizeOrSlot, 1);

	if (window.Wikia && window.Wikia.InstantGlobals && window.Wikia.InstantGlobals.wgSitewideDisableLiftium) {
		Liftium.d('(callInjectedIframeAd) Liftium Disaster Recovery enabled.', 1);
		return;
	}

	var slotname = Liftium.getContainingDivId(iframeElement);
	Liftium.d("It's " + iframeElement.id + " inside " + slotname + " div", 3);

	if (slotPlacement) {
		Liftium.d('Setting placement of slot ' + slotname + ' to ' + slotPlacement, 3);
		Liftium.slotPlacements[slotname] = slotPlacement;
	}

	// this is a(n ugly?) shortcut, the right name would be slotname's parent div
	var placement = iframeElement.id.replace(/_iframe$/, "");
	Wikia.Tracker.track({
		eventName: 'liftium.slot',
		ga_category: 'slot/' + sizeOrSlot,
		ga_action: placement,
		ga_label: 'liftium',
		trackingMethod: 'ad'
	});

	var t = Liftium.getNextTag(slotname);
	if (!t) {
		Liftium.d("no tag found for " + sizeOrSlot + ". Collapsing frame.", 1);
		iframeElement.width = 0;
		iframeElement.height = 0;
		return;
	}

	var iframeUrl = Liftium.getIframeUrl(slotname, t);
	iframeElement.setAttribute('data-tag-id', t.tag_id);
	iframeElement.src = iframeUrl;

	Liftium.slotTimer2[slotname + "-" + t.tag_id] = Liftium.debugTime();
	Liftium.d("slotTimer2 begin for #" + t.tag_id + " in " + slotname, 3, Liftium.slotTimer2);

	if (iframeUrl == "about:blank") {
		Liftium.d("Forced size 0x0 for " + slotname, 3);
		iframeElement.width = 0;
		iframeElement.height = 0;
		return;
	}

	// expandable slots via in-tag-name magic phrase
	// eg. 300x250 with "foo 600x250 bar"
	var fs = t.tag_name && t.tag_name.match(/ [0-9]+x[0-9]+ /);
	if (fs) {
		fs = fs[0].match(/[0-9]+x[0-9]+/);
		fs = fs[0].split("x");
		if (fs[0] == iframeElement.width && fs[1] == iframeElement.height) {
			return;
		}

		Liftium.d("Forced size " + fs[0] + "x" + fs[1] + " for " + slotname, 3);
		iframeElement.className += " jumbo";
		iframeElement.width = fs[0];
		iframeElement.height = fs[1];

		var sz = iframeUrl.match(/;sz=[0-9x,]+;/);
		if (sz) {
			iframeUrl = iframeUrl.replace(/;sz=[0-9x,]+;/, ";sz=" + fs[0] + "x" + fs[1] + ";");
			Liftium.d("Forced size " + fs[0] + "x" + fs[1] + " in Dart URL: " + iframeUrl, 3);
			iframeElement.src = iframeUrl;
		}
		return;
	}
};


/* Handle Javascript errors with window.onerror */
Liftium.catchError = function (msg, url, line) {
	try {
		var jsmsg;
		if (typeof msg == "object"){
			jsmsg = "Error object: " + Liftium.print_r(msg);
		} else {
			// Careful of the format here, it's processed by error.php
			jsmsg = "Error on line #" + line + " of " + url + " : " + msg;
		}

		Liftium.d("ERROR! " + jsmsg);

		if (Liftium.e(Liftium.lastTag)){
			Liftium.reportError(jsmsg, "onerror");
		} else {
			Liftium.reportError("Tag error for tag " + Liftium.print_r(Liftium.lastTag) + "\n" + jsmsg, "tag");
		}
		// If being called from the unit testing suite, mark it as a failed test
		if (! Liftium.e(window.failTestOnError)) { // Set in LiftiumTest
			window.LiftiumTest.testFailed();
			alert(msg);
		}
	} catch (e) {
		// Oh no. Error in the error handler.
	}
	return false; // Make sure we let the default error handling continue
};


/* Sort the chain based on the following criteria:
 * tier, weighted_random
 * The idea behind weighted_random is that we want to sort items
 * within the same tier randomly (to take advantage of cream skimming)
 * But we also want to favor the higher paying ads
 */
Liftium.chainSort = function(a, b){
	var a_tier = parseInt(a.tier, 10) || 0;
	var b_tier = parseInt(b.tier, 10) || 0;
	if (a_tier < b_tier){
		return -1;
	} else if (a_tier > b_tier){
		return 1;
	} else {
		// Same tier, sort by weighted random
		var a_value= parseFloat(a.adjusted_value) || 0;
		var b_value = parseFloat(b.adjusted_value) || 0;
		var a_weight = a_value + (a_value * Math.random() * 0.75);
		var b_weight = b_value + (b_value * Math.random() * 0.75);
		return b_weight - a_weight;
	}
};


Liftium.clearPreviousIframes = function(slotname){
	var loadDiv = Liftium._(slotname);
	if (loadDiv === null){
		return false;
	}

	var iframes = loadDiv.getElementsByTagName("iframe");
	for (var i = 0, l = iframes.length; i < l; i++){
		iframes[i].style.display = "none";
	}

	return true;
};


/* By default, javascript passes by value, UNLESS you are passing a javascript
 * object, then it passes by reference.
 * Yes, I could have extended object prototype, but I hate it when people do that */
Liftium.clone = function (obj){
	if (typeof obj == "object"){
		if (obj == null) { Liftium.d("Liftium.clone: obj == null", 7); return ""; }
		var t = new obj.constructor();
		for(var key in obj) {
			t[key] = Liftium.clone(obj[key]);
		}

		return t;
	} else {
		// Some other type (null, undefined, string, number)
		return obj;
	}
};


/* Handler for messages from XDM */
Liftium.crossDomainMessage = function (message){
	XDM.allowedMethods = ["Liftium.iframeHop", "LiftiumTest.testPassed"];
	XDM.executeMessage(message.data);
};


/* Set/get cookies. Borrowed from a jquery plugin. Note that options.expires is either a date object,
 * or a number of *milli*seconds until the cookie expires */
Liftium.cookie = function(name, value, options) {
    if (arguments.length > 1) { // name and value given, set cookie
	options = options || {};
	if (Liftium.e(value)) {
	    value = '';
	    options.expires = -1;
	}
	var expires = '';
	if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
	    var d;
	    if (typeof options.expires == 'number') {
		d = new Date();
		Liftium.d("Setting cookie expire " + options.expires + " milliseconds from " + d.toUTCString(), 7);
		d.setTime(d.getTime() + (options.expires));
	    } else {
		d = options.expires;
	    }
	    expires = '; expires=' + d.toUTCString(); // use expires attribute, max-age is not supported by IE
	}
	// CAUTION: Needed to parenthesize options.path and options.domain
	// in the following expressions, otherwise they evaluate to undefined
	// in the packed version for some reason...
	var path = options.path ? '; path=' + (options.path) : '';
	var domain = options.domain ? '; domain=' + (options.domain) : '';
	var secure = options.secure ? '; secure' : '';
	Liftium.d("Set-Cookie: " + [name, '=', encodeURIComponent(value), expires, path, domain, secure].join(''), 6);
	document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
	return true;
    } else { // only name given, get cookie
	var cookieValue = null;
	if (!Liftium.e(document.cookie)){
	    var cookies = document.cookie.split(';');
	    for (var i = 0, l = cookies.length; i < l; i++) {
		var cookie = cookies[i].replace( /^\s+|\s+$/g, "");
		// Does this cookie string begin with the name we want?
		if (cookie.substring(0, name.length + 1) == (name + '=')) {
		    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
		    break;
		}
	    }
	}
	return cookieValue;
    }
};


/* Send a message to the debug console if available, otherwise alert */
Liftium.debug = function (msg, level, obj){
	if (Liftium.e(Liftium.debugLevel)){
		return false;
	} else if (level > Liftium.debugLevel){
		return false;
	}

	// Firebug enabled
	if (typeof console == "object" && console.dir){
		console.log(Liftium.debugTime() + " Liftium: " + msg);
		if (arguments.length > 2){
			console.dir(obj);
		}
	// Default console, available on IE 8+, FF 3+ Safari 4+
	} else if (typeof console == "object" && console.log){
		console.log(Liftium.debugTime() + " Liftium: " + msg);
		if (arguments.length > 2){
			console.log(Liftium.print_r(obj));
		}
	}

	return true;
};
Liftium.d = Liftium.debug; // Shortcut to reduce size of JS

Liftium.debugTime = function() {
	return new Date().getTime() - Liftium.startTime;
};

Liftium.formatTrackTime = function(t, max) {
	if (isNaN(t)) {
		Liftium.d("Error, time tracked is NaN: " + t, 7);
		return "NaN";
	}

	if (t < 0) {
		Liftium.d("Error, time tracked is a negative number: " + t, 7);
		return "negative";
	}

	t = t / 1000;
	if (t > max) {
		return "more_than_" + max;
	}

	return t.toFixed(1);
};

Liftium.dec2hex = function(d){
	var h = parseInt(d, 10).toString(16);
	if (h.toString() == "0"){
		return "00";
	} else {
		return h.toUpperCase();
	}
};


/* Emulate php's empty(). */
Liftium.empty = function ( v ) {
    if (typeof v === 'object') {
	for (var key in v) {
	      return false;
	}
	return true;
    } else {
	return	v === undefined ||
		v === "" ||
		v === 0 ||
		v === null ||
		v === false ||
		(typeof v === "number" && isNaN(v)) ||
		false; // Everything else
    }
};
Liftium.e = Liftium.empty; // Shortcut to make the Javascript smaller


/**
 * Filler ad when we don't have anything better to display. Usually means an error,
 * either with the code or the chain
 */
Liftium.fillerAd = function(slotname, message){
	// Pull the height/width out of size
	var size, tag = '', tagId = -1;

	try {
		size = slotname.split('_')[1];
	} catch (e) {
		size = '300x250';
	}

	if (!Liftium.e(message)){
		tag += '<div class="LiftiumError" style="display:none">Liftium message: ' + message + "</div>";
	}

	if (size.match(/300x250/)){
		tagId = 2198;
	} else if (size.match(/728x90/)){
		tagId = 2197;
	} else if (size.match(/160x600/)){
		tagId = 2199;
	} else {
		// Note that this text is specifically referenced in unit tests
		tag += '<span style="display: none">No available ads</span>';
	}
	return {tag_id: tagId, network_name: "Internal Error", tag: tag, size: size};
};


/* For the supplied type, (text, link, bg), return the color as a hex string.
 * Useful for passing to text ad networks to have the ad match the colors of the website
 */
Liftium.getAdColor = function (type){
  try {
	switch (type){
	  case "link":
	    var links = document.getElementsByTagName("a");
	    if (Liftium.e(links)){
		return null;
	    } else {
		return Liftium.normalizeColor(Liftium.getStyle(links[0], "color"));
	    }
	  case "bg":
		return Liftium.normalizeColor(Liftium.getStyle(document.body, "background-color"));
	  case "text":
		return Liftium.normalizeColor(Liftium.getStyle(document.body, "color"));
	  default: return null;
	}
  } catch(e){
     // Silence errors from this funciton and just return null.
     Liftium.d("Error in Liftium.getAdColor: " + e.message);
     return null;
  }
};


/* For the supplied element, return the id of the containing div */
Liftium.getContainingDivId = function(element){
	// Walk up the dom and find which div it's in
	var tempElement = element, tries = 0;
	while(tempElement && tries < 10){
		if (tempElement.tagName == "DIV" && tempElement.id){
			return tempElement.id;
		} else {
			tempElement = tempElement.parentNode;
		}
		tries++;
	}
	return false;
};


Liftium.getCookieDomain = function () {
	var domain = document.domain;

	var d = domain.match(/(?:wikia(?:-dev)?\.com|wowwiki\.com|wiki\.ffxiclopedia\.org|memory-alpha\.org|websitewiki\.de|yoyowiki\.org|marveldatabase\.com|www\.jedipedia\.de)$/);
	if (!Liftium.e(d)) {
		domain = d[0];
	} else {
		Wikia.Tracker.track({
			eventName: 'liftium.varia',
			ga_category: 'varia/cookie_domain',
			ga_action: domain,
			trackingMethod: 'ad'
		});
	}

	Liftium.d("cookie domain is " + domain, 7);
	return domain;
};

Liftium.getPageVar = function(name, defaultVal){
	return LiftiumOptions['kv_' + name] || defaultVal || '';
};


/* Get the css style for the supplied element.
   TODO: support for float and other idiosyncracies
*/
Liftium.getStyle = function (element, cssprop){
	var camelCase = cssprop.replace(/\-(\w)/g, function(all, letter){
		return letter.toUpperCase();
	});
	if (element.currentStyle) { //IE
		return element.currentStyle[camelCase] || "";
	} else if (document.defaultView && document.defaultView.getComputedStyle) { //Firefox
		return document.defaultView.getComputedStyle(element, "")[camelCase] || "";
	} else { //try and get inline style
		return element.style[camelCase] || "";
	}
};


/* Look through the list of ads in the potential chain, and return the best always_fill */
Liftium.getAlwaysFillAd = function(size, slotname){

	if (Liftium.e(Liftium.config) || Liftium.e(Liftium.config.sizes)){
		Liftium.d('Error, config is empty in getAlwaysFillAd(' + size + ', ' + slotname + ')', 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/no_config',
			ga_action: 'getAlwaysFillAd',
			ga_label: size + '/' + slotname,
			trackingMethod: 'ad'
		});
		return false;
	}

	for (var i = 0, l = Liftium.config.sizes[size].length; i < l; i++){
		var t = Liftium.config.sizes[size][i];

		if (t.always_fill == 1 && Liftium.isValidCriteria(t, slotname)){
			return Liftium.clone(t);
		}
	}

	// Rut roh
	return false;
};


/* Get the users country */
Liftium.getCountry = function(){
	if (!Liftium.e(Liftium.getCountryFound)){
		return Liftium.getCountryFound;
	}

	var ac, geo = Liftium.geo || window.Geo ;
	if (!Liftium.e(Liftium.getRequestVal('liftium_country'))){
		ac = Liftium.getRequestVal('liftium_country');
		Liftium.d("Using liftium_country for geo targeting (" + ac + ")", 8);
	} else if (Liftium.e(geo) || Liftium.e(geo.country)) {
		// It downloaded, but it's empty, because we were unable to determine the country
		Liftium.d("Unable to find a country for this IP, defaulting to unknown");
		return "unknown"; // Bail here so Liftium.getCountryFound doesn't get set
	} else {
		// Everything worked
		ac = geo.country.toLowerCase();
	}

	if (ac === "gb"){
		// Wankers.
		ac = "uk";
	}

	Liftium.getCountryFound = ac;
	return ac;
};


/* Normalize the language of the browser.
 * FF, Safari, Chrome, Camino use 'language'
 * Opera uses browserLanguage and userLanguage
 * IE uses 'systemLanguage', and 'userLanguage'
 * May vary depending on platform based on what the OS exposes
 */
Liftium.getBrowserLang = function () {
	var n = window.navigator;
	var l = n.language || n.systemLanguage || n.browserLanguage || n.userLanguage || "";
	return l.substring(0,2);
};


/* When an ad does a document.write and we are already passed that point on the page,
 * we need to call it in an lframe (document.write can only be executed inline)
 * We handle this by calling the iframe from Liftium. This function returns the iframe url */
Liftium.getIframeUrl = function(slotname, tag) {

	// Check to see if the tag is already an iframe.
	var m = tag.tag ? tag.tag.match(/<iframe[\s\S]+src="([^"]+)"/) : null;
	var iframeUrl;

	if (m !== null) {
		iframeUrl = m[1].replace(/&amp;/g, "&");
		Liftium.d("Found iframe in tag, using " + iframeUrl + " for " + slotname, 3);
		// Handle "No Ad" here so it doesn't get called by iframe
	} else if (tag.network_name == "No Ad") {
		Liftium.d("Using about:blank for 'No Ad' to avoid iframe in " + slotname, 3);
		iframeUrl = "about:blank";
		// Special case for DART.
	} else if (tag.network_name == "DART") {
		iframeUrl = window.LiftiumDART.getUrl(Liftium.slotPlacements[slotname], tag.size, tag.network_options, true);
	} else {
		var p = { "tag_id": tag.tag_id, "size": tag.size, "slotname": slotname, "placement": Liftium.slotPlacements[slotname]};
		iframeUrl = Liftium.baseUrl + "tag/?" + Liftium.buildQueryString(p);
		Liftium.d("No iframe found in tag, using " + iframeUrl + " for " + slotname, 4);
	}
	return iframeUrl;
};


/* Returns the number of minutes that have elapsed since midnight, according to the users clock */
Liftium.getMinutesSinceMidnight = function(){
	var now = new Date();
	return (now.getHours() * 60) + now.getMinutes();
};

/* Return the number of minutes since the last reject for the supplied tag id.
 * null if there hasn't been a reject
 */
Liftium.getMinutesSinceReject = function(tag_id){
	var m = Liftium.getTagStat(tag_id, "m");
	if (m === null){
		return null;
	} else {
		return Liftium.getMinutesSinceMidnight() - m;
	}
};



/* Iterate through the chain and deliver the next ad tag to be called */
Liftium.getNextTag = function(slotname){
	// Do we need to build the chain?
	if (Liftium.e(Liftium.chain[slotname])){
		if ( Liftium.buildChain(slotname) === false){
			Liftium.reportError("Error building chain " + slotname, "chain");
			return false;
		}
	}

	// Belt and suspenders to prevent too many hops
	Liftium.slotHops[slotname] = Liftium.slotHops[slotname] || 0;
	Liftium.slotHops[slotname]++;
	if (Liftium.slotHops[slotname] > 10){
		Liftium.reportError("Maximum number of hops exceeded: 10", "chain");
		return false;
	}

	// \suspenders

	var now = new Date();
	var length = Liftium.chain[slotname].length;
	var current = Liftium.currents[slotname] || 0;

	var diff = now.getTime() - Liftium.slotTimer[slotname];
	if (diff > Liftium.maxHopTime){
		// Maximum fill time has been exceeded, jump to the always_fill
		Liftium.d("Liftium.maxHopTime=" + Liftium.maxHopTime, 5);
		Liftium.d("Hop Time of " + Liftium.maxHopTime + " exceeded, it's " + diff + " now. Using the always_fill for " + slotname, 2);
		var sec = diff / 1000;
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/hop_timeout',
			ga_action: 'slot ' + slotname + ', net ' + Liftium.chain[slotname][current].network_id + ', tag ' + Liftium.chain[slotname][current].tag_id,
			ga_label: sec.toFixed(1),
			trackingMethod: 'ad'
		});
		Liftium.slotTimeouts++;

		// Return the always_fill
		var lastOne = length - 1;
		Liftium.currents[slotname] = lastOne;
		Liftium.chain[slotname][lastOne].started = now.getTime();
		return Liftium.chain[slotname][lastOne];
	} else {
		for (var i = current, l = length; i < l; i++){
			if (!Liftium.e(Liftium.chain[slotname][i].started)){
				continue;
			} else {
				// Win nah!
				Liftium.chain[slotname][i].started = now.getTime();
				Liftium.currents[slotname] = i;
				return Liftium.chain[slotname][i];
			}

		}
	}

	// Rut roh.
	Liftium.reportError("No more tags left in the chain - " + slotname + " Last ad in the chain marked as always fill but actually hopped? :" + Liftium.print_r(Liftium.chain[slotname][Liftium.chain[slotname].length-1]), "chain");
	Wikia.Tracker.track({
		eventName: 'liftium.errors',
		ga_category: 'errors/last_hopped',
		ga_action: slotname,
		trackingMethod: 'ad'
	});
	// Return a default ad here (don't hop there!)
	return Liftium.fillerAd(slotname, "No more tags left in the chain");
};

Liftium.getPagesSinceSearch = function (){
	var kwords = Liftium.getReferringKeywords();
	if (Liftium.e(kwords)){
		// None, direct traffic
		return null;
	}

	var pagesSince = Liftium.cookie("Lps");
	if (Liftium.e(pagesSince)){
		pagesSince = 1;
	} else {
		pagesSince++;
	}
	Liftium.cookie("Lps", pagesSince);
	return null;
};


Liftium.getPropertyCount = function (obj){
  try {
	if (typeof obj != "object") {
		return 0;
	}
	var c = 0;
	for (var property in obj){
		if (obj.hasOwnProperty(property)){
			c++;
		}
	}
	return c;
  } catch (e) {
	return 0;
  }
};


/* Do what we can to figure out the referring url.
 * TODO: Consider if an iframe how to get the url */
Liftium.getReferrer = function () {
	return LiftiumOptions.referrer || document.referrer;
};


/* Look at the referring keywords for this page
 * TODO: Found this snippet inside ga.js
 * l("daum:q,eniro:search_word,naver:query,images.google:q,google:q,yahoo:p,msn:q,bing:q,aol:query,aol:encquery,lycos:query,ask:q,altavista:q,netscape:query,cnn:query,about:terms,mamma:query,alltheweb:q,voila:rdata,virgilio:qs,live:q,baidu:wd,alice:qs,yandex:text,najdi:q,aol:q,mama:query,seznam:q,search:q,wp:szukaj,onet:qt,szukacz:q,yam:k,pchome:q,kvasir:q,sesam:q,ozu:q,terra:query,mynet:q,ekolay:q,rambler:words");
 * */
Liftium.getReferringKeywords = function (){

	var l = Liftium.getReferrer(), kwords;
	var qstring = l.match(/\?(.*)$/);
	if (Liftium.e(qstring)){
		qstring = [];
	} else {
		qstring = qstring[1];
	}
	var varNames = [ "q", "p", "query" ];


	for (var i = 0; i < varNames.length; i++){
		kwords = Liftium.getRequestVal(varNames[i], '', qstring);
		if (!Liftium.e(kwords))	{
			break;
		}
	}

	var kwordsCookie = Liftium.cookie("Lrk");
	if (!Liftium.e(kwords)){
		Liftium.cookie("Lrk", kwords);
		return kwords;
	} else if (!Liftium.e(kwordsCookie)){
		return kwordsCookie;
	} else {
		return null;
	}
};


Liftium.getRequestVal = function(varName, defaultVal, qstring){
	var nvpairs = Liftium.parseQueryString(qstring || document.location.search);
	if (typeof nvpairs[varName] != "undefined"){
		return nvpairs[varName];
	} else if (typeof defaultVal != "undefined" ) {
		return defaultVal;
	} else {
		return '';
	}
};

/* Look through the list of ads in the potential chain, and find one that is sample-able */
Liftium.getSampledAd = function(size){
	if (Liftium.e(Liftium.config) || Liftium.e(Liftium.config.sizes)){
		Liftium.d('Error, config is empty in getSampledAd(' + size + ')', 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/no_config',
			ga_action: 'getSampledAd',
			ga_label: size,
			trackingMethod: 'ad'
		});
		return false;
	}

	// Build up an array of the sample stats.
	var sArray = [], total = 0, myRandom = Math.random() * 100;
	for (var i = 0, l = Liftium.config.sizes[size].length; i < l; i++){
		var sample_rate = parseFloat(Liftium.config.sizes[size][i].sample_rate);
		if (Liftium.e(sample_rate)){
			continue;
		}
		total += sample_rate;

		Liftium.d("Sample Rate for " + Liftium.config.sizes[size][i].tag_id + " is " + sample_rate, 7);
		sArray.push( { "upper_bound": total, "index": i });

	}
	Liftium.d("Sample Array = ", 7, sArray);

	// Now check to see if the random number is in sArray
	for (var j = 0, l2 = sArray.length; j < l2; j++){
		if (myRandom < sArray[j].upper_bound){
			var f = sArray[j].index;
			return Liftium.clone(Liftium.config.sizes[size][f]);
		}
	}

	return false;
};


Liftium.getSlotnameFromElement = function(element){
	if (typeof element != "object") {
		return false;
	}

	// Walk up the dom and find which slot div it's in
	var tempElement = element, tries = 0;
	while(tempElement && tries < 10){
		if (tempElement.id && tempElement.id.match(/^Liftium_/)){
			return tempElement.id;
		} else {
			tempElement = tempElement.parentNode;
		}
		tries++;
	}
	return false;
};


/* Format is $day_{$tag_id}l{$loads}r{$rejects}m{$lastrejecttime}
 * r and m are optional, only if there is a reject
 * $day -- 0 to 6, where 0 is Sunday
 * $tag_id -- you better know what this is
 * $loads -- number of loads today
 * $rejects -- number of rejects today
 * $lastrejecttime -- minutes since midnight of the last reject
 */
Liftium.getStatRegExp = function(tag_id){
	return new RegExp(Liftium.now.getDay() + '_' + tag_id + 'l([0-9]+)r*([0-9]*)m*([0-9]*)' );
};


/* Figure out what size a slot is by looking at the config.
 * Should we pass a map of sizes->slotnames in the config? Maybe, but it would make it bigger...
 */
Liftium.getSizeForSlotname = function (slotname){
	var match = slotname.match(/[0-9]{1,3}x[0-9]{1,3}/);
	if (match !== null){
		return match[0];
	}

	for (var slot in Liftium.config.slotnames){
		if (typeof Liftium.config.slotnames[slot] == "function"){
			// Prototype js library overwrites the array handler and adds crap. EVIL.
			continue;
		}
		if (slot == slotname){
			return Liftium.config.slotnames[slot];
		}
	}

	return false;
};


/* Get loads/rejects for a tag. Type = "l" for loads,  "r" for rejects,
 * and "m" for the minutes since midnight of the last rejection */
Liftium.getTagStat = function (tag_id, type){
	var stat = null;

	if (Liftium.e(Liftium.tagStats)){
		Liftium.tagStats = Liftium.getRequestVal("liftium_tag_stats", null) || Liftium.cookie("LTS") || "";
	}

	var statMatch = Liftium.tagStats.match(Liftium.getStatRegExp(tag_id));
	if (!Liftium.e(statMatch)){
		var len = statMatch.length;
		if (type === "l" && len >= 2){
			stat = statMatch[1];
		} else if (type === "r" && len >= 3){
			stat = statMatch[2];
		} else if (type === "m" && len >= 4){
			stat = statMatch[3];
		} else if (type === "a"){
			var l = parseInt(statMatch[1], 0) || 0;
			var r = parseInt(statMatch[2], 0) || 0;
			stat = l + r; // attempts are loads + rejects
		}
	}

	if (Liftium.e(stat)) {
		// For type = m, we return null if not found. Otherwise, return 0
		if ( type == "m" ){
			stat = null;
		} else {
			stat = 0;
		}
	} else {
		stat = parseInt(stat, 10); // convert to number for numerical comparison
	}

	Liftium.d("Stats for " + tag_id + " type " + type + " = " + stat, 9);
	return stat;
};



Liftium.getUniqueSlotname = function(sizeOrSlot) {
	Liftium.slotnames = Liftium.slotnames || [];
	var s = "Liftium_" + sizeOrSlot + '_' + Liftium.slotnames.length;
	Liftium.slotnames.push(s);
	return s;
};


/* Pass options from LiftiumOptions through to the tag */
Liftium.handleNetworkOptions = function (tag) {

	switch (tag.network_id){
	  case "1": /* Google */

	    for (var opt in LiftiumOptions){
		if (opt.match(/^google_/)){
			Liftium.d(opt + " set to " +  LiftiumOptions[opt], 5);
			window[opt] = LiftiumOptions[opt];
		}
	    }
	    return true;

	  default:
	    return true;
	}
};


/* This is the backup tag used to go to the next ad in the configuration */
Liftium.hop = function (slotname){
	// Use the slotname from the last called ad.
	if (Liftium.e(slotname)){
		slotname = Liftium.lastSlot;
	}
	Liftium.d("Liftium.hop() called for " + slotname);

	Liftium.markLastAdAsRejected(slotname);

	return Liftium._callAd(slotname);
};
// Some networks let you hop with a javascript function and that's it (VideoEgg)
var LiftiumHop = Liftium.hop;


/* Hop called from inside an iframe. This part is tricky */
Liftium.iframeHop = function(iframeUrl){
	Liftium.d("Liftium.iframeHop() called from " + iframeUrl, 3);

	if (Liftium.in_array(iframeUrl, Liftium.hopRegister)) {
		Liftium.d("Hop from " + iframeUrl + " already registered. Bailing out.", 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/last_hopped_2',
			ga_action: 'last_hopped_2',
			trackingMethod: 'ad'
		});
		Liftium.reportError("Hop from " + iframeUrl + " already registered.");
		return;
	}
	Liftium.hopRegister.push(iframeUrl);

	var slotname;

	// Go through all the irames to find the matching src
	var iframes = document.getElementsByTagName("iframe"), found = false, srcs=[];
	Liftium.d("iframes:", 5, iframes);
	for (var i = 0, len = iframes.length; i < len; i++){
		/* IMPORTANT: getElementsByTagName returns a dynamic object.
		 * Capture the specific iframe here, don't reference it with index,
		 * because it will change
		 */
		var id = Math.random();
		if (!iframes[i].id){
			iframes[i].id = id;
		} else {
			id = iframes[i].id;
		}
		var myframe = Liftium._(id);

		if (Liftium.e(myframe.src)) {
			Liftium.d("myframe.src for #" + i + " (" + id + ") is empty, skipping", 7);
			continue;
		}

		// IE doesn't prepend the host name if you call a local iframe
		if (iframeUrl.indexOf(myframe.src) >=  0){
			found = true;
			Liftium.d("found iframe match, #" + i + " (" + id + ")", 5);
			// Found match
			slotname = Liftium.getContainingDivId(myframe);
			Liftium.debug("Slotname from containing div is " + slotname, 3);
			if (Liftium.e(slotname)) {
				Liftium.reportError("Unable to determine slotname from iframe " + iframeUrl);
				return;
			}
			break;
		}
		srcs.push(myframe.src);
	}

	if ( ! found ){
		Liftium.reportError("Unable to find iframe for " + iframeUrl + "in : " + srcs.join(", "));
		return;
	}

	Liftium.d("slotname is " + slotname + " in iframeHop", 3);

	Liftium.markLastAdAsRejected(slotname);
	Liftium._callAd(slotname, true);
};


/* Set / Get an iframes contents, depending on the number of arguments */
Liftium.iframeContents = function(iframe, html){
	if (typeof iframe != "object"){
		return false;
	}

	// Get the dom object
	// IE does one way, W3C is another. Sooprise!
	// Thanks to: http://bindzus.wordpress.com/2007/12/24/adding-dynamic-contents-to-iframes/
	if (! iframe.doc) {
		if(iframe.contentDocument) {
			// Firefox, Opera
			iframe.doc = iframe.contentDocument;
		} else if(iframe.contentWindow) {
			// IE
			iframe.doc = iframe.contentWindow.document;
		} else if(iframe.document) {
			// Others?
			iframe.doc = iframe.document;
		}

		// Trick to set up the document. See url above for info
		iframe.doc.open();
		iframe.doc.close();
	}


	if (typeof html != "undefined" ){
		// Set
		iframe.doc.body.style.backgroundColor="blue";
		var div = iframe.doc.createElement("div");
		div.id = "div42";
		div.innerHTML = html;
		iframe.doc.body.appendChild(div);
		return true;
	} else {
		// Get
		return iframe.doc.getElementById("div42").innerHTML;
	}
};



/* Emulate PHP's in_array, which will return true/false if a key exists in an array */
Liftium.in_array = function (needle, haystack, ignoreCase){
    for (var key in haystack) {
	if (haystack[key] == needle) {
	    return true;
	} else if (ignoreCase && haystack[key].toString().toLowerCase() == needle.toString().toLowerCase()){
	    return true;
	}
    }

    return false;
};

Liftium.injectAd = function (doc, slotname, slotsize) {
	Liftium.addAdDiv(doc, slotname, slotsize);
	Liftium.queue.push({
		slotsize: slotsize,
		htmlElement: doc.getElementById(slotname + '_iframe'),
		slotname: slotname
	});
};



Liftium.init = function () {
	if (window.Wikia && window.Wikia.InstantGlobals && window.Wikia.InstantGlobals.wgSitewideDisableLiftium) {
		Liftium.d('(init) Liftium Disaster Recovery enabled.', 1);
		return;
	}

	if (Liftium.e(LiftiumOptions.pubid)){
		// Liftium.reportError("LiftiumOptions.pubid must be set", "publisher"); // TODO: provide a link to documentation
		// pubid is set only if there are ads on the page - so if it is not set it means there are no ads - so no point of initialising Liftium /Inez
		return false;
	}

	window.require && require(['ext.wikia.adEngine.adTracker'], function(tracker) {
		tracker.measureTime('adengine.init', 'liftium').track();
	});

	Liftium.pullGeo();
	Liftium.pullConfig(Liftium.processQueue);

	// Tell the parent window to listen to hop messages
	if (LiftiumOptions.enableXDM !== false ){
		XDM.listenForMessages(Liftium.crossDomainMessage);
	}

	/* Opera can be handled by setting the readyState when the iframe loads */
	if (BrowserDetect.browser == "Opera"){
	  Liftium.iframeOnload = function (e){
		var iframe = e.target || e;

		// Different browsers do/do not set the readyState. For the ones that don't set it here to normalize
		try { // Supress permission denied errors for cross domain iframes
			if (typeof iframe.readyState == "undefined" ) {
				iframe.readyState = "complete";
			}
		} catch (err) {}
	  };
	  Liftium.addEventListener(window, "DOMFrameContentLoaded", Liftium.iframeOnload);
	}

	if (Liftium.getRequestVal('liftium_exclude_tag')){
		LiftiumOptions.exclude_tags = [ Liftium.getRequestVal('liftium_exclude_tag') ];
	}

	Liftium.trackQcseg();

	return true;
};

/* Different browsers handle iframe load state differently. For once, IE actually does it best.
 * IE - document.readyState *and* iframes.readyState is "interactive" until all iframes loaded, then it is "complete"
 * Chrome/Safari - loading|loaded|complete, DOMFrameContentLoaded supported, but won't allow you to change iframe.readyState
 *	Unfortunately, nested iframes will be called "loaded"
 */
Liftium.iframesLoaded = function(){
	if (Liftium.isCalledAfterOnload && Liftium.hasMoreCalls) { return false; }

	var iframes = document.getElementsByTagName("iframe");
	var l = iframes.length;
	if (l === 0){ return true; }

	var b = BrowserDetect.browser;
	if (Liftium.in_array(b, ["Firefox", "Gecko", "Mozilla"]) && !Liftium.isCalledAfterOnload && Liftium.pageLoaded){
		// Firefox/Seamonkey/Camino - no document.readyState, but load event is *after* iframes
		return true;
	} else if (Liftium.in_array(b, ["Explorer","Opera"]) && document.readyState == "complete") {
		// We also need to check the document.readyState for each iframe
		for (var i = 0; i < l; i++){
			if (iframes[i].document.readyState != "complete"){
				return false;
			}
		}
		// And... their could be nested iframes, so wait at least 200 milliseconds for each slot
		if (Liftium.loadDelay < 200){
			return false;
		} else {
			return true;
		}
	} else {
		// All other browsers will send the beacon after waiting 1000 milliseconds for each slot
		if (Liftium.loadDelay < 1000 * Liftium.slotnames.length ){
			return false;
		} else {
			return true;
		}
	}
};


/* Check to see if the user is using the right browser */
Liftium.isValidBrowser = function (browser){
	var obv = BrowserDetect.OS + " " + BrowserDetect.browser + " " + BrowserDetect.version;
	var reg = new RegExp(browser, "i");
	if (obv.match(reg)){
		return true;
	} else {
		return false;
	}
};


Liftium.isNetworkInChain = function (network_name, slotname){
	var found = false;
	for (var k = 0; k < Liftium.chain[slotname].length; k++){
		if (Liftium.chain[slotname][k].network_name == network_name) {
			found = true;
			break;
		}
	}
	return found;
};

Liftium.isHighValueCountry = function (countryCode) {
	return window.adLogicHighValueCountry.isHighValueCountry(countryCode);
}

/* Check to see if the user from the right geography */
Liftium.isValidCountry = function (countryList){

	var ac = Liftium.getCountry();

	Liftium.d("Checking if '" + ac + "' is in:", 8, countryList);

	if (Liftium.in_array("row", countryList, true) &&
		!Liftium.isHighValueCountry(ac)){
		Liftium.d("ROW targetted, and country not high-value", 8);
		return true;
	}
	if (Liftium.in_array(ac, countryList, true)){
		return true;
	}

	return false;
};

/* Does the criteria match for this tag? */
Liftium.isValidCriteria = function (t, slotname){

	var rejmsg = "Ad #" + t.tag_id + " from " + t.network_name + " invalid for " + slotname+": ";

	// For ads that have a frequency cap, don't load them more than once per page
	if (!Liftium.e(t.inChain) && !Liftium.e(t.freq_cap)) {
		Liftium.d(rejmsg + "it has a freq cap and is already in another chain", 3);
		return false;
	}

	if (!Liftium.e(LiftiumOptions.exclude_tags) &&
	     Liftium.in_array(t.tag_id, LiftiumOptions.exclude_tags)){
		Liftium.d(rejmsg + "in LiftiumOptions excluded tags list", 2);
		return false;
	}


	// Frequency Cap
	if (!Liftium.e(t.freq_cap)){
		var a = Liftium.getTagStat(t.tag_id, "a");
		if (a >= parseInt(t.freq_cap, 10)){
			Liftium.d(rejmsg +  a + "attempts is >= freq_cap of " + t.freq_cap, 5);
			return false;
		}

	}

	// Rejection time
	if (!Liftium.e(t.rej_time)){
		var elapsedMinutes = Liftium.getMinutesSinceReject(t.tag_id);

		if (elapsedMinutes !== null){
			Liftium.d(" rej_time = " + t.rej_time + " elapsed = " + elapsedMinutes, 8);
			if (elapsedMinutes < parseInt(t.rej_time, 10)){
				Liftium.d(rejmsg + "tag was rejected sooner than rej_time of " + t.rej_time, 5);
				return false;
			}
		}

	}

	if (!Liftium.e(t.criteria)){
		for (var key in t.criteria){
			switch (key){
			  case 'country':
				if ( ! Liftium.isValidCountry(t.criteria.country)){
					Liftium.d(rejmsg + "Invalid country", 6);
					return false;
				}
				break;
			  case 'browser':
				if ( ! Liftium.isValidBrowser(t.criteria.browser[0])){
					Liftium.d(rejmsg + "Invalid browser", 6);
					return false;
				}
				break;
			  case 'domain':
				LiftiumOptions.domain = LiftiumOptions.domain || document.domain;
				if ( t.criteria.domain[0] != LiftiumOptions.domain ){
					Liftium.d(rejmsg + "Invalid domain", 6);
					return false;
				}
				break;
			  case 'placement':
				if (!Liftium.in_array(Liftium.slotPlacements[slotname], t.criteria.placement)){
					Liftium.d(rejmsg + "Invalid placement (" + Liftium.slotPlacements[slotname] + ")", 6, t.criteria.placement);

					return false;
				}
				break;
			  default:
				// Arbitrary key values passed as LiftiumOptions that start with kv_
				if (key.match(/^kv_/)){
					if (!Liftium.in_array(LiftiumOptions[key], t.criteria[key])){
						Liftium.d(rejmsg + "key value " + key + " does not match: " + t.criteria[key], 6);
						return false;
					}
				}

				break; // Shouldn't be necessary, but silences a jslint error
			}
		}
	}

	// Don't use iframes if no xdm iframe path is set on a browser that doesn't support it
	if (!XDM.canPostMessage() &&
		Liftium.e(Liftium.config.xdm_iframe_path) &&
		t.tag.toString().match(/iframe/i) &&
		t.always_fill != 1){
		Liftium.reportError("Iframe called on HTML 4 browser for publisher without a xdm_iframe_path. tagid #" + t.tag_id, "tag");
		return false;
	}

	// Tag is valid, check pacing
	if (!Liftium.e(t.pacing) && !Liftium.isValidPacing(t)){
		Liftium.d(rejmsg + " - pacing criteria not met (" + t.pacing + ")", 5);
		return false;
	}

	// All criteria passed
	Liftium.d("Targeting criteria passed for tag #" + t.tag_id, 6);
	return true;

};


/* Pacing allows for tags to be throttled. If the tag is valid, it will be in the chain x percent of the time */
Liftium.isValidPacing = function(tag){
	return (Math.random() * 100) < tag.pacing;
};


/* Load the supplied url inside a script tag  */
Liftium.loadScript = function(url, noblock, callback) {
	Liftium.d("Loading script from " + url + " (not blocking: " + (!Liftium.e(noblock) ? "true" : "false") + ", with callback: " + (!Liftium.e(callback) ? "true" : "false") + ")", 5);
	if (typeof noblock == "undefined"){
		Liftium.d("Using document.write", 5);
		// This method blocks
		document.write('<scr' + 'ipt type="text/javascript" src="' + url + '"><\/sc' + 'ript>');
		return true;
	} else {
		// This method does not block
		if (typeof jQuery == "undefined" || !callback) {
			Liftium.d("Using document.createElement(script)", 5);
			var h = document.getElementsByTagName("head").item(0);
			var s = document.createElement("script");
			s.src = url;
			h.appendChild(s);
			return s;
		}
		else {
			Liftium.d("Using $.ajax", 5);
			$.ajax({
				dataType: "script",
				url: url,
				complete: callback
			});
			return true;
		}
	}
};


Liftium.markChain = function (slotname){
	Liftium.d("Marking chain for " + slotname, 5);
	if (Liftium.e(Liftium.chain[slotname])){
		Liftium.debug("Skipping marking chain for " + slotname + ", chain was empty");
		return false;
	}
	for (var i = 0, len = Liftium.chain[slotname].length; i < len; i++){
		if (i < Liftium.currents[slotname] && Liftium.chain[slotname][i].started){
			Liftium.chain[slotname][i].rejected = true;
		} else if (i == Liftium.currents[slotname]){
			Liftium.chain[slotname][i].loaded = true;
			break;
		}
	}
	return i;
};


Liftium.markLastAdAsRejected = function (slotname){
	var i = Liftium.currents[slotname];
	if (typeof i == "undefined") {
		Liftium.d("No chain for " + slotname + " found. Bailing out.", 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/no_chain',
			ga_action: slotname,
			trackingMethod: 'ad'
		});
		return;
	}

	var tag_id = Liftium.chain[slotname][i].tag_id;
	Liftium.d("Marking last ad as rejected for " + slotname + " (#" + tag_id + ")", 3);

	Liftium.chain[slotname][i].rejected = true;
	Liftium.setTagStat(tag_id, "r");

	var time = Liftium.debugTime() - Liftium.slotTimer2[slotname + "-" + tag_id];
	Liftium.d("slotTimer2 end for #" + tag_id + " in " + slotname + " after " + time + " ms", 3);
	var net_id = Liftium.chain[slotname][i].network_id;
	Wikia.Tracker.track({
		eventName: 'liftium.hop',
		ga_category: 'hop/net ' + net_id,
		ga_action: 'tag ' + tag_id,
		ga_label: Liftium.formatTrackTime(time, 5),
		trackingMethod: 'ad'
	});
};


/* We can get color data in a lot of different formats. Normalize here for css. false on error */
Liftium.normalizeColor = function(input){
	input = input || "";
	if (input == "transparent") {
		return "";
	} else if (input.match(/^#[A-F0-9a-f]{6}/)){
		// It's 6 digit already hex
		return input.toUpperCase().replace(/^#/, "");
	} else if (input.match(/^#[A-F0-9a-f]{3}$/)){
		// It's 3 digit hex. Convert to 6. Thank you IE.
		var f = input.substring(1, 1);
		var s = input.substring(2, 1);
		var t = input.substring(3, 1);
		var out = f + f + s + s + t + t;
		return out.toUpperCase();
	} else if (input.match(/^rgb/)){
		var str = input.replace(/[^0-9,]/g, '');
		var rgb = str.split(",");
		return Liftium.dec2hex(rgb[0]) +
		       Liftium.dec2hex(rgb[1]) +
		       Liftium.dec2hex(rgb[2]);
	} else {
		// Input is a string, like "white"
		// Note: Opera returns it quoted. So remove those.
		return input.replace(/"/g, "");
	}
};


Liftium.onLoadHandler = function () {
	//Liftium.trackEvent(["onload", Liftium.formatTrackTime(Liftium.debugTime(), 30)], "UA-17475676-7");
	if (window.Wikia && window.Wikia.InstantGlobals && window.Wikia.InstantGlobals.wgSitewideDisableLiftium) {
		Liftium.d('(onLoadHandler) Liftium Disaster Recovery enabled.', 1);
		return;
	}

	Liftium.pageLoaded = true;
	if (!Liftium.e(Liftium.config) && Liftium.iframesLoaded()) {
		Liftium.sendBeacon();
	} else if (Liftium.loadDelay < Liftium.maxLoadDelay){
		// Check again in a bit. Keep increasing the time
		Liftium.loadDelay += Liftium.loadDelay;
		window.setTimeout(Liftium.onLoadHandler, Liftium.loadDelay);
	} else {
		var config_status = Liftium.e(Liftium.config) ? 'no config' : 'config loaded';
		Liftium.d("Gave up waiting for ads to load (" + config_status + "), sending beacon now", 1);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/gave_up_waiting_for_ads',
			ga_action: config_status,
			trackingMethod: 'ad'
		});
		Liftium.sendBeacon();
	}
};


/* This code looks at the supplied query string and parses it.
 * It returns an associative array of url decoded name value pairs
 */
Liftium.parseQueryString = function (qs){
	var ret = [];
	if (typeof qs != "string" || qs === "") { return ret; }

	if (qs.charAt(0) === '?') { qs = qs.substr(1); }


	qs=qs.replace(/\;/g, '&', qs);
	qs=qs.replace(/\+/g, '%20', qs);

	var nvpairs=qs.split('&');

	for (var i = 0, intIndex; i < nvpairs.length; i++){
		if (nvpairs[i].length === 0){
			continue;
		}

		var varName = '', varValue = '';
		if ((intIndex = nvpairs[i].indexOf('=')) != -1) {
			try {
				// UTF-8 version
				varName = decodeURIComponent(nvpairs[i].substr(0, intIndex));
				varValue = decodeURIComponent(nvpairs[i].substr(intIndex + 1));
			} catch (e) {
				// non-UTF version
				varName = unescape(nvpairs[i].substr(0, intIndex));
				varValue = unescape(nvpairs[i].substr(intIndex + 1));
			}
		} else {
			// No value, but it's there
			varName = nvpairs[i];
			varValue = true;
		}

		ret[varName] = varValue;
	}

	return ret;
};

Liftium.processQueue = function () {
	Liftium.d('Processing the queue', 'debug', 1);

	Wikia.LazyQueue.makeQueue(Liftium.queue, function (slot) {
		Liftium.d('Liftium queue processing a slot', 1);
		Liftium.callInjectedIframeAd(
			slot.slotsize,
			window.document.getElementById(slot.slotname + '_iframe'),
			slot.slotname
		);
	});

	Liftium.queue.start();
};

/* Pull the configuration data from our servers */
Liftium.pullConfig = function (callback){

	if (Liftium.config) {
		return;
	}

	var p = {
		"pubid" : LiftiumOptions.pubid,
		"v": 1.2, // versioning for config
		"country": Liftium.getCountry()
	};

	// Simulate a small delay (used by unit tests)
	if (!Liftium.e(LiftiumOptions.config_delay)){
		p.config_delay = LiftiumOptions.config_delay;
		p.cb = Math.random();
	}

	// Allow for us to work in a dev environment
	if (window.location.hostname.indexOf(".dev.liftium.com") > -1){
		Liftium.baseUrl = '/';
	}

	var u = Liftium.baseUrl  + 'config?' + Liftium.buildQueryString(p);
	Liftium.d("Loading config from " + u, 2);
	if (callback) {
		Liftium.loadScript(u, true, callback);
	}
	else {
		Liftium.loadScript(u);
	}
};

/* Pull the geo data from our servers */
Liftium.pullGeo = function (){
	if (Liftium.geo) {
		return;
	}

	Liftium.d("Loading geo data from cookie", 3);
	var cookie = decodeURIComponent(Liftium.cookie("Geo"));
	if (!Liftium.e(cookie)) {
		try {
			Liftium.geo = JSON.parse(cookie) || {};
		} catch (e) {
			Liftium.geo = {};
		}
		Liftium.d("Geo data loaded:", 7, Liftium.geo);
		return;
	}

	Liftium.d("Loading geo data from " + Liftium.geoUrl, 3);
	Liftium.loadScript(Liftium.geoUrl);
};

/* Javascript equivalent of php's print_r.  */
Liftium.print_r = function (data, level) {

	if (data === null) { return "*null*"; }

	// Sanity check against too much recursion
	level = level || 0;
	if (level > 6) { return false; }

	//The padding given at the beginning of the line.
	var padding = '';
	for(var j = 1; j < level+1 ; j++) {
		padding += "	";
	}
	switch (typeof data) {
	  case "string" : return data === "" ? "*empty string*" : data;
	  case "undefined" : return "*undefined*";
	  case "boolean" : return data === true ? "*boolean true*" : "*boolean false*";
	  case "function" : return "*function*" ;
	  case "object" : // The fun one

		var out = [];
		for(var item in data) {

			if(typeof data[item] == 'object') {
				out.push(padding + "'" + item + "' ..." + "\n");
				out.push(Liftium.print_r(data[item],level+1));
			} else {
				out.push(padding + "'" + item + "' => \"" +
					Liftium.print_r(data[item]) + "\"\n");
			}
		}
		if (Liftium.e(out)){
			return "*empty object*";
		} else {
			return out.join("");
		}

	  default : return data.toString();
	}
};

/* Record the loads/rejects, and return a string of events to be sent by the beacon */
Liftium.recordEvents = function(slotname){

	var e = '';
	for (var i = 0, l = Liftium.chain[slotname].length; i < l; i++){
		var t = Liftium.chain[slotname][i];
		if ( Liftium.e(t.started)){
			// There can't be a load or a reject if it wasn't started.
			continue;
		}

		var loads = Liftium.getTagStat(t.tag_id, "l");

		// Load
		if (!Liftium.e(Liftium.chain[slotname][i].loaded)){
			Liftium.d("Recording Load for " + t.network_name + ", #" + t.tag_id + " in " + slotname, 4);
			Liftium.setTagStat(t.tag_id, "l");
			e += ',l' + t.tag_id + 'pl' + loads;

		// Reject
		} else if (! Liftium.e(t.rejected)){
			e += ',r' + t.tag_id + 'pl' + loads;
			Liftium.d("Recording Reject for " + t.network_name + ", #" + t.tag_id + " in " + slotname, 5);
			continue;

		}
	}

	return e.replace(/^,/, ''); // Strip off first comma
};



Liftium.reportError = function (msg, type) {
  // wrapped in a try catch block because if this function is reporting an error,
  // all hell breaks loose
  try {
	Liftium.d("Liftium ERROR: " + msg);
	if (Liftium.getBrowserLang() != "en"){
		// Sorry non english speakers
		//return;
	}


	// Note that the Unit tests also track the number of errors
	if (typeof Liftium.errorCount != "undefined") {
		Liftium.errorCount++;
	} else {
		Liftium.errorCount = 1;
	}

	if (Liftium.errorCount > 5){
		// Don't overwhelm our servers if the browser is stuck in a loop.
		return;
	}

	// Ignore certain errors that we can't do anything about
	var ignores = [
		"Error loading script", // This is when a user pushes "Stop"
		"Script error.", // This is when a user pushes "Stop"
		"GA_googleFillSlot is not defined", // They probably have AdBlock on.
		"translate.google",
		"COMSCORE",
		"quantserve",
		"urchin",
		"greasemonkey",
		"Permission denied", // Ads trying to get the window location, which isn't allowed
		"Unexpected token ILLEGAL", // Wierd Chrome error about postmessage from Google Ads.
		"Access is denied" // Bad iframe access from IE
	];
	for (var i = 0; i < ignores.length; i++){
		if (msg.indexOf(ignores[i]) >= 0){
			return;
		}
	}

	if(type == 'onerror') {

		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/js',
			ga_action: msg,
			trackingMethod: 'ad'
		});

	} else {
		var p = {
			'msg' : msg.substr(0, 512),
			'type': type || "general",
			'pubid' : LiftiumOptions.pubid,
			'lang' : "en" // hard coded for now, because we excluded above
		};
		if (type == "tag"){
			p.tag_id = Liftium.lastTag.tag_id;
		}

		Liftium.beaconCall(Liftium.baseUrl + "error?" + Liftium.buildQueryString(p));

	}

  } catch (e) {
	Liftium.d("Yikes. Liftium.reportError has an error");
	Wikia.Tracker.track({
		eventName: 'liftium.errors',
		ga_category: 'errors/reportError',
		ga_action: 'reportError',
		trackingMethod: 'ad'
	});
  }
};


Liftium.errorMessage = function (e) {
	// e can be a native javascript error or a message. Figure out which
	if (typeof e == "object" ){
		// For now, so I can see what the format is for all browsers
		return Liftium.print_r(e);
	} else {
		return e;
	}
};


/* Send a beacon back to our server so we know if it worked */
Liftium.sendBeacon = function (){

	// This is called a second time from the *un*load handler, so make sure we don't call the beacon twice.
	if (!Liftium.e(Liftium.beacon)){
		return true;
	}

	// Throttle the beacon
	var throttle;
		// Missing config, throttle undefined, or no value from the DB needs to be defaulted (0 is OK and means no beacons should be sent.)
	if (Liftium.e(Liftium.config) || throttle === undefined || throttle === null){
		Liftium.d("No throttle defined, using 1.0");
		throttle = 1.0;
	} else {
		throttle = Liftium.config.throttle;
	}
	if (Math.random() > throttle){
		Liftium.d("Beacon throttled at " + throttle);
		return true;
	}

	var events = '', numSlots = 0;
	for(var slotname in Liftium.chain){
		if (typeof Liftium.chain[slotname] == "function"){
			// Prototype js library overwrites the array handler and adds crap. EVIL.
			continue;
		}
		numSlots++;
		// Clean up the chain
		Liftium.markChain(slotname);
		// Set tag stats and get a string of events
		events += ',' + Liftium.recordEvents(slotname);
	}

	events = events.replace(/^,/, ''); // Strip off first comma

	Liftium.storeTagStats();

	var b = {};
	b.numSlots = numSlots;
	b.events = events;

	// Pass along other goodies
	b.country = Liftium.getCountry();

	if (Liftium.slotTimeouts > 0) {
		b.slotTimeouts = Liftium.slotTimeouts;
	}

	Liftium.d ("Beacon: ", 7, b);


	// Not all browsers support JSON
	var p;
	if (! window.JSON) {
		p = { "events": b.events };
	} else {
		p = { "beacon": window.JSON.stringify(b) };
	}
	Liftium.beacon = p;

	Liftium.beaconCall(Liftium.baseUrl + 'beacon?' + Liftium.buildQueryString(p));

	Liftium.d ("Liftium done, beacon sent");

	// Track the beacons with GA

	window.require && require(['ext.wikia.adEngine.adTracker'], function(tracker) {
		tracker.measureTime('adengine.init', 'liftium.beacon').track();
	});

	// Call the unit tests
	if (window.LiftiumTest && typeof window.LiftiumTest.afterBeacon == "function"){
		window.LiftiumTest.afterBeacon();
	}

	return true;
};


/* Tags lose their value for each impression, calculate an adjusted value here */
Liftium.setAdjustedValues = function(tags){
	var attempts, reducer = 0.05, avalue;
	for (var i = 0; i < tags.length; i++){
		if (tags[i].adjusted_value){
			// Our work is done here
			continue;
		}

		avalue = tags[i].value;
		if (tags[i].pay_type == "CPC"){
			reducer += 0.20;
		}

		if (parseFloat(tags[i].floor, 10)) {
			// Tags with floors A) get a little love and B) shouldn't be skewed down for the number of attempts
			avalue = avalue * 1.01;
		}

		// Skew CPC higher for users in the discovery mindset
		if (tags[i].pay_type == "CPC" && !Liftium.e(Liftium.getReferringKeywords())){
			avalue = avalue * 1.25;
			reducer = 0;
		}

		attempts = Liftium.getTagStat(tags[i].tag_id, "a");
		// Reduce by $reducer for every attempt
		for (var j = 0; j < attempts; j++){
			avalue = avalue - (avalue * reducer);
		}

		// Never go below 15% of the original value
		if (avalue < tags[i].value * 0.15){
			tags[i].adjusted_value = tags[i].value * 0.15;
		} else {
			tags[i].adjusted_value = avalue;
		}
	}
	return tags; // Not really necessary, because it modified values in place
};


Liftium.setPageVar = function(name, value){
	LiftiumOptions['kv_' + name] = value;
};


/* Set loads/rejects for a tag. type is "l" or "r" */
Liftium.setTagStat = function (tag_id, type){
	Liftium.d("Setting a " + type + " stat for " + tag_id, 6);

	var pieces = Liftium.tagStats.split(',');
	if (pieces.length > Liftium.statMax){
		// If too may, take off the first one
		pieces.shift();
	}

	// Get the current stats and rebuild
	var loads = Liftium.getTagStat(tag_id, "l");
	var rejects = Liftium.getTagStat(tag_id, "r");
	var rejectMinutes = 0;

	if (type === "l"){
		loads++;
		rejectMinutes = Liftium.getTagStat(tag_id, "m") || 0;
	} else if (type === "r"){
		rejects++;
		rejectMinutes = Liftium.getMinutesSinceMidnight();
	}

	// Tack on the rejects/rejectMinutes
	var piece = Liftium.now.getDay() + '_' + tag_id + "l" + loads;
	if (rejects > 0){
		piece = piece + "r" + rejects;
		piece = piece + "m" + rejectMinutes;
	}

	var ts = Liftium.tagStats.replace(Liftium.getStatRegExp(tag_id), piece);
	if (ts === Liftium.tagStats){
		// tagid not found in stats, Append it to the end.
		Liftium.tagStats = Liftium.tagStats + ',' + piece;
	} else {
		Liftium.tagStats = ts;
	}

	Liftium.tagStats = Liftium.tagStats.replace(/^,/, ''); // Strip off first comma

	Liftium.d("Tag Stats After Set = " + Liftium.tagStats, 6);
	Liftium.storeTagStats();
};


/* Store accepts/rejections in a cookie
 * Keep this as small as possible!
 */
Liftium.storeTagStats = function (){
	Liftium.d("Stored Tag Stats = " + Liftium.tagStats, 6);
	Liftium.cookie("LTS", Liftium.tagStats, {
		  domain: Liftium.getCookieDomain(),
		  path: "/",
		  expires: 86400 * 1000 // one day from now, in milliseconds
		 }
	);
};


/* Event tracking. Used for external verification of stats. Based on:
 * I wanted to simply call Google's code for buildng this url, but wasn't able to
 * get it to work, because Google uses global variables. :(
 * TODO: Make sure I guessed correctly
 * http://code.google.com/apis/analytics/docs/tracking/gaTrackingTroubleshooting.html
 */
Liftium.trackEvent = function(page, profile) {
	if (typeof page == "object") {
		page = page.join("/");
	}
	Liftium.d("Track event: " + page, 1);

	var n = window.navigator;
	Liftium.sessionid = Liftium.sessionid || Math.round(Math.random() * 2147483647);

	page = '/' + LiftiumOptions.pubid + '/' + page;

	var c = "__utma=" + Liftium.cookie("__utma") + ';+__utmz=' + Liftium.cookie("__utmz") + ';';
	var p = {
		utmwv:	"4.6.5", // Hardcode inside ga.js. Code version?
		utmn:	Math.round(Math.random() * 2147483647), // Cache buster
		utmhn:	"liftium.wikia.com",
		utmcs:	"UTF-8", // TODO Un-hardcode
		utmsr:	"1024x768", // TODO Un-hardcode
		utmsc:	"24-bit", // TODO Un-hardcode
		utmul:	(n.language || n.systemLanguage || n.browserLanguage || n.userLanguage || "").toLowerCase(),
		utmje:	"1", // Java enabled. TODO: Un-hardcode
		utmfl:	"10.0 r32", // Flash Version? TODO: Un-hardcode
		utmdt:	document.title,
		utmhid: Liftium.sessionid,
		utmr:	"0", // ??
		utmp:	page,
		//utmac:	"UA-17475676-3",
		utmcc:	c
	};

	if (typeof profile != "undefined") {
		p.utmac = profile;
		Liftium.d("Tracking is using custom profile: " + profile, 7);
	} else {
		p.utmac = "UA-17475676-10";
	}

	var url = "https:" == window.location.protocol ? "https://ssl." : "http://www.";
	url += "google-analytics.com/__utm.gif?" + Liftium.buildQueryString(p);

	Liftium.beaconCall(url, false);
};

Liftium.buildTrackUrl = function(data) {
	return data.join("/") + "/" +
		[
		Liftium.getPageVar("Hub", "unknown"),
		Liftium.langForTracking(Liftium.getPageVar("cont_lang", "unknown")),
		Liftium.dbnameForTracking(Liftium.getPageVar("wgDBname", "unknown")),
		/* Liftium.getPageVar("page_type", "unknown"), */
		Liftium.geoForTracking(Liftium.getCountry())
		].join("/");
};

Liftium.langForTracking = function(lang) {
	if (!Liftium.in_array(lang, ["en", "es", "de", "fr"])) {
		Liftium.d("Wiki lang " + lang + " changed to 'other' for tracking", 7);
		lang = "other";
	}
	return lang;
};

Liftium.dbnameForTracking = function(dbname) {
	// this is a hack... FIXME NEF
	if (wgWikiFactoryTagIds != "undefined" && !Liftium.e(wgWikiFactoryTagIds) && wgWikiFactoryTagIds.length > 4) {
		return dbname;
	}

	Liftium.d("Wiki dbname " + dbname + " changed to 'other' for tracking", 7);
	return "other";
};

Liftium.geoForTracking = function(country) {
	if (!Liftium.in_array(country, ["unknown", "us", "uk", "ca"])) {
		Liftium.d("Country " + country + " changed to 'other' for tracking", 7);
		// fall back to the continent FIXME NEF
		country = "other";
	}
	return country;
};

Liftium.trackQcseg = function() {
	var c = Liftium.cookie("qcseg");
	Liftium.d("Quantcast cookie: " + c, 5);
	if (Liftium.e(c)) {
		//Liftium.trackEvent(Liftium.buildTrackUrl(["quantcast", "none"]), "UA-17475676-9");
		return;
	}

	if ((c.search(/"[DT]"/) != -1) && (c.search(/"[0-9]{4}"/) == -1)) {
		//Liftium.trackEvent(Liftium.buildTrackUrl(["quantcast", "segments", "DT_only"]), "UA-17475676-9");
		return;
	}

	try {
		var qcseg = JSON.parse(c);
		Liftium.d("Quantcast cookie parsed:", 7, qcseg);
		if (Liftium.e(qcseg.segments)) {
			//Liftium.trackEvent(Liftium.buildTrackUrl(["quantcast", "empty"]), "UA-17475676-9");
			return;
		}

		var empty = true;
		for (var i in qcseg.segments) {
			if (typeof qcseg.segments[i] != "object") {
				continue;
			}

			if (Liftium.e(qcseg.segments[i])) {
				//Liftium.trackEvent(Liftium.buildTrackUrl(["quantcast", "segments", "empty"]), "UA-17475676-9");
				continue;
			}
			if (Liftium.e(qcseg.segments[i].id)) {
				//FIXME: this tracking call needs to be updated before it is uncommented
				//Wikia.Tracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "quantcast", "segments", "broken", c]), 'liftium.errors');
				continue;
			}
			Liftium.d("Quantcast segment: " + qcseg.segments[i].id, 5);
			//FIXME: this tracking call needs to be updated before it is uncommented
			//Wikia.Tracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "quantcast", "segments", qcseg.segments[i].id]), 'liftium.quantcast');

			empty = false;
		}

		if (empty) {
			//Liftium.trackEvent(Liftium.buildTrackUrl(["quantcast", "empty"]), "UA-17475676-9");
			return;
		}
	} catch (e) {
		Liftium.d("Quantcast cookie parse error:", 7, e);
		//FIXME: this tracking call needs to be updated before it is uncommented
		//Wikia.Tracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "quantcast", "broken"]), 'liftium.errors');
		return;
	}
};

/* Why do we even have this lever!? Because we need to test error handling (see test_jserror.php) */
Liftium.throwError = function () {
	return window.LiftiumthrowError.UndefinedVar;
};


/* Browser Detect
http://www.quirksmode.org/js/detect.html
*/
var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "";
		this.version = this.searchVersion(navigator.userAgent) ||
			this.searchVersion(navigator.appVersion) ||
			"";
		this.OS = this.searchString(this.dataOS) || "";
	},
	searchString: function (data) {
		for (var i = 0, l = data.length ; i < l; i++){
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1) {
					return data[i].identity;
				}
			} else if (dataProp) {
				return data[i].identity;
			}
		}
		return null;
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) { return null; }
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{ string: navigator.userAgent, subString: "Chrome", identity: "Chrome" },
		{ string: navigator.userAgent, subString: "OmniWeb", versionSearch: "OmniWeb/", identity: "OmniWeb" },
		{ string: navigator.vendor, subString: "Apple", identity: "Safari", versionSearch: "Version" },
		{ prop: window.opera, identity: "Opera" },
		{ string: navigator.vendor, subString: "iCab", identity: "iCab" },
		{ string: navigator.vendor, subString: "KDE", identity: "Konqueror" },
		{ string: navigator.userAgent, subString: "Firefox", identity: "Firefox" },
		{ string: navigator.vendor, subString: "Camino", identity: "Camino" },
		{ string: navigator.userAgent, subString: "Netscape", identity: "Netscape"},
		{ string: navigator.userAgent, subString: "MSIE", identity: "Explorer", versionSearch: "MSIE" },
		{ string: navigator.userAgent, subString: "Gecko", identity: "Mozilla", versionSearch: "rv" },
		{ string: navigator.userAgent, subString: "Mozilla", identity: "Netscape", versionSearch: "Mozilla" }
	],
	dataOS : [
		{ string: navigator.userAgent, subString: "Android", identity: "Android" },
		{ string: navigator.userAgent, subString: "iPad", identity: "iPad" },
		{ string: navigator.userAgent, subString: "iPhone", identity: "iPhone/iPod" },
		{ string: navigator.userAgent, subString: "SymbianOs", identity: "Symbian" },
		{ string: navigator.userAgent, subString: "Windows Phone", identity: "Windows Phone" },
		{ string: navigator.platform, subString: "Win", identity: "Windows" },
		{ string: navigator.platform, subString: "Mac", identity: "Mac" },
		{ string: navigator.platform, subString: "Linux", identity: "Linux" }
	]

};
BrowserDetect.init();

// Load the Inspector code.
Liftium.loadInspector = function () {
	var d = Liftium._("LiftiumInspectorScript");
	if (Liftium.e(d)) {
		var s = Liftium.loadScript(Liftium.baseUrl + "js/Inspector.js?r=" + Math.random().toString().substring(2,8), true);
		s.id = "LiftiumInspectorScript";
	}
};

/* Include of XDM.js */

/* This Toolkit allows for you to send messages between windows, including cross domain.
 * Ideas borrowed from http://code.google.com/p/xssinterface/, but rewritten from scratch.
 *
 * XDM has two methods for sending messages cross domain. The first of which uses
 * postMessages(), an HTML 5 javascript method.
 * As I write this, the following * browsers support postMessage
 * Firefox 3.0+
 * IE 8+
 * Safari 4+
 * Chrome 3+
 * Opera 9+
 *
 * For the rest of the browsers, we use a backward compatible hack that utilizes an
 * external html file that acts as a conduit for information - XDM.iframeUrl
 * This file is expected to be able to parse the query string and act upon
 * the parameters.
 */

var XDM = {
	allowedMethods : [],
	debugOn	   : false, // Print debug messages to console.log

	// These options only needed for the iframe based method,
	// for browsers that don't support postMessage
	iframeUrl      : "/liftium_iframe.html",
	postMessageEnabled : true // Set to false to force fallback method
};


/*
 * @param frame - the window object to execute the code in. Example: top, window.parent
 * @param method - the method to execute in the parent window. Note the other window has to be listening for it with XDMListen(), and the method must be in XDM.allowedMethods
 */
XDM.send = function (destWin, method, args){
	XDM.debug("XDM.send called from " + document.location.hostname);
	// Sanity checks
	if (typeof method != "string") {
		XDM.debug("Bad argument for XDM.send, 'method' is not a string, (" + typeof method + ")");
		return false;
	}
	if ( typeof args == "undefined" ){
		// Just set it to an empty array
		args = [];
	}

	if (XDM.canPostMessage()){
		return XDM._postMessage(destWin, method, args);
	} else {
		return XDM._postMessageWithIframe(destWin, method, args);
	}

};


XDM.getDestinationDomain = function(destWin){
	if (destWin == top){
		// Pull domain from referrer.
		if (document.referrer.toString() !== ''){
			var m = document.referrer.toString().match(/https*:\/\/([^\/]+)/);
			XDM.debug("Hostname for destWin set to " + m[1] + " using referrer");
			return m[1];
		} else {
			return false;
		}
	} else {
		return destWin.location.hostname;
	}
};


XDM._postMessage = function(destWin, method, args) {
	XDM.debug("Sending message using postMessage()");
	var d = XDM.getDestinationDomain(destWin), targetOrigin;
	if (d === false){
		targetOrigin = '*';
	} else {
		targetOrigin = 'http://' + d;
	}


	var msg = XDM.serializeMessage(method, args);

	if(destWin.postMessage) { // HTML 5 Standard
		return destWin.postMessage(msg, targetOrigin);
	} else if(destWin.document.postMessage) { // Opera 9
		return destWin.document.postMessage(msg, targetOrigin);
	} else {
		throw ("No supported way of using postMessage");
	}
};


XDM._postMessageWithIframe = function(destWin, method, args) {
	XDM.debug("Sending message using iframe");
	if (XDM.iframeUrl === null) {
		XDM.debug("Iframe method called, but no html file is specified");
		return false;
	}


	var d = XDM.getDestinationDomain(destWin), targetOrigin;
	if (d === false){
		// No where to send
		return false;
	} else {
		targetOrigin = 'http://' + d;
	}

	var iframeUrl = targetOrigin + XDM.iframeUrl + '?' + XDM.serializeMessage(method, args);
	XDM.debug("Calling iframe dispatch url: " + iframeUrl);

	if (typeof XDM.iframe == "undefined"){
		XDM.iframe = document.createElement("iframe");
		XDM.iframe.style.display = "none";
		XDM.iframe.width = 0;
		XDM.iframe.height = 0;
		if (document.body === null){
			document.firstChild.appendChild(document.createElement("body"));
		}
		document.body.appendChild(XDM.iframe);
	}
	XDM.iframe.src = iframeUrl;

	return false;
};


XDM.serializeMessage = function(method, args){
	var out = 'method=' + escape(method.toString());
	var x;
	for (var i = 0; i < args.length; i++){
		x = i+1;
		out += ';arg' + x + '=' + escape(args[i]);
	}
	XDM.debug("Serialized message: " + out);
	return out;
};


XDM.canPostMessage = function(){
	if (XDM.postMessageEnabled === false){
		return false;
	} else if( window.postMessage || window.document.postMessage) {
		return true;
	} else {
		return false;
	}
};


XDM.debug = function(msg){
	if (XDM.debugOn && typeof console != "undefined" && typeof console.log != "undefined"){
		console.log("XDM debug: " +  msg);
	}
};


XDM.listenForMessages = function(handler){
	if (XDM.canPostMessage()){
		if (window.addEventListener) { // W3C
			return window.addEventListener("message", handler, false);
		} else if (window.attachEvent){ // IE
			return window.attachEvent("onmessage", handler);
		} else {
			return false;
		}
	} else {
		// Remote iframe will execute the messages
		return true;
	}
};


XDM.isAllowedMethod = function(method){
	if (typeof method == "undefined") {
		return false;
	}

	var found = false;
	for (var i = 0; i < XDM.allowedMethods.length; i++){
		if (method.toString() === XDM.allowedMethods[i]){
			found = true;
			break;
		}
	}
	return found;
};


XDM.executeMessage = function(serializedMessage){
	var nvpairs = XDM.parseQueryString(serializedMessage);
	if ( XDM.isAllowedMethod(nvpairs["method"])){

		var functionArgs = [], code = nvpairs["method"];
		// Build up the argument list
		for (var prop in nvpairs){
			if (prop.substring(0, 3) == "arg"){
				functionArgs.push(nvpairs[prop].replace(/"/g, '\\"'));
			}
		}

		// Why hard code this? To prevent stupid shit.
		if (functionArgs.length > 0){
			code += '("' + functionArgs.join('","') + '");';
		} else {
			code += "();";
		}
		if (top != self ){
			nvpairs.destWin = nvpairs.destWin || "top";
			code = nvpairs.destWin + "." + code;
		}

		XDM.debug("Evaluating " + code);
		return eval(code);
	} else {
		XDM.debug("Invalid method from XDM: " + nvpairs["method"]);
		return false;
	}
};


/* This code looks at the supplied query string and parses it.
 * It returns an associative array of url decoded name value pairs
 */
XDM.parseQueryString = function (qs){
	var ret = [];
	if (typeof qs != "string") { return ret; }

	if (qs.charAt(0) === '?') { qs = qs.substr(1); }

	qs=qs.replace(/\;/g, '&', qs);

	var nvpairs=qs.split('&');

	for (var i = 0, intIndex; i < nvpairs.length; i++){
		if (nvpairs[i].length === 0){
			continue;
		}

		var varName = '', varValue = '';
		if ((intIndex = nvpairs[i].indexOf('=')) != -1) {
			try {
				// UTF-8 version
				varName = decodeURIComponent(nvpairs[i].substr(0, intIndex));
				varValue = decodeURIComponent(nvpairs[i].substr(intIndex + 1));
			} catch (e) {
				// non-UTF version
				varName = unescape(nvpairs[i].substr(0, intIndex));
				varValue = unescape(nvpairs[i].substr(intIndex + 1));
			}
		} else {
			// No value, but it's there
			varName = nvpairs[i];
			varValue = true;
		}

		ret[varName] = varValue;
	}

	return ret;
};

/* Set up */
Liftium.now = new Date();
if (typeof wgNow != "undefined") { /* wgNow is not defined on exitstitials FIXME */
	Liftium.now = wgNow;
	Liftium.d("Using monaco time:", 7, wgNow);
}
Liftium.startTime = Liftium.now.getTime();
Liftium.debugLevel = Liftium.getRequestVal('liftium_debug', 0) || Liftium.cookie("liftium_debug");
Liftium.maxHopTime = Liftium.getRequestVal('liftium_timeout', 0) || Liftium.cookie("liftium_timeout") || 1800000;

LiftiumOptions.error_beacon = !Liftium.debugLevel && !Liftium.getRequestVal('liftium_onerror', 0) && !Liftium.cookie("liftium_onerror");
if (LiftiumOptions.error_beacon !== false ){
	(function () {
		var originalOnError = window.onerror;
		window.onerror = function(m, l, e) {
			originalOnError && originalOnError(m, l, e);
			return Liftium.catchError(m, l, e);
		}
	}());
}

} // \if (typeof Liftium == "undefined" )


// Gentlemen, Start your optimization!

if (window.wgAdDriverStartLiftiumOnLoad) {
	Liftium.addEventListener(window, 'load', Liftium.init);
} else {
	if (Liftium.empty(LiftiumOptions.offline)){
		Liftium.init();
	}
}

Liftium.addEventListener(window, 'load', Liftium.onLoadHandler);
