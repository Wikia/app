(function() {
	'use strict';
	document.addEventListener('DOMContentLoaded', function() {
		var inputResultLang, formElement, selectElement, searchLabel, chevron;

		selectElement = document.getElementById('search-select');

		if (!selectElement) {
			return;
		}

		function setFormOptions() {
			var selectedOption;

			selectedOption = selectElement.selectedOptions[0];
			searchLabel.textContent = selectedOption.text;
			formElement.action = selectedOption.getAttribute('data-search-url');
			if (selectedOption.value === 'global') {
				inputResultLang.disabled = false;
			} else if (selectedOption.value === 'local') {
				inputResultLang.disabled = true;
			}
		}

		inputResultLang = document.getElementById('search-input-resultLang');
		chevron = document.getElementById('search-form-chevron');
		formElement = document.getElementById('search-form');
		searchLabel = document.getElementById('search-label-inline');

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
}());
