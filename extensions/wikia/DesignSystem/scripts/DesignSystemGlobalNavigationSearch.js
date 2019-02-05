$(function ($) {
	'use strict';

	var $globalNav = $('.wds-global-navigation'),
		$searchContainer = $globalNav.find('.wds-global-navigation__search-container'),
		$searchInput = $globalNav.find('.wds-global-navigation__search-input'),
		$searchSubmit = $globalNav.find('.wds-global-navigation__search-submit'),
		$searchToggle = $globalNav.find('.wds-global-navigation__search-toggle'),
		activeSearchClass = 'wds-search-is-active';

	function activateSearch() {
		if (!$globalNav.hasClass(activeSearchClass)) {
			$globalNav.addClass(activeSearchClass);
			$searchInput.focus();
		}
	}

	function deactivateSearch() {
		$searchSubmit.prop('disabled', true);
		$searchInput.val('');
		$globalNav.removeClass(activeSearchClass);
	}

	$searchInput.on('input', function () {
		var textLength = this.value.length;

		if (textLength > 0 && $searchSubmit.prop('disabled')) {
			$searchSubmit.prop('disabled', false);
		} else if (textLength === 0) {
			$searchSubmit.prop('disabled', true);
		}
	});

	$searchInput
		.on('keydown', function (event) {
			// Escape key
			if (event.which === 27) {
				deactivateSearch();
				$searchInput.blur();
			}
		})
		.on('blur', function () {
			if (!this.value.length) {
				deactivateSearch();
			}
			$searchContainer.removeClass('wds-search-is-focused');
		})
		.on('focus', function () {
			$searchContainer.addClass('wds-search-is-focused');
		});

	$globalNav.find('.wds-global-navigation__search-close').on('click', deactivateSearch);

	if ($searchInput.val().length === 0) {
		$searchSubmit.prop('disabled', true);
	}

	$searchToggle.click(activateSearch);
});
