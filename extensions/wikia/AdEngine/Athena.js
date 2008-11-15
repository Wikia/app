/* Simple Ad Server written in javascript.
 * Pulls Ajax configuration to deliver ads for various Ad Networks
 * Allows for the backup tags to be just "Athena.hop()", which will go to the next network in the list
 * Sends a beacon back upon success/failure for reporting
 */

Athena = {};
Athena.pageVars = new Array();
Athena.debugLevel = 1;
Athena.ApiUrl = "http://nick.dev.wikia-inc.com/extensions/wikia/AdEngine/AthenaConfig.php";

// Load up config asynchronously

/* Pull down the configuration via ajax */
Athena.pullConfig = function (){
	Athena.debug("pullConfig() called");
	// TODO: Make this asyncronous for performance and with a time out for reliability
	document.write('<scr' + 'ipt src="' + Athena.ApiUrl + '"></scr' + 'ipt>');
};

Athena.callAd = function (slotname){
	Athena.debug("callAd() called for " + slotname);
};

/* Hop to the next ad in the network */
Athena.hop = function (){
	Athena.debug("hop() called");

};

/* Send a beacon back to our server so we know if it worked */
Athena.sendBeacon = function (success, network, networkInfo, geography, site, page){
	Athena.debug("sendBeacon() called");

};


/* Set / get page variables */
Athena.setPageVar = function (key, value){
	Athena.pageVars[key]=value;
	Athena.debug("Page var '" + key + "' set to '" + value + "'");
	return true;
};

Athena.getPageVar = function (key){
	if (Athena.pageVars[key] !== undefined){
		return Athena.pageVars[key];
	} else {
		return '';
	}
};

Athena.debug = function (msg){
	if (Athena.debugLevel == 0){
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
