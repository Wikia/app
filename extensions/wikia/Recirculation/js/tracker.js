/*global define*/
define('ext.wikia.recirculation.tracker', [
	'wikia.tracker',
	'wikia.abTest'
], function (tracker, abTest) {
	'use strict';

	function trackVerboseClick(experiment, label) {
		var group = abTest.getGroup(experiment),
			structuredLabel = [experiment, group, label].join('=');

		trackClick(structuredLabel);
	}

	function trackVerboseImpression(experiment, label) {
		var group = abTest.getGroup(experiment),
			structuredLabel = [experiment, group, label].join('=');

		trackImpression(structuredLabel);
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
		trackVerboseClick: trackVerboseClick,
		trackVerboseImpression: trackVerboseImpression,
		trackImpression: trackImpression,
		trackClick: trackClick
	};
});
