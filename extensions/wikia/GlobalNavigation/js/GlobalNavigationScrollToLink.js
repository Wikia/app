require(['wikia.scrollToLink'], function(scrollToLink) {
	'use strict';

	var offset, init;

	offset = 16; //additional spacing

	init = function() {
		var globalNavigationHeight = document.getElementById('globalNavigation').offsetHeight;

		scrollToLink.init(globalNavigationHeight + offset);
	};

	if (document.readyState === 'complete' || document.readyState === 'loaded' || document.readyState === 'interactive') {
		init();
	} else {
		document.addEventListener('DOMContentLoaded', init, false);
	}
});
