require([
	'jquery',
	'wikia.tracker',
], function ($, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'community-page-entry-point',
		trackingMethod: 'analytics'
	});

	$(function() {
		$('.community-page-rail-module .entry-button').on(
			'mousedown touchstart',
			track.bind(this, {label: 'entry-button'})
		);

		$('.community-page-rail-module .wds-avatar').on(
			'mousedown touchstart',
			track.bind(this, {label: 'avatar'})
		);

		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'entry-point-loaded',
		});
	});
});
