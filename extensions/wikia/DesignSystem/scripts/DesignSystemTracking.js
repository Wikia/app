$(function ($) {
	'use strict';

	var globalNavigationTracker = Wikia.Tracker.buildTrackingFunction({
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'navigation',
			trackingMethod: 'analytics'
		}),
		globalFooterTracker = Wikia.Tracker.buildTrackingFunction({
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'footer',
			trackingMethod: 'analytics'
		});

	function addTrackingToSelector(selector, tracker) {
		$(selector).click(function (event) {
			var label = $(event.target).closest('a, button').data('tracking-label') || false;

			if (label !== false) {
				tracker({
					label: label
				});
			}
		});
	}

	addTrackingToSelector('.wds-global-navigation', globalNavigationTracker);
	addTrackingToSelector('.wds-global-footer', globalFooterTracker);
});
