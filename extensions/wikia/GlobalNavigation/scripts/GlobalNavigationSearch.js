require(['jquery', 'wikia.browserDetect', 'GlobalNavigationiOSScrollFix'], function ($, browserDetect, scrollFix) {
	'use strict';
	var $selectElement,
		$chevron,
		$searchInput,
		$globalNav,
		$inputResultLang,
		$formElement,
		$searchLabel,
		$autocompleteObj;

	/**
	 * Look up elements in global navigation's search form
	 */
	function setElements() {
		$inputResultLang = $('#searchInputResultLang');
		$formElement = $('#searchForm');
		$searchLabel = $('#searchLabelInline');
		$selectElement = $('#searchSelect');
		$chevron = $('#searchFormChevron');
		$searchInput = $('#searchInput');
		$globalNav = $('#globalNavigation');
	}

	/**
	 * Set options on search form
	 */
	function setFormOptions() {
		var $selectedOption = $selectElement.find('option:selected');
		$searchLabel.text($selectedOption.text());
		$formElement.attr('action', $selectedOption.attr('data-search-url'));
		//Setting reference to jQuery search autocomplete object
		$autocompleteObj = $autocompleteObj || $searchInput.data('autocomplete');
		if ($selectedOption.val() === 'global') {
			setPropertiesOnInput(false);
		} else {
			setPropertiesOnInput(true);
		}
	}

	/**
	 * Disable or enable properties on search form
	 * @param {boolean} enable - should autocomplete be enabled and lang input disabled
	 */
	function setPropertiesOnInput(enable) {
		$inputResultLang.prop('disabled', enable);
		if ($autocompleteObj) {
			if (enable) {
				$autocompleteObj.enable();
			} else {
				$autocompleteObj.disable();
			}
		}
	}

	$(function () {
		setElements();

		if ($selectElement) {
			setFormOptions();
			$selectElement
				.on('change keyup keydown', function () {
					setFormOptions();
				})
				.on('focus', function () {
					$chevron.addClass('dark');
				})
				.on('blur', function () {
					$chevron.removeClass('dark');
				});
		}

		if (!browserDetect.isIOS7orLower()) {
			$searchInput
				.on('focus', function () {
					scrollFix.scrollToTop($globalNav);
				})
				.on('blur', function () {
					scrollFix.restoreScrollY($globalNav);
				});
		}
	});
});
