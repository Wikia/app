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
			}
		}

		$('.wds-dropdown.wds-is-active').not($clickedDropdown)
			.removeClass('wds-is-active')
			.trigger('wds-dropdown-close');

		$('.wds-global-navigation').toggleClass(
			'wds-dropdown-is-open',
			Boolean($clickedDropdown.hasClass('wds-is-active'))
		);
	});
});
