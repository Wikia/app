require(['jquery', 'wikia.window'], function($, win) {
	'use strict';
	var $accountNavigation = $('#AccountNavigation');

	function changeStateOnScroll() {
		var scrollTop = win.pageYOffset,
			inversedStateClass = 'inverse';

		if (scrollTop <= 0 && $globalNav.hasClass(inversedStateClass)) {
			$accountNavigation.removeClass('active');
		} else if (scrollTop > 200) {
			$accountNavigation.removeClass('active');
		}
	}

	$(win).on('scroll', $.throttle(250, changeStateOnScroll));
});
