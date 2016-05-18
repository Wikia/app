/*global require*/
require([
	'jquery',
	'wikia.window',
	require.optional('ext.wikia.adEngine.template.bfaa')
], function($, win, bfaa) {
	'use strict';
	var $globalNav = $('#globalNavigation');

	function changeStateOnScroll() {
		var adSize = (bfaa && bfaa.getSize()) || 0,
			scrollTop = win.pageYOffset,
			inversedStateClass = 'inverse';

		if (scrollTop <= adSize && $globalNav.hasClass(inversedStateClass)) {
			$globalNav.removeClass(inversedStateClass);
		} else if (scrollTop > 200 + adSize) {
			$globalNav.addClass(inversedStateClass);
		}
		console.log(adSize, $globalNav.hasClass(inversedStateClass));
	}

	$(win).on('scroll', $.throttle(250, changeStateOnScroll));
});
