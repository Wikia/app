require(['wikia.querystring'], function (qs) {
	'use strict';

	// reload the page after choosing ordering option
	var orderingOptions = document.getElementById('orderMapList');
	orderingOptions.addEventListener('change', function(event) {
		qs().setVal('sort', event.target.value, false).goTo();
	});
});
