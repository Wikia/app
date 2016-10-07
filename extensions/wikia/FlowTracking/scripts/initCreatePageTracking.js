require([
	'ext.wikia.flowTracking.createPageTracking', 'wikia.querystring', 'mw', 'jquery', 'wikia.window'
], function (flowTrackingCreatePage, QueryString, mw, $, window) {
	function init() {
		// Create Page flow tracking, adding flow param in redlinks href.
		// This parameter is added here to avoid reparsing all articles.
		$('#WikiaArticle').find('a.new').each(function (index, redlink) {
			var qs = QueryString(redlink.href),
				redLinkFlow = mw.config.get('wgNamespaceNumber') === -1 ?
					window.wgFlowTrackingFlows.CREATE_PAGE_SPECIAL_REDLINK :
					window.wgFlowTrackingFlows.CREATE_PAGE_ARTICLE_REDLINK;

			qs.setVal('flow', redLinkFlow);
			redlink.href = qs.toString();
		});
	}

	function initVEHooks() {
		mw.hook('ve.activationComplete').add(function () {
			flowTrackingCreatePage.trackOnEditPageLoad('visualeditor');
		});

		mw.hook('ve.deactivationComplete').add(function () {
			var qs = new QueryString(),
				flow = qs.getVal('flow');

			if (flow) {
				qs.removeVal('flow');
				window.history.replaceState({}, '', qs.toString())
			}
		});
	}

	$(function () {
		init();
		initVEHooks();
	});
});
