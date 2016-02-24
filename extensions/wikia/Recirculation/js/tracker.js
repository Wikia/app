/*global define*/
define('ext.wikia.recirculation.tracker', [
	'wikia.tracker'
], function (tracker) {
	'use strict';

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
		trackClick: trackClick,
		trackImpression: trackImpression
	};
});
