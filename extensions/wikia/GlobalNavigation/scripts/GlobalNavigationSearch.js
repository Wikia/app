require(['jquery', 'wikia.browserDetect', 'GlobalNavigationiOSScrollFix'], function ($, browserDetect, scrollFix) {
	'use strict';
	var $selectElement = $('#searchSelect'),
		$searchInput = $('#searchInput'),
		$autocompleteObj;

	/**
	 * Set options on search form
	 */
	function setFormOptions() {
		var $selectedOption = $selectElement.find('option:selected'),
			isLocalSearchDisabled = !$selectElement.length;

		$searchInput.attr('placeholder', $selectedOption.data('placeholder'));
		$('#searchForm').attr('action', $selectedOption.attr('data-search-url'));
		//Setting reference to jQuery search autocomplete object
		$autocompleteObj = $autocompleteObj || $searchInput.data('autocomplete');
		if ($selectedOption.val() === 'global' || isLocalSearchDisabled) {
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
		$('#searchInputResultLang').prop('disabled', enable);
		if ($autocompleteObj) {
			if (enable) {
				$autocompleteObj.enable();
			} else {
				$autocompleteObj.disable();
			}
		}
	}

	$(function () {
		var $globalNav = $('#globalNavigation'),
			$searchForm = $('#searchForm');

		//Checks whether the searchInput is empty and prevents any action if true
		$searchForm.submit(function () {
			if (!$searchInput.val()) {
				return false;
			}
		})

		if ($selectElement) {
			setFormOptions();
			$selectElement
				.on('change keyup keydown', function () {
					setFormOptions();
				});
		}

		if (browserDetect.isIOS7orLower()) {
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
