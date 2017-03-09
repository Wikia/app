require(['wikia.window', 'jquery'], function (window, $) {
	'use strict';

	$(function () {
		$('.pph-local-nav-container').on('mouseenter', function () {
			$(this).children('.pph-local-nav-sub-menu').show();
		});
		$('.pph-local-nav-container').on('mouseleave', function () {
			$(this).children('.pph-local-nav-sub-menu').hide();
		});
	})
});
