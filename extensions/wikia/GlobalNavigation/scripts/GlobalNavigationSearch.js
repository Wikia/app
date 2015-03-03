require(['jquery', 'wikia.browserDetect', 'GlobalNavigationiOSScrollFix'], function ($, browserDetect, scrollFix) {
	'use strict';
	var $selectElement = $('#searchSelect'),
		$searchInput = $('#searchInput'),
		$searchForm = $('#searchForm'),
		$autocompleteObj;

	/**
	 * Set options on search form
	 */
	function setFormOptions() {
		var $selectedOption = $selectElement.find('option:selected'),
			isLocalSearchDisabled = !$selectElement.length;

		$searchInput.attr('placeholder', $selectedOption.data('placeholder'));
		$searchForm.attr('action', $selectedOption.attr('data-search-url'));
		//Setting reference to jQuery search autocomplete object
		$autocompleteObj = $autocompleteObj || $searchInput.data('autocomplete');
		if ($selectedOption.val() === 'global' || isLocalSearchDisabled) {
			setPropertiesOnInput(false);
		} else {
			setPropertiesOnInput(true);
		}

		//Disables search button until the user has entered at least one character.
		$searchInput.keydown(function () {
			if ($searchInput.val()) {
				$searchSubmit.prop('disabled', false);
			} else {
				$searchSubmit.prop('disabled', 'disabled');
			}
		})
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
		var $globalNav = $('#globalNavigation');

		//Disables search button until the user has entered at least one character.
		$searchForm.submit(function (e) {
			if (!$searchInput.val()) {
				e.preventDefault();
				e.stopPropagation();
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
