require(['wikia.scrollToLink'], function(scrollToLink) {
	'use strict';
	var offset = 16; //additional spacing

	document.addEventListener("DOMContentLoaded", function() {
		var globalNavigationHeight = document.getElementById('globalNavigation').offsetHeight;

		scrollToLink.init(globalNavigationHeight + offset);
	});

});
