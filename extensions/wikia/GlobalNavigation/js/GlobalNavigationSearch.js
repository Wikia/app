(function() {
	'use strict';
	var formElement, selectElement, searchLabel;

	function setFormOptions() {
		var selectedOption;

		selectedOption = selectElement.selectedOptions[0];
		searchLabel.textContent = selectedOption.text;
		formElement.action = selectedOption.getAttribute('data-search-url');
	}

	selectElement = document.getElementById('search-select');
	searchLabel = document.getElementById('search-label-inline');
	formElement = document.getElementById('search-form');

	selectElement.addEventListener('change', function() {
		setFormOptions();
	});
}());
