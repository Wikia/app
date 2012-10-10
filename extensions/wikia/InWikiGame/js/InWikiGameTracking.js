var InWikiGameTracking = {
	init: function(jsonObject) {
		WikiaTracker.trackClick({
			'category': 'in-wiki-game',
			'action': WikiaTracker.ACTIONS.IMPRESSION,
			'label': 'game-page',
			'value': null,
			'params': {},
			'trackingMethod': 'internal'
		});
	}
}

$(function () {
	InWikiGameTracking.init();
});
