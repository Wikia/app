/* Simple Ad Server written in javascript.
 * Pulls Ajax configuration to deliver ads for various Ad Networks
 * Allows for the backup tags to be just "Athena.hop()", which will go to the next network in the list
 * Sends a beacon back upon success/failure for reporting
 */

Athena = {};
Athena.pageVars = new Array();
Athena.configUrl = "/athena/AthenaConfig.php";
Athena.setup = function (){
	// Allow for the debug level to be set in the url
	var athenaUrlDebug = document.location.search.match(/athena_debug=[A-Za-z0-9_\-]+/);
	if (athenaUrlDebug != null ){ 
		Athena.debugLevel = athenaUrlDebug.toString().substr(13);
		Athena.debug("Debug level set to " + Athena.debugLevel);
	} else {
		Athena.debugLevel = 0;
	}

};

/* Pull the current configuration from our web servers via json 
 */
Athena.pullConfig = function (){
	Athena.debug("pullConfig() called");
	Athena.loadScript(Athena.configUrl, true);
};

Athena.callAd = function (slotname){
	Athena.debug("Config for " + slotname + " is " +
		Athena.print_r(Athena.config['slots'][slotname]), 5); 

	for (i = 0; i < Athena.config['slots'][slotname].length; i++){
		// Check to see if it has already been called
		if (Athena.config['slots'][slotname][i]['called'] == true){
			continue;
		}
		
		// Print the tag
		document.write(Athena.config['slots'][slotname][i]['tag']); 

		// Mark it as called
		Athena.config['slots'][slotname][i]['called'] = true;
		break;
	}
};

Athena.hop = function (slotname){
	Athena.debug("hop() called");
	//Athena.sendBeacon(false, ...);
	Athena.callAd(slotname);	
};

/* Send a beacon back to our server so we know if it worked */
Athena.sendBeacon = function (success, network, networkInfo, geography, site, page){
	Athena.debug("sendBeacon() called");

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
	alert("Athena error: " + msg);
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

// Init
Athena.setup();
