(function() {
	'use strict';
	var formElement, selectElement, searchLabel;

	function setFormOptions() {
		var selectedOption, selectedElementText;

		selectedOption = selectElement.selectedOptions[0];
		selectedElementText = selectedOption.text;
		searchLabel.textContent = selectedElementText;
		formElement.action = selectedOption.getAttribute('data-search-url');
	}

	selectElement = document.getElementById('search-select');
	searchLabel = document.getElementById('search-label-inline');
	formElement = document.getElementById('search-form');

	selectElement.addEventListener('change', function() {
		setFormOptions();
	});
}());
