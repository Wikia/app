/*global require*/
require([
	'jquery',
	'wikia.window'
], function ($, win) {
	'use strict';
	var $globalNav = $('#globalNavigation'),
		$topAds = $('#WikiaTopAds');

	function changeStateOnScroll() {
		var adSize = $topAds.height(),
			scrollTop = win.pageYOffset,
			inversedStateClass = 'inverse';

		if (scrollTop <= adSize && $globalNav.hasClass(inversedStateClass)) {
			$globalNav.removeClass(inversedStateClass);
		} else if (scrollTop > 50 + adSize) {
			$globalNav.addClass(inversedStateClass);
		}
	}

	$(win).on('scroll', $.throttle(250, changeStateOnScroll));
});
