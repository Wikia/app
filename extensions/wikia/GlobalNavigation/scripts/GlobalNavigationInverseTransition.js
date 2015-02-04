require(['jquery', 'wikia.window'], function($, win) {
	'use strict';
	var $globalNav = $('#globalNavigation');

	function changeStateOnScroll() {
		if (win.scrollY === 0 && $globalNav.hasClass('inverse')) {
			$globalNav.removeClass('inverse');
		} else if  (win.scrollY > 200) {
			$globalNav.addClass('inverse');
		}
	}

	$(win).on('scroll', $.throttle(250, changeStateOnScroll));
});