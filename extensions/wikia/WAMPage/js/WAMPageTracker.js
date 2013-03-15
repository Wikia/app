define('WAMPageTracker', ['wikia.tracker'], function(WikiaTracker) {
	var track = WikiaTracker.buildTrackingFunction({
		category: 'WAMPage',
		trackingMethod: 'internal'
	});
	
	return {
		track: function(label) {
			track({
				action: WikiaTracker.ACTIONS.IMPRESSION,
				label: label
			});
		}
	}
});