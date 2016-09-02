$(function ($) {
	'use strict';

	var $globalNav = $('.wds-global-navigation'),
		$searchInput = $globalNav.find('.wds-global-navigation__search-input'),
		$searchSubmit = $globalNav.find('.wds-global-navigation__search-submit'),
		placeHolderText = $searchInput.attr('placeholder'),
		activeSearchClass = 'wds-search-is-active';

	$searchInput.on('focus', function () {
		if (!$globalNav.hasClass(activeSearchClass)) {
			$globalNav.addClass(activeSearchClass);
			$searchInput.attr('placeholder', $searchInput.data('active-text'));
		}
	});

	// Make sure default state is correct when navigating back in Chrome
	if ($searchInput.val().length > 0 && $searchSubmit.prop('disabled')) {
		$searchSubmit.prop('disabled', false);
	}

	$searchInput.on('input', function () {
		var textLength = $(this).val().length;

		if (textLength > 0 && $searchSubmit.prop('disabled')) {
			$searchSubmit.prop('disabled', false);
		} else if (textLength === 0) {
			$searchSubmit.prop('disabled', true);
		}
	});

	$globalNav.find('.wds-global-navigation__search-close').on('click', function () {
		$globalNav.removeClass(activeSearchClass);
		$searchInput.attr('placeholder', placeHolderText);
	});
});
