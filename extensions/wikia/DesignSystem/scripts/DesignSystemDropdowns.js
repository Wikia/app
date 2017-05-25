$(function ($) {
	'use strict';

	if (window.Wikia.isTouchScreen()) {
		$('body').on('click touchstart', '.wds-dropdown', function (e) {
			if (!$(this).hasClass('is-clicked')) {
				$(this).addClass('is-clicked');
				e.preventDefault();
			}
		}).on('mouseleave', '.wds-dropdown', function () {
			$(this).removeClass('is-clicked');
		});
	}
});