/* Simple Ad Server written in javascript.
 * Pulls Ajax configuration to deliver ads for various Ad Networks
 * Allows for the backup tags to be simple and centrally managed
 * Sends a beacon back upon success/failure for reporting
 */

Athena = {};
Athena.beaconData = {};
Athena.beaconData.events=Array();
Athena.pageVars = new Array();
Athena.loadedTags = new Array();
Athena.configUrl = "http://athena.dev.wikia-inc.com/athena/configApi.php";
Athena.beaconUrl = "http://athena.dev.wikia-inc.com/athena/beacon.php";
Athena.hopTracker = new Array();

Athena.setup = function (){
	Athena.debugLevel = Athena.getRequestVal('athena_debug', 0);
};

/* Pull the current configuration from our web servers via json 
 */
Athena.pullConfig = function (){
	Athena.debug("pullConfig() called");
	var myConfigUrl = Athena.configUrl + '?athena_debug=' + Athena.debugLevel;
	myConfigUrl += '&' + Athena.buildQueryString(Athena.pageVars);
	Athena.loadScript(myConfigUrl, true);
};

/* Do the work of displaying an ad */
Athena.callAd = function (slotname){
	Athena.debug("Config for " + slotname + " is " +
		Athena.print_r(Athena.config['slots'][slotname]), 7); 
	
	Athena.recordHop(slotname);

	var start;
	if (Athena.ok2Hop(slotname)){
		start = 0;
	} else {
		// No more hops available. Go to the last one in the list
		start = Athena.config['slots'][slotname].length-1;
		Athena.debug("Using the last tag in the list (" + start + ")");
	}

	for (i = start; i < Athena.config['slots'][slotname].length; i++){
		var thisAd;

		thisAd = Athena.config['slots'][slotname][i];
		// Check to see if it has already been called
		if (thisAd['started'] != undefined){
			continue;
		}

		Athena.debug("Calling Ad from " + thisAd['network_name']);
		Athena.debug("Config for this hop #" + Athena.hopTracker[slotname]['count'] +
			" for " + slotname + " is " +
			Athena.print_r(thisAd), 5); 
	

		// Mark it as started
		Athena.config['slots'][slotname][i]['started'] = new Date();

		// Keep track of the current and next tags for hopping and beacon
		Athena.currentTag = Athena.config['slots'][slotname][i];
		Athena.currentSlot = slotname;
		Athena.recordEvent({
			"type": "Attempt",
			"tag_id": thisAd["tag_id"]
		});

		// Keep track of if the ad loaded.
		Athena.loadedTags[slotname]={"tag_id": thisAd["tag_id"], "started": new Date()};
		YAHOO.util.Event.purgeElement(slotname + "_load");
		YAHOO.util.Event.onContentReady(slotname + "_load", Athena.adLoadHandler, thisAd["tag_id"]);

		// Attach a listener so we know when the ad loads.

		// Print the tag
		document.write(Athena.config['slots'][slotname][i]['tag']); 

		break;
	}

	// Rut roh
	document.write('<!-- No ads to call for ' + slotname + '-->');
};

/* Handler function for when the _load div is done (when the ad is loaded)
 * Called from the delayed ad loading code
 */
Athena.adLoadHandler = function(tag_id){
	var now, slotname, hopTime;

	slotname = this.id.replace(/_load/, '');

	if (Athena.loadedTags[slotname]["tag_id"] != tag_id){
		return false; // This is the wrong listener. Note that purgeElement isn't working correctly.
	}

	/* See how long it took. Not working correctly. :(
	now = new Date();
	hopTime = now.getMilliseconds() - Athena.loadedTags[slotname]["started"].getMilliseconds();
	*/

	Athena.recordEvent({
		"type": "Ad Loaded",
		"slotname": slotname,
		"tag_id": Athena.loadedTags[slotname]["tag_id"]
		// "hopTime": hopTime
	});
};


/* This is the backup tag used to go to the next ad in the configuration */
Athena.hop = function (){
	var now, hopTime;
	Athena.debug("hop() called");

	// See how long it took
	now = new Date();
	hopTime = now.getMilliseconds() - Athena.currentTag['started'].getMilliseconds();

	// Note that there was a hop
	Athena.recordEvent({
		"type": "Reject",
		"tag_id": Athena.currentTag['tag_id'],
		"hopTime": hopTime
        });


	// Call the next ad in the stack
	Athena.callAd(Athena.currentSlot);
};


/* Keep track of the number of hops, and the total time spent hopping. */
Athena.recordHop = function (slotname) {
	// Keep track of the number of hops
	if (Athena.hopTracker[slotname] == undefined){
		Athena.hopTracker[slotname] = Array();
		Athena.hopTracker[slotname]['started'] = new Date();
		Athena.hopTracker[slotname]['count'] = 1;
	} else {
		Athena.hopTracker[slotname]['count']++; 
	}
	Athena.debug("Hop Tracker Data: " + Athena.print_r(Athena.hopTracker), 6);
};


/* Is it ok to do another hop? Check how many hops they have already done and/or
 * How much time they have already spent waiting. Return true/false
 */
