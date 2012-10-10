var InWikiExternalForm = {
	init: function() {
		WikiaTracker.trackClick({
			'category': 'in-wiki-external-form',
			'action': WikiaTracker.ACTIONS.IMPRESSION,
			'label': 'form-impression',
			'value': null,
			'params': {},
			'trackingMethod': 'internal'
		});
	}
}

$(function () {
	InWikiExternalForm.init();
});
