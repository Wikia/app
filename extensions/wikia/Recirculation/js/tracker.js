/*global define*/
define('ext.wikia.recirculation.tracker', [
	'wikia.tracker',
	'wikia.abTest'
], function (tracker, abTest) {
	'use strict';

	function trackSelect(label) {
		tracker.track({
			action: tracker.ACTIONS.SELECT,
			category: 'recirculation',
			label: label,
			trackingMethod: 'analytics'
		})
	}

	function trackClick(label) {
		tracker.track({
			action: tracker.ACTIONS.CLICK,
			category: 'recirculation',
			label: label,
			trackingMethod: 'analytics'
		});
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