Athena.ok2Hop = function (slotname){
	var now, hopTime;

	// Check the number of hops
	if (Athena.hopTracker[slotname]['count'] > Athena.config.maxHops){
		Athena.debug("Maximum number of hops exceeded (" + Athena.config.maxHops + ")..");
		return false;
	}

	// Check the time spent on hops
	now = new Date();
	hopTime = now.getMilliseconds() - Athena.hopTracker[slotname]['started'].getMilliseconds();
	if (hopTime > Athena.config.maxHopTime){
		Athena.debug("Maximum hop time exceeded (" + Athena.config.maxHopTime + ").");
		return false;
	}

	// All good
	return true;
};


/* Record an event. data arg should have enough info to identify it */
Athena.recordEvent = function (data){
	Athena.beaconData.events.push(data);
	Athena.debug("Event recorded: " + Athena.print_r(data), 4);
};


/* Send a beacon back to our server so we know if it worked */
Athena.sendBeacon = function (){
	Athena.debug("sendBeacon() called");
	Athena.beaconData.cookie="my cookie";
	Athena.debug("Beacon: " + Athena.print_r(Athena.beaconData), 7);

	var beacon = Athena.json_encode(Athena.beaconData);

	var head= document.getElementsByTagName('head')[0];
	var s= document.createElement('script');
	s.type= 'text/javascript';
	s.src= Athena.beaconUrl + '?beacon=' + encodeURIComponent(beacon) + '&events=' + encodeURIComponent(Athena.json_encode(Athena.beaconData.events));
	head.appendChild(s);
};

YAHOO.util.Event.onDOMReady(Athena.sendBeacon);


/* Set / get page variables */
Athena.setPageVar = function (key, value){
	Athena.pageVars[key]=value;
	Athena.debug("Page var '" + key + "' set to '" + value + "'", 4);
	return true;
};

Athena.getPageVar = function (key){
	if (Athena.pageVars[key] !== undefined){
		return Athena.pageVars[key];
	} else {
		return '';
	}
};

/* Send a message to the debug console if available, otherwise alert */
Athena.debug = function (msg, level){
	if (Athena.debugLevel == 0){
		return false;
	} else if (level > Athena.debugLevel){
		return false;
	} else if (YAHOO.log !== undefined){
		YAHOO.log("Athena debug: " + msg);
	} else {
		alert("Athena debug: " + msg);
	}
};


Athena.reportError = function (error){
	// TODO send back a javascript call to an error reporter
	// For now, just do an alert
	alert("Athena error: " + error);
};

/* Load the supplied url inside a script tag  */
Athena.loadScript = function(url) {
	document.write('<script type="text/javascript" src="' + url + '"><\/script>');
};


/* Javascript equivalent of php's print_r. 
 * http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
Athena.print_r = function (arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += Athena.print_r(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
};

/* Nick wrote: This code looks at the query string supplied in the url and parses it.
 * It returns an associative array of url decoded name value pairs
 */
Athena.parseQueryString = function (qstring){
  var ret = new Array();
  var varName, varValue, nvpairs, intIndex, i;
  
  if (qstring.charAt(0) == '?') qstring = qstring.substr(1);
  if (qstring.length == 0) return ret;
  
  qstring=qstring.replace(/\;/g, '&', qstring);
  
  nvpairs=qstring.split('&');

  for (i = 0; i < nvpairs.length; i++){
    if (nvpairs[i].length == 0){
      continue;
    }

    if ((intIndex = nvpairs[i].indexOf('=')) != -1) {
      varName = decodeURIComponent(nvpairs[i].substr(0, intIndex));
      varValue = decodeURIComponent(nvpairs[i].substr(intIndex + 1)); 
    } else {
      varName = decodeURIComponent(nvpairs[i].substr(0, intIndex));
      varValue = '';
    }

    if (varName == '' || varValue == ''){
      continue;
    }

    ret[varName]=varValue;
  }

  return ret;
};


/* Look for a particular value in the query string, and return it. Optional second arg is a default. */
Athena.getRequestVal = function(varname, defaultval){
	nvpairs = Athena.parseQueryString(document.location.search);
	if (nvpairs[varname] !== undefined){
		return nvpairs[varname];
	} else {
		return defaultval;
	}
};


/* Take an array of name value pairs and return a url encoded string */
Athena.buildQueryString = function (nvpairs){
	var ret='';
	for (name in nvpairs){
		if (ret !=''){
			ret += "&";
		}
		ret += escape(name) + '=' + escape(nvpairs[name]);
	}
	return ret;
};


/* Generate random number to use as a cache buster during the call for ad (OpenX and DART) 
 * AdsCB is referenced in a lot of places, but I'd like for us to use Athena.random() long term
 */
var AdsCB = Math.floor(Math.random()*99999999);
Athena.random = function (){
	return AdsCB;
};


/* Target based on the minute of the hour */
Athena.getMinuteTargeting = function (){
        var myDate;
	myDate = new Date();
        return myDate.getMinutes() % 15;
};


/* Alias for our JSON encoder; see json2.js for code */
Athena.json_encode = JSON.stringify;

// Init
Athena.setup();
