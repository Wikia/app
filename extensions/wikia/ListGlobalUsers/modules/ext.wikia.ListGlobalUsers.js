/* global jQuery, mediaWiki */
(function ($, mw) {
	'use strict';

	var areAllSelected = false,
		selectToggle = document.getElementById('list-global-users-selector-toggle'),

		noneSelectedLabel = mw.message('listglobalusers-select-all').text(),
		allSelectedLabel = mw.message('listglobalusers-deselect-all').text(),

		checkBoxes = document.getElementsByClassName('list-global-users-group-checkbox'),
		checkBoxCount = checkBoxes.length,

		i;

	selectToggle.addEventListener('click', function () {
		var newState = !areAllSelected;

		for (i = 0; i < checkBoxCount; i++) {
			checkBoxes[i].checked = newState;
		}

		selectToggle.textContent = newState ? allSelectedLabel : noneSelectedLabel;
		areAllSelected = newState;
	});
})(jQuery, mediaWiki);
