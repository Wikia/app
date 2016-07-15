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
			inverseOffset = 50,
			inversedStateClass = 'inverse';

		if (scrollTop <= adSize && $globalNav.hasClass(inversedStateClass)) {
			$globalNav.removeClass(inversedStateClass);
		} else if (scrollTop > inverseOffset + adSize) {
			$globalNav.addClass(inversedStateClass);
		}
	}

	$(win).on('scroll', $.throttle(250, changeStateOnScroll));
});
