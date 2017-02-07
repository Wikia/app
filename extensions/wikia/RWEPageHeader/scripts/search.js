$(function ($) {
	'use strict';
	require(['wikia.tracker'], function(tracker) {
		var $RWEPageHeaderNav = $('.rwe-page-header-nav'),
			$searchFormWrapperRWE = $('#searchFormWrapperRWE'),
			$searchInputFormRWE = $searchFormWrapperRWE.find('form'),
			$searchInputWrapper = $searchFormWrapperRWE.find('.wds-global-navigation__search-input-wrapper'),
			$searchInput = $searchFormWrapperRWE.find('.wds-global-navigation__search-input'),
			$searchSubmit = $searchFormWrapperRWE.find('.wds-global-navigation__search-submit'),
			placeholderText = $searchInput.attr('placeholder'),
			activeSearchClass = 'wds-search-is-active',
			track = tracker.buildTrackingFunction({
				category: 'rwe-page-header',
				trackingMethod: 'analytics',
				label: 'search'
			});


		function activateSearch() {
			if (!$RWEPageHeaderNav.hasClass(activeSearchClass)) {
				track({
					action: tracker.ACTIONS.CLICK
				});

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

			$searchInputFormRWE.on('submit', function() {
				track({
					action: tracker.ACTIONS.SUBMIT
				});
			});

			$searchFormWrapperRWE.find('.wds-global-navigation__search-close').on('click', deactivateSearch);

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
});
