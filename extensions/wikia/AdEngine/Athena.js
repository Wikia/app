/* Simple Ad Server written in javascript.
 * Pulls Ajax configuration to deliver ads for various Ad Networks
 * Allows for the backup tags to be simple and centrally managed
 * Sends a beacon back upon success/failure for reporting
 */

Athena = {};
Athena.beaconData = {};
Athena.pageVars = new Array();
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

Athena.callAd = function (slotname){
	Athena.debug("Config for " + slotname + " is " +
		Athena.print_r(Athena.config['slots'][slotname]), 5); 

	for (i = 0; i < Athena.config['slots'][slotname].length; i++){

		var thisAd = Athena.config['slots'][slotname][i];
		// Check to see if it has already been called
		if (thisAd['called'] != undefined){
			continue;
		}
		Athena.debug("Calling Ad from " + thisAd['network_name']);

		// Mark it as called
		Athena.config['slots'][slotname][i]['called'] = new Date();

		// Keep track of the current and next tags for hopping and beacon
		Athena.currentTag = Athena.config['slots'][slotname][i];
		Athena.currentSlot = slotname;

		// Print the tag
		document.write(Athena.config['slots'][slotname][i]['tag']); 

		break;
	}
};

Athena.hop = function (slotname){

	Athena.hopTracker[slotname] = 
	Athena.debug("hop() called");
//	Athena.sendBeacon(false);
	Athena.callAd(Athena.currentSlot);
};

/* Send a beacon back to our server so we know if it worked */
Athena.sendBeacon = function ( success ){
	Athena.debug("sendBeacon() called");

	// success
	Athena.beaconData.success = success;
	// network -- already defined by callAd
	
	// networkInfo
	// TODO -- what is this supposed to contain BTW? :P
	// geography
	// TODO
	// site
	Athena.beaconData.site = Athena.getPageVar('Server');
	// page
	Athena.beaconData.page = Athena.getPageVar('PageId');

	beacon = Athena.json_encode(Athena.beaconData);

	document.write('<img src="' + Athena.beaconUrl + '?beacon=' + beacon + '" />');
};


/* Set / get page variables */
Athena.setPageVar = function (key, value){
	Athena.pageVars[key]=value;
	Athena.debug("Page var '" + key + "' set to '" + value + "'", 3);
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

/*
 * Converts the given data structure to a JSON string.
 * Argument: arr - The data structure that must be converted to JSON
 * http://www.openjs.com/scripts/data/json_encode.php
 */
Athena.json_encode = function (arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(Athena.json_encode(value)); /* :RECURSION: */
            else parts[key] = Athena.json_encode(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
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
        var myDate = new Date();
        return myDate.getMinutes() % 15;
};



// Init
Athena.setup();
