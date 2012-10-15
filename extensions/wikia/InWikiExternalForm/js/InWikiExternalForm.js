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

		var iframe = $('iframe.ExternalForm');
		var iframeBody = iframe.contents();

		iframe.load(function() {
			var self = $('iframe.ExternalForm');
			var iframeBody = self.contents();

			iframeBody.find('#main-header').css({
				'display': 'none'
			});

			iframeBody.find('#main').css({
				'display': 'none'
			});

			iframeBody.find('#sitemap').css({
				'display': 'none'
			});

			iframeBody.find('#lang_select').css({
				'display': 'none'
			});

			iframeBody.find('#content').css({
				'top': '0px'
			});
		});

	}
}

$(function () {
	InWikiExternalForm.init();
});
