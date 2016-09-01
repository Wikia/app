$(function ($) {
	'use strict';

	$('body').on('click', function(event) {
		var $eventTarget = $(event.target),
			$clickedContent = $eventTarget.closest('.wds-dropdown__content'),
			$clickedDropdown = $eventTarget.closest('.wds-dropdown');

		// We don't use toggle as it has disabled pointer events due to bug in IE.
		if ($clickedContent.length === 0) {
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
