$(function ($) {
	'use strict';

	$('body').on('click', function(event) {
		var eventTarget = $(event.target),
			clickedToggle = eventTarget.closest('.wds-dropdown-toggle'),
			clickedDropdown = eventTarget.closest('.wds-dropdown');

		if (clickedToggle.length) {
			$(clickedToggle).closest('.wds-dropdown').toggleClass('wds-is-active');
		}

		$('.wds-dropdown.wds-is-active').not(clickedDropdown).removeClass('wds-is-active');
	});
});
