/*global define*/
define('ext.wikia.recirculation.tracker', [
	'jquery',
	'wikia.tracker',
], function ($, tracker) {
	'use strict';

	function trackSelect(label, additionalParams) {
		var computedTracking = $.extend({
			action: tracker.ACTIONS.SELECT,
			category: 'recirculation',
			label: label,
			trackingMethod: 'analytics'
		}, additionalParams);

		tracker.track(computedTracking);
	}

	function trackClick(label, additionalParams) {
		var computedTracking = $.extend({
			action: tracker.ACTIONS.CLICK,
			category: 'recirculation',
			label: label,
			trackingMethod: 'analytics'
		}, additionalParams);

		tracker.track(computedTracking);
	}

	function trackImpression(label) {
		tracker.track({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'recirculation',
			label: label,
			trackingMethod: 'analytics'
		});
	}

	return {
		trackImpression: trackImpression,
		trackClick: trackClick,
		trackSelect: trackSelect,
	};
});
