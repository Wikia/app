(function($) {
	'use strict';
	document.addEventListener('DOMContentLoaded', function() {
		var inputResultLang, formElement, selectElement, $searchInput, searchLabel, chevron;


		function setFormOptions() {
			var selectedOption;

			selectedOption = selectElement.selectedOptions[0];
			searchLabel.textContent = selectedOption.text;
			formElement.action = selectedOption.getAttribute('data-search-url');
			if (selectedOption.value === 'global') {
				inputResultLang.disabled = false;
				if ($searchInput.data('autocomplete')) {
					$searchInput.data('autocomplete').disable();
				}
			} else {
				inputResultLang.disabled = true;
				if ($searchInput.data('autocomplete')) {
					$searchInput.data('autocomplete').enable();
				}
			}
		}

		// TODO change id to camelCase
		inputResultLang = document.getElementById('search-input-resultLang');
		chevron = document.getElementById('search-form-chevron');
		formElement = document.getElementById('search-form');
		selectElement = document.getElementById('search-select');
		searchLabel = document.getElementById('search-label-inline');
		$searchInput = $('#searchInput');
		// TODO rework to jquery

		setFormOptions();

		selectElement.addEventListener('change', function() {
			setFormOptions();
		});
		selectElement.addEventListener('keyup', function() {
			setFormOptions();
		});
		selectElement.addEventListener('keydown', function() {
			setFormOptions();
		});
		selectElement.addEventListener('focus', function() {
			chevron.classList.add('dark');
		});
		selectElement.addEventListener('blur', function() {
			chevron.classList.remove('dark');
		});
	});
}(jQuery));
