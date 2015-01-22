/**
 * Module for overriding boolean InstantGlobals
 * based on querystring params
 */
(function () {
	'use strict';
	window.location.search.replace(
		/InstantGlobals\.(\w+)=(\d)/g,
		//Applying all the InstantGlobals.*=[0|1] params
		function ($0, $1, $2) {
			Wikia.InstantGlobals[$1] = $2 > 0;
		}
	);
})();
