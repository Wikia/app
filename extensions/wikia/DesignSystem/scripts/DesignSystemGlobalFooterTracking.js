$(function ($) {
	'use strict';
	/**
	 * Tracking helper function with most commonly used options. Overrides are passed in by callers.
	 */
	var track = Wikia.Tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'footer',
		trackingMethod: 'analytics'
	});

	$('.wds-global-footer').click(function (event) {
		var $element, label;

		$element = $(event.target);

		label = $element.closest('a').data('tracking-label') || false;

		if (label !== false) {
			track({
				label: label
			});
		}
	});
});
