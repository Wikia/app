require(['wikia.window', 'jquery'], function (window, $) {
	'use strict';

	$(function () {
		$('.pph-local-nav-container').on('mouseenter', function () {
			var container = $(this);

			// move this after the click action, when clicked on tablet
			setTimeout(function () {
				$('.pph-local-nav-item-l2 > .pph-click').removeClass('pph-click');
				container.children('a').addClass('pph-click');
			}, 0);
		});

		$('.pph-local-nav-item-l1').on('mouseleave', function () {
			var menuItem = $(this);
			menuItem.children('a').removeClass('pph-click');
		});

		$('.pph-local-nav-container > a').on('click', function (e) {
			if (!$(this).hasClass('pph-click')) {
				e.preventDefault();
			}
		});
	})
});
