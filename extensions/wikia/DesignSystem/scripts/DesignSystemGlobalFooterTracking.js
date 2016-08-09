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

	/**
	 * Parent click handler for events in the DS Global Footer
	 * @param {object} event
	 */
	function clickTrackingHandler(event) {
		var $element, label;

		//Track only primary mouse button click
		if (event.type === 'mousedown' && event.which !== 1) {
			return;
		}

		$element = $(event.target);

		label = $element.closest('a').data('tracking-label') || false;

		if (label !== false) {
			track({
				label: label
			});
		}
	}

	$('.wds-global-footer').on('mousedown touchstart', clickTrackingHandler);
});
