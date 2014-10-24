require(['jquery', 'wikia.browserDetect', 'wikia.window'], function ($, browserDetect, win) {
	'use strict';
	var $selectElement, $chevron, cachedScrollY, $searchInput, $globalNav;

	/**
	 * Look up elements in global navigation's search form and set options for it
	 */
	function setFormOptions() {
		var $inputResultLang = $('#searchInputResultLang'),
			$formElement = $('#searchForm'),
			$searchLabel = $('#searchLabelInline'),
			$selectedOption;

		$selectElement = $('#searchSelect');
		$chevron = $('#searchFormChevron');
		$searchInput = $('#searchInput');
		$globalNav = $('#globalNavigation');

		if (!$selectElement) {
			return;
		}

		$selectedOption = $selectElement.find('option:selected');
		$searchLabel.text($selectedOption.text());
		$formElement.attr('action', $selectedOption.attr('data-search-url'));
		if ($selectedOption.val() === 'global') {
			$inputResultLang.prop('disabled', false);
			if ($searchInput.data('autocomplete')) {
				$searchInput.data('autocomplete').disable();
			}
		} else {
			$inputResultLang.prop('disabled', true);
			if ($searchInput.data('autocomplete')) {
				$searchInput.data('autocomplete').enable();
			}
		}
	}

	/**
	 * Scroll window to top
	 */
	function scrollToTop() {
		cachedScrollY = win.scrollY;
		setTimeout(function () {
			win.scrollTo(win.scrollX, 0);
			$globalNav.addClass('position-static');
		}, 5);
	}

	/**
	 * Restore scrollY to position cached inside cachedScrollY var
	 */
	function restoreScrollY() {
		win.scrollTo(win.scrollX, cachedScrollY);
		$globalNav.removeClass('position-static');
	}

	$(function () {
		var isPositionFixedSupported = browserDetect.isPositionFixedSupported();

		setFormOptions();

		$selectElement.on('change keyup keydown', function () {
			setFormOptions();
		});

		$selectElement.on('focus', function () {
			$chevron.addClass('dark');
			if (browserDetect.isPositionFixedSupported()) {
				scrollToTop();
			}
		});

		$selectElement.on('blur', function () {
			$chevron.removeClass('dark');
			if (browserDetect.isPositionFixedSupported()) {
				restoreScrollY();
			}
		});

		if (!isPositionFixedSupported) {
			$searchInput
				.on('focus', scrollToTop)
				.on('blur', restoreScrollY);
		}
	});
});
