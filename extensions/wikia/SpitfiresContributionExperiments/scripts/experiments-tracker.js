/*global define*/
define('ext.wikia.spitfires.experiments.tracker', [
	'wikia.tracker',
	'wikia.abTest',
	'wikia.cookies'
], function (tracker, abTest, cookies) {
	'use strict';

	function trackVerboseClick(experiment, label) {
		var group = abTest.getGroup(experiment),
			userStatusLabel = getUserStatus(),
			structuredLabel = [experiment, group, userStatusLabel, label].join('-');

		trackClick(structuredLabel);
	}

	function trackVerboseImpression(experiment, label) {
		var group = abTest.getGroup(experiment),
			userStatusLabel = getUserStatus(),
			structuredLabel = [experiment, group, userStatusLabel, label].join('-');

		trackImpression(structuredLabel);
	}

	function trackClick(label) {
		tracker.track({
			action: tracker.ACTIONS.CLICK,
			category: 'spitfires-contribution-experiments',
			label: label,
			trackingMethod: 'analytics'
		});
	}

	function trackImpression(label) {
		tracker.track({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'spitfires-contribution-experiments',
			label: label,
			trackingMethod: 'analytics'
		});
	}

	function getUserStatus() {
		if (cookies.get('newlyregistered') === 1) {
			return 'newlyregistered';
		} else if (cookies.get('userwithoutedit') === 1) {
			return 'userwithoutedit';
		} else {
			return 'userStatusNaN';
		}
	}

	return {
		trackVerboseClick: trackVerboseClick,
		trackVerboseImpression: trackVerboseImpression
	};
});
