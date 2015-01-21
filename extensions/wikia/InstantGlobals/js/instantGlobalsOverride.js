(function () {
	'use strict';
	window.location.search.replace(
		/InstantGlobals\.(\w+)=(\d)/g,
		function ($0, $1, $2) {
			Wikia.InstantGlobals[$1] = $2 > 0;
		}
	);
})();
