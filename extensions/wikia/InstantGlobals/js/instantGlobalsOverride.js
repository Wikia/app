/**
 * Method for overriding boolean InstantGlobals
 * based on querystring params
 */
location.search.replace(
	/InstantGlobals\.(\w+)=(\d)/g,
	//Applying all the InstantGlobals.*=[0|1] params
	function (a, b, c) {
		Wikia.InstantGlobals[b] = c > 0;
	}
);
