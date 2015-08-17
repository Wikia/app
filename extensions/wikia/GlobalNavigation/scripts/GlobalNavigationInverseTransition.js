require(['jquery', 'wikia.window'], function($, win) {
	'use strict';
	var $globalNav = $('#globalNavigation');

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
});
