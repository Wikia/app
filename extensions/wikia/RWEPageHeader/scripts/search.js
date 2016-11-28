$(function ($) {
	'use strict';

	var $RWEPageHeaderNav = $('.rwe-page-header-nav'),
		$searchFormRWE = $('#searchFormWrapperRWE'),
		$searchInputWrapper = $searchFormRWE.find('.wds-global-navigation__search-input-wrapper'),
		$searchInput = $searchFormRWE.find('.wds-global-navigation__search-input'),
		$searchSubmit = $searchFormRWE.find('.wds-global-navigation__search-submit'),
		placeholderText = $searchInput.attr('placeholder'),
		activeSearchClass = 'wds-search-is-active';

	function activateSearch() {
		if (!$RWEPageHeaderNav.hasClass(activeSearchClass)) {
			$RWEPageHeaderNav.addClass(activeSearchClass);
			$searchInput.attr('placeholder', $searchInput.data('active-placeholder'));

			/**
			 * [bug fix]: On Firefox click is not triggered when placeholder text is changed
			 * that is why we have to do it manually
			 */
			$(this).click();
		}
	}

	function deactivateSearch() {
		$searchSubmit.prop('disabled', true);
		$RWEPageHeaderNav.removeClass(activeSearchClass);
		$searchInput.attr('placeholder', placeholderText).val('');
	}

	function init() {
		$searchInput.on('focus', activateSearch);

		$searchInput.on('input', function () {
			var textLength = this.value.length;

			if (textLength > 0 && $searchSubmit.prop('disabled')) {
				$searchSubmit.prop('disabled', false);
			} else if (textLength === 0) {
				$searchSubmit.prop('disabled', true);
			}
		});

		$searchInput.on('keydown', function (event) {
			// Escape key
			if (event.which === 27) {
				$searchInputWrapper.removeClass('wds-is-active');
				this.blur();
				deactivateSearch();
				event.preventDefault();
				event.stopImmediatePropagation();
			}
		});

		$searchFormRWE.find('.wds-global-navigation__search-close').on('click', deactivateSearch);

		if ($searchInput.is(':focus')) {
			activateSearch();
		}

		if ($searchInput.val().length === 0) {
			$searchSubmit.prop('disabled', true);
		}
	}

	if ($searchInput.length) {
		init();
	}

});
