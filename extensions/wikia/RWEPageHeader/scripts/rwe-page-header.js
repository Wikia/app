require(['jquery'], function ($) {
	'use strict';

	$(function () {
		$('.rwe-page-header--dropdown').hover(function () {
			$(this).parent('.rwe-page-header__nav-element')
				.addClass('rwe-page-header__nav-element--active');
		}, function () {
			$(this).parent('.rwe-page-header__nav-element')
				.removeClass('rwe-page-header__nav-element--active');
		});
	});
});
