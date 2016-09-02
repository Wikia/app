$(function ($) {
	'use strict';

	$('body').on('click', function(event) {
		var $eventTarget = $(event.target),
			$clickedToggle = $eventTarget.closest('.wds-dropdown__toggle'),
			$clickedDropdown = $eventTarget.closest('.wds-dropdown');

		if ($clickedToggle.length) {
			$clickedDropdown.toggleClass('wds-is-active');

			if ($clickedDropdown.hasClass('wds-is-active')) {
				$clickedDropdown.trigger('wds-dropdown-open');
			} else {
				$clickedDropdown.trigger('wds-dropdown-close');
			}
		}

		$('.wds-dropdown.wds-is-active').not($clickedDropdown).removeClass('wds-is-active');
	});
});
