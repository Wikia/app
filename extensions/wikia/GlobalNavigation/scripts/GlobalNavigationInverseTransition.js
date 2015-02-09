require(['jquery', 'wikia.window'], function($, win) {
	'use strict';
	var $globalNav = $('#globalNavigation'),
		$accountNavigation = $('#AccountNavigation');

	function changeStateOnScroll() {
		var scrollTop = win.pageYOffset,
			inversedStateClass = 'inverse';

		if (scrollTop <= 0 && $globalNav.hasClass(inversedStateClass)) {
			$accountNavigation.removeClass('active');
			$globalNav.removeClass(inversedStateClass);
		} else if (scrollTop > 200) {
			$accountNavigation.removeClass('active');
			$globalNav.addClass(inversedStateClass);
		}
	}

	$(win).on('scroll', $.throttle(250, changeStateOnScroll));
});
