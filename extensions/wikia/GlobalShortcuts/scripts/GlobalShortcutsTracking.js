define('GlobalShortcutsTracking', ['wikia.tracker'], function(tracker){
	'use strict';

	var track = Wikia.Tracker.buildTrackingFunction({
		category: 'global-shortcuts',
		trackingMethod: 'analytics',
		action: tracker.ACTIONS.KEYPRESS
	});

	function trackKey(label) {
		track({ label: label });
	}

	function trackClick(label) {
		track({ action: tracker.ACTIONS.CLICK, label: label });
	}

	return {
		trackKey: trackKey,
		trackClick: trackClick
	}
});
