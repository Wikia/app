(function () {
	'use strict';
	var $ = require('jquery'),
		win = require('wikia.window'),
		$globalNav = $('#globalNavigation');

	function changeStateOnScroll() {
		var scrollTop = win.pageYOffset,
			inversedStateClass = 'inverse';

		if (scrollTop <= 0 && $globalNav.hasClass(inversedStateClass)) {
			$globalNav.removeClass(inversedStateClass);
		} else if (scrollTop > 200) {
			$globalNav.addClass(inversedStateClass);
		}
	}

	$(win).on('scroll', $.throttle(250, changeStateOnScroll));
})();
