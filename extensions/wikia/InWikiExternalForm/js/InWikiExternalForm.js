var InWikiExternalForm = {
	init: function() {
		WikiaTracker.track({
			category: 'in-wiki-external-form',
			action: WikiaTracker.ACTIONS.IMPRESSION,
			label: 'form-impression',
			trackingMethod: 'internal'
		});
	}
}

$(function () {
	InWikiExternalForm.init();
});
