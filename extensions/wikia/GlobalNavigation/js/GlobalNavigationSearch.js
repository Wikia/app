(function() {
	'use strict';
	document.addEventListener('DOMContentLoaded', function() {
		var formElement, selectElement, searchLabel, chevron;
		function setFormOptions() {
			var selectedOption;

			selectedOption = selectElement.selectedOptions[0];
			searchLabel.textContent = selectedOption.text;
			formElement.action = selectedOption.getAttribute('data-search-url');
		}

		selectElement = document.getElementById('search-select');
		searchLabel = document.getElementById('search-label-inline');
		formElement = document.getElementById('search-form');
		chevron = document.getElementById('search-form-chevron');

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
