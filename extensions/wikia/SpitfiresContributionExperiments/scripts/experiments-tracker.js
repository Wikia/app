/*global define*/
define('ext.wikia.spitfires.experiments.tracker', [
	'wikia.tracker',
	'wikia.abTest',
	'wikia.cookies'
], function (tracker, abTest, cookies) {
	'use strict';

	var track = tracker.buildTrackingFunction({
			category: 'spitfires-contribution-experiments',
			trackingMethod: 'analytics'
		}),
		freshlyRegisteredExperimentId = 5654433460,
		usersWithoutEditExperimentId = 5735670451;

	function trackVerboseClick(experiment, label) {
		trackClick(prepareStructuredLabel(experiment, label));
	}

	function trackVerboseImpression(experiment, label) {
		trackImpression(prepareStructuredLabel(experiment, label));
	}

	function trackVerboseSuccess(experiment, label) {
		trackSuccess(prepareStructuredLabel(experiment, label));
	}

	function trackClick(label) {
		track({
			action: tracker.ACTIONS.CLICK,
			label: label
		});
	}

	function trackImpression(label) {
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: label
		});
	}

	function trackSuccess(label) {
		track({
			action: tracker.ACTIONS.SUCCESS,
			label: label
		});
	}

	function getUserStatus() {
		if (cookies.get('newlyregistered')) {
			return 'newlyregistered';
		} else if (cookies.get('userwithoutedit')) {
			return 'userwithoutedit';
		} else {
			return 'userStatusNaN';
		}
	}

	function getVariationName() {
		if (window.optimizely.activeExperiments.indexOf(freshlyRegisteredExperimentId) !== -1) {
			return window.optimizely.variationNamesMap[freshlyRegisteredExperimentId].toLowerCase();
		}
		return window.optimizely.variationNamesMap[usersWithoutEditExperimentId].toLowerCase();
	}

	function prepareStructuredLabel(experiment, label) {
		var group = getVariationName(),
			userStatusLabel = getUserStatus();
		return [experiment, group, userStatusLabel, label].join('-');
	}
			
	return {
		trackVerboseClick: trackVerboseClick,
		trackVerboseImpression: trackVerboseImpression,
		trackVerboseSuccess: trackVerboseSuccess
	};
});
